<?php

/**
 * increment update index
 */
function increment_update() {
  global $db;
  $db->query("UPDATE settings SET value=value+1 WHERE name='current_update'");
} // increment_update


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
  $max_length = 50;
  $title = $page->title;
  if (strlen($page->title) > $max_length) {
    $title = substr($page->title, 0, $max_length)."...";
  }
  $link_page = '<a href="/'.$page->url.'">'.$title.'</a>';
  $link_edit = '<a href="/admin/page_edit/'.$page->id.'"><i class="material-icons md-24">edit</i> edit</a>';
  if ($page->id == 1 || $page->id == 2) {
    $link_delete = '<span class="disabled"><i class="material-icons md-24">clear</i> delete</span>';
  }
  else {
    $link_delete = '<a href="/admin/page_delete/'.$page->id.'"><i class="material-icons md-24">clear</i> delete</a>';
  }
  $output = '
    <div class="cell page">'.$link_page.'</div>
    <div class="cell delete">'.$link_delete.'</div>
    <div class="cell edit">'.$link_edit.'</div>
  ';
  return $output;
} // display_page_list_row


/**
 * uploads an image
 */
function upload_image($file, $path) {
  $result = new stdClass();
  $result->status = "success";
  $validExtensions = array('.jpg', '.jpeg', '.gif', '.png', '.JPG', '.JPEG');
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
 * uploads a file
 */
function upload_file($file, $path) {
  $result = new stdClass();
  $result->status = "success";
  $validExtensions = array('.mp3');
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
    $result->errorMessage = "The file must be an MP3 file";
  }
  return $result;
} // upload_file


/**
 * resizes an image
 */
function resize_image($file_name, $path, $size) {
  $full_path = $path.$file_name;
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
    case "thumbnail":
      $newImage = $manipulator->resample(200, 200);
      break;
  }
  $manipulator->save($_SERVER["DOCUMENT_ROOT"].'/my_website/uploaded_files/'.$size."/".$file_name);
} // resize_image


/**
 * saves the order of the pages returned by nestable
 */
function save_pages_order($pages, $parent) {
  global $db;
  foreach($pages as $index => $page) {
    $db->query("UPDATE page SET parent=".$parent.", display_order=".$index." WHERE id=".$page->id);
    if (isset($page->children)) {
      save_pages_order($page->children, $page->id);
    }
  }
} // save_pages_order


/**
 * returns a tree of all pages (in hierarchical order)
 */
function get_pages_tree(&$pages_full, $page_id=0, &$pages_url=array(), $level=0) {
  global $db;
  if ($pages = $db->get_results("SELECT * FROM page WHERE parent=".$page_id." ORDER BY display_order ASC")) {
    foreach($pages as $page) {
      $page_title = str_repeat("--",$level)." ".$page->title;
      $obj = new stdClass();
      $obj->text = $page_title;
      $obj->value = "/".$page->url;
      $obj->id = $page->id;
      $pages_full[] = $obj;
      $pages_url[] = "/".$page->url;
      get_pages_tree($pages_full, $page->id, $pages_url, $level+1);
    }
  }
} // page_tree


/**
 * creates a new empty row
 */
function create_new_row($row_index) {
  $row = new stdClass();
  $row->id = "new-".$row_index;
  $row->row_index = $row_index;
  $row->columns_size = "two-large-small";
  $row->number_of_columns = 2;
  $row->no_padding = 0;
  $row->center_heading = 0;
  $row->heading = "";
  $row->column1 = "";
  $row->column2 = "";
  $row->column3 = "";
  return $row;
} // create_new_row


/**
 * creates a new empty column
 */
function create_new_col($row_id, $col_index) {
  $col = new stdClass();
  $col->id = $row_id."-".$col_index;
  if (strpos($col->id, "new") === false) { // this will fix the issue with new columns being not created before update #15
    $col->id = "new-".$col->id;
  }
  $col->row_id = $row_id;
  $col->col_index = $col_index;
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
  $browser_title = $db->escape($var["browser_title"]);
  $parent = $var["parent"];
  if ($page_id == 0) {
    // create new page
    $db->query("INSERT INTO page (title, url, description, browser_title, parent) VALUES ('".$title."', '".$url."', '".$description."', '".$browser_title."', ".$parent.")");
    $page_id = $db->insert_id;
  }
  else {
    // update existing page
    $db->query("UPDATE page SET title='".$title."', url='".$url."', description='".$description."', browser_title='".$browser_title."', parent=".$parent." WHERE id=".$page_id);
  }
  // save rows
  if (isset($var["rows"])) {
    foreach($var["rows"] as $row) {
      save_row($row, $page_id, $var);
    }
  }
  // save columns
  if (isset($var["cols"])) {
    foreach($var["cols"] as $col) {
      save_column($col, $var);
    }
  }
  // save widgets
  if (isset($var["widgets"])) {
    foreach($var["widgets"] as $widget) {
      save_widget($widget);
    }
  }
  // save text widgets
  if (isset($var["widget_text"])) {
    foreach($var["widget_text"] as $widget_id => $text) {
      $text = $db->escape($text);
      $db->query("UPDATE widget_text SET text='".$text."' WHERE widget_id=".$widget_id);
    }
  }
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
} // save_page


