<img src="/your_site/uploaded_files/thumbnail/<?php print $data->file; ?>" />

<div class="heading">
  <a href="/<?php print $data->url; ?>"><?php print $data->heading; ?></a>
</div>

<?php if ($data->text != "") { ?>
<div class="text">
  <?php print $data->text; ?>
</div>
<?php } ?>