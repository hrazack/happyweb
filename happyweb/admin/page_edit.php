<?php
global $db;
$page_id = arg(2);
$page = get_page($page_id);
if (!$page) exit();

if (isset($_POST["action"])) {

  save_page($_POST, $page_id);
  set_message('The page <em>"'.$_POST["title"].'"</em> has been saved successfully, phew!');
  if ($_POST["return"] == "page") {
    redirect($page->url);
  } 
  else {
    redirect('admin');
  }
  
}
else {
  
  $head_page_title = "Edit a page";
  $number_of_rows = $db->get_var("SELECT COUNT(*) FROM row WHERE page_id=".$page->id);
  $page_title = $page->title;
  $page_url = $page->url;
  $description = $page->description;
  $browser_title = $page->browser_title;
  $rows = $db->get_results("SELECT * FROM row WHERE page_id=".$page->id." ORDER BY row_index ASC");
  include("inc_form_page.php");
  
}

?>

<script src="/happyweb/admin/page_build.js"></script>