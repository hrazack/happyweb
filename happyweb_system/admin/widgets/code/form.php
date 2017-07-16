<?php
$filename = ($action == "edit")?$data->filename:"";
?>

<div class="form-item">
  <input name="filename" placeholder="The file in /custom_code" class="text" value="<?php print $filename; ?>" required />
</div>