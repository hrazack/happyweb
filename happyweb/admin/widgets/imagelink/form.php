<?php
$text = ($action == "edit")?$data->text:"";
$heading = ($action == "edit")?$data->heading:"";
$external_url = "";
$url = ($action == "edit")?$data->url:"";
$label_image = ($action == "edit")?"Select a new image":"Select your image";

$pages_full = array();
$pages_url = array();

// get pages that are in the hierarchy
get_pages_tree($pages_full, $pages_url);

// get other pages
if ($pages = $db->get_results("SELECT * FROM page WHERE parent=-1 AND id!=2 ORDER BY display_order ASC")) {
  foreach($pages as $page) {
    $obj = new stdClass();
    $obj->text = $page->title;
    $obj->value = "/".$page->url;
    $pages_full[] = $obj;
    $pages_url[] = "/".$page->url;
  }
}

if (!in_array($url, $pages_url)) {
  $external_url = $url;
}
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
  <label>Choose the page you would like to link to</label />
  <select name="url" id="image-link-url">
    <option value="">* No link</option>
    <option value="external-url" <?php print ($external_url != "")?"selected":""; ?>>* A page outside of your site</option>
    <?php 
    foreach($pages_full as $page) { 
      $selected = ($url == $page->value)?"selected":"";
      ?>
      <option value="<?php print $page->value; ?>" <?php print $selected; ?>><?php print $page->text; ?></option>
    <?php } ?>
  </select>
</div>
  
<div class="form-item" id="image-link-external-url" style="display: <?php print ($external_url != "")?"block":"none"; ?>;">
  <label>Type the address of the outside page</label />
  <input name="external-url" class="text" value="<?php print $external_url; ?>" placeholder='Something like "www.google.com"' />
</div>

<script>
  $("#image-link-url").change(function() {
    if ($(this).val() == "external-url") {
      $("#image-link-external-url").slideDown();
    }
    else {
      $("#image-link-external-url").slideUp();
    }
  });
</script>
