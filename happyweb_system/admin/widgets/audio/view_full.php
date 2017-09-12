<?php if ($data->type == "url") { ?>

  <?php
  // add soundcloud player
  add_js('<script type="text/javascript" src="/happyweb_system/includes/soundcloud_player/soundcloud.player.api.js"></script>');
  add_js('<script type="text/javascript" src="/happyweb_system/includes/soundcloud_player/sc-player.js"></script>');
  add_css('<link rel="stylesheet" href="/happyweb_system/includes/soundcloud_player/sc-player.css" type="text/css">');
  ?>

  <a href="<?php print $data->url; ?>" class="sc-player"></a>

<?php } else { ?>

  <?php
  // add audio player
  add_js('<script src="/happyweb_system/includes/audioplayer/audioplayer.min.js"></script>');
  add_js('<script>$(function(){$(\'audio\').audioPlayer();});</script>');
  add_css('<link rel="stylesheet" href="/happyweb_system/includes/audioplayer/audioplayer.css" />');
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
    <audio src="<?php print base_url(); ?>/my_website/uploaded_files/audio/<?php print $data->file; ?>" preload="auto" control />
  </div>

<?php } ?>
