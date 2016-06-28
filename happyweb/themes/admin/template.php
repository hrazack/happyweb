<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!--<link rel="shortcut icon" href="http://www.livingmelody.com/sites/default/files/favicon-lm.png" type="image/png" />-->
  <title><?php print $head_page_title; ?></title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="/happyweb/includes/happyweb.css" media="all" />
  <link rel="stylesheet" href="/happyweb/includes/trumbowyg/trumbowyg.css">
  <link rel="stylesheet" href="/happyweb/themes/admin/styles.css" media="all" />
</head>

<body>

  <header>
    <div class="container">
      <h1><?php print $head_page_title; ?></h1>
    </div>
  </header>
  
  <div id="content">
    <div class="container">
      
      <?php if ($messages != "") { ?>
      <div class="messages"><i class="material-icons">info_outline</i><?php print $messages; ?></div>
      <?php } ?>
      
      <?php print $content; ?>
      
      <?php if (isset($display_navigation) && $display_navigation) { ?>
      <ul class="side-navigation">
        <li><a href="/admin"><i class="material-icons">library_books</i> Pages</a></li>
        <li><a href="/admin/users"><i class="material-icons">account_circle</i> Users</a></li>
        <li><a href="/admin/settings"><i class="material-icons">settings</i>Settings</a></li>
        <li><a href="/admin/logout"><i class="material-icons">exit_to_app</i>Logout</a></li>
        <li><a href="/"><i class="material-icons">forward</i> Go to your site</a></li>
      </ul>
      <?php } ?>
      
    </div>
  </div>
  
  <div id="loader"><div id="loader-anim"></div></div>
  
  <script src="/happyweb/includes/jquery.min.js"></script>
  <script src="/happyweb/includes/jquery.validate.min.js"></script>
  <script src="/happyweb/includes/jquery-ui.min.js"></script>
  <script src="/happyweb/includes/trumbowyg/trumbowyg.js"></script>
  <script src="/happyweb/admin/scripts.js"></script>
  
</body>

</html>
