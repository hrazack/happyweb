<?php
$action = $_POST["action"];
if ($action == "edit") {
  // editing a widget
  $widget_id = $_POST["widget_id"];
  $widget = $db->get_row("SELECT * FROM widget WHERE id=".$widget_id);
  $widget_type = $widget->type;
  $data = $db->get_row("SELECT * FROM widget_".$widget->type." WHERE widget_id=".$widget->id);
}
else {
  // creating a new widget
  $widget_type = $_POST["widget_type"];
  $col_id = $_POST["col_id"];
  $widget_index = $_POST["widget_index"];
}
?>

<form name="widget" enctype="multipart/form-data" method="post">

<?php
include($_SERVER["DOCUMENT_ROOT"]."/happyweb_system/admin/widgets/".$widget_type."/form.php");
?>

<?php
if ($action == "create") { ?>
<input type="hidden" name="widget_type" value="<?php print $widget_type; ?>" />
<input type="hidden" name="col_id" value="<?php print $col_id; ?>" />
<input type="hidden" name="widget_index" value="<?php print $widget_index; ?>" />
<?php } else { ?>
<input type="hidden" name="widget_id" value="<?php print $widget->id; ?>" />
<?php } ?>

<input type="hidden" name="action" value="<?php print $action; ?>" />
</form>