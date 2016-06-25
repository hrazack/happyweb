<form action="<?php print $url_info["path"];?>" method="post">

  <div class="columns-container two">
  
    <div class="column column1">
  
      <div class="form-item">
        <label>Page title:</label>
        <input type="text" name="title" class="text" value="<?php print $page_title; ?>" placeholder="A simple but eloquent title for the page" required />
      </div>
      
      <div class="form-item">
        <label>Description:</label>
        <textarea name="description" rows="3" placeholder="This is optional. It is used for search engines like Google. Let's type something that will describe your awesome page!"><?php print $description; ?></textarea>
      </div>
      
    </div>
    
    <div class="column column2">
    
      <div class="form-item">
        <label>Page address:</label>
        <input type="text" name="url" class="text" value="<?php print $page_url; ?>" placeholder="Something like 'about-us', or 'news/a-cool-news'" required />
      </div>
      
      <div class="form-item">
        <label>Page position:</label>
        <select name="parent">
          <?php
          if ($action == "create") {
            $selected_nowhere = "selected";
            $selected_top = "";
          }
          else {
            $selected_nowhere = ($page->parent == -1)?"selected":"";
            $selected_top = ($page->parent == 0)?"selected":"";
          }
          ?>
          <option value="-1" <?php print $selected_nowhere; ?>>Nowhere</option>
          <option value="0" <?php print $selected_top; ?>>In the top navigation</option>
          <?php
          if ($pages = $db->get_results("SELECT * FROM page WHERE parent!=-1 AND id!=1")) {
            foreach($pages as $p) {
              if ($action == "create") {
                $selected = "";
              }
              else {
                $selected = ($page->parent == $p->id)?"selected":"";
              }
              ?>
              <option value="<?php print $p->id; ?>" <?php print $selected; ?>>Below "<?php print $p->title; ?>"</option>
              <?php
            }
          }
          ?>
        </select>
      </div>
      
    </div>
  
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
  
  <input type="submit" value="Save this page" class="submit page with-cancel" />
  <a href="/admin" class="cancel"><i class="material-icons big">clear</i> Mmm, no, let's go back</a>
  
  <input type="hidden" name="deleted_rows" value="" />
  <input type="hidden" name="deleted_widgets" value="" />
  <input type="hidden" name="number_of_rows" value="<?php print $number_of_rows; ?>" />
  <input type="hidden" name="action" value="form_page" />
  
</form>


<div id="widget-list">
  <ul class="widget-list">
    <li><a data-widget-type="text" class="text"><i class="material-icons bigger">subject</i>Some text</a></li>
    <li><a data-widget-type="image" class="image"><i class="material-icons bigger">image</i>An image</a></li>
    <li><a data-widget-type="video" class="video"><i class="material-icons bigger">video_label</i>A video</a></li>
  </ul>
</div>