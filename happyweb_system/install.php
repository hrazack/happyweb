<?php
// if config.php exists, we've already run the installation
if (file_exists("my_website/config.php")) {
  redirect("");
  exit();
}

require("happyweb_system/includes/functions_admin.php");
// get the output of the script
ob_start();
require('happyweb_system/admin/installation.php');
$content = ob_get_contents();
ob_end_clean();
// display the admin template
include("happyweb_system/themes/admin/template.php");
?>