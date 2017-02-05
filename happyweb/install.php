<?php
// if config.php exists, we've already run the installation
if (file_exists("your_site/config.php")) {
  redirect("");
  exit();
}

require("happyweb/includes/functions_admin.php");
// get the output of the script
ob_start();
require('happyweb/admin/installation.php');
$content = ob_get_contents();
ob_end_clean();
// display the admin template
include("happyweb/themes/admin/template.php");
?>