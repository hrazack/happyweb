<?php
// delete the audio file
unlink($_SERVER["DOCUMENT_ROOT"]."/my_website/uploaded_files/audio/".$data->file);