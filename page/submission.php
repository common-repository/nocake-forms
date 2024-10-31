<?php
    $id = (int) isset($_GET['id']) ? $_GET['id'] : '';

    $ncf = nocake_forms();
    $sub = $ncf->getSubmission($id);
    if (!$sub) {
        exit('Submission does not exists.');
    }

    $form = $ncf->getForm($sub['form_id']);
    if (!$form) {
        exit('Form does not exists.');
    }
    $form = $ncf->createFormInstance($form);

    $table = $ncf->getDbTablePrefix('submissions_values');
    $rows = $wpdb->get_results(sprintf("
            SELECT control_id, value FROM `{$table}`
            WHERE submission_id = '%d'
        ", $id), \ARRAY_A);

    $values = [];
    foreach ($rows as $row) {
        $values[$row['control_id']] = $row['value'];
    }
    unset($rows);
?>
<div class="wrap">
    <?php include 'partials/topbar.php' ?>
    <h2 style="margin-bottom: -5px; text-transform: uppercase; color: gray; font-size: 1.1em;"><?php echo $form->getName() ?></h2>
    <h1 class="wp-heading-inline">Submission #<?php echo $id ?></h1>
    <a href="<?php echo admin_url('admin.php?page='.nocake_forms('dirName').'/page/submissions.php&form_id='.$sub['form_id']) ?>" class="page-title-action">Back</a>
    <hr class="wp-header-end">
    <br>

    <table class="wp-list-table widefat fixed striped">
        <tr>
            <th style="width: 20%;"><strong>Field name</strong></th>
            <th><strong>Value</strong></th>
        </tr>
        <?php foreach ($form->getControls() as $ctrl) { ?>
            <?php if ($ctrl->getType() == 'cnt') continue; ?>
            <tr>
                <th><?php echo $ctrl->getName() ?></th>
                <td>
                    <?php
                        $value = isset($values[$ctrl->getUid()]) ? $values[$ctrl->getUid()] : '';
                        $value = json_decode((string)$value, true);
                        if (json_last_error() !== \JSON_ERROR_NONE) {
                            $value = null;
                        }

                        switch ($ctrl->getType()) {
                            case 'file':
                                foreach ($value as $file) {
                                    $url = $ncf->getFormsAttachmentsUrl($form->getUid(), $file['file_name']);
                                    if (\NoCake\FormBuilder\Control\File::isDisplayableFile($ncf->getFormsAttachmentsDir($form->getUid()).'/'.$file['file_name'])) {
                                        echo '<img src="'.$url.'">';
                                    } else {
                                        echo '<a href="'.$url.'" target="_blank">'.$file['original_name'].'</a>';
                                    }
                                }
                                break;
                            case 'checkbox':
                            case 'radio':
                                echo esc_html(implode(', ', (array) $value));
                                break;
                            default:
                                echo esc_html($value);
                                break;
                        }

                    ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <p>
        <strong>User agent:</strong> <?php echo esc_html($sub['user_agent']) ?> <br>
        <strong>IP:</strong> <?php echo esc_html($sub['ip']) ?>
    </p>
</div>