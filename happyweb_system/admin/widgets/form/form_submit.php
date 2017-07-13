<?php
$email_from = (isset($_POST["email_from"]))?$db->escape($_POST["email_from"]):"";
$name_from = (isset($_POST["email_from"]))?$db->escape($_POST["name_from"]):"";
$email_to = (isset($_POST["email_to"]))?$db->escape($_POST["email_to"]):"";
$submit_text = (isset($_POST["submit_text"]))?$db->escape($_POST["submit_text"]):"";
$message = (isset($_POST["message"]))?$db->escape($_POST["message"]):"";

if ($action == "create") {
  $db->query("INSERT INTO widget_form (widget_id, name_from, email_from, email_to, submit_text, message) VALUES (".$widget_id.", '".$name_from."', '".$email_from."', '".$email_to."', '".$submit_text."', '".$message."')");
}
else {
  $db->query("UPDATE widget_form SET name_from='".$name_from."', email_from='".$email_from."', email_to='".$email_to."', submit_text='".$submit_text."', message='".$message."' WHERE widget_id=".$widget_id);
}
?>