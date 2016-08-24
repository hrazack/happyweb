<?php
// delete the resized image
unlink($_SERVER["DOCUMENT_ROOT"]."/your_site/uploaded_files/thumbnail/".$data->file);
// delete the original image
unlink($_SERVER["DOCUMENT_ROOT"]."/your_site/uploaded_files/originals/".$data->file);