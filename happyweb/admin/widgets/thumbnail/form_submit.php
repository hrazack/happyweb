<?php

include($_SERVER["DOCUMENT_ROOT"]."/happyweb/includes/image_manipulator.php");
$file_path = "your_site/uploaded_files/";
$text = (isset($_POST["text"]))?$db->escape($_POST["text"]):"";
$heading = (isset($_POST["heading"]))?$db->escape($_POST["heading"]):"";
$url = (isset($_POST["url"]))?$db->escape($_POST["url"]):"";

if ($action == "create") {
  
  if ($_FILES['image_file']['error'] > 0) {
    $data->status = "error";
    $data->errorMessage = $_FILES['image_file']['error'];
  } 
  else {
    // upload the original image
    $result = upload_image($_FILES['image_file'], $file_path."originals/");
    if ($result->status == "success") {
      // resize the image
      resize_image($result->file_name, $file_path."originals/", "thumbnail");
      // save data
      $file_name = $db->escape($result->file_name);
      $db->query("INSERT INTO widget_thumbnail (widget_id, file, heading, text, url) VALUES (".$widget_id.", '".$file_name."', '".$heading."', '".$text."', '".$url."')");
    }
    else {
      $data->status = "error";
      $data->errorMessage = $result->erroMessage;
    }
  }
}

else {
  $original_data = $db->get_row("SELECT * FROM widget_thumbnail WHERE widget_id=".$widget_id);
  $db->query("UPDATE widget_thumbnail SET text='".$text."', heading='".$heading."', url='".$url."' WHERE widget_id=".$widget_id);
   
  // if we have entered a new image
  if ($_FILES['image_file']['error'] == 0) {
    $result = upload_image($_FILES['image_file'], $file_path."originals/");
    if ($result->status == "success") {
      // resize the image
      resize_image($result->file_name, $file_path."originals/", "thumbnail");
      // save data
      $file_name = $db->escape($result->file_name);
      $db->query("UPDATE widget_thumbnail SET file='".$file_name."' WHERE widget_id=".$widget_id);
      // delete the previous image
      unlink($_SERVER["DOCUMENT_ROOT"]."/".$file_path."medium/".$original_data->file);
      // delete the previous resized image
      unlink($_SERVER["DOCUMENT_ROOT"]."/".$file_path."originals/".$original_data->file);
    }
    else {
      $data->status = "error";
      $data->errorMessage = $result->erroMessage;
    }
  }
}

?>