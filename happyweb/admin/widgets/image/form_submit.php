<?php
//$file = $_GET["file"];
$file = "yay, an image!";
if ($action == "create") {
  $db->query("INSERT INTO widget_image (widget_id, file) VALUES (".$widget_id.", '".$file."')");
}
else {
  //$db->query("UPDATE widget_text SET text='".$text."' WHERE widget_id=".$widget_id);
}
?>