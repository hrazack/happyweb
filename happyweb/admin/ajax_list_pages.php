<?php
$pages_full = array();
$pages_url = array();

// get pages that are in the hierarchy
get_pages_tree($pages_full, $pages_url);

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

?>