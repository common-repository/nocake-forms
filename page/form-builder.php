<?php

$ncf = nocake_forms();
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$value = null;
if (preg_match('/^\d+$/', (string) $id)) {
    $value = $ncf->getForm($id);
}
?>

<?php if (is_array($value)) { ?>
    <script>
        ncforms_data.id = <?php echo $value['id'] ?>;
        ncforms_data.value = <?php echo json_encode($value['definition']) ?>;
    </script>
<?php } ?>

<div class="wrap">
    <?php include 'partials/topbar.php' ?>
    <div class="ncforms-form-header">
        <div>
            <h1 class="wp-heading-inline">Form builder</h1>
            <a href="<?php echo admin_url('admin.php?page='.nocake_forms('dirName').'/page/index.php') ?>" class="page-title-action">Back</a>
        </div>
        <a href="#" class="js-<?php echo $ncf->getPrefix() ?>-delete-form page-title-action ncform-form-delete" data-id="<?php echo $value['id'] ?>" data-nonce="<?php echo wp_create_nonce($ncf->getPrefix().'-form-'.$value['id']) ?>" data-redirect-url="<?php echo admin_url('admin.php?page='.nocake_forms('dirName').'/page/index.php') ?>">Delete form</a>
    </div>
    <hr class="wp-header-end">
    <div id="ncforms-form-builder"></div>
</div>
