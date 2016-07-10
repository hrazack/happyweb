<?php
$head_page_title = "Amazing admin dashboard";
$display_navigation = true;

if (isset($_POST["action"])) {
  
  $pages = json_decode($_POST["pages"]); 
  foreach($pages as $index => $page) {
    $db->query("UPDATE page SET parent=0, display_order=".$index." WHERE id=".$page->id);
    if (isset($page->children)) {
      foreach($page->children as $index_sub => $sub_page) {
        $db->query("UPDATE page SET parent=".$page->id.", display_order=".$index_sub." WHERE id=".$sub_page->id);
      }
    }
  }
  set_message('The page order has been updated!');
  redirect('admin');
  
}   
?>

<p class="help">
  <i class="material-icons">info_outline</i>
  These are all the pages on your site.<br />
  You can edit or delete them, and also create a new page.<br />
  You can also change their order by clicking on a page and moving it around.
</p>

<p><a href="/admin/page_create"><i class="material-icons md-24">add_circle</i> Create a new awesome page</a></p>

<form action="<?php print $url_info["path"];?>" method="post">
  
<div class="dd">
  <ol class="dd-list">
    <div class="dd-handle text">Pages included in the navigation</div>
    <?php
    $pages = $db->get_results("SELECT * FROM page WHERE parent=0 ORDER BY display_order ASC");
    foreach($pages as $page) {
      ?>
      <li class="dd-item" data-id="<?php print $page->id; ?>">
        <div class="dd-handle"><?php print display_page_list_row($page); ?></div>
        <?php
        if ($sub_pages = $db->get_results("SELECT * FROM page WHERE parent=".$page->id." ORDER BY display_order ASC")) {
          ?>
          <ol class="dd-list">
          <?php
          foreach($sub_pages as $sub_page) {
            ?>
            <li class="dd-item" data-id="<?php print $sub_page->id; ?>">
              <div class="dd-handle"><?php print display_page_list_row($sub_page); ?></div>
            </li>
            <?php
          }
          ?>
          </ol>
          <?php
        }
        ?>
      </li>
      <?php
    }
    ?>
    <li class="dd-item" data-id="-1">
      <div class="dd-handle text margin">Pages that are not in the navigation</div>
      <ol class="dd-list not-in-nav">
      <?php
      $pages = $db->get_results("SELECT * FROM page WHERE parent=-1");
      foreach($pages as $page) {
        ?>
        <li class="dd-item" data-id="<?php print $page->id; ?>">
          <div class="dd-handle"><?php print display_page_list_row($page); ?></div>
        </li>
        <?php
      }
      ?>
      </ol>
    </li>
  </ol>
</div>
  
  <input type="submit" class="submit" value="Save pages order" />
  <input type="hidden" name="pages" value="" id="pages" />
  <input type="hidden" name="action" value="save_navigation" />
  
</form>


<script src="/happyweb/includes/jquery.nestable.js"></script>
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
