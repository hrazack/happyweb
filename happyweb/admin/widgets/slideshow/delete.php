<?php
$files = json_decode($data->filenames);
if ($data->filenames != "") {
  foreach($files as $obj) {
    // delete the original images
    unlink($_SERVER["DOCUMENT_ROOT"]."/your_site/uploaded_files/originals/".$obj->id);
    // delete the resized images
    unlink($_SERVER["DOCUMENT_ROOT"]."/your_site/uploaded_files/large/".$obj->id);  
  }
}