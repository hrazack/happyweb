<?php
$head_page_title = "Amazing admin dashboard";
$display_navigation = true;
?>

<p class="help"><i class="material-icons">info_outline</i>These are all the pages on your site.<br />You can edit or delete them, and also create a new page.</p>

<p><a href="/admin/page_create"><i class="material-icons md-24">add_circle</i> Create a new awesome page</a></p>

<table class="full">
<thead>
  <tr>
    <th>Page title</th>
    <th class="url">URL</th>
    <th></th>
    <th></th>
</thead>
<tbody>
<?php
$pages = $db->get_results("SELECT * FROM page");
// put the "page not found" page at the end of the list
$not_found_page = $pages[1];
unset($pages[1]);
$pages[] = $not_found_page;
// display the list
foreach($pages as $page) {
  if ($page->id == 1 || $page->id == 2) {
    $link_delete = '<span class="disabled"><i class="material-icons md-24">clear</i> delete</span>';
  }
  else {
      $link_delete = '<a href="/admin/page_delete/'.$page->id.'"><i class="material-icons md-24">clear</i> delete</a>';
  }
  print '<tr>';
  print '<td><a href="/'.$page->url.'">'.$page->title.'</a></td>';
  print '<td>/'.$page->url.'</td>';
  print '<td><a href="/admin/page_edit/'.$page->id.'"><i class="material-icons md-24">edit</i> edit</a></td>';
  print '<td>'.$link_delete.'</td>';
  print '</tr>';
}
?>
</tbody>
</table>