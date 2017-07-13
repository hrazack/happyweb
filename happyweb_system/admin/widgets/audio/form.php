<?php
$label = ($action == "edit")?"Select a new MP3 file":"Select an MP3 file";
$title = ($action == "edit")?$data->title:"";
$description = ($action == "edit")?$data->description:"";
?>

<?php if ($action == "edit") { ?>

  <div class="form-item">
    <label>Current file:</label />
    <em><?php print $data->file; ?></em>
  </div>
  
<?php } ?>

<div class="form-item">
  <label><?php print $label; ?></label />
  <input type="file" name="file" />
</div>

<div class="form-item">
  <label>Title</label />
  <input name="title" class="text" value="<?php print $title; ?>" />
</div>

<div class="form-item">
  <label>Description</label />
  <textarea name="description"><?php print $description; ?></textarea>
</div>