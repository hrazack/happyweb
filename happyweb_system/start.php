<?php

session_start();
global $db;

// load db and various functions
require("happyweb_system/includes/ez_sql/ez_sql_core.php");
require("happyweb_system/includes/ez_sql/ez_sql_pdo.php");
require("happyweb_system/includes/functions.php");

// catch errors
set_error_handler("set_error", E_ALL);

// check if we have any messages to display
$messages = get_messages();

// check whether config.php exists or not
if (!file_exists("my_website/config.php")) {
  include("happyweb_system/install.php");
  exit();
}

// set up database
require("my_website/config.php");
$db = new ezSQL_pdo('mysql:host='.$host.';dbname='.$db_name.';', $user, $password);

// check which page we want to see
$url_info = parse_url($_SERVER['REQUEST_URI']);
$path = ltrim($url_info["path"], "/");

// initialize optional extra scripts and styles
$_SESSION['happyweb']['js'] = array();
$_SESSION['happyweb']['css'] = array();

switch(arg(0)) {
  
  // admin page
  case "admin": 
    // make sure we are logged in
    if (!isset($_SESSION["happyweb"]["user"]) && arg(1) != "login") {
      // if not go to the login page
      redirect("admin/login");
      exit();
    }
    require("happyweb_system/includes/functions_admin.php");
    // get the filename to display (that's the bit after /admin in the URL);
    $admin_filename = (arg(1))?arg(1):"index";
    // get the output of the script
    ob_start();
    require('happyweb_system/admin/'.$admin_filename.'.php');
    $content = ob_get_contents();
    ob_end_clean();
    // display the admin template
    include("happyweb_system/themes/admin/template.php");
    exit();
  break;

  
  // AJAX request
  case "ajax":
    require("happyweb_system/includes/functions_admin.php");
    // get the filename to display (that's the bit after /ajax in the URL);
    $ajax_filename = arg(1);
    // display the raw output of the script
    require('happyweb_system/admin/ajax_'.$ajax_filename.'.php');
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
    
    // get the browser title
    $browser_title = ($page->browser_title != "")?$page->browser_title:$page->title." | ".$site_name;
    
    // add body class
    $body_class = "page".$page->id;
    
    // get admin tools
    $admin_tools = get_admin_tools($page);
    
    // print javascript
    $scripts = '
      <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox-min.js"></script>
      <script src="/happyweb_system/includes/scripts.js"></script>';
    foreach($_SESSION['happyweb']['js'] as $js) {
      $scripts .= "\n".$js;
    }
    
    // print css
    $css = '
      <link rel="stylesheet" href="/happyweb_system/includes/happyweb.css" media="all" />
      <link rel="stylesheet" href="/happyweb_system/includes/colorbox/colorbox.css" media="all" />';
    foreach($_SESSION['happyweb']['css'] as $c) {
      $css .= "\n".$c;
    }
    if ($theme == "basic") {
      $css .= '<link rel="stylesheet" href="/happyweb_system/themes/basic/styles.css" media="all" />';
    }
    else {
      $css .= '<link rel="stylesheet" href="/my_website/themes/'.$theme.'/styles.css" media="all" />';
    }
    
    // add custom colours
    if ($theme != "admin") {
      $css .= '<style type="text/css">';
      if (get_setting("colour_h1")) $css .= 'h1 {color: '.get_setting("colour_h1").';}';
      if (get_setting("colour_h2")) $css .= 'h2 {color: '.get_setting("colour_h2").';}';
      if (get_setting("colour_h3")) $css .= 'h3 {color: '.get_setting("colour_h3").';}';
      if (get_setting("colour_links")) $css .= 'a {color: '.get_setting("colour_links").';}';
      if (get_setting("colour_header_text")) $css .= 'header h1 {color: '.get_setting("colour_header_text").';}';
      if (get_setting("colour_header_bg")) $css .= 'header {background-color: '.get_setting("colour_header_bg").';}';
      if (get_setting("colour_nav_text")) $css .= 'nav a {color: '.get_setting("colour_nav_text").';}';
      if (get_setting("colour_nav_bg")) $css .= 'nav {background-color: '.get_setting("colour_nav_bg").';}';
      if (get_setting("colour_footer_text")) $css .= 'footer {color: '.get_setting("colour_footer_text").';}';
      if (get_setting("colour_footer_bg")) $css .= 'footer {background-color: '.get_setting("colour_footer_bg").';}';
      $css .= '</style>';
    }

    // display the template
    $path_theme = ($theme == "basic" || $theme == "admin")?"happyweb_system/themes/":"my_website/themes/";
    include($path_theme.$theme."/template.php");
  break;
}