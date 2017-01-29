<form action="<?php print $url_info["path"];?>" method="post">

  <div class="form-item">
    <label>Page title:</label>
    <input type="text" name="title" class="text" value="<?php print $page_title; ?>" placeholder="A simple but eloquent title for the page" required />
  </div>
  
  <div class="form-item">
    <label>Page address:</label>
    <input type="text" name="url" class="text" value="<?php print $page_url; ?>" placeholder="Something like 'about-us', or 'news/a-cool-news'" required />
  </div>
      
  <p><a class="more"><i class="material-icons icon-open">arrow_right</i><i class="material-icons icon-close">arrow_drop_down</i> More mind-blasting options for this page</a></p>

  <div id="page-options">

    <div class="form-item">
      <label>Select the parent of the page:</label>
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
        <option value="-1" <?php print $selected_nowhere; ?>>* No parent, it's a standalone page</option>
        <option value="0" <?php print $selected_top; ?>>* In the top navigation</option>
        <?php
        $pages = array();
        get_pages_tree($pages);
        foreach($pages as $p) {
          if ($p->id != $page_id) {
            if (!isset($page)) {
              $selected = "";
            }
            else {
              $selected = ($page->parent == $p->id)?"selected":"";
            }
            ?>
            <option value="<?php print $p->id; ?>" <?php print $selected; ?>><?php print $p->text; ?></option>
            <?php
          }
        }
        ?>
      </select>
    </div>
    
    <div class="form-item">
      <label>Text in the top bar of the browser:</label>
      <input name="browser_title" class="text" placeholder="This is the text displayed in the top bar of the browser" value="<?php print $browser_title; ?>" />
    </div>
    
    <div class="form-item">
      <label>Description:</label>
      <textarea id="textarea" name="description" rows="3" placeholder="This is also optional. It is used for search engines like Google. Let's type something that will describe your awesome page!"><?php print $description; ?></textarea>
    </div>
  
  </div>
      
  <label>Page content:</label>
  <p class="help full">
    <i class="material-icons">info_outline</i>
    This is where you build the content of your page.<br />
    You can have one or several rows, and each row can have one or several columns (each row also has an optional heading)<br />
    Then each column has some content inside it.
  </p>

  <div id="rows-container">
    <?php
    if ($rows) {    
      foreach($rows as $row) {
        include("inc_form_row.php");
      }
    }
    ?>
  </div>
  
  <p class="add-row"><a id="add-row" class="grey"><i class="material-icons md-24">add_circle</i> Add another row</a></p>
  
  <input type="submit" value="Save this page" class="submit page" />
  <a href="/admin" class="cancel">Cancel</a>
  
  <input type="hidden" name="deleted_rows" value="" />
  <input type="hidden" name="deleted_widgets" value="" />
  <input type="hidden" name="page_id" value="<?php print $page_id; ?>" />
  <input type="hidden" name="return" value="<?php print isset($_GET["return-to-page"])?"page":"admin"; ?>" />
  <input type="hidden" name="action" value="form_page" />
  
</form>


<?php include ("widgets/widget_list.php"); ?>