<?php

$user_id = arg(2);
$user = $db->get_row("SELECT * FROM user WHERE id=".$user_id);
if (!$user) exit();

$head_page_title = "Delete a user";

if (isset($_POST["action"])) {
  $db->query("DELETE FROM user WHERE id=".$user_id);
  set_message($user->username.' has been terminated... Poor '.$user->username.'...');
  redirect('admin/users');
}

?>

<p>Are you sure you want to remove <em><?php print $user->username; ?></em> from the site?</p>

<form action="<?php print $url_info["path"];?>" method="post">
  <input type="submit" value="Oh yes" class="submit" />
  <a href="/admin/users" class="cancel">Cancel</a>
  <input type="hidden" name="action" value="delete_user" />
</form>