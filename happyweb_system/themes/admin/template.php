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
  <link rel="stylesheet" href="/happyweb_system/includes/spectrum/spectrum.css" media="all" />
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="/happyweb_system/includes/jquery.validate.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/tinymce/4.4.3/tinymce.min.js'></script>
  <script src="/happyweb_system/includes/tooltipster/tooltipster.min.js"></script>
  <script src="/happyweb_system/includes/spectrum/spectrum.min.js"></script>
  <script src="/happyweb_system/includes/scripts_admin.js"></script>
</head>

<body class="admin">

  <header>
    <div class="container">
      <h1><?php print $head_page_title; ?></h1>
    </div>
  </header>
  
  <div id="content">
    <div class="container">
      
      <div id="main">
      
        <?php if ($messages != "") print $messages; ?>
        <?php print $content; ?>
      
      </div>
      
      <?php if (isset($display_navigation) && $display_navigation) { ?>
      <?php
      $selected_pages = (arg(1) == "")?"selected":"";
      $selected_navigation = (arg(1) == "navigation")?"selected":"";
      $selected_users = (arg(1) == "users")?"selected":"";
      $selected_settings = (arg(1) == "settings")?"selected":"";
      $selected_colours = (arg(1) == "colours")?"selected":"";
      $selected_fonts = (arg(1) == "fonts")?"selected":"";
      $selected_news = (arg(1) == "news")?"selected":"";
      $selected_export = (arg(1) == "export")?"selected":"";
      ?>
      <ul class="side-navigation">
        <li class="<?php print $selected_pages; ?>"><a href="/admin"><i class="material-icons">library_books</i> Pages</a></li>
        <li class="<?php print $selected_users; ?>"><a href="/admin/users"><i class="material-icons">account_circle</i> Users</a></li>
        <li class="<?php print $selected_settings; ?>"><a href="/admin/settings"><i class="material-icons">settings</i>Settings</a></li>
        <li class="<?php print $selected_colours; ?>"><a href="/admin/colours"><i class="material-icons">format_paint</i>Colours</a></li>
        <li class="<?php print $selected_fonts; ?>"><a href="/admin/fonts"><i class="material-icons">font_download</i>Fonts</a></li>
        <li class="<?php print $selected_news; ?>"><a href="/admin/news"><i class="material-icons">help_outline</i>What's new</a></li>
        <li class="<?php print $selected_export; ?>"><a href="/admin/export"><i class="material-icons">call_made</i>Export website</a></li>
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
