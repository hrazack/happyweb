<?php
$youtube_id = get_youtube_id($data->video_url);
$thumbnail_url = "http://i3.ytimg.com/vi/".$youtube_id."/mqdefault.jpg";
//$thumbnail_url = "http://i3.ytimg.com/vi/".$youtube_id."/maxresdefault.jpg";
?>

<div class="video-image">
  <img src="<?php print $thumbnail_url; ?>" />
</div>

<?php if ($data->video_description != "") { ?>
<div class="video-description">
  <?php print $data->video_description; ?>
</div>
<?php } ?>