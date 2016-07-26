<?php
$text = ($action == "edit")?$data->text:"";
?>

<div class="form-item">
  <textarea name="text" class="formatted" placeholder="Let's type some text! You can use the buttons above to format your text" required>
    <?php print $text; ?>
  </textarea>
</div>