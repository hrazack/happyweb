<?php
//add_js('<script src="/happyweb/includes/audiojs/audio.min.js"></script>');
//add_js('<script>audiojs.events.ready(function(){var as = audiojs.createAll();});</script>');
add_js('<script src="/happyweb/includes/audioplayer/audioplayer.min.js"></script>');
add_js('<script>$(function(){$(\'audio\').audioPlayer();});</script>');
add_css('<link rel="stylesheet" href="/happyweb/includes/audioplayer/audioplayer.css" />');
?>

<?php if ($data->title != "") { ?>
<h4 class="title">
  <?php print $data->title; ?>
</h4>
<?php } ?>

<?php if ($data->description != "") { ?>
<div class="description">
  <?php print $data->description; ?>
</div>
<?php } ?>

<div>
  <audio src="<?php print base_url(); ?>/your_site/uploaded_files/audio/<?php print $data->file; ?>" preload="auto" control />
</div>



