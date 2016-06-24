<?php
$text = ($action == "edit")?$data->text:"";
?>

<div class="form-item">
  <textarea name="text" placeholder="type some content for your page" required><?php print $text; ?></textarea>
</div>