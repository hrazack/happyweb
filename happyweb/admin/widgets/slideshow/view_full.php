<?php
$files = json_decode($data->filenames);
add_css('<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>');
add_js('<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>');
add_js('<script type="text/javascript" src="/happyweb/admin/widgets/slideshow/slideshow.js"></script>');
?>

<div class="slideshow-full">
<?php
foreach($files as $obj) {
  print '<img src="/your_site/uploaded_files/large/'.$obj->id.'" />';
}
?>
</div>

<?php
/*
<div class="slideshow-nav">
<?php
foreach($files as $obj) {
  print '<div><img src="/your_site/uploaded_files/large/'.$obj->id.'" /></div>';
}
?>
</div>
*/
?>
