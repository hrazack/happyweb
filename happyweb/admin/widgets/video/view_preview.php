<?php
$thumbnail_url = get_video_thumbnail($data->video_url);
?>

<div class="video-image">
  <img src="<?php print $thumbnail_url; ?>" />
</div>

<?php if ($data->video_description != "") { ?>
<div class="video-description">
  <?php print $data->video_description; ?>
</div>
<?php } ?>