<?php
$label = ($action == "edit")?"Select a new image":"Select your image";
$description = ($action == "edit")?$data->description:"";
$checked_align_right = ($data->align_right == 1)?"checked":"";
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
  <label>Description</label />
  <textarea name="description" class="formatted"><?php print $description; ?></textarea>
</div>

<p><a class="more"><i class="material-icons icon-open">arrow_right</i><i class="material-icons icon-close">arrow_drop_down</i> More options for this image</a></p>

<div id="options" style="display: none;">
  
  <div class="form-item">
    <input type="checkbox" name="align_right" <?php print $checked_align_right; ?> />
    <label class="inline">Stick the image to the right</label>
  </div>
  
  <div class="form-item">
    <label>Choose a size</label>
    <div class="form-item-radio"><input type="radio" class="radio" name="size" value="large" <?php print $checked_large; ?> /> Large <span class="comment">(if you've put the image in a very wide column)</span></div>
    <div class="form-item-radio"><input type="radio" class="radio" name="size" value="medium" <?php print $checked_medium; ?> /> Medium  <span class="comment">(for all other cases)</span></div>
    <!--<div class="form-item-radio"><input type="radio" class="radio" name="size" value="small" <?php print $checked_small; ?> /> Small</div>-->
  </div>

</div>