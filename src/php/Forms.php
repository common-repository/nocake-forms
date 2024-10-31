<?php

namespace NoCake;

use NoCake\FormBuilder\Data;

final class Forms
{
    /**
     * @var Forms Instance of this class.
     */
    protected static $instance;
    /**
     * @var bool Resolve whether form-renderer.js was already loaded by short code.
     */
    public $shortCodeAssetsAdded = false;
    /**
     * @var string Absolute path to plugins directory.
     */
    protected $pluginDir;
    /**
     * @var string Absolute path to main plugin file.
     */
    protected $pluginFile;
    /**
     * @var string Plugin directory name.
     */
    protected $dirName;
    /**
     * @var string Plugins prefix used to build unique identifiers.
     */
    protected $prefix = 'ncforms';
    /**
     * @var string Plugin version.
     */
    protected $version = '1.0.0';
    /**
     * @var string Minimum Wordpress version required by this plugin.
     */
    protected $minWpVersion = '5.2';
    /**
     * @var string Minimum PHP version required by this plugin.
     */
    protected $minPhpVersion  = '5.4';
    /**
     * @var string Url to the website where you can buy plugin.
     */
    protected $buyUrl = 'https://nocake.io/nocake-wp-forms';
    /**
     * @var string Url to the api of contact.
     */
    protected $contactUrl = 'https://nocake.io/api/product/help';
    private $licenseKey = null;
    private $options = [];

    private function __construct()
    {
        $this->pluginDir = realpath(__DIR__.'/../..');
        $this->pluginFile = $this->pluginDir.'/main.php';
        $this->dirName = plugin_basename($this->pluginDir);

        if ($this->isDeactivation() or !$this->canBeActivated()) {
            return;
        }

        $me = $this;
        // Do nothing until all plugins loaded.
        add_action('plugins_loaded', function() use ($me) {
            $prefix = $this->getPrefix();
            $this->options = $options = get_option($prefix, []);

            if (!isset($options['version'])) {
                // Create tables.
                $this->createDbTables();
            }

            if (!isset($options['version'])) {
                update_option($prefix, [
                    'version' => $me->getVersion(),
                    'license_key' => null
                ]);
            }

            $this->licenseKey = $this->getOption('license_key');
        }, 1);

        $this->init();
        $this->initAdmin();
    }

    /**
     * Allows to detect plugin deactivation.
     *
     * @return bool true if the plugin is currently beeing deactivated.
     */
    public function isDeactivation()
    {
        return (isset( $_GET['action'], $_GET['plugin'] ) and 'deactivate' === $_GET['action'] and $this->getDirName() === $_GET['plugin']);
    }

    /**
     * @return string
     */
    public function getDirName()
    {
        return $this->dirName;
    }

