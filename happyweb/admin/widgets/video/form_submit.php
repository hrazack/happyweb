<?php
$video_url = $db->escape($_POST["video_url"]);
$video_description = $db->escape($_POST["video_description"]);

if ($action == "create") {
  $db->query("INSERT INTO widget_video (widget_id, video_url, video_description) VALUES (".$widget_id.", '".$video_url."', '".$video_description."')");
}
else {
  $db->query("UPDATE widget_video SET video_url='".$video_url."', video_description='".$video_description."' WHERE widget_id=".$widget_id);
}
?>