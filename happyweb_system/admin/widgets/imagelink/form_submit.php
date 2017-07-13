<?php

include($_SERVER["DOCUMENT_ROOT"]."/happyweb_system/includes/image_manipulator.php");
$file_path = $_SERVER["DOCUMENT_ROOT"]."/my_website/uploaded_files/";
$text = (isset($_POST["text"]))?$db->escape($_POST["text"]):"";
$heading = (isset($_POST["heading"]))?$db->escape($_POST["heading"]):"";
$url = (isset($_POST["url"]))?$db->escape($_POST["url"]):"";
if ($url == "external-url") {
  $url = (isset($_POST["external-url"]))?$db->escape($_POST["external-url"]):"";
}

if ($action == "create") {
  
  if ($_FILES['image_file']['error'] == 0) {
    // upload the original image
    $result = upload_image($_FILES['image_file'], $file_path."originals/");
    if ($result->status == "success") {
      // resize the image
      resize_image($result->file_name, $file_path."originals/", "thumbnail");
      // save data
      $file_name = $db->escape($result->file_name);
      $db->query("INSERT INTO widget_imagelink (widget_id, file, heading, text, url) VALUES (".$widget_id.", '".$file_name."', '".$heading."', '".$text."', '".$url."')");
    }
    else {
      $data->status = "error";
      $data->errorMessage = $result->errorMessage;
    }
  }
  else {
    $data->status = "error";
    $data->errorMessage = $_FILES['image_file']['error'];
  }
}

else {
  $original_data = $db->get_row("SELECT * FROM widget_imagelink WHERE widget_id=".$widget_id);
  $db->query("UPDATE widget_imagelink SET text='".$text."', heading='".$heading."', url='".$url."' WHERE widget_id=".$widget_id);
   
  // if we have entered a new image
  if ($_FILES['image_file']['error'] == 0) {
    $result = upload_image($_FILES['image_file'], $file_path."originals/");
    if ($result->status == "success") {
      // resize the image
      resize_image($result->file_name, $file_path."originals/", "thumbnail");
      // save data
      $file_name = $db->escape($result->file_name);
      $db->query("UPDATE widget_imagelink SET file='".$file_name."' WHERE widget_id=".$widget_id);
      // delete the previous image
      unlink($file_path."originals/".$original_data->file);
      // delete the previous resized image
      unlink($file_path."thumbnail/".$original_data->file);
    }
    else {
      $data->status = "error";
      $data->errorMessage = $result->errorMessage;
    }
  }
}

?>