    /**
     * Check min PHP and WP version, desplays a notice if a requirement is not met.
     */
    public function canBeActivated()
    {
        global $wp_version;

        if ( version_compare( PHP_VERSION, $this->getMinPhpVersion(), '<' ) ) {
            add_action('admin_notices', function() {
                echo '<div class="error"><p>NoCake Forms has deactivated itself because you are using an old PHP version. You are using PHP '.PHP_VERSION.'. NoCake Forms requires PHP '.$this->getMinPhpVersion().'.</p></div>';
            });
            return false;
        }

        if ( version_compare( $wp_version, $this->getMinWpVersion(), '<' ) ) {
            add_action('admin_notices', function() use ($wp_version) {
                echo '<div class="error"><p>NoCake Forms Builder has deactivated itself because you are using an old Wordpress version. You are using Wordpress '.$wp_version.'. NoCake Forms requires Wordpress '.$this->getMinWpVersion().'.</p></div>';
            });
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getMinPhpVersion()
    {
        return $this->minPhpVersion;
    }

    /**
     * @return string
     */
    public function getMinWpVersion()
    {
        return $this->minWpVersion;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Create database tables.
     */
    public function createDbTables()
    {
        global $wpdb;

        $prefix = $this->getDbTablePrefix();

        $wpdb->query("
            CREATE TABLE IF NOT EXISTS `{$prefix}forms` (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `uid` VARCHAR(60) NULL DEFAULT NULL,
                `name` VARCHAR(255) NULL DEFAULT NULL,
                `description` TEXT NULL,
                `definition` LONGTEXT NULL,
                `created_at` DATETIME NULL DEFAULT NULL,
                `updated_at` DATETIME NULL DEFAULT NULL,
                PRIMARY KEY (`id`),
                UNIQUE INDEX `Index 2` (`uid`)
            )
            COLLATE='{$wpdb->collate}'
            ENGINE=InnoDB
            ;
        ");

        $wpdb->query("
            CREATE TABLE IF NOT EXISTS `{$prefix}submissions` (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `form_id` INT(10) UNSIGNED NULL DEFAULT NULL,
                `user_agent` TINYTEXT NULL,
                `ip` VARCHAR(16) NULL DEFAULT NULL,
                `created_at` DATETIME NULL DEFAULT NULL,
                `updated_at` DATETIME NULL DEFAULT NULL,
                PRIMARY KEY (`id`),
                INDEX `Index 2` (`form_id`),
                CONSTRAINT `FK_{$prefix}submissions_{$prefix}forms` FOREIGN KEY (`form_id`) REFERENCES `{$prefix}forms` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE
            )
            COLLATE='{$wpdb->collate}'
            ENGINE=InnoDB
            ;
        ");

        $wpdb->query("
            CREATE TABLE IF NOT EXISTS `{$prefix}submissions_values` (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `submission_id` INT(10) UNSIGNED NOT NULL,
                `control_id` VARCHAR(20) NULL DEFAULT NULL,
                `value` TEXT NULL,
                PRIMARY KEY (`id`),
                UNIQUE INDEX `Index 2` (`submission_id`, `control_id`),
                INDEX `Index 3` (`submission_id`, `control_id`),
                CONSTRAINT `FK_{$prefix}submissions_values_{$prefix}submissions` FOREIGN KEY (`submission_id`) REFERENCES `{$prefix}submissions` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE
            )
            COLLATE='{$wpdb->collate}'
            ENGINE=InnoDB
            ;
        ");
    }

    /**
     * Return database table prefix (or if first argument is provided,
     * prefixed table name).
     *
     * @param string $tableName Table name.
     * @return string
     */
    public function getDbTablePrefix($tableName = '')
    {
        global $wpdb;
        return $wpdb->prefix.$this->getPrefix().'_'.$tableName;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    public function getOption($key, $default = null)
    {
        return isset($this->options[$key]) ? $this->options[$key] : $default;
    }

    protected function init()
    {
        $this->initGutenbergBlock();
        $this->initShortCode();
        $this->initQueryVars();
        $this->formSubmitRequest();
        $this->formShowRequest();

//        add_action('init', function() {
//            // Register rewrite rule.
//            // @todo almost sure it's not needed.
////            add_rewrite_rule('^'.HSPG_FB_PREFIX.'/([-a-zA-Z0-9]+)/([_a-z]+)/?', 'index.php?'.HSPG_FB_PREFIX.'_form=$matches[1]&'.HSPG_FB_PREFIX.'_action=$matches[2]', 'top');
//        }, 10, 0);
    }

    protected function initGutenbergBlock()
    {
        add_action('init', function() {
            register_block_type('ncforms/form', [
                'render_callback' => function($attributes, $content = null) {
                    return $this->renderGutenbergBlock($attributes, $content);
                },
                'attributes' => [
                    'form_uid' => [
                        'type' => 'string'
                    ]
                ],
                'category' => 'common'
            ]);
        });
    }

    protected function renderGutenbergBlock($attributes, $content = null)
    {
        $form = $this->getForm($attributes['form_uid']);

        if (!$form) {
            return '<span style="font-family: Arial;">Form with specified id does not exists.</span>';
        }

        $formDef = $form['definition'];
        $md5 = md5($form['uid']);
        $prefix = $this->getPrefix();
        $url = plugin_dir_url($this->getPluginFile());
        $html = "";

        // Include form renderer script.
        if (!$this->shortCodeAssetsAdded) {
            $dir = WP_DEBUG ? 'build' : 'dist';
            foreach (scandir($this->getPluginDir().'/form-builder/assets/'.$dir.'/js') as $file) {
                if ($file == '.' or $file == '..') {
                    continue;
                }
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if ($ext != 'js') {
                    continue;
                }
                if (strpos($file, 'form-renderer-') !== false) {
                    $fileName = 'form-builder/assets/'.$dir.'/js/'.$file;
                    break;
                }
            }

            $html .= "<script src='".$url.$fileName."'></script>\n";
        }

        return $html."
                    <div id='{$prefix}_{$md5}'></div>
                    <script>
                        var renderer = nocake.form.renderer.create({
                            el: '#{$prefix}_{$md5}',
                            url: '".site_url('?'.$prefix.'_action=submit&'.$prefix.'_form='.$form['uid'])."',
                            themes: {
                                'ncfbdef': { name: 'Default', url: '".$url."form-builder/assets/themes/default.css' },
                                'ncfbmodern': { name: 'Default', url: '".$url."form-builder/assets/themes/modern.css' },
                                'ncfbmonokai': { name: 'Default', url: '".$url."form-builder/assets/themes/monokai.css' },
                                'ncfbwombat': { name: 'Default', url: '".$url."form-builder/assets/themes/wombat.css' },
                                'ncfbzenburn': { name: 'Default', url: '".$url."form-builder/assets/themes/zenburn.css' },
                            },
                            form: ".json_encode($formDef)."
                        })
                    </script>
                ";
    }

    /**
     * Register short code.
     */
    protected function initShortCode()
    {
        $me = $this;
        add_action('init', function() use ($me) {
            // Register shortcode.
            add_shortcode('nocake-form', function($attrs) use ($me) {
                $args = shortcode_atts([
                    'id' => null
                ], $attrs);

                $id = $args['id'];
                if (!preg_match('/^\d+$/', (string) $id)) {
                    return '<span style="font-family: Arial;">Form with specified id does not exists.</span>';
                }

                $form = $me->getForm($id);

                if (!$form) {
                    return '<span style="font-family: Arial;">Form with specified id does not exists.</span>';
                }

                $formDef = $form['definition'];
                $md5 = md5($form['uid']);
                $prefix = $this->getPrefix();
                $url = plugin_dir_url($this->getPluginFile());
                $html = "";

                // Include form renderer script.
                if (!$me->shortCodeAssetsAdded) {
                    $dir = WP_DEBUG ? 'build' : 'dist';
                    foreach (scandir($me->getPluginDir().'/form-builder/assets/'.$dir.'/js') as $file) {
                        if ($file == '.' or $file == '..') {
                            continue;
                        }
                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                        if ($ext != 'js') {
                            continue;
                        }
                        if (strpos($file, 'form-renderer-') !== false) {
                            $fileName = 'form-builder/assets/'.$dir.'/js/'.$file;
                            break;
                        }
                    }

                    $html .= "<script src='".$url.$fileName."'></script>\n";
                }

                return $html."
                    <div id='{$prefix}_{$md5}'></div>
                    <script>
                        var renderer = nocake.form.renderer.create({
                            el: '#{$prefix}_{$md5}',
                            url: '".site_url('?'.$prefix.'_action=submit&'.$prefix.'_form='.$form['uid'])."',
                            themes: {
                                'ncfbdef': { name: 'Default', url: '".$url."form-builder/assets/themes/default.css' },
                                'ncfbmodern': { name: 'Default', url: '".$url."form-builder/assets/themes/modern.css' },
                                'ncfbmonokai': { name: 'Default', url: '".$url."form-builder/assets/themes/monokai.css' },
                                'ncfbwombat': { name: 'Default', url: '".$url."form-builder/assets/themes/wombat.css' },
                                'ncfbzenburn': { name: 'Default', url: '".$url."form-builder/assets/themes/zenburn.css' },
                            },
                            form: ".json_encode($formDef)."
                        })
                    </script>
                ";
            });
        }, 10, 0);
    }

    /**
     * Return form.
     *
     * @param integer $id Form id or uid.
     * @return array|null
     */
    public function getForm($id)
    {
        global $wpdb;

        $field = preg_match('/^\d+$/', (string) $id) ? 'id' : 'uid';

        $table = $this->getDbTablePrefix('forms');
        $form = $wpdb->get_row(sprintf("SELECT * FROM {$table} WHERE `{$field}` = '%s' LIMIT 1", (string) $id), \ARRAY_A);

        if ($form) {
            $def = $form['definition'];
            $def = json_decode($def, true);
            if (json_last_error() !== \JSON_ERROR_NONE) {
                $def = [];
            }
            $form['definition'] = $def;
        }

        return $form;
    }

    public function createFormInstance(array $form, $data = null)
    {
        return new \NoCake\FormBuilder\Form($form['definition'], $data, [
            'controls' => [
                'file' => [
                    'upload_dir' => $this->getFormsAttachmentsDir($form['uid'])
                ]
            ]
        ]);
    }

    /**
     * Return submission array.
     *
     * @param integer $id Submission id.
     * @return array
     */
    public function getSubmission($id)
    {
        global $wpdb;

        $id = (string) $id;
        if (!preg_match('/^\d+$/', $id)) {
            throw new \InvalidArgumentException('Submission id must be integer.');
        }

        $table = $this->getDbTablePrefix('submissions');
        return $wpdb->get_row(sprintf("SELECT * FROM {$table} WHERE id = '%d' LIMIT 1", $id), \ARRAY_A);
    }

    /**
     * Return path to forms attachment directory.
     *
     * @param string $formUid
     * @return string
     */
    public function getFormsAttachmentsDir($formUid)
    {
        return WP_CONTENT_DIR.'/nocake_forms_attachments/'.$formUid;
    }

    public function getFormsAttachmentsUrl($formUid, $file = null)
    {
        return content_url('nocake_forms_attachments/'.$formUid).($file ? '/'.$file : '');
    }

    /**
     * @return string
     */
    public function getPluginFile()
    {
        return $this->pluginFile;
    }

    /**
     * @return string
     */
    public function getPluginDir()
    {
        return $this->pluginDir;
    }

    /**
     * Add "hspgfb_form" & "hspgfb_action" to query vars.
     */
    protected function initQueryVars()
    {
        $prefix = $this->getPrefix();
        add_filter('query_vars', function($vars) use ($prefix) {
            $vars[] = $prefix.'_form';
            $vars[] = $prefix.'_action';
            return $vars;
        });
    }

    /**
     * Handle form submit request.
     */
    protected function formSubmitRequest()
    {
        $me = $this;
        add_filter('request', function($query) use ($me) {
            global $wpdb;
            $prefix = $this->getPrefix();

            $actionKey = $prefix.'_action';
            $uidKey = $prefix.'_form';
            if (isset($query[$actionKey]) and $query[$uidKey] and $query[$actionKey] == 'submit') {
                $uid = $query[$uidKey];
                $isPreview = isset($_POST['_ncforms_preview']);

                $formRow = $me->getForm($uid);

                if (!$formRow) {
                    $me->ajaxResponse(['error' => 'Form does not exists.'], 400);
                }

                $messages = include $me->getPluginDir() . '/form-builder/php/NoCake/FormBuilder/messages/en.php';

                $data = wp_unslash(isset($_POST['_fc']) ? $_POST['_fc'] : '');
                $data = json_decode($data, true);
                if (json_last_error() !== \JSON_ERROR_NONE) {
                    $data = [];
                }
                $data = new \NoCake\FormBuilder\Data($data, $_FILES);

                $form = $this->createFormInstance($formRow, $data);
                $form->setErrorMessages($messages);

                try {
                    // This will validate data passed to form.
                    $form->process();

                    if (!$isPreview) {
                        $result = $wpdb->insert(
                            $me->getDbTablePrefix('submissions'),
                            [
                                'form_id' => $formRow['id'],
                                'created_at' => date('Y-m-d H:i:s'),
                                'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? wp_unslash($_SERVER['HTTP_USER_AGENT']) : null,
                                'ip' => isset($_SERVER['REMOTE_ADDR']) ? wp_unslash($_SERVER['REMOTE_ADDR']) : null
                            ]
                        );

                        if ($result) {
                            $submissionId = $wpdb->insert_id;
                            foreach ($data as $controlUid => $value) {
                                //$ctrl = $form->getControlByUid($controlUid);
                                $wpdb->insert(
                                    $me->getDbTablePrefix('submissions_values'),
                                    [
                                        'submission_id' => $submissionId,
                                        'control_id' => $controlUid,
                                        'value' => json_encode($value)
                                    ]
                                );
                            }

                            $delivery = $form->getEmailDeliveryConfig();
                            if ($delivery['emails']) {
                                wp_mail($delivery['emails'], $delivery['subject'], $delivery['message'], ['Content-Type: text/html; charset=UTF-8']);
                            }
                        }
                    }

                    $me->ajaxResponse(['success' => true]);
                } catch (\NoCake\FormBuilder\Exception\ValidationException $e) {
                    $me->ajaxResponse(['errors' => $e->getErrors()], 400);
                }
            }

            return $query;
        });
    }

    public function ajaxResponse(array $data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Handle form show request.
     */
    protected function formShowRequest()
    {
        $me = $this;
        add_filter('request', function($query) use ($me) {
            $prefix = $me->getPrefix();
            $actionKey = $prefix.'_action';
            $uidKey = $prefix.'_form';
            if (isset($query[$actionKey]) and $query[$uidKey] and $query[$actionKey] == 'form') {
                $uid = $query[$uidKey];

                $formRow = $me->getForm($uid);

                if (!$formRow) {
                    $me->response('<span style="font-family: Arial;">Form with specified id does not exists.</span>', 404);
                }

                $formDef = $formRow['definition'];

                $dir = WP_DEBUG ? 'build' : 'dist';
                foreach (scandir($me->getPluginDir().'/form-builder/assets/'.$dir.'/js') as $file) {
                    if ($file == '.' or $file == '..') {
                        continue;
                    }
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    if ($ext != 'js') {
                        continue;
                    }
                    if (strpos($file, 'form-renderer-') !== false) {
                        $fileName = 'form-builder/assets/'.$dir.'/js/'.$file;
                        break;
                    }
                }
                $url = plugin_dir_url($this->pluginFile);
                $response = "
                    <html>
                        <head>

                        </head>
                        <body>
                            <div id='app'></div>
                            <script src='".$url.$fileName."'></script>
                            <script>
                                const renderer = nocake.form.renderer.create({
                                    el: '#app',
                                    url: '".site_url('?'.$prefix.'_action=submit&'.$prefix.'_form='.$uid)."',
                                    themes: {
                                        'ncfbdef': { name: 'Default', url: '".$url."form-builder/assets/themes/default.css' },
                                        'ncfbmodern': { name: 'Default', url: '".$url."form-builder/assets/themes/modern.css' },
                                        'ncfbmonokai': { name: 'Default', url: '".$url."form-builder/assets/themes/monokai.css' },
                                        'ncfbwombat': { name: 'Default', url: '".$url."form-builder/assets/themes/wombat.css' },
                                        'ncfbzenburn': { name: 'Default', url: '".$url."form-builder/assets/themes/zenburn.css' },
                                    },
                                    form: ".json_encode($formDef)."
                                })
                            </script>
                        </body>
                    </html>
                ";
                $me->response($response);
            }

            return $query;
        });
    }

    public function response($string = '', $status = 200)
    {
        http_response_code($status);
        header('Content-Type: text/html');
        echo $string;
        exit;
    }

    protected function initAdmin()
    {
        $this->initAdminMenu();
        $this->initAdminGutenberg();
        $this->initAdminAssets();
        $this->formSaveRequest();
        $this->formDeleteRequest();
        $this->formListRequest();
        $this->submissionDeleteRequest();
        $this->contactFormRequest();
    }

    /**
     * Handle contact form request.
     */
    protected function contactFormRequest()
    {
        $prefix = $this->getPrefix();
        add_action('wp_ajax_'.$prefix.'_contact_form', function() {
            $data = $_POST;

            $response = wp_remote_post($this->getContactUrl(), [
                'method' => 'POST',
                'body' => [
                    'source' => 'wp',
                    'product' => '6005fb862c',
                    'type' => $data['type'],
                    'email' => $data['email'],
                    'message' => $data['message'],
                    'data' => [
                        'form_definition' => isset($data['data']) ? $data['data'] : '',
                        'user_ip' => $_SERVER['REMOTE_ADDR'],
                        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                    ],
                ]
            ]);

            // Response body.
            if ($response['response']['code'] != 200) {
                $body = wp_remote_retrieve_body($response);

                wp_send_json_error(json_decode($body, true ), $response['response']['code']);
            }

            wp_send_json_success();
        });
    }

    /**
     * Handle submission delete request.
     */
    protected function submissionDeleteRequest()
    {
        $me = $this;
        $prefix = $this->getPrefix();
        add_action('wp_ajax_'.$prefix.'_delete_submission', function() use ($me, $prefix) {
            global $wpdb;
            $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
            if (preg_match('/^\d+$/', (string) $id)) {

                $nonce = isset($_GET['nonce']) ? $_GET['nonce'] : '';
                if (
                    // Have permissions.
                    current_user_can('manage_options') and
                    // Nonce is ok.
                    wp_verify_nonce($nonce, $prefix.'-submission-'.$id)) {
                    $wpdb->delete($me->getDbTablePrefix('submissions'), ['id' => $id]);
                    wp_send_json_success();
                }

                wp_send_json_error();
            }
        });
    }

    /**
     * Add admin menu items.
     */
    protected function initAdminMenu()
    {
        $dirName = $this->getDirName();
        // Add menu items.
        add_action('admin_menu', function() use ($dirName) {
            add_menu_page(
                'NoCake Forms',
                'NoCake Forms',
                'manage_options',
                $dirName.'/page/index.php',
                ''
            );
            add_menu_page(
                'NoCake Forms - Delete form',
                'Delete form',
                'manage_options',
                $dirName.'/page/delete.php',
                ''
            );
            add_submenu_page(
                $dirName.'/page/index.php',
                'NoCake Forms - Submission',
                'Submission',
                'manage_options',
                $dirName.'/page/submission.php'
            );
            add_submenu_page(
                $dirName.'/page/index.php',
                'NoCake Forms - Forms',
                'Forms',
                'manage_options',
                $dirName.'/page/index.php'
            );
            add_submenu_page(
                $dirName.'/page/index.php',
                'NoCake Forms - New form',
                'New form',
                'manage_options',
                $dirName.'/page/form-builder.php'
            );
            add_submenu_page(
                $dirName.'/page/index.php',
                'NoCake Forms - Submissions',
                'Submissions',
                'manage_options',
                $dirName.'/page/submissions.php'
            );
            add_submenu_page(
                $dirName.'/page/index.php',
                'NoCake Forms - Settings',
                'Settings',
                'manage_options',
                $dirName.'/page/settings.php'
            );
        });

        add_action('admin_head', function() use ($dirName) {
            remove_menu_page($dirName.'/page/delete.php');

            remove_submenu_page($dirName.'/page/index.php', $dirName.'/page/index.php');
            remove_submenu_page($dirName.'/page/index.php', $dirName.'/page/submission.php');

            if (!$this->isPro()) {
                remove_submenu_page($dirName.'/page/index.php', $dirName.'/page/submissions.php');
            }
        });
    }

    protected function initAdminGutenberg()
    {
        $me = $this;
        add_action('enqueue_block_editor_assets', function() use ($me) {
            $dir = \WP_DEBUG ? 'build' : 'dist';
            wp_enqueue_script(
                $name = $me->getPrefix().'-form-block',
                plugins_url('assets/'.$dir.'/js/admin/form-block.js', $this->pluginFile),
                ['wp-blocks', 'wp-element', 'wp-components', 'wp-editor', 'wp-data']
            );
            $me->localizeScript($name);
            wp_enqueue_style(
                $name = $me->getPrefix().'-form-block',
                plugins_url('assets/css/admin/form-block.css', $this->pluginFile)
            );
        });
    }

    public function localizeScript($name)
    {
        wp_localize_script($name, $this->getPrefix().'_data', [
            'siteUrl' => site_url(),
            'restUrl' => rest_url(),
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'pluginUrl' => plugin_dir_url($this->pluginFile),
            'nonce' => wp_create_nonce('wp_rest'),
            'prefix' => $this->getPrefix()
        ]);
    }

    protected function initAdminAssets()
    {
        $me = $this;
        // Load admin scripts.
        add_action('admin_enqueue_scripts', function($hook) use ($me) {
            $dir = WP_DEBUG ? 'build' : 'dist';
            $prefix = $me->getPrefix();
            $dirName = $this->getDirName();

            // Attach styles.
            if (strpos($hook, $dirName) !== false) {
                wp_enqueue_style(
                    $prefix.'-admin',
                    plugins_url('assets/css/admin/admin.css', $this->pluginFile)
                );
            }

            switch ($hook) {
                case $dirName.'/page/index.php':
                    wp_enqueue_script($name = $prefix.'-forms-page', plugins_url('assets/'.$dir.'/js/admin/forms-list.js', $this->pluginFile));
                    $me->localizeScript($name);
                    wp_enqueue_script($name = $prefix.'-support', plugins_url('assets/'.$dir.'/js/admin/support.js', $this->pluginFile));
                    $me->localizeScript($name);
                    break;
                case $dirName.'/page/form-builder.php':
                    foreach (scandir($this->getPluginDir().'/form-builder/assets/'.$dir.'/js') as $file) {
                        if ($file == '.' or $file == '..') {
                            continue;
                        }
                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                        if ($ext != 'js') {
                            continue;
                        }
                        if (strpos($file, 'form-builder-') !== false) {
                            $fileName = 'form-builder/assets/'.$dir.'/js/'.$file;
                            break;
                        }
                    }

                    wp_enqueue_script('underscore');
                    wp_enqueue_script($prefix.'-form-builder', plugins_url($fileName, $this->pluginFile));
                    wp_enqueue_script($name = $prefix.'-form-builder-page', plugins_url('assets/'.$dir.'/js/admin/form-builder.js', $this->pluginFile));
                    wp_enqueue_script($name = $prefix.'-support', plugins_url('assets/'.$dir.'/js/admin/support.js', $this->pluginFile));
                    $me->localizeScript($name);
                    break;
                case $dirName.'/page/submissions.php':
                    wp_enqueue_script($name = $prefix.'-submissions-page', plugins_url('assets/'.$dir.'/js/admin/submissions-list.js', $this->pluginFile));
                    $me->localizeScript($name);
                    wp_enqueue_script($name = $prefix.'-support', plugins_url('assets/'.$dir.'/js/admin/support.js', $this->pluginFile));
                    $me->localizeScript($name);
                    break;
                case $dirName.'/page/submission.php':
                case $dirName.'/page/settings.php':
                    wp_enqueue_script($name = $prefix.'-support', plugins_url('assets/'.$dir.'/js/admin/support.js', $this->pluginFile));
                    $me->localizeScript($name);
                    break;
            }
        });
    }

    /**
     * Handle form save request.
     */
    protected function formSaveRequest()
    {
        $me = $this;
        add_action('rest_api_init', function() use ($me) {
            register_rest_route($me->getPrefix().'/v1', 'form/save', [
                'methods' => 'POST',
                'callback' => function(\WP_REST_Request $request) use ($me) {
                    global $wpdb;
                    $post = $request->get_body_params();
                    if (isset($post['form'])) {
                        $form = @json_decode($post['form'], true);
                        if (json_last_error() !== JSON_ERROR_NONE) {
                            return new \WP_REST_Response(null, 500);
                        }

                        $id = isset($post['id']) ? $post['id'] : null;
                        if (!preg_match('/^\d+$/', (string) $id)) {
                            $id = null;
                        }

                        if ($id) {
                            $result = $wpdb->update($me->getDbTablePrefix('forms'), [
                                'uid' => $form['uuid'],
                                'name' => sanitize_text_field($form['name']),
                                'description' => sanitize_textarea_field($form['description']),
                                'definition' => json_encode($form),
                                'updated_at' => date('Y-m-d H:i:s')
                            ], ['id' => $id]);

                            if ($result) {
                                return new \WP_REST_Response(['id' => $id], 200);
                            } else {
                                return new \WP_REST_Response(['error' => true], 500);
                            }
                        } else {
                            $result = $wpdb->insert($me->getDbTablePrefix('forms'), [
                                'uid' => $form['uuid'],
                                'name' => sanitize_text_field($form['name']),
                                'description' => sanitize_textarea_field($form['description']),
                                'definition' => json_encode($form),
                                'created_at' => date('Y-m-d H:i:s')
                            ]);

                            if ($result) {
                                return new \WP_REST_Response(['id' => $wpdb->insert_id], 201);
                            } else {
                                return new \WP_REST_Response(['error' => true], 500);
                            }
                        }
                    }

                    return new \WP_REST_Response(null, 404);
                }
            ]);
        });
    }

    /**
     * Handle form delete request.
     */
    protected function formDeleteRequest()
    {
        $me = $this;
        $prefix = $this->getPrefix();
        add_action('wp_ajax_'.$prefix.'_delete_form', function() use ($me, $prefix) {
            global $wpdb;
            $id = (int) (isset($_GET['id']) ? $_GET['id'] : '');

            $nonce = isset($_GET['nonce']) ? $_GET['nonce'] : '';
            if (
                // Have permissions.
                current_user_can('manage_options') and
                // Nonce is ok.
                wp_verify_nonce($nonce, $prefix.'-form-'.$id)) {
                $wpdb->delete($me->getDbTablePrefix('forms'), ['id' => $id]);
                wp_send_json_success();
            }

            wp_send_json_error();

        });
    }

    /**
     * Handle get forms list request.
     */
    protected function formListRequest()
    {
        $me = $this;
        $prefix = $this->getPrefix();
        add_action('wp_ajax_'.$prefix.'_forms', function() use ($me) {
            global $wpdb;
            if (current_user_can('manage_options')) {
                $table = $me->getDbTablePrefix('forms');
                $result = $wpdb->get_results("
                    SELECT id, uid, name FROM `{$table}`
                    ORDER BY `id` DESC
                ", \ARRAY_A);

                wp_send_json_success($result);
            }
        });
    }

    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @return string
     */
    public function getBuyUrl()
    {
        return defined('NOCAKE_FORMS_BUY_URL') ? NOCAKE_FORMS_BUY_URL : $this->buyUrl;
    }

    /**
     * @return string
     */
    public function getContactUrl()
    {
        return defined('NOCAKE_CONTACT_URL') ? NOCAKE_CONTACT_URL : $this->contactUrl;
    }

    public function checkLicenseKey($key)
    {
        $url = defined('NOCAKE_FORMS_LICENSE_KEY_CHECK_URL') ? NOCAKE_FORMS_LICENSE_KEY_CHECK_URL : 'https://nocake.io/nocake-wp-forms/license/check';

        $response = wp_remote_post($url, [
            'headers'     => array('Content-Type' => 'application/json; charset=utf-8'),
            'body'        => json_encode([
                'key' => $key,
                'data' => [
                    'http_host' => isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '',
                    'hostname' => gethostname()
                ]
            ]),
            'method'      => 'POST',
            'data_format' => 'body',
            'timeout'     => 20
        ]);

        if (is_wp_error($response)) {
            $this->setOptions(['license_key' => $key]);
            $this->licenseKey = $key;
            return true;
        } else {
            $response = $response['http_response'];

            switch ($response->get_status()) {
                default:
                case 200:
                    $this->setOptions(['license_key' => $key]);
                    $this->licenseKey = $key;
                    return true;
                    break;
                case 400:
                    $data = json_decode($response->get_data(), true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $this->setOptions(['license_key' => $key]);
                        $this->licenseKey = $key;
                        return true;
                    }
                    $this->setOptions(['license_key' => null]);
                    return ['error' => isset($data['error']) ? $data['error'] : 'Unknown license error.'];
                    break;
            }
        }

        return false;
    }

    public function setOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
        update_option($this->getPrefix(), $this->options);
    }

    /**
     * @return bool Return true if user bought pro version.
     */
    public function isPro()
    {
        return !empty($this->licenseKey);
    }

    public function dropDbTables()
    {
        global $wpdb;

        $prefix = $this->getDbTablePrefix();
        $wpdb->query("DROP TABLE IF EXISTS `{$prefix}forms`");
        $wpdb->query("DROP TABLE IF EXISTS `{$prefix}submissions`");
        $wpdb->query("DROP TABLE IF EXISTS `{$prefix}submission_value`");
    }
}
