<?php
$video_url = ($action == "edit")?$data->video_url:"";
?>

<div class="form-item">
  <label>Youtube URL:</label>
  <input name="video_url" class="text" placeholder="Please paste the full Youtube video link here" value="<?php print $video_url; ?>" required />
</div>