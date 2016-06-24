<?php
$action = $_GET["action"];
if ($action == "edit") {
  // editing a widget
  $widget_id = $_GET["widget_id"];
  $widget = $db->get_row("SELECT * FROM widget WHERE id=".$widget_id);
  $widget_type = $widget->type;
  $data = $db->get_row("SELECT * FROM widget_".$widget->type." WHERE widget_id=".$widget->id);
}
else {
  // creating a new widget
  $widget_type = $_GET["widget_type"];
  $col_id = $_GET["col_id"];
  $display_order = $_GET["display_order"];
  $index_row = $_GET["index_row"];
  $index_col = $_GET["index_col"];
}
?>

<form name="widget" enctype="multipart/form-data">

<?php
include($_SERVER["DOCUMENT_ROOT"]."/happyweb/admin/widgets/".$widget_type."/form.php");
?>

<?php
if ($action == "create") { ?>
<input type="hidden" name="display_order" value="<?php print $display_order; ?>" />
<input type="hidden" name="col_id" value="<?php print $col_id; ?>" />
<input type="hidden" name="widget_type" value="<?php print $widget_type; ?>" />
<input type="hidden" name="index_row" value="<?php print $index_row; ?>" />
<input type="hidden" name="index_col" value="<?php print $index_col; ?>" />
<?php } else { ?>
<input type="hidden" name="widget_id" value="<?php print $widget->id; ?>" />
<?php } ?>

<input type="hidden" name="action" value="<?php print $action; ?>" />
</form>