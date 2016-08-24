<?php
$text = ($action == "edit")?$data->text:"";
$heading = ($action == "edit")?$data->heading:"";
$url = ($action == "edit")?$data->url:"";
$label_image = ($action == "edit")?"Select a new image":"Select your image";
?>

<?php if ($action == "edit") { ?>

  <div class="form-item">
    <label>Current image:</label />
    <img src="/your_site/uploaded_files/originals/<?php print $data->file; ?>" width="200" />
  </div>
  
<?php } ?>

<div class="form-item">
  <label><?php print $label_image; ?></label />
  <input type="file" name="image_file" />
</div>

<div class="form-item">
  <label>Heading</label />
  <input name="heading" class="text" value="<?php print $heading; ?>" placeholder='A heading for your link' />
</div>

<div class="form-item">
  <label>Text</label />
  <textarea name="text" placeholder='Some text that will make your visitors go: "Oh yeah, I would love to go read that page!"'><?php print $text; ?></textarea>
</div>

<div class="form-item">
  <label>Address of the page you would like to link to</label />
  <input name="url" class="text" value="<?php print $url; ?>" placeholder='Something like "about-us", or "contact/location-map"' />
</div>

