<?php
$video_url = $db->escape($_POST["video_url"]);
$video_description = (isset($_POST["video_description"]))?$db->escape($_POST["video_description"]):"";
$popup = isset($_POST["popup"])?1:0;

if ($action == "create") {
  $db->query("INSERT INTO widget_video (widget_id, video_url, video_description, popup) VALUES (".$widget_id.", '".$video_url."', '".$video_description."', ".$popup.")");
}
else {
  $db->query("UPDATE widget_video SET video_url='".$video_url."', video_description='".$video_description."', popup=".$popup." WHERE widget_id=".$widget_id);
}
?>