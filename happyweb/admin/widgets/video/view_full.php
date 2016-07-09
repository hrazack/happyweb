<?php
$youtube_id = get_youtube_id($data->video_url);
$width = 640;
$height = 360;
?>

<div class="video-container">
  <iframe type="text/html" width="<?php echo $width ?>px" height="<?php echo $height ?>px" src="https://www.youtube.com/embed/<?php print $youtube_id; ?>?rel=0&showinfo=0&color=white&iv_load_policy=3" frameborder="0" allowfullscreen></iframe> 
</div>

<?php if ($data->video_description != "") { ?>
<div class="video-description">
  <?php print $data->video_description; ?>
</div>
<?php } ?>