<?php
include($_SERVER["DOCUMENT_ROOT"]."/happyweb/includes/image_manipulator.php");
require($_SERVER["DOCUMENT_ROOT"]."/happyweb/includes/functions.php");
require($_SERVER["DOCUMENT_ROOT"]."/happyweb/includes/functions_admin.php");
$file_path = $_SERVER['DOCUMENT_ROOT']."/your_site/uploaded_files/";

$data = new stdClass();
foreach($_FILES as $file) {
  // upload the original image
  $result = upload_image($file, $file_path."originals/");
  if ($result->status == "success") {
    $data->files[] = $file["name"];
    // resize the image
    resize_image($result->file_name, $file_path."originals/", "large");
  }
}
print json_encode($data);
