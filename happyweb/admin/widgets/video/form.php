<?php
$video_url = ($action == "edit")?$data->video_url:"";
$video_description = ($action == "edit")?$data->video_description:"";
$selected_popup = (($action == "edit" && $data->popup == 1) || $action != "edit")?"checked":"";
$selected_embedded = ($action == "edit" && $data->popup == 0)?"checked":"";
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
  <label>Options:</label>
  <div><input type="radio" name="popup" value="1" <?php print $selected_popup; ?> /> <label class="inline">This video will open in a popup</label></div>
  <div><input type="radio" name="popup" value="0" <?php print $selected_embedded; ?> /> <label class="inline">This video will be displayed directly on the page</label></div>
</div>