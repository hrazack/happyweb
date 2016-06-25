<!DOCTYPE html>
<html lang="en">

<head profile="http://www.w3.org/1999/xhtml/vocab">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!--<link rel="shortcut icon" href="http://www.livingmelody.com/sites/default/files/favicon-lm.png" type="image/png" />-->
  <title><?php print $head_page_title; ?></title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/happyweb/includes/happyweb.css" media="all" />
  <link type="text/css" rel="stylesheet" href="/happyweb/themes/admin/styles.css" media="all" />
  <?php print $scripts; ?>
  <script type="text/javascript" src="/happyweb/includes/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/happyweb/includes/jquery-ui.min.js"></script>
  <script type="text/javascript" src="/happyweb/admin/scripts.js"></script>
</head>

<body>

  <header>
    <div class="container">
      <h1><?php print $head_page_title; ?></h1>
      <div id="header-tools">
        <?php print isset($tools)?$tools:""; ?>
      </div>
    </div>
  </header>
  
  <div id="content">
    <div class="container">
      <?php if ($messages != "") { ?>
      <div class="messages"><i class="material-icons">info_outline</i><?php print $messages; ?></div>
      <?php } ?>
      <?php print $content; ?>
    </div>
  </div>
  
  <footer>
    <div class="container">
      Super admin footer
    </div>
  </footer>
  
  <div id="loader"><div id="loader-anim"></div></div>
  
</body>

</html>
