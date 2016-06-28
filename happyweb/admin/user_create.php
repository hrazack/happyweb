<?php
global $db;

$head_page_title = "Create a new user";

if (isset($_POST["action"])) {
  
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $username = $db->escape($_POST["username"]);
  $db->query("INSERT INTO user (username, password) VALUES ('".$username."', '".password."')");
  set_message('The user <em>"'.$username.'"</em> has been created, woohoo!');
  redirect('admin/users');
  
}   
?>

<form action="<?php print $url_info["path"];?>" method="post">
  
  <div class="form-item">
    <label>Username:</label>
    <input type="text" class="text" name="username" placeholder="A username that will be used to login to the site" required />
  </div>
  
  <div class="form-item">
    <label>Password:</label>
    <input type="password" class="text" name="password" placeholder="A password for that username" required />
  </div>
  
  <input type="submit" class="submit" value="Create new user" />
  <a href="/admin/users" class="cancel">Cancel</a>
  <input type="hidden" name="action" value="create_user" />
  
</form>
