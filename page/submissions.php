<?php

$ncf = nocake_forms();

$formsTable = $ncf->getDbTablePrefix('forms');

// Find all forms.
$forms = $wpdb->get_results("
        SELECT * FROM `{$formsTable}`
        ORDER BY `name` DESC
    ", \ARRAY_A);

if (!empty($forms)) {
    // Find selected form.
    $formId = (int) (isset($_GET['form_id']) ? $_GET['form_id'] : $forms[0]['id']);
    $form = $ncf->getForm($formId);

    if ($form) {
        $form = $ncf->createFormInstance($form);

        $table = $ncf->getDbTablePrefix('submissions');

        $currentPage = isset($_GET['paged']) ? (int) $_GET['paged'] : 1;
        $perPage = 20;
        $offset = ($currentPage-1) * $perPage;
        $count = (int) $wpdb->get_col(sprintf("SELECT COUNT(*) FROM `{$table}` WHERE form_id = %d", $formId))[0];
        $totalPages = ceil($count / $perPage);

        $items = $wpdb->get_results(sprintf("
            SELECT * FROM `{$table}` 
            WHERE form_id = %d   
            ORDER BY `id` DESC    
            LIMIT {$offset}, {$perPage}
        ", $formId), \ARRAY_A);

        // Get controls to display in table.
        $cols = [];
        $colsIds = [];
        foreach ($form->getControls() as $ctrl) {
            if ($ctrl->isOnList()) {
                $cols[] = $ctrl;
                $colsIds[] = $ctrl->getUid();
            }
        }

        if ($items and $cols) {
            $subIds = [];
            foreach ($items as $item) {
                $subIds[] = $item['id'];
            }

            $table = $ncf->getDbTablePrefix('submissions_values');
            $values = $wpdb->get_results("
                SELECT submission_id, control_id, value FROM `{$table}`
                WHERE 
                    submission_id IN (".implode(',', $subIds).") AND
                    control_id IN ('".implode('\', \'', $colsIds)."')
            ", \ARRAY_A);

            $arr = [];
            foreach ($values as $value) {
                $arr[$value['submission_id']][$value['control_id']] = $value['value'];
            }

            $_items = [];
            foreach ($items as $key => $item) {
                $values = isset($arr[$item['id']]) ? $arr[$item['id']] : [];

                foreach ($values as $controlId => $value) {
                    $ctrl = $form->getControlByUid($controlId);
                    $item['controls'][$controlId] = $value;
                }

                $_items[] = $item;
            }

            $items = $_items;
        }

        $baseUrl = '?page='.nocake_forms('dirName').'/page/submissions.php&form_id='.$formId;
    }
}

?>
<div class="wrap">
    <?php include 'partials/topbar.php' ?>
    <h1 class="wp-heading-inline">Submissions</h1>
    <a href="<?php echo admin_url('admin.php?page='.nocake_forms('dirName').'/page/index.php') ?>" class="page-title-action">Back to forms</a>
    <br/><br/>
    <select class="js-ncforms-submissions-select-form">
        <?php foreach ($forms as $f) { ?>
            <option
                <?php echo $f['id'] == $formId ? 'selected' : '' ?>
                value="<?php echo admin_url('admin.php?page='.nocake_forms('dirName').'/page/submissions.php&form_id='.$f['id']) ?>"><?php echo $f['name'] ?></option>
        <?php } ?>
    </select>
    <hr class="wp-header-end">
    <br>
    <?php
        if (empty($forms)) {
            echo '<div class="ncforms-submissions-list-error">No forms added</div>';
        } else {
            if (!isset($form)) {
                echo '<div class="ncforms-submissions-list-error">Form does not exists.</div>';
            }
        }
    ?>

    <?php if (isset($form)) { ?>
        <?php if (!$ncf->isPro()) { ?>
            <?php
            $what = 'Form submissions';
            include __DIR__.'/partials/pro-notice.php'
            ?>
        <?php } else { ?>
            <div class="tablenav top">
                <?php ob_start(); ?>
                <div class="tablenav-pages">
                    <span class="displaying-num"><?php echo $count ?> items</span>
                    <span class="pagination-links">
                    <?php /* 7 PREV LINK */ ?>
                        <?php $active = ($currentPage - 7) > 0 ?>
                        <?php if ($active) { ?>
                        <a class="prev-page button" href="<?php echo admin_url($baseUrl.'&paged='.($currentPage-7)) ?>">
                    <?php } ?>
                    <span class="<?php echo !$active ? 'tablenav-pages-navspan button disabled' : '' ?>">«</span>
                    <?php if ($active) { ?>
                        </a>
                    <?php } ?>

                        <?php /* 1 PREV LINK */ ?>
                        <?php $active = ($currentPage - 1) > 0 ?>
                        <?php if ($active) { ?>
                        <a class="prev-page button" href="<?php echo admin_url($baseUrl.'&paged='.($currentPage-1)) ?>">
                    <?php } ?>
                    <span class="<?php echo !$active ? 'tablenav-pages-navspan button disabled' : '' ?>">‹</span>
                    <?php if ($active) { ?>
                        </a>
                    <?php } ?>

                    <span class="paging-input">
                        <label for="current-page-selector" class="screen-reader-text">Current page</label>
                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="<?php echo $currentPage ?>" size="1" aria-describedby="table-paging">
                        <span class="tablenav-paging-text"> z <span class="total-pages"><?php echo $totalPages ?></span>
                        </span>
                    </span>
                    <?php /* 1 NEXT LINK */ ?>
                        <?php $active = ($currentPage + 1) <= $totalPages ?>
                        <?php if ($active) { ?>
                        <a class="tablenav-pages-navspan next-page button" href="<?php echo admin_url($baseUrl.'&paged='.($currentPage+1)) ?>">
                    <?php } ?>
                        <span class="<?php echo !$active ? 'tablenav-pages-navspan button disabled' : '' ?>">›</span>
                    <?php if ($active) { ?>
                        </a>
                    <?php } ?>

                        <?php /* 7 NEXT LINK */ ?>
                        <?php $active = ($currentPage + 7) <= $totalPages ?>
                        <?php if ($active) { ?>
                        <a class="tablenav-pages-navspan button last-page button" href="<?php echo admin_url($baseUrl.'&paged='.($currentPage+7)) ?>">
                    <?php } ?>
                        <span class="<?php echo !$active ? 'tablenav-pages-navspan button disabled' : '' ?>">»</span>
                    <?php if ($active) { ?>
                        </a>
                    <?php } ?>
                </span>
                </div>
                <br class="clear">
                <?php
                    $pagination = ob_get_contents();
                    ob_end_clean();
                    echo $pagination;
                ?>
            </div>
            <table class="wp-list-table widefat fixed striped" cellspacing="0">
                <thead>
                <tr>
                    <th>Id</th>
                    <?php foreach ($cols as $ctrl) { ?>
                        <th><?php echo $ctrl->getName() ?></th>
                    <?php } ?>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php if ($items) { ?>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td>
                                <strong><a class="row-title" href="<?php echo admin_url('admin.php?page='.$ncf->getDirName().'/page/submission.php&id='.$item['id']) ?>"><?php echo $item['id'] ?></a></strong>
                            </td>
                            <?php foreach ($cols as $ctrl) { ?>
                                <td>
                                    <?php
                                        $value = isset($item['controls'][$ctrl->getUid()]) ? json_decode($item['controls'][$ctrl->getUid()]) : '';

                                        switch ($ctrl->getType()) {
                                            case 'file':
                                                foreach ($value as $file) {
                                                    $url = $ncf->getFormsAttachmentsUrl($form->getUid(), $file->file_name);

                                                    echo '<a href="'.$url.'" target="_blank">'.$file->original_name.'</a>';
                                                }


                                                break;
                                            case 'checkbox':
                                            case 'radio':
                                            case 'select':
                                                echo esc_html(implode(', ', (array) $value));
                                                break;
                                            default:
                                                echo $value;
                                                break;
                                        }
                                    ?>
                                </td>
                            <?php } ?>
                            <td style="text-align: right;">
                                <div class="row-actions" style="left: 0;">
                                    <span class="edit"><a href="<?php echo admin_url('admin.php?page='.$ncf->getDirName().'/page/submission.php&id='.$item['id']) ?>">Edit</a> |</span>
                                    <span class="trash"><a href="#" class="js-<?php echo $ncf->getPrefix() ?>-delete-submission" data-id="<?php echo $item['id'] ?>" data-nonce="<?php echo wp_create_nonce($ncf->getPrefix().'-submission-'.$item['id']) ?>">Delete</a></span>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="<?php echo (2 + count($cols)) ?>">No submissions yet.</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div class="tablenav bottom">
                <?php echo $pagination ?>
            </div>
        <?php } ?>
    <?php } ?>
</div>