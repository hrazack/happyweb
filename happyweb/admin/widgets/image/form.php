<?php
$label = ($action == "edit")?"Select a new image":"Select your image";
$description = ($action == "edit")?$data->description:"";
if ($action == "edit") {
  $checked_large = ($data->size == "large")?"checked":"";
  $checked_medium = ($data->size == "medium")?"checked":"";
  $checked_small = ($data->size == "small")?"checked":"";
}
else {
  $checked_large = "";
  $checked_medium = "checked";
  $checked_small = "";
}
?>

<?php if ($action == "edit") { ?>

  <div class="form-item">
    <label>Current image:</label />
    <img src="/your_site/uploaded_files/originals/<?php print $data->file; ?>" width="200" />
  </div>
  
<?php } ?>

<div class="form-item">
  <label><?php print $label; ?></label />
  <input type="file" name="image_file" />
</div>

<div class="form-item">
  <label>Choose a size</label>
  <div class="form-item-radio"><input type="radio" class="radio" name="size" value="large" <?php print $checked_large; ?> /> Large <span class="comment">(if you've put the image in a very wide column)</span></div>
  <div class="form-item-radio"><input type="radio" class="radio" name="size" value="medium" <?php print $checked_medium; ?> /> Medium  <span class="comment">(for all other cases)</span></div>
  <!--<div class="form-item-radio"><input type="radio" class="radio" name="size" value="small" <?php print $checked_small; ?> /> Small</div>-->
</div>

<div class="form-item">
  <label>description</label />
  <textarea name="description" class="formatted"><?php print $description; ?></textarea>
</div>