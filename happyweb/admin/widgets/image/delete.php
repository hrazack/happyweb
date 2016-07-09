<?php
// delete the original image
unlink($_SERVER["DOCUMENT_ROOT"]."/your_site/uploaded_files/".$data->size."/".$data->file);
// delete the resized image
unlink($_SERVER["DOCUMENT_ROOT"]."/your_site/uploaded_files/originals/".$data->file);