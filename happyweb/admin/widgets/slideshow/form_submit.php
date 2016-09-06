<?php
$filenames = (isset($_POST["filenames"]))?$db->escape($_POST["filenames"]):"";

if ($action == "create") {
  $db->query("INSERT INTO widget_slideshow (widget_id, filenames) VALUES (".$widget_id.", '".$filenames."')");
}
else {
  $db->query("UPDATE widget_slideshow SET filenames='".$filenames."' WHERE widget_id=".$widget_id);
}