<?php
$head_page_title = "Logs";
$display_navigation = true;
?>

<p class="help"><i class="material-icons">info_outline</i>What did everyone do?</p>

<?php
if ($logs = $db->get_results("SELECT * FROM logs ORDER BY date DESC")) {
  ?>
  <table>
  <thead>
    <tr>
      <th>Date</th>
      <th>User</th>
      <th>Action</th>
  </thead>
  <tbody>
  <?php
  foreach($logs as $log) {
    $username = $db->get_var("SELECT username FROM user WHERE id=".$log->user_id);
    print '<tr>';
    print '<td>'.date("d/m/Y, g:ia", $log->date).'</td>';
    print '<td>'.$username.'</td>';
    print '<td>'.$log->description.'</td>';
    print '</tr>';
  }
  ?>
  </table>
  <?php
}
else {
  ?>
  <p>Ah, no one has done anything yet on the website</p>
  <?php
}
?>
