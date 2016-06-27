<?php

include($_SERVER["DOCUMENT_ROOT"]."/happyweb/includes/image_manipulator.php");
$path = "uploaded_files/originals/";
$size = $db->escape($_POST["size"]);

// uploading a new image
if ($action == "create") {
  
  if ($_FILES['image_file']['error'] > 0) {
    $data->status = "error";
    $data->errorMessage = $_FILES['image_file']['error'];
  } else {
    // upload the original image
    $result = upload_image($_FILES['image_file'], $path);
    if ($result->status == "success") {
      // resize the image
      resize_image($result->file_name, $path, $size);
      // save data
      $file_name = $db->escape($result->file_name);
      $db->query("INSERT INTO widget_image (widget_id, file, size) VALUES (".$widget_id.", '".$file_name."', '".$size."')");
    }
    else {
      $data->status = "error";
      $data->errorMessage = $result->erroMessage;
    }
  }
}

// editing an existing image
else {
   $original_data = $db->get_row("SELECT * FROM widget_image WHERE widget_id=".$widget_id);
   
  // if we have entered a new image
  if ($_FILES['image_file']['error'] == 0) {
    $result = upload_image($_FILES['image_file'], $path);
    if ($result->status == "success") {
      // resize the image
      resize_image($result->file_name, $path, $size);
      // save data
      $file_name = $db->escape($result->file_name);
      $db->query("UPDATE widget_image SET file='".$file_name."', size='".$size."' WHERE widget_id=".$widget_id);
      // delete the previous image
      unlink($_SERVER["DOCUMENT_ROOT"]."/uploaded_files/".$original_data->size."/".$original_data->file);
      // delete the previous resized image
      unlink($_SERVER["DOCUMENT_ROOT"]."/uploaded_files/originals/".$original_data->file);
    }
    else {
      $data->status = "error";
      $data->errorMessage = $result->erroMessage;
    }
  }
  
  // if we don't have a new image
  else {
    // check if we have changed the size
    if ($original_data->size != $size) {
      // if so, resize the image
      resize_image($original_data->file, $path, $size);
      $db->query("UPDATE widget_image SET size='".$size."' WHERE widget_id=".$widget_id);
      // delete the previous resized image
      unlink($_SERVER["DOCUMENT_ROOT"]."/uploaded_files/".$original_data->size."/".$original_data->file);
    }
  }
  
}

?>