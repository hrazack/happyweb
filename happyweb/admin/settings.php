<?php
$head_page_title = "Super settings";
$display_navigation = true;
if (isset($_POST["action"])) {
  
  update_setting("site_name", $db->escape($_POST["site_name"]));
  update_setting("footer_text", $db->escape($_POST["footer_text"]));
  update_setting("side_nav_heading", $db->escape($_POST["side_nav_heading"]));
  update_setting("theme", $_POST["theme"]);
  set_message('The settings have been updated!');
  redirect('admin/settings');
  
}   
?>

<p class="help"><i class="material-icons">info_outline</i>Some settings for your website.<br />Most of the time you can safely ignore this page, it's already been set up for you!</p>

<form action="<?php print $url_info["path"];?>" method="post">
  
  <div class="form-item">
    <label>Site name:</label>
    <input type="text" class="text" name="site_name" placeholder="The name of the site" value="<?php print get_setting("site_name"); ?>" required />
  </div>
  
  <div class="form-item">
    <label>Text in the footer:</label>
    <input type="text" class="text" name="footer_text" placeholder="The text at the bottom of each page" value="<?php print get_setting("footer_text"); ?>" />
  </div>
  
  <div class="form-item">
    <label>Text above the side navigation:</label>
    <input type="text" class="text" name="side_nav_heading" placeholder="The text displayed above the side navigation" value="<?php print get_setting("side_nav_heading"); ?>" />
  </div>
  
  <div class="form-item">
    <label>Theme:</label>
    <select name="theme">
      <?php
      $current_theme = get_setting("theme");
      $selected = ($current_theme == "basic")?"selected":"";
      ?>
      <option value="basic" <?php print $selected; ?>>Basic</option>
      <?php
      $themes = array_diff(scandir("your_site/themes"), array('..', '.', 'readme.txt'));
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
