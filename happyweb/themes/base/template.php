<!DOCTYPE html>
<html lang="en">

<head profile="http://www.w3.org/1999/xhtml/vocab">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!--<link rel="shortcut icon" href="http://www.livingmelody.com/sites/default/files/favicon-lm.png" type="image/png" />-->
  <title><?php print $page->title; ?></title>
  <link type="text/css" rel="stylesheet" href="/happyweb/includes/happyweb.css" media="all" />
  <link type="text/css" rel="stylesheet" href="/happyweb/themes/<?php print $theme; ?>/styles.css" media="all" />
  <?php print $scripts; ?>
  <meta name="description" content="<?php print $sso_description; ?>">
	<meta property="og:image" content="<?php print $_SERVER['REQUEST_URI']; ?>/images/polymer-cover-small.jpg">
	<meta property="og:title" content="<?php print $page->title; ?>">
	<meta property="og:site_name" content="<?php print $page->title; ?>">
	<meta property="og:description" content="<?php print $sso_description; ?>">
	<meta property="og:url" content="<?php print $_SERVER['REQUEST_URI']; ?>">
</head>

<body>

  <header>
    <div class="container">
      <h1><?php print $page->title; ?></h1>
    </div>
  </header>
  
  <div id="content">
    <?php print $content; ?>
  </div>
  
  <footer>
    <div class="container">
      Super footer
    </div>
  </footer>
  
  
</body>

</html>
