<?php
$text = ($action == "edit")?$data->text:"";
$author = ($action == "edit")?$data->author:"";
?>

<div class="form-item">
  <textarea name="text" placeholder="The text for the quote" required><?php print $text; ?></textarea>
</div>

<div class="form-item">
  <input name="author" placeholder="The author of the quote" class="text" value="<?php print $author; ?>" required />
</div>