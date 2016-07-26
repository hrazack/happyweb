<?php
$text = (isset($data->text))?$data->text:"";
?>

<textarea class="formatted" name="widget_text[<?php print $widget->id; ?>]">
  <?php print $text; ?>
</textarea>