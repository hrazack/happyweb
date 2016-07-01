<form action="<?php print $url_info["path"];?>" method="post">

  <div class="form-item">
    <label>Page title:</label>
    <input type="text" name="title" class="text" value="<?php print $page_title; ?>" placeholder="A simple but eloquent title for the page" required />
  </div>
  
  <div class="form-item">
    <label>Page address:</label>
    <input type="text" name="url" class="text" value="<?php print $page_url; ?>" placeholder="Something like 'about-us', or 'news/a-cool-news'" required />
  </div>
      
  <p><a class="more"><i class="material-icons icon-open">arrow_right</i><i class="material-icons icon-close">arrow_drop_down</i> More amazing options for this page</a></p>

  <div id="page-options">
  
    <div class="form-item">
      <label>Page position:</label>
      <select name="parent">
        <?php
        if (!isset($page)) {
          $selected_nowhere = "selected";
          $selected_top = "";
        }
        else {
          $selected_nowhere = ($page->parent == -1)?"selected":"";
          $selected_top = ($page->parent == 0)?"selected":"";
        }
        ?>
        <option value="-1" <?php print $selected_nowhere; ?>>Nowhere, it's a standalone page</option>
        <option value="0" <?php print $selected_top; ?>>In the top navigation</option>
        <?php
        if ($pages = $db->get_results("SELECT * FROM page WHERE parent=0 AND id!=1 ORDER BY display_order ASC")) {
          foreach($pages as $p) {
            if (!isset($page)) {
              $selected = "";
            }
            else {
              $selected = ($page->parent == $p->id)?"selected":"";
            }
            ?>
            <option value="<?php print $p->id; ?>" <?php print $selected; ?>>Under "<?php print $p->title; ?>"</option>
            <?php
          }
        }
        ?>
      </select>
    </div>
    
    <div class="form-item">
      <label>Description:</label>
      <textarea id="textarea" name="description" rows="3" placeholder="This is optional. It is used for search engines like Google. Let's type something that will describe your awesome page!"><?php print $description; ?></textarea>
    </div>
  
  </div>
      
  <label>Page content:</label>
  <div id="rows-container">
    <?php    
    $index_row = 1;
    foreach($rows as $row) {
      include("inc_form_row.php");
      $index_row++;
    }
    ?>
  </div>
  
  <p class="add-row"><a id="add-row" class="grey"><i class="material-icons md-24">add_circle</i> Add another row</a></p>
  
  <input type="submit" value="Save this page" class="submit page" />
  <a href="/admin" class="cancel">Cancel</a>
  
  <input type="hidden" name="deleted_rows" value="" />
  <input type="hidden" name="deleted_widgets" value="" />
  <input type="hidden" name="number_of_rows" value="<?php print $number_of_rows; ?>" />
  <input type="hidden" name="return" value="<?php print isset($_GET["return-to-page"])?"page":"admin"; ?>" />
  <input type="hidden" name="action" value="form_page" />
  
</form>


<div id="widget-list">
  <ul class="widget-list">
    <li><a data-widget-type="text" class="text"><i class="material-icons bigger">subject</i>Some text</a></li>
    <li><a data-widget-type="image" class="image"><i class="material-icons bigger">image</i>An image</a></li>
    <li><a data-widget-type="video" class="video"><i class="material-icons bigger">video_label</i>A video</a></li>
  </ul>
  <p><a class="more"><i class="material-icons icon-open">arrow_right</i><i class="material-icons icon-close">arrow_drop_down</i> More things you can add</a></p>
  <ul class="widget-list extra">
    <li><a data-widget-type="navigation" class="navigation"><i class="material-icons bigger">featured_play_list</i>Navigation</a></li>
  </ul>
</div>