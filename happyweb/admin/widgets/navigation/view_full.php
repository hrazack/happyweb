See also:
<?php
$page = get_current_page();
// check if the page has children
if ($sub_pages = $db->get_results("SELECT * FROM page WHERE parent=".$page->id." ORDER BY display_order ASC")) {
  print "<ul>";
  foreach($sub_pages as $p) {
    ?>
    <li><a href="/<?php print $p->url; ?>"><?php print $p->title; ?></a></li>
    <?php
  }
  print "</ul>";
}
// if not check if it has siblings
else if ($sibling_pages = $db->get_results("SELECT * FROM page WHERE parent=".$page->parent." ORDER BY display_order ASC")) {
  print "<ul>";
  foreach($sibling_pages as $p) {
    ?>
    <li><a href="/<?php print $p->url; ?>"><?php print $p->title; ?></a></li>
    <?php
  }
  print "</ul>";
  
}
?>
