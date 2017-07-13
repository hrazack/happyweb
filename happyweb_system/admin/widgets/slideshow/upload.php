<?php
include($_SERVER["DOCUMENT_ROOT"]."/happyweb_system/includes/image_manipulator.php");
require($_SERVER["DOCUMENT_ROOT"]."/happyweb_system/includes/functions.php");
require($_SERVER["DOCUMENT_ROOT"]."/happyweb_system/includes/functions_admin.php");
$file_path = $_SERVER['DOCUMENT_ROOT']."/my_website/uploaded_files/";

$data = new stdClass();
$data->status = "success";
foreach($_FILES as $file) {
  // upload the original image
  $result = upload_image($file, $file_path."originals/");
  if ($result->status == "success") {
    $data->files[] = $file["name"];
    // resize the image
    resize_image($result->file_name, $file_path."originals/", "large");
  }
  else {
    $data->status = "error";
    $data->errorMessage = $result->errorMessage;
  }
}
print json_encode($data);
