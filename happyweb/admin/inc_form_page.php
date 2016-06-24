<form action="<?php print $url_info["path"];?>" method="post">

  <div class="form-item">
    <label>Page title:</label>
    <input type="text" name="title" class="text" value="<?php print $page_title; ?>" placeholder="Something to describe the page" required />
  </div>
  
  <div class="form-item">
    <label>Page address:</label>
    <input type="text" name="url" class="text" value="<?php print $page_url; ?>" placeholder="Something like 'about-us', or 'news/a-cool-news'" required />
  </div>
  
  <div id="rows-container">
    <?php    
    $index_row = 1;
    foreach($rows as $row) {
      include("inc_form_row.php");
      $index_row++;
    }
    ?>
  </div>
  
  <p><a id="add-row" class="grey"><i class="material-icons md-24">add_circle</i> Add another row</a></p>
  
  <input type="submit" value="Save this page" class="submit with-cancel" />
  <a href="/admin" class="cancel"><i class="material-icons big">clear</i> Mmm, no, let's go back</a>
  
  <input type="hidden" name="deleted_rows" value="" />
  <input type="hidden" name="deleted_widgets" value="" />
  <input type="hidden" name="number_of_rows" value="<?php print $number_of_rows; ?>" />
  <input type="hidden" name="action" value="form_page" />
  
</form>