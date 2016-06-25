<?php
$text = $db->escape($_GET["text"]);

if ($action == "create") {
  $db->query("INSERT INTO widget_text (widget_id, text) VALUES (".$widget_id.", '".$text."')");
}
else {
  $db->query("UPDATE widget_text SET text='".$text."' WHERE widget_id=".$widget_id);
}
?>