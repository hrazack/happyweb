<?php
$pages_full = array();
$pages_url = array();

// get pages that are in the hierarchy
page_tree($pages_full, $pages_url);

// get other pages
$pages = $db->get_results("SELECT * FROM page WHERE parent=-1 AND id!=2 ORDER BY display_order ASC");
foreach($pages as $page) {
  $obj = new stdClass();
  $obj->text = $page->title;
  $obj->value = "/".$page->url;
  $pages_full[] = $obj;
  $pages_url[] = "/".$page->url;
}
  
// output the data
$data = new stdClass();
$data->pages = $pages_full;
$data->pages_url = $pages_url;
print json_encode($data);


/**
 * returns a tree of all pages (in hierarchical order)
 */
function page_tree(&$pages_full, &$pages_url, $page_id=0, $level=0) {
  global $db;
  $pages = $db->get_results("SELECT * FROM page WHERE parent=".$page_id." ORDER BY display_order ASC");
  foreach($pages as $page) {
    $page_title = str_repeat("-- ",$level).$page->title;
    $obj = new stdClass();
    $obj->text = $page_title;
    $obj->value = "/".$page->url;
    $pages_full[] = $obj;
    $pages_url[] = "/".$page->url;
    page_tree($pages_full, $pages_url, $page->id, $level+1);
  }
} // page_tree

?>