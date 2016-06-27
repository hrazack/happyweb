<?php
$video_url = $db->escape($_POST["video_url"]);

if ($action == "create") {
  $db->query("INSERT INTO widget_video (widget_id, video_url) VALUES (".$widget_id.", '".$video_url."')");
}
else {
  $db->query("UPDATE widget_video SET video_url='".$video_url."' WHERE widget_id=".$widget_id);
}
?>