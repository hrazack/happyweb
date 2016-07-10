<?php

/**
 * updates the value of a setting
 */
function update_setting($name, $value) {
  global $db;
  if ($db->get_var("SELECT name FROM settings WHERE name='".$name."'")) {
    $db->query("UPDATE settings SET value='".$value."' WHERE name='".$name."'");
  }
  else {
    $db->query("INSERT INTO settings (name, value) VALUES ('".$name."', '".$value."')");
  }
} // update_setting


/**
 * checks if a file already exists. If so, rename it with incremental number
 */
function file_newname($path, $filename) {
  if ($pos = strrpos($filename, '.')) {
    $name = substr($filename, 0, $pos);
    $ext = substr($filename, $pos);
  } else {
    $name = $filename;
  }
  $newpath = $path.'/'.$filename;
  $newname = $filename;
  $counter = 0;
  while (file_exists($newpath)) {
    $newname = $name .'_'. $counter . $ext;
    $newpath = $path.'/'.$newname;
    $counter++;
   }
  return $newname;
} // file_newname


/**
 * display a row on the list of pages
 */
function display_page_list_row($page) {
  $link_page = '<i class="material-icons">open_with</i><a href="/'.$page->url.'">'.$page->title.'</a>';
  $link_edit = '<a href="/admin/page_edit/'.$page->id.'"><i class="material-icons md-24">edit</i> edit</a>';
  if ($page->id == 1 || $page->id == 2) {
    $link_delete = '<span class="disabled"><i class="material-icons md-24">clear</i> delete</span>';
  }
  else {
    $link_delete = '<a href="/admin/page_delete/'.$page->id.'"><i class="material-icons md-24">clear</i> delete</a>';
  }
  $output = '
    <div class="cell page">'.$link_page.'</div>
    <div class="cell edit">'.$link_edit.'</div>
    <div class="cell delete">'.$link_delete.'</div>
  ';
  return $output;
} // display_page_list_row


/**
 * uploads an image
 */
function upload_image($file, $path) {
  $result = new stdClass();
  $result->status = "success";
  $validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
  $fileExtension = strrchr($file['name'], ".");
  if (in_array($fileExtension, $validExtensions)) {
    $file_name = file_newname($path, $file['name']);
    $destination = $path.$file_name;
    if (move_uploaded_file($file['tmp_name'], $destination)) {
      $result->file_name = $file_name;
    }
    else {
      $result->status = "error";
      $result->errorMessage = "Mmm, something went wrong with the file upload...";
    }
  } else {
    $result->status = "error";
    $result->errorMessage = "The file must be an image";
  }
  return $result;
} // upload_image


/**
 * resizes an image
 */
function resize_image($file_name, $path, $size) {
  $full_path = $_SERVER["DOCUMENT_ROOT"]."/".$path.$file_name;
  $manipulator = new ImageManipulator($full_path);
  switch($size) {
    case "large":
      $newImage = $manipulator->resample(1200, 1200);
      break;
    case "medium":
      $newImage = $manipulator->resample(800, 800);
      break;
    case "small":
      $newImage = $manipulator->resample(400, 400);
      break;
  }
  $manipulator->save('your_site/uploaded_files/'.$size."/".$file_name);
} // resize_image


/**
 * creates a new empty row
 */
function create_new_row($index) {
  $row = new stdClass();
  $row->id = 0;
  $row->display_order = $index;
  $row->columns_size = "two-large-small";
  $row->number_of_columns = 2;
  $row->heading = "";
  $row->column1 = "";
  $row->column2 = "";
  $row->column3 = "";
  return $row;
} // create_new_row


/**
 * creates a new empty column
 */
function create_new_col($index) {
  $col = new stdClass();
  $col->id = 0;
  $col->display_order = $index;
  $col->number_of_widgets = 0;
  return $col;
} // create_new_col


/**
 * saves a page
 */
