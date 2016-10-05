<?php

include($_SERVER["DOCUMENT_ROOT"]."/happyweb/includes/image_manipulator.php");
$file_path = $_SERVER["DOCUMENT_ROOT"]."/your_site/uploaded_files/";
$size = $db->escape($_POST["size"]);
$description = $db->escape($_POST["description"]);
$align_right = (isset($_POST["align_right"]))?1:0;

// uploading a new image
if ($action == "create") {
  
  if ($_FILES['image_file']['error'] == 0) {
    // upload the original image
    $result = upload_image($_FILES['image_file'], $file_path."originals/");
    if ($result->status == "success") {
      // resize the image
      resize_image($result->file_name, $file_path."originals/", $size);
      // save data
      $file_name = $db->escape($result->file_name);
      $db->query("INSERT INTO widget_image (widget_id, file, size, description, align_right) VALUES (".$widget_id.", '".$file_name."', '".$size."', '".$description."', ".$align_right.")");
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

// editing an existing image
else {
   $original_data = $db->get_row("SELECT * FROM widget_image WHERE widget_id=".$widget_id);
   $db->query("UPDATE widget_image SET description='".$description."', align_right=".$align_right." WHERE widget_id=".$widget_id);
   
  // if we have entered a new image
  if ($_FILES['image_file']['error'] == 0) {
    $result = upload_image($_FILES['image_file'], $file_path."originals/");
    if ($result->status == "success") {
      // resize the image
      resize_image($result->file_name, $file_path."originals/", $size);
      // save data
      $file_name = $db->escape($result->file_name);
      $db->query("UPDATE widget_image SET file='".$file_name."', size='".$size."' WHERE widget_id=".$widget_id);
      // delete the previous image
      unlink($file_path."originals/".$original_data->file);
      // delete the previous resized image
      unlink($file_path.$original_data->size."/".$original_data->file);
    }
    else {
      $data->status = "error";
      $data->errorMessage = $result->errorMessage;
    }
  }
  
  // if we don't have a new image
  else {
    // check if we have changed the size
    if ($original_data->size != $size) {
      // if so, resize the image
      resize_image($original_data->file, $file_path."originals/", $size);
      $db->query("UPDATE widget_image SET size='".$size."' WHERE widget_id=".$widget_id);
      // delete the previous resized image
      unlink($file_path.$original_data->size."/".$original_data->file);
    }
  }
  
}

?>