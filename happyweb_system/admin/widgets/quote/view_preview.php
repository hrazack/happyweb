<?php
$text = (isset($data->text))?$data->text:"";
$author = (isset($data->author))?$data->author:"";
?>

<div class="quote-text">
  <?php print $data->text; ?>
</div>

<div class="quote-author">
  <?php print $data->author; ?>
</div>