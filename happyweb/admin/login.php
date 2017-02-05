<?php
$head_page_title = "Please login";

if (isset($_POST["action"])) {
  
  $username = $db->escape($_POST["username"]);
  $user = $db->get_row("SELECT * FROM user WHERE username='".$username."'");
  // check username
  if (!$user) {
    print '<p class="error">Ooops, wrong username...</p>';
  }
  else {
    // check password
    if (password_verify($_POST["password"], $user->password)) {
      $_SESSION["happyweb"]["user"] = $user;
      redirect('admin');
    } 
    else {
      print '<p class="error">Oh no, wrong password!</p>';
    }
  }

}
?>

<form action="<?php print $url_info["path"];?>" method="post">
  
  <div class="form-item">
    <label>Username:</label>
    <input type="text" class="text" name="username" required />
  </div>
  
  <div class="form-item">
    <label>Password:</label>
    <input type="password" class="text" name="password" required />
  </div>
  
  <input type="submit" class="submit" value="Let's login!" />
  <input type="hidden" name="action" value="login" />
  
</form>