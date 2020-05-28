<?php
$head_page_title = "Export website";
$display_navigation = true;

if (isset($_GET["action"])) {

  $zip = new ZipArchive();
  $filename = "./website_export.zip";
  if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
  }

  $theme = get_setting("theme");
  $site_name = get_setting("site_name");
  
  // go through each, generate the content as a file, and add it to the zip
  $pages = $db->get_results("SELECT * FROM page");
  foreach($pages as $page) {
    $navigation = build_navigation($page, true);
    $content = build_page($page, true);
    $browser_title = ($page->browser_title != "")?$page->browser_title:$page->title." | ".$site_name;
    $body_class = "page".$page->id;
    $scripts = '
      <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox-min.js"></script>
      <script src="/javascript/scripts.js"></script>';
    $css = '';
    $css .= '
      <link rel="stylesheet" href="/css/happyweb.css?v='.time().'" media="all" />
      <link rel="stylesheet" href="/css/colorbox.css" media="all" />';
    $css .= '<link rel="stylesheet" href="/css/styles.css?v='.time().'" media="all" />';
    if (get_setting("font_headings") != "") {
      $css .= get_custom_fonts_css_for_headings();
    }
    if (get_setting("font_text") != "") {
      $css .= get_custom_fonts_css_for_text();
    }
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
    $admin_tools = "";
    ob_start();
    $return = include "my_website/themes/$theme/template.php";
    $page_content = ob_get_clean();
    $url = ($page->url == "home")?"index":$page->url;
    $zip->addFromString($url.".html", $page_content);
  }
  // add theme images
  $rootPath = realpath("my_website/themes/$theme/images");
  $files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
  );
  foreach ($files as $name => $file) {
    if (!$file->isDir()){
      $filePath = $file->getRealPath();
      $relativePath = substr($filePath, strlen($rootPath) + 1);
      $zip->addFile($filePath, "images/".$relativePath);
    }
  }
  // add uploaded images
  $rootPath = realpath("my_website/uploaded_files");
  $files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
  );
  foreach ($files as $name => $file) {
    if (!$file->isDir()){
      $filePath = $file->getRealPath();
      $relativePath = substr($filePath, strlen($rootPath) + 1);
      $zip->addFile($filePath, "images/".$relativePath);
    }
  }
  // add css
  $zip->addFile("happyweb_system/includes/happyweb.css","css/happyweb.css");
  $zip->addFile("happyweb_system/includes/colorbox/colorbox.css","css/colorbox.css");
  $zip->addFile("my_website/themes/$theme/styles.css","css/styles.css");
  $zip->addFile("happyweb_system/includes/scripts.js","javascript/scripts.js");
  // close
  $zip->close();
  // prompt download
  header("Content-type: application/zip");
  header("Content-disposition: attachment; filename=website_export.zip"); 
  readfile("website_export.zip");
  exit();
}   
?>

<p class="help"><i class="material-icons">info_outline</i>If you click the "export" button, you will be able to download a zip file that contains your whole website.<br />You can use this to host your website somewhere else or get a backup of your pages.</p>

<a href="/admin/export?action" class="button">Export website</a>