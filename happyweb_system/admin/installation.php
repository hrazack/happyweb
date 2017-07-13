<?php
// if config.php exists, we've already run the installation
if (file_exists("my_website/config.php")) {
  redirect("");
  exit();
}

$head_page_title = "Happy web installation";
$display_navigation = false;
$url_info = parse_url($_SERVER['REQUEST_URI']);
if (isset($_POST["action"])) {
  
  // Let's try to connect to the database
  $conn = new mysqli($_POST["db_host"], $_POST["db_user"], $_POST["db_password"], $_POST["db_name"]);
  if ($conn->connect_error) {
    // We couldn't connect
    set_error("", "Ah, it looks like we couldn't connect to the database", "", "", "");
    redirect("");
    exit();
  } 
  $conn->close();
  // write the config file
  $filename = "my_website/config.php";
  $fh = fopen($filename, "w");
  if (!is_resource($fh)) {
    // we couldn't write the file
    set_error("", "The database details are fine, but we are having trouble creating some files", "", "", "");
    redirect("");
    exit();
  }
  $config = array(
    "host" => $_POST["db_host"],
    "db_name" => $_POST["db_name"],
    "user" => $_POST["db_user"],
    "password" => $_POST["db_password"]
  );
  fwrite($fh, "<?php\n");
  foreach ($config as $key => $value) {
    fwrite($fh, sprintf("$%s = \"%s\";\n", $key, $value));
  }
  fwrite($fh, "?>");
  fclose($fh);
  // populate the database
  $db = new ezSQL_pdo('mysql:host='.$_POST["db_host"].';dbname='.$_POST["db_name"].';', $_POST["db_user"], $_POST["db_password"]);
  $sql_filename = "happyweb_system/includes/happyweb.sql";
  $templine = '';
  $lines = file($sql_filename);
  foreach ($lines as $line) {
    if (substr($line, 0, 2) == '--' || $line == '') {
      continue;
    }
    $templine .= $line;
    if (substr(trim($line), -1, 1) == ';') {
      $db->query($templine);
      $templine = '';
    }
  }
  // copy the basic theme to "my_website/themes/site_name
  $site_name = $db->escape($_POST["site_name"]);
  $new_theme = sanitize_string($site_name);
  copy_folder("happyweb_system/themes/basic", "my_website/themes/".$new_theme);
  // update some settings
  update_setting("theme", $new_theme);
  update_setting("site_name", $site_name);
  update_setting("footer_text", "Copyright 2017 ".$site_name);
  // create the user
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $username = $db->escape($_POST["username"]);
  $db->query("INSERT INTO user (username, password) VALUES ('".$username."', '".$password."')");
  // log in as admin user
  $user = $db->get_row("SELECT * FROM user WHERE username='".$username."'");
  $_SESSION["happyweb"]["user"] = $user;
  // redirect to home page
  set_message('Your website is now ready!');
  redirect('');
}
?>

<form action="<?php print $url_info["path"];?>" method="post">
  
  <p>Ah, the joy of setting up a new exciting website. Let's get started!</p>

  <p>First let's give a name to your website:</p>

  <div class="form-item">
    <label>Website name:</label>
    <input type="text" class="text" name="site_name" placeholder="Something really cool" required />
  </div>
  
  <p>Then you will need to create a new MySQL database using your hosting company's control panel.<br />After you have done so you should have the following information:</p>
  
  <div class="form-item">
    <label>Database host:</label>
    <input type="text" class="text" name="db_host" placeholder="Usually this is just 'localhost'" required />
  </div>
  
  <div class="form-item">
    <label>Database name:</label>
    <input type="text" class="text" name="db_name" placeholder="The name of the database" required />
  </div>
  
  <div class="form-item">
    <label>Database username:</label>
    <input type="text" class="text" name="db_user" placeholder="A username that has access to this database" required />
  </div>
  
  <div class="form-item">
    <label>Database username password:</label>
    <input type="password" class="text" name="db_password" placeholder="The password for this user" />
  </div>
  
  <p>Then let's choose a username for you, so that you can log in to the website:</p>
  
  <div class="form-item">
    <label>Your username:</label>
    <input type="text" class="text" name="username" placeholder="Your username" required />
  </div>
  
  <div class="form-item">
    <label>Your password:</label>
    <input type="password" class="text" name="password" placeholder="Your password" />
  </div>
  
  <p>And that's about it! Now we are ready to roll</p>
  
  <input type="submit" class="submit" value="Let's setup the website" />
  <input type="hidden" name="action" value="save_install" />
  
</form>