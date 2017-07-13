<?php
// delete the resized image
unlink($_SERVER["DOCUMENT_ROOT"]."/my_website/uploaded_files/".$data->size."/".$data->file);
// delete the original image
unlink($_SERVER["DOCUMENT_ROOT"]."/my_website/uploaded_files/originals/".$data->file);