<?php

// let's define all the column sizes
global $columns_sizes;
$columns_sizes = array(
  "one"               =>  array("size" => 1, "description" => "one column"),
  "one-small"         =>  array("size" => 1, "description" => "one small column"),
  "two"               =>  array("size" => 2, "description" => "two equal columns"),
  "two-large-small"   =>  array("size" => 2, "description" => "two columns (large and small)"), 
  "two-small-large"   =>  array("size" => 2, "description" => "two columns (small and large)"), 
  "three"             =>  array("size" => 3, "description" => "three equal columns"), 
);


/**
 * redirects to an internal URL
 */
function redirect($path) {
  header('Location: /'.$path);
  exit();
} // redirect


/**
 * get the base url
 */
function base_url() {
  if (isset($_SERVER['HTTPS'])){
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
  }
  else {
    $protocol = 'http';
  }
  return $protocol . "://" . $_SERVER['HTTP_HOST'];
} // base_url


/**
 * returns the current page
 */
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
 * returns a setting's value
 */
function get_setting($name) {
  global $db;
  return $db->get_var("SELECT value FROM settings WHERE name='".$name."'");
} // get_setting


/**
 * sets a system message to be displayed
 */
function set_message($str) {
  $_SESSION["happyweb"]["messages"][] = $str;
} // set_message


/**
 * catches and sets errors to be displayed
 */
function set_error($error_level, $message, $filename, $line, $context) {
  $_SESSION["happyweb"]["errors"][] = $message." in ".$filename." on line ".$line;
} // display_error


/**
 * builds messages and errors to be displayed
 */
