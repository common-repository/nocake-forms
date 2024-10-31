<?php

$ncf = nocake_forms();
$table = $ncf->getDbTablePrefix('forms');
$items = $wpdb->get_results("
    SELECT * FROM `{$table}`
    ORDER BY `id` DESC
", \ARRAY_A);
?>
<div class="wrap">
    <?php include 'partials/topbar.php' ?>
    <h1 class="wp-heading-inline">Forms</h1>
    <a href="<?php echo admin_url('admin.php?page='.$ncf->getDirName().'/page/form-builder.php') ?>" class="page-title-action">Create new form</a>
    <hr class="wp-header-end">
    <br>
    <table class="widefat fixed" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 40px">Id</th>
                <th>Name</th>
                <th>Description</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($items) { ?>
                <?php foreach ($items as $item) { ?>
                    <?php
                        $formDef = json_decode($item['definition'], true);
                        if (json_last_error() !== \JSON_ERROR_NONE) {
                            $formDef = [];
                        }
                    ?>
                    <tr>
                        <td><?php echo $item['id'] ?></td>
                        <td>
                            <strong><a class="row-title" href="<?php echo admin_url('admin.php?page='.$ncf->getDirName().'/page/form-builder.php&id='.$item['id']) ?>"><?php echo $item['name'] ?></a></strong>
                        </td>
                        <td><?php echo esc_html($item['description']) ?></td>
                        <td>
                            <a href="<?php echo admin_url('admin.php?page='.$ncf->getDirName().'/page/submissions.php&form_id='.$item['id']) ?>">Submissions</a>
                        </td>
                        <td>
                            <div class="row-actions" style="left: 0;">
                                <span class="edit"><a href="<?php echo admin_url('admin.php?page='.$ncf->getDirName().'/page/form-builder.php&id='.$item['id']) ?>">Edit</a> |</span>
                                <span class="trash"><a href="#" class="js-<?php echo $ncf->getPrefix() ?>-delete-form" data-id="<?php echo $item['id'] ?>" data-nonce="<?php echo wp_create_nonce($ncf->getPrefix().'-form-'.$item['id']) ?>">Delete</a></span>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="3">No forms found.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
