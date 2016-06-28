<?php
global $db;

if (isset($_POST["action"])) {
  
  //print "<pre>".print_r($_POST, 1)."</pre>";
  save_page($_POST);
  set_message('The page <em>"'.$_POST["title"].'"</em> has been created, woohoo!');
  redirect('admin');
  
} else {
  
  $head_page_title = "Create a formidable page";
  $number_of_rows = 1;
  $page_title = "";
  $page_url = "";
  $description = "";
  $row = create_new_row(1);
  $rows[] = $row;
  include("inc_form_page.php");
  
}

?>

