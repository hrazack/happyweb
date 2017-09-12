<?php
$selected_url = (($action == "edit" && $data->type == "url") || $action != "edit")?"checked":"";
$selected_upload = ($action == "edit" && $data->type == "upload")?"checked":"";
$style_url = ($selected_url == "")?"display: none;":"";
$style_upload = ($selected_upload == "")?"display: none;":"";
$label_file = ($action == "edit")?"Select a new MP3 file":"Select an MP3 file";
$url = ($action == "edit")?$data->url:"";
$title = ($action == "edit")?$data->title:"";
$description = ($action == "edit")?$data->description:"";
?>

<div class="form-item">
  <label>What method shall we use:</label>
  <div><input type="radio" name="type" value="url" id="select-url" <?php print $selected_url; ?> /> <label class="inline">Enter a Soundcloud URL</label></div>
  <div><input type="radio" name="type" value="upload" id="select-upload" <?php print $selected_upload; ?> /> <label class="inline">Upload an MP3 file</label></div>
</div>

<div id="form-url" style="<?php print $style_url; ?>">

  <div class="form-item">
    <label>Soundcloud URL</label />
    <input name="url" class="text" value="<?php print $url; ?>" />
  </div>

</div>

<div id="form-upload" style="<?php print $style_upload; ?>">

  <?php if ($action == "edit") { ?>

    <div class="form-item">
      <label>Current MP3 file:</label />
      <em><?php print $data->file; ?></em>
    </div>
    
  <?php } ?>

  <div class="form-item">
    <label><?php print $label_file; ?></label />
    <input type="file" name="file" />
  </div>

  <div class="form-item">
    <label>Title</label />
    <input name="title" class="text" value="<?php print $title; ?>" />
  </div>

</div>

<div class="form-item">
  <label>Description</label />
  <textarea name="description"><?php print $description; ?></textarea>
</div>

<script>
$(document).ready(function() {
  $("input[name=type]").change(function(e) {
    $("#form-url").toggle();
    $("#form-upload").toggle();
  });
});
</script>