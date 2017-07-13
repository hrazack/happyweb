<?php
$class_align = $data->align;
?>

<div class="image align-<?php print $class_align; ?>">
  <img src="/my_website/uploaded_files/<?php print $data->size; ?>/<?php print $data->file; ?>" />
</div>

<?php if ($data->description != "") { ?>
<div class="description align-<?php print $class_align; ?>">
  <?php print $data->description; ?>
</div>
<?php } ?>