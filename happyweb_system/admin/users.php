<?php
$head_page_title = "All the fantastic users on your site";
$display_navigation = true;
?>

<p class="help"><i class="material-icons">info_outline</i>These are all the users who can log in to the admin site.<br />You can edit them to change their username or password, and also add a new user.</p>

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
$users = $db->get_results("SELECT * FROM user WHERE id!=1");
foreach($users as $user) {
  if ($user->id == 1 && $_SESSION["happyweb"]["user"]->id != 1) {
    continue;
  }
  if ($user->id == 1 || $user->id == 2) {
    $link_delete = '<span class="disabled"><i class="material-icons md-24">clear</i><span class="text">delete</span></span>';
  }
  else {
    $link_delete = '<a href="/admin/user_delete/'.$user->id.'"><i class="material-icons md-24">clear</i><span class="text">delete</span></a>';
  }
  print '<tr>';
  print '<td>'.$user->username.'</td>';
  print '<td class="icon"><a href="/admin/user_edit/'.$user->id.'"><i class="material-icons md-24">edit</i><span class="text">edit</span></a></td>';
  print '<td class="icon">'.$link_delete.'</td>';
  print '</tr>';
}
?>
</tbody>
</table>