<?php
$filename = (isset($_POST["filename"]))?$db->escape($_POST["filename"]):"";

if ($action == "create") {
  $db->query("INSERT INTO widget_code (widget_id, filename) VALUES (".$widget_id.", '".$filename."')");
}
else {
  $db->query("UPDATE widget_code SET filename='".$text."' WHERE widget_id=".$widget_id);
}
?>