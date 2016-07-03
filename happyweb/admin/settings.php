<?php
$head_page_title = "Super settings";
$display_navigation = true;
if (isset($_POST["action"])) {
  
  $site_name = $db->escape($_POST["site_name"]);
  $db->query("UPDATE settings SET value='".$site_name."' WHERE name='site_name'");
  $theme = $_POST["theme"];
  $db->query("UPDATE settings SET value='".$theme."' WHERE name='theme'");
  set_message('The settings have been updated!');
  redirect('admin/settings');
  
}   
?>

<p class="help"><i class="material-icons">info_outline</i>Some settings for your website.<br />Most of the time you can safely ignore this page, it's already been set up for you!</p>

<form action="<?php print $url_info["path"];?>" method="post">
  
  <div class="form-item">
    <label>Site name:</label>
    <?php $site_name = $db->get_var("SELECT value FROM settings WHERE name='site_name'"); ?>
    <input type="text" class="text" name="site_name" placeholder="The name of the site" value="<?php print $site_name; ?>" required />
  </div>
  
  <div class="form-item">
    <label>Theme:</label>
    <select name="theme">
      <?php
      $current_theme = $db->get_var("SELECT value FROM settings WHERE name='theme'");
      $selected = ($current_theme == "basic")?"selected":"";
      ?>
      <option value="basic" <?php print $selected; ?>>Basic</option>
      <?php
      $themes = array_diff(scandir("custom_themes"), array('..', '.', 'readme.txt'));
      foreach($themes as $theme) {
        $selected = ($current_theme == $theme)?"selected":"";
        ?>
        <option value="<?php print $theme; ?>" <?php print $selected; ?>><?php print $theme; ?></option>
      <?php } ?>
    </select>
  </div>
  
  <input type="submit" class="submit" value="Save" />
  <input type="hidden" name="action" value="save_settings" />
  
</form>
