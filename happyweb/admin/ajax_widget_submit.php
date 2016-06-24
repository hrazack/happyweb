<?php
$action = $_GET["action"];
if ($action == "edit") {
  $widget_id = $_GET["widget_id"];
}
else {
  $widget_type = $_GET["widget_type"];
  $col_id = $_GET["col_id"];
  $display_order = $_GET["display_order"];
  $index_row = $_GET["index_row"];
  $index_col = $_GET["index_col"];
  $index_widget = $display_order;
  // save widget
  $db->query("INSERT INTO widget (col_id, display_order, type) VALUES (".$col_id.", ".$display_order.", '".$widget_type."')");
  $widget_id = $db->insert_id;
}

$data = new stdClass();
$data->action = $action;
$widget = $db->get_row("SELECT * FROM widget WHERE id=".$widget_id);

// save widget data
include($_SERVER["DOCUMENT_ROOT"]."/happyweb/admin/widgets/".$widget->type."/form_submit.php");

if ($action == "create") {
  // get full widget box
  ob_start();
  require('inc_form_widget.php');
  $data->widget_box = ob_get_contents();
  ob_end_clean();
}
else {
  // get widget overview
  $data->widget_overview = build_widget_overview($widget);
}

print json_encode($data);

?>