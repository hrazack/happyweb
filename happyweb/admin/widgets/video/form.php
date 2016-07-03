<?php
$video_url = ($action == "edit")?$data->video_url:"";
$video_description = ($action == "edit")?$data->video_description:"";
?>

<div class="form-item">
  <label>Youtube URL:</label>
  <input name="video_url" class="text" placeholder="Please paste the full Youtube video link here" value="<?php print $video_url; ?>" required />
</div>

<div class="form-item">
  <label>Description:</label>
  <textarea name="video_description" placeholder="An optional description for your video"><?php print $video_description; ?></textarea>
</div>