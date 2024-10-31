<?php

$ncf = nocake_forms();

$licenseKey = $ncf->getOption('license_key');
$licenseKeyError = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['license_key']) and $_POST['license_key']) {
        $licenseKey = sanitize_key(wp_unslash($_POST['license_key']));
        if (!preg_match('/^[-a-z0-9]{36}$/i', $licenseKey)) {
            $licenseKeyError = 'It is not a valid license key.';
        }

        if (!$licenseKeyError) {
            $result = $ncf->checkLicenseKey($licenseKey);
            if (is_array($result)) {
                $licenseKeyError = $result['error'];
            }
        }
    }
}

?>
<div class="wrap">
    <?php include 'partials/topbar.php' ?>
  <br>
  <h1>NoCake Forms settings</h1>
  <form method="post">
    <h2 class="title">License</h2>
    <?php if (!$ncf->isPro()) { ?>
      <p>If you need additional functionallities such as viewing submissions straight in the Wordpress admin panel or
        extra form controls we encourage you to buy a license key and activate NoCake WP Forms Pro.</p>
      <a href="<?php echo $ncf->getBuyUrl() ?>" class="ncforms-buy-btn" target="_blank">Buy Licence Key</a><br><br>

    <?php } else { ?>
      <table class="form-table">
        <tr>
          <td colspan="2" style="padding: 0;"><p style="border: 1px solid #00a700;
  padding: 10px;
  color: #00c600;
  font-weight: bold;">You are using NoCake Pro version.</p></td>
        </tr>
      </table>
    <?php } ?>

    <table class="form-table">
      <tr>
        <th scope="row"><label for="ncforms_key">License key</label></th>
        <td>
          <input name="license_key" type="text" id="ncforms_key" value="<?php echo $licenseKey ?>"
                 class="regular-text">
            <?php if ($licenseKeyError) { ?>
              <div class="ncforms-input-error"><?php echo $licenseKeyError ?></div>
            <?php } ?>
        </td>
      </tr>
    </table>

    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
    </p>
  </form>
</div>