function get_messages() {
  $messages = "";
  if (isset($_SESSION["happyweb"]["messages"])) {
    $messages .= '<div class="messages status"><a class="close"><i class="material-icons">clear</i></a><i class="material-icons">check_circle</i>';
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
    $errors .= '<div class="messages errors"><a class="close"><i class="material-icons">clear</i></a><i class="material-icons">check_circle</i>';
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
 * returns admin tools for the public site
 */
function get_admin_tools($page) {
  $output = "";
  if (isset($_SESSION["happyweb"]["user"])) {
    $output .= '<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">';
    $output .= '<link rel="stylesheet" href="/happyweb_system/includes/tooltipster/tooltipster.min.css" media="all" />';
    $output .= '<script src="/happyweb_system/includes/tooltipster/tooltipster.min.js"></script>';
    $output .= '<script>$(document).ready(function() { $(".tooltip").tooltipster({animation: "grow", theme: "tooltipster-borderless", delay: 0 });});</script>';
    $output .= '<ul id="admin-tools">';
    $output .= '<li><a class="tooltip" href="/admin/page_edit/'.$page->id.'?return-to-page" title="Edit this page"><i class="material-icons">edit</i></a></li>';
    $output .= '<li><a class="tooltip" href="/admin" title="Go to admin"><i class="material-icons">settings</i></a></li>';
    $output .= '<li><a class="tooltip" href="/admin/logout" title="Logout"><i class="material-icons">exit_to_app</i></a></li>';
    $output .= '</ul>';
  }
  return $output;
} // get_admin_tools


/**
 * add some javascript to be inserted in the page
 */
function add_js($js) {
  if (!in_array($js, $_SESSION['happyweb']['js'])) {
    $_SESSION['happyweb']['js'][] = $js;
  }
} // add_js


/**
 * add some css to be inserted in the page
 */
function add_css($css) {
  if (!in_array($css, $_SESSION['happyweb']['css'])) {
    $_SESSION['happyweb']['css'][] = $css;
  }
} // add_css


/**
 * returns the ID for a YouTube video
 */
function get_youtube_id($url) {
  $parts = parse_url($url);
  if (isset($parts['query'])){
    parse_str($parts['query'], $qs);
    if (isset($qs['v'])){
      return $qs['v'];
    } else if(isset($qs['vi'])){
      return $qs['vi'];
    }
  }
  if (isset($parts['path'])){
    $path = explode('/', trim($parts['path'], '/'));
    return $path[count($path)-1];
  }
  return false;
} // get_youtube_id


/**
 * returns the ID for a Vimeo video
 */
function get_vimeo_id($url) {
	$regex = '~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/videos?)?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix';
	preg_match($regex, $url, $matches);
	return $matches[1];
} // get_vimeo_id


/**
 * returns the thumbnail for a video from YouTube or Vimeo
 */
function get_video_thumbnail($url) {
  $is_youtube = (strpos($url, "youtu") !== FALSE);
  $is_vimeo = (strpos($url, "vimeo") !== FALSE);
  if ($is_youtube) {
    $youtube_id = get_youtube_id($url);
    $thumbnail = "http://i3.ytimg.com/vi/".$youtube_id."/hqdefault.jpg";
  }
  else if ($is_vimeo) {
    $vimeo_id = get_vimeo_id($url);
    $data = file_get_contents("http://vimeo.com/api/v2/video/$vimeo_id.json");
    $data = json_decode($data);
    $thumbnail = $data[0]->thumbnail_large;
  }
  return $thumbnail;
} // get_video_thumbnail


/**
 * returns an embedded YouTube or Vimeo video from the URL
 */
function get_video_embed($url) {
  $is_youtube = (strpos($url, "youtu") !== FALSE);
  $is_vimeo = (strpos($url, "vimeo") !== FALSE);
  if ($is_youtube) {
    $youtube_id = get_youtube_id($url);
    $video = 'http://www.youtube.com/embed/'.$youtube_id.'?rel=0&showinfo=0&color=white&iv_load_policy=3&autoplay=1';
  }
  else if ($is_vimeo) {
    $vimeo_id = get_vimeo_id($url);
    $video = 'http://player.vimeo.com/video/'.$vimeo_id.'?title=0&byline=0&portrait=0&autoplay=1';
  }
  return $video;
} // get_video_embed


/**
 * returns a YouTube or Vimeo video from the URL
 */
function get_video_iframe($url) {
  $is_youtube = (strpos($url, "youtu") !== FALSE);
  $is_vimeo = (strpos($url, "vimeo") !== FALSE);
  if ($is_youtube) {
    $youtube_id = get_youtube_id($url);
    $width = 640;
    $height = 360;
    $video = '<iframe type="text/html" width="'.$width.'px" height="'.$height.'" src="https://www.youtube.com/embed/'.$youtube_id.'?rel=0&showinfo=0&color=white&iv_load_policy=3" frameborder="0" allowfullscreen></iframe> ';
  }
  else if ($is_vimeo) {
    $vimeo_id = get_vimeo_id($url);
    $width = 640;
    $height = 427;
    $video = '<iframe src="https://player.vimeo.com/video/'.$vimeo_id.'?title=0&byline=0&portrait=0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
  }
  return $video;
} // get_video


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
function build_page($page, $is_export = false) {
  global $db;
  $content = "";
  $content .= '<div class="sections">';
  if ($rows = $db->get_results("SELECT * FROM row WHERE page_id=".$page->id." ORDER BY row_index ASC")) {
    foreach($rows as $index => $row) {
      if ($row->hidden == 0) {
        $class_padding = ($row->no_padding == 1)?"no-padding":"";
        $class_heading = ($row->center_heading == 1)?"center-heading":"";
        $content .= '<section id="section'.$index.'" class="'.$class_padding.' '.$class_heading.'">';
        $content .= '<div class="container">';
        if ($row->heading != "") {
          $content .= '<h1>'.$row->heading.'</h1>';
        }
        // build columns
        $is_content_in_columns = false;
        $content_columns = "";
        $columns = $db->get_results("SELECT * FROM col WHERE row_id=".$row->id." ORDER BY col_index ASC");
        if ($columns) {
          $col_index = 0;
          foreach($columns as $col) {
            $col_index++;
            if ($col_index <= $row->number_of_columns) {
              $content_columns .= '<div class="column column'.$col_index.'" data-id="'.$col->id.'">';
              if ($widgets = $db->get_results("SELECT * FROM widget WHERE col_id=".$col->id." ORDER BY widget_index ASC")) {
                $is_content_in_columns = true;
                foreach($widgets as $widget) {          
                  $content_columns .= '<div class="widget '.$widget->type.'" id="widget-'.$widget->id.'">';
                  $content_columns .= build_widget($widget, $is_export, $page->id);
                  $content_columns .= '</div>';
                }
              }
              $content_columns .= '</div>';
            }
          }
        }
        // populate columns if they have content
        if ($is_content_in_columns) {
          $content .= '<div class="columns-container '.$row->columns_size.'">';
          $content .= $content_columns;
          $content .= '</div>';
        }
        $content .= '</div>';
        $content .= '</section>';
      }
    }
    $content .= "</div>";
  }
  return $content;
} // build page


/**
 * builds the navigation
 */
function build_navigation($current_page, $is_export = false) {
  global $db;
  $output = "";
  $pages = $db->get_results("SELECT * FROM page WHERE parent=0 ORDER BY display_order");
  $output .= '<ul>';
  if ($pages) {
    foreach($pages as $page) {
      if ($page->hidden == 0) {
        $selected = ($page->id == $current_page->id || $page->id == $current_page->parent)?"selected":"";
        $url = $page->url;
        if ($is_export) {
          if ($page->url == "home") {
            $page->url = "index";
          }
          $url = $page->url.".html";
        }
        $output .= '<li class="'.$selected.'"><a href="/'.$url.'">'.$page->title.'</a></li>';
      }
    }
  }
  $output .= '</ul>';
  $output .= '<a id="mobile-nav-close">Close</a>';
  return $output;
} // build_navigation


/**
 * builds the full content of a widget
 */
function build_widget($widget, $is_export = false, $page_id = 0) {
  global $db;
  $data = $db->get_row("SELECT * FROM widget_".$widget->type." WHERE widget_id=".$widget->id);
  $output = "";
  ob_start();
  include($_SERVER["DOCUMENT_ROOT"]."/happyweb_system/admin/widgets/".$widget->type."/view_full.php");
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
  include($_SERVER["DOCUMENT_ROOT"]."/happyweb_system/admin/widgets/".$widget->type."/view_preview.php");
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
} // build_widget_overview



/**
 * return the css for custom heading fonts
 */
function get_custom_fonts_css_for_headings() { 
  $h1_size = get_setting("size_heading");
  $h1_line_height = $h1_size + 10;
  $h2_size = $h1_size - 10;
  $h2_line_height = $h2_size + 10;
  $h3_size = $h2_size - 10;
  $h3_line_height = $h3_size + 10;
  $css = '';
  // call Google Font
  $css .= '<link href="https://fonts.googleapis.com/css?family='.str_replace(" ", "+", get_setting("font_headings")).'" rel="stylesheet">';
  // add custom CSS
  $css .= '<style type="text/css">';
  $css .= 'h1, h2, h3 {font-family: '.get_setting("font_headings").';}';
  $css .= 'h1 {font-size: '.$h1_size.'px; line-height: '.$h1_line_height.'px;}';
  $css .= 'h2 {font-size: '.$h2_size.'px; line-height: '.$h2_line_height.'px;}';
  $css .= 'h3 {font-size: '.$h3_size.'px; line-height: '.$h3_line_height.'px;}';
  $css .= '</style>';
  return $css;
} // get_custom_fonts_css_for_headings


/**
 * return the css for custom text fonts
 */
function get_custom_fonts_css_for_text() { 
  $line_height = get_setting("size_text") + 10;
  $css = '';
  // call Google Font
  $css .= '<link href="https://fonts.googleapis.com/css?family='.str_replace(" ", "+", get_setting("font_text")).'" rel="stylesheet">';
  // add custom CSS
  $css .= '<style type="text/css">';
  $css .= 'body {font-family: '.get_setting("font_text").'; font-size: '.get_setting("size_text").'px; line-height: '.$line_height.'px;}';
  $css .= '</style>';
  return $css;
} // get_custom_fonts_css_for_text