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
      
  }
  return $message;
} // perform_updates