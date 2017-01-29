<?php 
$current_page = get_current_page();
if ($current_page->parent != -1) {
  ?>

  <?php
  $heading = get_setting("side_nav_heading");
  if ($heading != "") { ?>
  <div class="sub-navigation-heading"><?php print $heading; ?></div>
  <?php } ?>

  <?php
  // check if the page has children
  if ($sub_pages = $db->get_results("SELECT * FROM page WHERE parent=".$current_page->id." ORDER BY display_order ASC")) {
    print "<ul>";
    foreach($sub_pages as $p) {
      $class_selected = ($p->id == $current_page->id)?"selected":"";
      ?>
      <li class="<?php print $class_selected; ?>"><a href="/<?php print $p->url; ?>"><?php print $p->title; ?></a></li>
      <?php
    }
    print "</ul>";
  }
  // if not check if it has siblings
  else if ($sibling_pages = $db->get_results("SELECT * FROM page WHERE parent!=0 AND parent=".$current_page->parent." ORDER BY display_order ASC")) {
    print "<ul>";
    foreach($sibling_pages as $p) {
      $class_selected = ($p->id == $current_page->id)?"selected":"";
      ?>
      <li class="<?php print $class_selected; ?>"><a href="/<?php print $p->url; ?>"><?php print $p->title; ?></a></li>
      <?php
    }
    print "</ul>"; 
  }
  ?>

<?php } ?>