<?php
$path = ($is_export)?"/images/":"/my_website/uploaded_files/";
?>

<div class="image">
  <img src="<?php print $path; ?>thumbnail/<?php print $data->file; ?>" />
</div>

<div class="heading">
  <a href="<?php print $data->url; ?>"><?php print $data->heading; ?></a>
</div>

<?php if ($data->text != "") { ?>
<div class="text">
  <?php print nl2br($data->text); ?>
</div>
<?php } ?>