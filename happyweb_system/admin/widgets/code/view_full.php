<?php
$filename = (isset($data->filename))?$data->filename:"";
include($_SERVER["DOCUMENT_ROOT"]."/my_website/custom_code/$filename.php");
?>