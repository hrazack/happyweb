<?php
$class_align = ($data->align_right == 1)?"right":"";
?>

<div class="image <?php print $class_align; ?>">
  <img src="/your_site/uploaded_files/<?php print $data->size; ?>/<?php print $data->file; ?>" />
</div>

<?php if ($data->description != "") { ?>
<div class="description">
  <?php print $data->description; ?>
</div>
<?php } ?>