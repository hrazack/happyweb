<?php if ($data->type == "url") { ?>

  URL: <?php print $data->url; ?>

<?php } else { ?>

  <?php if ($data->title != "") { ?>
  <div class="title">
    <?php print $data->title; ?>
  </div>
  <?php } ?>

  <em><?php print $data->file; ?></em>

  <?php if ($data->description != "") { ?>
  <div class="description">
    <?php print $data->description; ?>
  </div>
  <?php } ?>

<?php } ?>