<?php
$head_page_title = "Amazing admin dashboard";
$display_navigation = true;

if (isset($_POST["action"])) {
  
  $pages = json_decode($_POST["pages"]); 
  save_pages_order($pages, 0);
  set_message('The page order has been updated!');
  redirect('admin');
  
}   
?>


<p class="help">
  <i class="material-icons">info_outline</i>
  These are all the pages on your site.<br />
  You can edit or delete them, and also create a new page.<br />
  You can also change their order by clicking on a page's handle and moving it around.
</p>

<p><a href="/admin/page_create"><i class="material-icons md-24">add_circle</i> Create a new awesome page</a></p>

<form action="<?php print $url_info["path"];?>" method="post">
  
<div class="dd">
  <?php print_page_edit_row(0); ?>
</div>
  
  <input type="submit" class="submit" value="Save pages order" />
  <input type="hidden" name="pages" value="" id="pages" />
  <input type="hidden" name="action" value="save_navigation" />
  
</form>


<script src="/happyweb_system/includes/jquery.nestable.js"></script>
<script>
  $(document).ready(function() {
    $('.dd').nestable();
    $(document).on("submit", "form", function(event) {
      var pages = $('.dd').nestable('serialize');
      pages = JSON.stringify(pages);
      $("#pages").val(pages);
      return true;
    });
  });
</script>


<?php
function print_page_edit_row($parent) {
  global $db;
  if ($pages = $db->get_results("SELECT * FROM page WHERE parent=".$parent." ORDER BY display_order ASC")) {
    print '<ol class="dd-list">';
    foreach($pages as $page) {
      ?>
      <li class="dd-item" data-id="<?php print $page->id; ?>">
        <div class="dd-handle"><i class="material-icons">open_with</i></div>
        <div class="dd-content"><?php print display_page_list_row($page); ?></div>
        <?php print_page_edit_row($page->id); ?>
      </li>
      <?php
    }
    if ($parent == 0) {
      ?>
      <li class="dd-item" data-id="-1">
      <div class="item-text">Pages that are not in the navigation:</div>
      <ol class="dd-list not-in-nav">
      <?php
      $pages = $db->get_results("SELECT * FROM page WHERE parent=-1");
      foreach($pages as $page) {
        ?>
        <li class="dd-item" data-id="<?php print $page->id; ?>">
          <div class="dd-handle"><i class="material-icons">open_with</i></div>
          <div class="dd-content"><?php print display_page_list_row($page); ?></div>
          <?php print_page_edit_row($page->id); ?>
        </li>
        <?php
      }
      ?>
      </ol>
    </li>
      <?php
    }
    print '</ol>';
  }
}
?>