<?php

$head_page_title = "Amazing admin dashboard";

?>

<p>Here are all the pages on the site:</p>

<p><a href="/admin/create_page"><i class="material-icons md-24">add_circle</i> Create a new awesome page</a></p>

<table>
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
foreach($pages as $page) {
  if ($page->id == 1 || $page->id == 2) {
    $link_delete = '<span class="disabled"><i class="material-icons md-24">clear</i> delete</span>';
  }
  else {
      $link_delete = '<a href="/admin/delete_page/'.$page->id.'"><i class="material-icons md-24">clear</i> delete</a>';
  }
  print '<tr>';
  print '<td><a href="/'.$page->url.'">'.$page->title.'</a></td>';
  print '<td>/'.$page->url.'</td>';
  print '<td><a href="/admin/edit_page/'.$page->id.'"><i class="material-icons md-24">edit</i> edit</a></td>';
  print '<td>'.$link_delete.'</td>';
  print '</tr>';
}
?>
</tbody>
</table>