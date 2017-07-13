<?php
$files = json_decode($data->filenames);
if ($data->filenames != "") {
  foreach($files as $obj) {
    $str = $obj->id;
    $part = explode("||", $str);
    $filename = $part[0];
    // delete the original images
    unlink($_SERVER["DOCUMENT_ROOT"]."/my_website/uploaded_files/originals/".$filename);
    // delete the resized images
    unlink($_SERVER["DOCUMENT_ROOT"]."/my_website/uploaded_files/large/".$filename);  
  }
}