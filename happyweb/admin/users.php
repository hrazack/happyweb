<?php
$head_page_title = "All the great people on your site";
$display_navigation = true;
?>

<p><a href="/admin/user_create"><i class="material-icons md-24">add_circle</i> Create a new user</a></p>

<table>
<thead>
  <tr>
    <th>Name</th>
    <th></th>
    <th></th>
</thead>
<tbody>
<?php
$users = $db->get_results("SELECT * FROM user");
foreach($users as $user) {
  if ($user->id == 1 || $user->id == 2) {
    $link_delete = '<span class="disabled"><i class="material-icons md-24">clear</i> delete</span>';
  }
  else {
      $link_delete = '<a href="/admin/user_delete/'.$user->id.'"><i class="material-icons md-24">clear</i> delete</a>';
  }
  print '<tr>';
  print '<td>'.$user->username.'</td>';
  print '<td><a href="/admin/user_edit/'.$user->id.'"><i class="material-icons md-24">edit</i> edit</a></td>';
  print '<td>'.$link_delete.'</td>';
  print '</tr>';
}
?>
</tbody>
</table>