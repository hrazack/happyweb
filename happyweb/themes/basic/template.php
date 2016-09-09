<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="shortcut icon" href="/happyweb/themes/basic/images/favicon.png" type="image/png" />
  <title><?php print $page->title; ?> | <?php print $site_name; ?></title>
  <?php print $css; ?>
  <?php print $scripts; ?>
  <meta name="description" content="<?php print $page->description; ?>">
	<meta property="og:title" content="<?php print $page->title; ?>">
	<meta property="og:site_name" content="<?php print $page->title; ?>">
	<meta property="og:description" content="<?php print $page->description; ?>">
	<meta property="og:url" content="<?php print $_SERVER['REQUEST_URI']; ?>">
</head>

<body class="<?php print $body_class; ?>">

  <header>
    <div class="container">
      <h1><?php print $site_name; ?></h1>
      <a id="mobile-nav-button">Menu</a>
    </div>
  </header>
  
  <nav>
    <div class="container">
      <?php print $navigation; ?>
    </div>
  </nav>
  
  <div id="content">
    <?php if ($messages != "") print '<div class="container">'.$messages.'</div>'; ?>
    <?php print $content; ?>
  </div>
  
  <footer>
    <div class="container">
      <?php print get_setting("footer_text"); ?>
    </div>
  </footer>
  
  <?php print $admin_tools; ?>
  
</body>

</html>
