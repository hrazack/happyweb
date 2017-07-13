<?php

$user_id = arg(2);
$user = $db->get_row("SELECT * FROM user WHERE id=".$user_id);
if (!$user) exit();

$head_page_title = "Edit user";

if (isset($_POST["action"])) {
  
  // update username
  $username = $db->escape($_POST["username"]);
  $db->query("UPDATE user SET username='".$username."' WHERE id=".$user->id);
  // update password if required
  if ($_POST["password"] != "") {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $db->query("UPDATE user SET password='".$password."' WHERE id=".$user->id);
  }
  set_message('The user <em>"'.$username.'"</em> has been been updated');
  redirect('admin/users');
  
}   
?>

<form action="<?php print $url_info["path"];?>" method="post">
  
  <div class="form-item">
    <label>Username:</label>
    <input type="text" class="text" name="username" placeholder="A username that will be used to login to the site" value="<?php print $user->username; ?>" required />
  </div>
  
  <div class="form-item">
    <label>Password:</label>
    <input type="password" class="text" name="password" placeholder="Leave empty if you don't want to change the password" />
  </div>
  
  <input type="submit" class="submit" value="Save" />
  <a href="/admin/users" class="cancel">Cancel</a>
  <input type="hidden" name="action" value="edit_user" />
  
</form>
