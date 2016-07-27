<?php
$video = get_video($data->video_url);
?>

<div class="video-container">
  <?php print $video; ?>
</div>

<?php if ($data->video_description != "") { ?>
<div class="video-description">
  <?php print $data->video_description; ?>
</div>
<?php } ?>