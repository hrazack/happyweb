<?php
preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $data->video_url, $matches);
$youtube_id = $matches[1];
$width = 640;
$height = 360;
?>

<iframe type="text/html" 
  width="<?php echo $width ?>px" 
  height="<?php echo $height ?>px"
  src="https://www.youtube.com/embed/<?php print $youtube_id; ?>?rel=0&showinfo=0&color=white&iv_load_policy=3"
  frameborder="0" allowfullscreen>
</iframe> 