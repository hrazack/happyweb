<?php
$head_page_title = "Your site navigation";
$display_navigation = true;
if (isset($_POST["action"])) {
  
  $pages = json_decode($_POST["pages"]); 
  //print "<pre>".print_r($pages, true)."</pre>";
  foreach($pages as $index => $page) {
    $db->query("UPDATE page SET parent=0, display_order=".$index." WHERE id=".$page->id);
    if (isset($page->children)) {
      foreach($page->children as $index_sub => $sub_page) {
        $db->query("UPDATE page SET parent=".$page->id.", display_order=".$index_sub." WHERE id=".$sub_page->id);
      }
    }
  }
  set_message('The navigation has been updated!');
  redirect('admin/navigation');
  
}   
?>

<p>Here you can reorder the pages in the site:</p>

<form action="<?php print $url_info["path"];?>" method="post">
  
<div class="dd">
  <ol class="dd-list">
      <?php
      $pages = $db->get_results("SELECT * FROM page WHERE parent=0 ORDER BY display_order ASC");
      foreach($pages as $page) {
        ?>
        <li class="dd-item" data-id="<?php print $page->id; ?>">
        <div class="dd-handle"><?php print $page->title; ?></div>
          <?php
          if ($sub_pages = $db->get_results("SELECT * FROM page WHERE parent=".$page->id." ORDER BY display_order ASC")) {
            ?>
            <ol class="dd-list">
            <?php
            foreach($sub_pages as $sub_page) {
              ?>
              <li class="dd-item" data-id="<?php print $sub_page->id; ?>">
                <div class="dd-handle"><?php print $sub_page->title; ?></div>
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
  </ol>
</div>
  
  <input type="submit" class="submit" value="Save" />
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