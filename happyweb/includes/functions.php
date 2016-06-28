<?php

// let's define all the column sizes
global $columns_sizes;
$columns_sizes = array("one" => 1, "one-small" => 1, "two" => 2, "two-large-small" => 2, "two-small-large" => 2, "three" => 3);


/**
 * returns part of a URL
 */
function arg($n) {
  $url_info = parse_url($_SERVER['REQUEST_URI']);
  $path = ltrim($url_info["path"], "/");
  $arg = explode("/", $path);
  return isset($arg[$n])?$arg[$n]:false;
} // arg


/**
 * returns a page, or false if $page_id is invalid
 */
function get_page($page_id) {
  global $db;
  if (!is_numeric($page_id)) return false;
  $page = $db->get_row("SELECT * FROM page WHERE id=".$page_id);
  if (!$page) return false;
  return $page;
} // get_page


/**
 * sets a system message to be displayed
 */
function set_message($message) {
  $_SESSION["happyweb"]["messages"][] = $message;
} // set_message


/**
 * redirects to an internal URL
 */
function redirect($path) {
  header('Location: /'.$path);
  exit();
} // set_message


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
  $manipulator->save('uploaded_files/'.$size."/".$file_name);
} // resize_image


/**
 * builds the page content
 */
function build_page($page) {
  global $db;
  $content = "";
  $rows = $db->get_results("SELECT * FROM row WHERE page_id=".$page->id." ORDER BY display_order ASC");
  foreach($rows as $row) {
    $content .= '<section>';
    $content .= '<div class="container">';
    if ($row->heading != "") {
      $content .= '<h2>'.$row->heading.'</h2>';
    }
    $content .= '<div class="columns-container '.$row->columns_size.'">';
    $columns = $db->get_results("SELECT * FROM col WHERE row_id=".$row->id." ORDER BY display_order ASC");
    $col_index = 0;
    foreach($columns as $col) {
      $col_index++;
      $content .= '<div class="column column'.$col_index.'">';
      if ($widgets = $db->get_results("SELECT * FROM widget WHERE col_id=".$col->id." ORDER BY display_order ASC")) {
        foreach($widgets as $widget) {          
          $content .= '<div class="widget">';
          $content .= build_widget($widget);
          $content .= '</div>';
        }
      }
      $content .= '</div>';
    }
    $content .= '</div>';
    $content .= '</div>';
    $content .= '</section>';
  }
  return $content;
} // build page


/**
 * builds the navigation
 */
function build_navigation($current_page) {
  global $db;
  $output = "";
  $pages = $db->get_results("SELECT * FROM page WHERE parent=0");
  $output .= '<ul>';
  if ($pages) {
    foreach($pages as $page) {
      $output .= '<li><a href="/'.$page->url.'">'.$page->title.'</a></li>';
    }
  }
  $output .= '</ul>';
  return $output;
} // build_navigation


/**
 * builds the full content of a widget
 */
function build_widget($widget) {
  global $db;
  $data = $db->get_row("SELECT * FROM widget_".$widget->type." WHERE widget_id=".$widget->id);
  $output = "";
  ob_start();
  include($_SERVER["DOCUMENT_ROOT"]."/happyweb/admin/widgets/".$widget->type."/view_full.php");
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
} // build_widget


/**
 * builds the content of a widget
 */
function build_widget_overview($widget) {
  global $db;
  $data = $db->get_row("SELECT * FROM widget_".$widget->type." WHERE widget_id=".$widget->id);
  ob_start();
  include($_SERVER["DOCUMENT_ROOT"]."/happyweb/admin/widgets/".$widget->type."/view_preview.php");
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
} // build_widget_overview


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
    $deleted_rows = explode(",", $var["deleted_rows"]);
    foreach($deleted_rows as $row_id) {
      delete_row($row_id);
    }
    // delete widgets that have been removed
    $deleted_widgets = explode(",", $var["deleted_widgets"]);
    foreach($deleted_widgets as $widget_id) {
      delete_widget($widget_id);
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
  foreach($column["widgets"] as $widget) {
    save_widget($widget, $column_id);
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
  $db->query("DELETE FROM col WHERE id=".$col->id);
  if ($widgets = $db->get_results("SELECT * FROM widget WHERE col_id=".$col->id)) {
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

?>