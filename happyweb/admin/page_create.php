<?php
global $db;
$page_id = 0;

if (isset($_POST["action"])) {
  
  save_page($_POST);
  set_message('The page <em>"'.$_POST["title"].'"</em> has been created, woohoo!');
  redirect('admin');
  
} else {
  
  $head_page_title = "Create a formidable page";
  $number_of_rows = 1;
  $page_title = "";
  $page_url = "";
  $browser_title = "";
  $description = "";
  $row = create_new_row(1);
  $rows[] = $row;
  include("inc_form_page.php");
  
}

?>

<script src="/happyweb/admin/page_build.js"></script>