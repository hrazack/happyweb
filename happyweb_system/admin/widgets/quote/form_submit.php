<?php
$text = (isset($_POST["text"]))?$db->escape($_POST["text"]):"";
$author = (isset($_POST["author"]))?$db->escape($_POST["author"]):"";

if ($action == "create") {
  $db->query("INSERT INTO widget_quote (widget_id, text, author) VALUES (".$widget_id.", '".$text."', '".$author."')");
}
else {
  $db->query("UPDATE widget_quote SET text='".$text."', author='".$author."' WHERE widget_id=".$widget_id);
}
?>