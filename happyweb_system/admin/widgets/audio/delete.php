<?php
// delete the audio file
if ($data->type == "upload" && $data->file != "") {
  unlink($_SERVER["DOCUMENT_ROOT"]."/my_website/uploaded_files/audio/".$data->file);
}