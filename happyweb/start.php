<?php

session_start();
global $db;

// load db and various functions
require("happyweb/includes/ez_sql/ez_sql_core.php");
require("happyweb/includes/ez_sql/ez_sql_pdo.php");
require("your_site/config.php");
require("happyweb/includes/functions.php");

// set up database
$db = new ezSQL_pdo('mysql:host='.$host.';dbname='.$db_name.';', $user, $password);

// catch errors
set_error_handler("set_error");

// check if we have any messages to display
$messages = get_messages();

// check which page we want to see
$url_info = parse_url($_SERVER['REQUEST_URI']);
$path = ltrim($url_info["path"], "/");

switch(arg(0)) {
  
  // first, let's check if it's an admin page
  case "admin": 
    // make sure we are logged in
    if (!isset($_SESSION["happyweb"]["user"]) && arg(1) != "login") {
      // if not go to the login page
      redirect("admin/login");
      exit();
    }
    require("happyweb/includes/functions_admin.php");
    // get the filename to display (that's the bit after /admin in the URL);
    $admin_filename = (arg(1))?arg(1):"index";
    // get the output of the script
    ob_start();
    require('happyweb/admin/'.$admin_filename.'.php');
    $content = ob_get_contents();
    ob_end_clean();
    // display the admin template
    include("happyweb/themes/admin/template.php");
    exit();
  break;

  
  // check if it's an AJAX request
  case "ajax":
    require("happyweb/includes/functions_admin.php");
    // get the filename to display (that's the bit after /ajax in the URL);
    $ajax_filename = arg(1);
    // display the raw output of the script
    require('happyweb/admin/ajax_'.$ajax_filename.'.php');
    exit();
  break;
 
 
  // if not, carry on
  default:
  
    // load the current page
    $page = get_current_page();

    // build the navigation
    $navigation = build_navigation($page);

    // build the page content
    $content = build_page($page);

    // get the current theme
    $theme = get_setting("theme");
    
    // get the site name
    $site_name = get_setting("site_name");
    
    // add body class
    $body_class = "page".$page->id;
    
    // get admin tools
    $admin_tools = get_admin_tools($page);

    // display the template
    $path_theme = ($theme == "basic" || $theme == "admin")?"happyweb/themes/":"your_site/themes/";
    include($path_theme.$theme."/template.php");
  break;
}