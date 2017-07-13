<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
  <meta http-equiv="Pragma" content="no-cache"/>
  <meta http-equiv="Expires" content="0"/>
  <title><?php print $head_page_title; ?></title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="/happyweb_system/includes/happyweb.css" media="all" />
  <link rel="stylesheet" href="/happyweb_system/includes/tooltipster/tooltipster.min.css" media="all" />
  <link rel="stylesheet" href="/happyweb_system/includes/dragula/dragula.min.css" media="all" />
  <link rel="stylesheet" href="/happyweb_system/themes/admin/styles.css" media="all" />
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="/happyweb_system/includes/jquery.validate.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/tinymce/4.4.3/tinymce.min.js'></script>
  <script src="/happyweb_system/includes/tooltipster/tooltipster.min.js"></script>
</head>

<body class="admin">

  <header>
    <div class="container">
      <h1><?php print $head_page_title; ?></h1>
    </div>
  </header>
  
  <div id="content">
    <div class="container">
      
      <?php if ($messages != "") print $messages; ?>

      <?php print $content; ?>
      
      <?php if (isset($display_navigation) && $display_navigation) { ?>
      <?php
      $selected_pages = (arg(1) == "")?"selected":"";
      $selected_navigation = (arg(1) == "navigation")?"selected":"";
      $selected_users = (arg(1) == "users")?"selected":"";
      $selected_settings = (arg(1) == "settings")?"selected":"";
      $selected_logs = (arg(1) == "logs")?"selected":"";
      ?>
      <ul class="side-navigation">
        <li class="<?php print $selected_pages; ?>"><a href="/admin"><i class="material-icons">library_books</i> Pages</a></li>
        <li class="<?php print $selected_users; ?>"><a href="/admin/users"><i class="material-icons">account_circle</i> Users</a></li>
        <li class="<?php print $selected_settings; ?>"><a href="/admin/settings"><i class="material-icons">settings</i>Settings</a></li>
        <li class="new-section"><a href="/admin/logout"><i class="material-icons">exit_to_app</i>Logout</a></li>
        <li><a href="/"><i class="material-icons">forward</i> Go to your site</a></li>
      </ul>
      <?php } ?>
      
    </div>
  </div>
  
  <div id="loader"><div id="loader-anim"></div></div>
  
  <script src="/happyweb_system/includes/dragula/dragula.min.js"></script>
</body>

</html>
