<?php
$class_align = $data->align;
$path = ($is_export)?"/images/":"/my_website/uploaded_files/";
?>

<div class="image align-<?php print $class_align; ?>">
  <img src="<?php print $path.$data->size; ?>/<?php print $data->file; ?>" />
</div>

<?php if ($data->description != "") { ?>
<div class="description align-<?php print $class_align; ?>">
  <?php print $data->description; ?>
</div>
<?php } ?>