<?php
/*
Plugin Name: NoCake Forms
Plugin URI:  https://nocake.io/nocake-wp-forms
Description: Easy to use visual Form Builder.
Version: 1.2.1
Author: <a href="https://nocake.io">NoCake</a>
Author UI: https://nocake.io
Text Domain: ncforms
Domain Path: /languages
Requires PHP: 5.4
Requires at least: 5.2
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // don't access directly
}

// Register form builder autoloader.
require_once __DIR__.'/form-builder/php/autoloader.php';
// Require plugin main class.
require_once __DIR__.'/src/php/Forms.php';

register_activation_hook(__FILE__, 'nocake_forms_activation_hook');
register_uninstall_hook(__FILE__, 'nocake_forms_uninstall_hook');

// Create instance of plugin class.
nocake_forms();

/**
 * @return \NoCake\Forms
 */
function nocake_forms($param = null) {
    $instance = \NoCake\Forms::getInstance();

    if ($param) {
        if ($param == 'pro') {
            return $instance->isPro();
        }

        return $instance->{'get'.ucfirst($param)}();
    }

    return $instance;
}

function nocake_forms_activation_hook()
{
    flush_rewrite_rules();
}
function nocake_forms_uninstall_hook()
{
    \NoCake\Forms::getInstance()->dropDbTables();
}