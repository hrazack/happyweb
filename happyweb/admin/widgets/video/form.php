<?php
$video_url = ($action == "edit")?$data->video_url:"";
$video_description = ($action == "edit")?$data->video_description:"";
$checked = (($action == "edit" && $data->popup == 1) || $action != "edit")?"checked":"";
?>

<div class="form-item">
  <label>Youtube or Vimeo URL:</label>
  <input name="video_url" class="text" placeholder="Please paste the full Youtube or Vimeo video link here" value="<?php print $video_url; ?>" required />
</div>

<div class="form-item">
  <label>Description:</label>
  <textarea name="video_description" placeholder="An optional description for your video"><?php print $video_description; ?></textarea>
</div>

<div class="form-item">
  <input type="checkbox" name="popup" value="1" <?php print $checked; ?> />
  <label class="inline">Open this video in a popup (rather than embedded in the page)</label>
</div>