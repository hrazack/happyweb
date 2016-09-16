<?php

$file_path = $_SERVER["DOCUMENT_ROOT"]."/your_site/uploaded_files/";
$title = $db->escape($_POST["title"]);
$description = $db->escape($_POST["description"]);

// uploading a new file
if ($action == "create") {
  
  if ($_FILES['file']['error'] == 0) {
    // upload the file
    $result = upload_file($_FILES['file'], $file_path."audio/");
    if ($result->status == "success") {
      // save data
      $file_name = $db->escape($result->file_name);
      $db->query("INSERT INTO widget_audio (widget_id, file, title, description) VALUES (".$widget_id.", '".$file_name."', '".$title."', '".$description."')");
    }
    else {
      $data->status = "error";
      $data->errorMessage = $result->errorMessage;
    }
  }
  else {
    $data->status = "error";
    $data->errorMessage = $_FILES['file']['error'];
  }
}

// editing an existing file
else {
   $original_data = $db->get_row("SELECT * FROM widget_audio WHERE widget_id=".$widget_id);
   $db->query("UPDATE widget_audio SET title='".$title."', description='".$description."' WHERE widget_id=".$widget_id);
   
  // if we have entered a new file
  if ($_FILES['file']['error'] == 0) {
    $result = upload_file($_FILES['file'], $file_path."audio/");
    if ($result->status == "success") {
      // save data
      $file_name = $db->escape($result->file_name);
      $db->query("UPDATE widget_audio SET file='".$file_name."' WHERE widget_id=".$widget_id);
      // delete the previous file
      unlink($file_path."audio/".$original_data->file);
    }
    else {
      $data->status = "error";
      $data->errorMessage = $result->errorMessage;
    }
  }
}

?>