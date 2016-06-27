<?php
$label = "Select your image";
if ($action == "edit") {
  $checked_large = ($data->size == "large")?"checked":"";
  $checked_medium = ($data->size == "medium")?"checked":"";
  $checked_small = ($data->size == "small")?"checked":"";
}
else {
  $checked_large = "checked";
  $checked_medium = "";
  $checked_small = "";
}
?>

<?php 
if ($action == "edit") { 
  $label = "Select a new image";
  ?>

  <div class="form-item">
    <label>Current image:</label />
    <img src="/uploaded_files/originals/<?php print $data->file; ?>" width="200" />
  </div>
  
<?php } ?>

<div class="form-item">
  <label><?php print $label; ?></label />
  <input type="file" name="image_file" />
</div>

<div class="form-item">
  <label>Choose a size</label>
  <div class="form-item-radio"><input type="radio" class="radio" name="size" value="large" <?php print $checked_large; ?> /> Large</div>
  <div class="form-item-radio"><input type="radio" class="radio" name="size" value="medium" <?php print $checked_medium; ?> /> Medium</div>
  <div class="form-item-radio"><input type="radio" class="radio" name="size" value="small" <?php print $checked_small; ?> /> Small</div>
</div>