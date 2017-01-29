<?php
global $db;
$head_page_title = "Update happy web";

// get "current update" value
if ($index = $db->get_var("SELECT value FROM settings WHERE name='current_update'")) {
  $current_update = $index;
}
else {
  $current_update = 0;
  $db->query("INSERT INTO settings (name, value) VALUES ('current_update', 0)");
}

// perform all outstanding updates
$index = $current_update + 1;
$update_message = perform_update($index);

if ($update_message == "") {
  print "<p>No updates are required - you're all up to date!</p>";
}
else {
  print $update_message;
}
?>

<p><a href="/admin">Back to admin</a></p>


<?php
function perform_update($index) {
  global $db;
  $message = "";
  switch($index) {
    
    // Add description field to images
    case 1:
      $db->query("ALTER TABLE `widget_image` ADD `description` MEDIUMTEXT NOT NULL DEFAULT '' AFTER `size`;");
      $message .= "<p>Added description to images</p>";
      increment_update();
    
    // add id to settings
    case 2:
      $db->query("ALTER TABLE `settings` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);");
      $message .= "<p>Added ID field to settings</p>";
      increment_update();
      
    // Add thumbnail widget
    case 3:
      $db->query("CREATE TABLE IF NOT EXISTS `widget_thumbnail` (`widget_id` int(11) NOT NULL, `file` varchar(400) NOT NULL, `heading` varchar(400) NOT NULL, `text` mediumtext NOT NULL, `url` varchar(400) NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"); 
      $message .= "<p>Added thumbnail widget</p>";
      increment_update();
      
    // Add popup option for videos
    case 4:
      $db->query("ALTER TABLE `widget_video` ADD `popup` INT(2) NOT NULL DEFAULT '0' AFTER `video_description`;"); 
      $message .= "<p>Added popup option for videos</p>";
      increment_update();
      
    // Add padding options for rows
    case 5:
      $db->query("ALTER TABLE `settings` DROP `id`;");
      $db->query("ALTER TABLE `settings` ADD UNIQUE(`name`);");
      $db->query("ALTER TABLE `row` ADD `no_padding` INT(2) NOT NULL DEFAULT '0' AFTER `heading`;");
      $message .= "<p>Added padding options for rows</p>";
      increment_update();
    
    // Rename "thumbnail" widget to "image link"
    case 6:
      $db->query("RENAME TABLE `widget_thumbnail` TO `widget_imagelink`;");
      $db->query("UPDATE widget SET type='imagelink' WHERE type='thumbnail';");
      $message .= "<p>Renamed 'thumbnail' into 'widget_link'</p>";
      increment_update();
    
    // Add slideshow widget
    case 7:
      $db->query("CREATE TABLE IF NOT EXISTS `widget_slideshow` (`widget_id` int(11) NOT NULL, `filenames` mediumtext NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;"); 
      $db->query("ALTER TABLE `widget_slideshow` ADD UNIQUE KEY `widget_id` (`widget_id`);");
      $message .= "<p>Added slideshow widget</p>";
      increment_update();    
    
    // Add quote widget
    case 8:
      $db->query("CREATE TABLE IF NOT EXISTS `widget_quote` (`widget_id` int(11) NOT NULL, `text` mediumtext NOT NULL, `author` varchar(400) NOT NULL DEFAULT '') ENGINE=InnoDB DEFAULT CHARSET=latin1;"); 
      $db->query("ALTER TABLE `widget_quote` ADD UNIQUE KEY `widget_id` (`widget_id`);");
      $message .= "<p>Added quote widget</p>";
      increment_update(); 
      
    // Add audio widget
    case 9:
      $db->query("CREATE TABLE IF NOT EXISTS `widget_audio` (`widget_id` int(11) NOT NULL, `file` varchar(400) NOT NULL DEFAULT '', `title` varchar(400) NOT NULL DEFAULT '', `description` mediumtext NOT NULL DEFAULT '') ENGINE=InnoDB DEFAULT CHARSET=latin1;"); 
      $db->query("ALTER TABLE `widget_audio` ADD UNIQUE KEY `widget_id` (`widget_id`);");
      $message .= "<p>Added audio widget</p>";
      increment_update(); 
      
    // Add center heading options for rows
    case 10:
      $db->query("ALTER TABLE `row` ADD `center_heading` INT(2) NOT NULL DEFAULT '0' AFTER `no_padding`;");
      $message .= "<p>Added center heading options for rows</p>";
      increment_update();
    
    // Add browser title for page
    case 11:
      $db->query("ALTER TABLE `page` ADD `browser_title` VARCHAR(400) NOT NULL DEFAULT '' AFTER `description`;");
      $message .= "<p>Added browser title options for pages</p>";
      increment_update();
      
    // Add right alignment option for images
    case 12:
      $db->query("ALTER TABLE `widget_image` ADD `align_right` INT(2) NOT NULL DEFAULT '0' AFTER `description`;");
      $message .= "<p>Added right alignment option for images</p>";
      increment_update();
    
    // Add "disable slideshow" option for slideshow
    case 13:
      $db->query("ALTER TABLE `widget_slideshow` ADD `disable_slideshow` INT(2) NOT NULL DEFAULT '0' AFTER `filenames`;");
      $message .= "<p>Added \"disable slideshow\" option for slideshow</p>";
      increment_update();
    
    // Add "left/right/center" image alignment options
    case 14:
      $db->query("ALTER TABLE `widget_image` CHANGE `align_right` `align` VARCHAR(400) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '';");
      $db->query("UPDATE widget_image SET align='right' WHERE align='1'");
      $db->query("UPDATE widget_image SET align='left' WHERE align='' OR align='0'");
      $message .= "<p>Added \"left/right/center\" image alignment options</p>";
      increment_update();
      
    // Cleaned some of the data model
    case 15:
      // change rows
      $db->query("ALTER TABLE `row` CHANGE `display_order` `row_index` INT(2) NOT NULL DEFAULT '0';");
      // change columns
      $db->query("ALTER TABLE `col` CHANGE `display_order` `col_index` INT(2) NOT NULL DEFAULT '0';");
      $db->query("ALTER TABLE `col` DROP `number_of_widgets`;");
      // change widgets
      $db->query("ALTER TABLE `widget` CHANGE `display_order` `widget_index` INT(2) NOT NULL DEFAULT '0';");
      $message .= "<p>cleaned some of the data model</p>";
      increment_update();

  }
  return $message;
} // perform_updates