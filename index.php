<?php

session_start();
global $db;

// load db and various functions
require("happyweb/includes/ez_sql/ez_sql_core.php");
require("happyweb/includes/ez_sql/ez_sql_mysql.php");
require("config.php");
require("happyweb/includes/functions.php");

// check if we have any messages to display
$messages = "";
if (isset($_SESSION["happyweb"]["messages"])) {
  foreach($_SESSION["happyweb"]["messages"] as $message) {
    $messages .= $message;
  }
  unset($_SESSION["happyweb"]["messages"]);
}

$scripts = '<script type="text/javascript" src="/happyweb/includes/jquery.min.js"></script>';

// check which page we want to see
$url_info = parse_url($_SERVER['REQUEST_URI']);
$path = ltrim($url_info["path"], "/");

// first, let's check if it's an admin page
$parts = explode("/", $path);
if ($parts[0] == "admin") {
  // get the filename to display (that's the bit after /admin in the URL);
  $admin_filename = isset($parts[1])?$parts[1]:"index";
  // get the output of the script
  ob_start();
  require('happyweb/admin/'.$admin_filename.'.php');
  $content = ob_get_contents();
  ob_end_clean();
  // display the admin template
  include("happyweb/themes/admin/template.php");
  exit();
}

// check if it's an AJAX request
if ($parts[0] == "ajax") {
  // get the filename to display (that's the bit after /ajax in the URL);
  $ajax_filename = isset($parts[1])?$parts[1]:"";
  // display the raw output of the script
  require('happyweb/admin/ajax_'.$ajax_filename.'.php');
  exit();
}

// if not, is it the homepage?
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

// load the current page
$page = $db->get_row("SELECT * FROM page WHERE id=".$page_id);

// build the navigation
$navigation = build_navigation($page);

// build the page content
$content = build_page($page);

// get the current theme
$theme = $db->get_var("SELECT value FROM settings WHERE name='theme'");

// display the template
$path_theme = ($theme == "base" || $theme == "admin")?"happyweb/themes/":"themes/";
include($path_theme.$theme."/template.php");
