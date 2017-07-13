<?php
$filenames = (isset($_POST["filenames"]))?$db->escape($_POST["filenames"]):"";
$disable_slideshow = (isset($_POST["disable_slideshow"]))?1:0;

if ($action == "create") {
  $db->query("INSERT INTO widget_slideshow (widget_id, filenames, disable_slideshow) VALUES (".$widget_id.", '".$filenames."', ".$disable_slideshow.")");
}
else {
  $db->query("UPDATE widget_slideshow SET filenames='".$filenames."', disable_slideshow=".$disable_slideshow." WHERE widget_id=".$widget_id);
}