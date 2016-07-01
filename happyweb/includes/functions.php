<?php

// let's define all the column sizes
global $columns_sizes;
$columns_sizes = array("one" => 1, "one-small" => 1, "two" => 2, "two-large-small" => 2, "two-small-large" => 2, "three" => 3);


function get_current_page() {
  global $db;
  $url_info = parse_url($_SERVER['REQUEST_URI']);
  $path = ltrim($url_info["path"], "/");
  // is it the homepage?
  if ($path == "") {
    $page_id = $db->get_var("SELECT value FROM settings WHERE name='home_page_id'");
  }
  else {
    // if not find out if there is a page with that path
    $page_id = $db->get_var("SELECT id FROM page WHERE url='".$path."'");
    // if not display the page not found
    if (!$page_id) {
      $page_id = $db->get_var("SELECT value FROM settings WHERE name='404_page_id'");
    }
  }
  $page = $db->get_row("SELECT * FROM page WHERE id=".$page_id);
  return $page;
} // get_current_page


/**
 * sets a system message to be displayed
 */
function set_message($str) {
  $_SESSION["happyweb"]["messages"][] = $str;
} // set_message


/**
 * catches and sets errors to be displayed
 */
function set_error($errno, $errstr) {
  $_SESSION["happyweb"]["errors"][] = $errstr;
} // display_error


/**
 * builds messages and errors to be displayed
 */
function get_messages() {
  $messages = "";
  if (isset($_SESSION["happyweb"]["messages"])) {
    $messages .= '<div class="messages"><i class="material-icons">info_outline</i>';
    if (count($_SESSION["happyweb"]["messages"]) > 1) {
      $messages .= '<ul>';
      foreach($_SESSION["happyweb"]["messages"] as $message) {
        $messages .= '<li>'.$message.'</li>';
      }
      $messages .= '</ul>';
    }
    else {
      $messages .= $_SESSION["happyweb"]["messages"][0];
    }
    $messages .= '</div>';
    unset($_SESSION["happyweb"]["messages"]);
  }
  $errors = "";
  if (isset($_SESSION["happyweb"]["errors"])) {
    $errors .= '<div class="errors"><i class="material-icons">info_outline</i>';
    if (count($_SESSION["happyweb"]["errors"]) > 1) {
      $errors .= '<ul>';
      foreach($_SESSION["happyweb"]["errors"] as $error) {
        $errors .= '<li>'.$error.'</li>';
      }
      $errors .= '</ul>';
    }
    else {
      $errors .= $_SESSION["happyweb"]["errors"][0];
    }
    $errors .= '</div>';
    unset($_SESSION["happyweb"]["errors"]);
  }
  $output = $errors.$messages;
  return $output;
} // get_messages


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
 * builds the page content
 */
function build_page($page) {
  global $db;
  $content = "";
  if ($rows = $db->get_results("SELECT * FROM row WHERE page_id=".$page->id." ORDER BY display_order ASC")) {
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
            $content .= '<div class="widget '.$widget->type.'">';
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
  }
  return $content;
} // build page


/**
 * builds the navigation
 */
function build_navigation($current_page) {
  global $db;
  $output = "";
  $pages = $db->get_results("SELECT * FROM page WHERE parent=0 ORDER BY display_order");
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
 * builds the overview of a widget
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


?>