function save_page($var, $page_id = 0) {
  global $db;
  $title = $db->escape($var["title"]);
  $url = $db->escape($var["url"]);
  $description = $db->escape($var["description"]);
  $parent = $var["parent"];
  if ($page_id == 0) {
    // create new page
    $db->query("INSERT INTO page (title, url, description, parent) VALUES ('".$title."', '".$url."', '".$description."', ".$parent.")");
    $page_id = $db->insert_id;
  }
  else {
    // update existing page
    $db->query("UPDATE page SET title='".$title."', url='".$url."', description='".$description."', parent=".$parent." WHERE id=".$page_id);
  }
  // save rows
  foreach($var["rows"] as $row) {
    save_row($row, $page_id);
  }
  if ($page_id != 0) {
    // delete rows that have been removed
    if ($var["deleted_rows"] != "") {
      $deleted_rows = explode(",", $var["deleted_rows"]);
      foreach($deleted_rows as $row_id) {
        if ($row_id != "") {
          delete_row($row_id);
        }
      }
    }
    // delete widgets that have been removed
    if ($var["deleted_widgets"] != "") {
      $deleted_widgets = explode(",", $var["deleted_widgets"]);
      foreach($deleted_widgets as $widget_id) {
        if ($widget_id != "") {
          delete_widget($widget_id);
        }
      }
    }
  }
} // save_page


/**
 * saves a row for a given page
 */
function save_row($row, $page_id) {
  global $db;
  $row_id = $row["id"];
  $heading = $db->escape($row["heading"]);
  if ($row["id"] == 0) { // this is a new row
    $db->query("INSERT INTO row (page_id, display_order, columns_size, number_of_columns, heading) VALUES (".$page_id.", ".$row["display_order"].", '".$row["columns_size"]."', ".$row["number_of_columns"].", '".$heading."')");
    $row_id = $db->insert_id;
  }
  else { // updating an existing row
    $db->query("UPDATE row SET display_order=".$row["display_order"].", columns_size='".$row["columns_size"]."', number_of_columns=".$row["number_of_columns"].", heading='".$heading."' WHERE id=".$row_id);
  }
  // save columns
  for ($i=1; $i<=$row["number_of_columns"]; $i++) {
    $column = $row["cols"][$i];
    save_column($column, $row_id);
  }
} // save_row


/**
 * saves a column for a given row
 */
function save_column($column, $row_id) {
  global $db;
  $column_id = $column["id"];
  if ($column_id == 0) { // this is a new column
    $db->query("INSERT INTO col (row_id, display_order, number_of_widgets) VALUES (".$row_id.", ".$column["display_order"].", ".$column["number_of_widgets"].")");
    $column_id = $db->insert_id;
  }
  else { // updating an existing column
    $db->query("UPDATE col SET display_order=".$column["display_order"].", row_id=".$row_id.", number_of_widgets=".$column["number_of_widgets"]." WHERE id=".$column["id"]);
  }
  // save widgets
  if (isset($column["widgets"])) {
    foreach($column["widgets"] as $widget) {
      save_widget($widget, $column_id);
    }
  }
} // save_column


/**
 * saves a widget for a given column
 */
function save_widget($widget, $column_id) {
  global $db;
  $widget_id = $widget["id"];
  $db->query("UPDATE widget SET display_order=".$widget["display_order"].",  col_id=".$column_id." WHERE id=".$widget["id"]);
} // save_widget


/**
 * deletes a page
 */
function delete_page($page_id) {
  global $db;
  $db->query("DELETE FROM page WHERE id=".$page_id);
  if ($rows = $db->get_results("SELECT * FROM row WHERE page_id=".$page_id)) {
    foreach($rows as $row) {
      delete_row($row->id);
    }
  }
} // delete_page


/**
 * deletes a row
 */
function delete_row($row_id) {
  global $db;
  $db->query("DELETE FROM row WHERE id=".$row_id);
  if ($columns = $db->get_results("SELECT * FROM col WHERE row_id=".$row_id)) {
    foreach($columns as $col) {
      delete_column($col->id);
    }
  }
} // delete_row


/**
 * deletes a column
 */
function delete_column($column_id) {
  global $db;
  $db->query("DELETE FROM col WHERE id=".$column_id);
  if ($widgets = $db->get_results("SELECT * FROM widget WHERE col_id=".$column_id)) {
    foreach($widgets as $widget) {
      delete_widget($widget->id);
    }
  }
} // delete_column


/**
 * deletes a widget
 */
function delete_widget($widget_id) {
  global $db;
  $type = $db->get_var("SELECT type FROM widget WHERE id=".$widget_id);
  $data = $db->get_row("SELECT * FROM widget_".$type." WHERE widget_id=".$widget_id);
  // if required run additional delete function for the widget
  $delete_function_path = $_SERVER["DOCUMENT_ROOT"]."/happyweb/admin/widgets/".$type."/delete.php";
  if (file_exists($delete_function_path)) {
    include($delete_function_path);
  }
  // delete data
  $db->query("DELETE FROM widget_".$type." WHERE widget_id=".$widget_id);
  $db->query("DELETE FROM widget WHERE id=".$widget_id);
} // delete_widget
