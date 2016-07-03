<?php
preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $data->video_url, $matches);
$youtube_id = $matches[1];
//$thumbnail_url = "http://i3.ytimg.com/vi/".$youtube_id."/mqdefault.jpg";
$thumbnail_url = "http://i3.ytimg.com/vi/".$youtube_id."/maxresdefault.jpg";
?>

<div class="video-image">
  <img src="<?php print $thumbnail_url; ?>" />
</div>

<?php if ($data->video_description != "") { ?>
<div class="video-description">
  <?php print $data->video_description; ?>
</div>
<?php } ?>