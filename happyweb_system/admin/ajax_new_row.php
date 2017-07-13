<?php

$row_index = $_GET["row_index"];
$page_id = $_GET["page_id"];
$row = create_new_row($row_index);

include("inc_form_row.php"); 

?>