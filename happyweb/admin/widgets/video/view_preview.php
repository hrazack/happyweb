<?php
preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $data->video_url, $matches);
$youtube_id = $matches[1];
$thumbnail_url = "http://i3.ytimg.com/vi/".$youtube_id."/default.jpg";
print "<img src='".$thumbnail_url."' />";
?>