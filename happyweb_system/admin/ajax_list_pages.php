<?php
$pages_full = array();
$pages_url = array();

// get pages that are in the hierarchy
get_pages_tree($pages_full, 0, $pages_url);

// get other pages
get_pages_tree($pages_full, -1, $pages_url);
  
// output the data
$data = new stdClass();
$data->pages = $pages_full;
$data->pages_url = $pages_url;
print json_encode($data);

?>