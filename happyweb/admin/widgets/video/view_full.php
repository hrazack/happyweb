<?php 
if ($data->popup == 0) {
  ?>
  <div class="video-container">
    <?php print get_video_iframe($data->video_url); ?>
  </div>
  <?php
}
else {
  $thumbnail_url = get_video_thumbnail($data->video_url);
  ?>
  <div class="video-thumbnail">
    <a href="<?php print get_video_embed($data->video_url); ?>" class="colorbox">
      <img src="<?php print $thumbnail_url; ?>" />
    </a>
  </div>
  <?php
}
?>

<?php if ($data->video_description != "") { ?>
<div class="video-description">
  <?php print $data->video_description; ?>
</div>
<?php } ?>