/**
 * saves a row for a given page
 */
function save_row($row, $page_id, &$var) {
  global $db;
  $row_id = $row["id"];
  $heading = $db->escape($row["heading"]);
  $no_padding = (isset($row["options"]["no_padding"]))?1:0;
  $center_heading = (isset($row["options"]["center_heading"]))?1:0;
  if (strpos($row["id"], "new") !== false) {
    // this is a new row
    $db->query("INSERT INTO row (page_id, row_index, columns_size, number_of_columns, heading, no_padding, center_heading) VALUES (".$page_id.", ".$row["row_index"].", '".$row["columns_size"]."', ".$row["number_of_columns"].", '".$heading."', ".$no_padding.", ".$center_heading.")");
    $row_id = $db->insert_id;
    // let's update all the columns in that row with the new row id
    foreach($var["cols"] as $key => $col) {
      if ($col["row_id"] == $row["id"]) {
        $var["cols"][$key]["row_id"] = $row_id;
      }
    }
  }
  else { 
  // updating an existing row
    $db->query("UPDATE row SET row_index=".$row["row_index"].", columns_size='".$row["columns_size"]."', number_of_columns=".$row["number_of_columns"].", heading='".$heading."', no_padding=".$no_padding.", center_heading=".$center_heading." WHERE id=".$row_id);
  }
} // save_row


/**
 * saves a column
 */
function save_column($column, &$var) {
  global $db;
  $column_id = $column["id"];
  if (strpos($column["id"], "new") !== false) {
    // this is a new column
    $db->query("INSERT INTO col (row_id, col_index) VALUES (".$column["row_id"].", ".$column["col_index"].")");
    $column_id = $db->insert_id;
    // let's update all the widgets in that column with the new column id
    if (isset($var["widgets"])) {
      foreach($var["widgets"] as $key => $widget) {
        if ($widget["col_id"] == $column["id"]) {
          $var["widgets"][$key]["col_id"] = $column_id;
        }
      }
    }
  }
  else { 
    $db->query("UPDATE col SET row_id=".$column["row_id"].", col_index=".$column["col_index"]." WHERE id=".$column["id"]);
  }
} // save_column


/**
 * saves a widget
 */
function save_widget($widget) {
  global $db;
  $widget_id = $widget["id"];
  $db->query("UPDATE widget SET col_id=".$widget["col_id"].", widget_index=".$widget["widget_index"]." WHERE id=".$widget["id"]);
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
  if (strpos($row_id, "new") === false) {
    // delete the row
    $db->query("DELETE FROM row WHERE id=".$row_id);
    // delete each column in the row
    if ($columns = $db->get_results("SELECT * FROM col WHERE row_id=".$row_id)) {
      foreach($columns as $col) {
        delete_column($col->id);
      }
    }
  }
} // delete_row


/**
 * deletes a column
 */
function delete_column($column_id) {
  global $db;
  if (strpos($column_id, "new") === false) {
    // delete the column
    $db->query("DELETE FROM col WHERE id=".$column_id);
    // delete the widgets for that column
    if ($widgets = $db->get_results("SELECT * FROM widget WHERE col_id=".$column_id)) {
      foreach($widgets as $widget) {
        delete_widget($widget->id);
      }
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
  $delete_function_path = $_SERVER["DOCUMENT_ROOT"]."/happyweb_system/admin/widgets/".$type."/delete.php";
  if (file_exists($delete_function_path)) {
    include($delete_function_path);
  }
  // delete data
  $db->query("DELETE FROM widget_".$type." WHERE widget_id=".$widget_id);
  $db->query("DELETE FROM widget WHERE id=".$widget_id);
} // delete_widget


/**
 * copy an entire folder
 */
function copy_folder($src, $dst) { 
  $dir = opendir($src); 
  @mkdir($dst); 
  while(false !== ( $file = readdir($dir)) ) { 
    if (( $file != '.' ) && ( $file != '..' )) { 
      if ( is_dir($src . '/' . $file) ) { 
        copy_folder($src . '/' . $file,$dst . '/' . $file); 
      } 
      else { 
        copy($src . '/' . $file,$dst . '/' . $file); 
      } 
    } 
  } 
  closedir($dir); 
}  // copy_folder


/**
 * sanitize a string for filename
 */
function sanitize_string($unformatted) {
  $url = strtolower(trim($unformatted));
  //replace accent characters, forien languages
  $search = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ'); 
  $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o'); 
  $url = str_replace($search, $replace, $url);
  //replace common characters
  $search = array('&', '£', '$'); 
  $replace = array('and', 'pounds', 'dollars'); 
  $url= str_replace($search, $replace, $url);
  // remove - for spaces and union characters
  $find = array(' ', '&', '\r\n', '\n', '+', ',', '//');
  $url = str_replace($find, '_', $url);
  //delete and replace rest of special chars
  $find = array('/[^a-z0-9\_<>]/', '/[\-]+/', '/<[^>]*>/');
  $replace = array('', '_', '');
  $uri = preg_replace($find, $replace, $url);
  return $uri;
} // sanitize_string