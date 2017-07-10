<?php
$files = json_decode($data->filenames);
$class_disabled = ($data->disable_slideshow == 1)?"disabled":"";

if ($data->disable_slideshow == 0) {
  add_css('<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>');
  add_js('<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>');
  add_js('<script type="text/javascript" src="/happyweb/admin/widgets/slideshow/slideshow.js"></script>');
}
?>

<div class="slideshow-full <?php print $class_disabled; ?>">
<?php
if ($data->filenames != "") {
  foreach($files as $obj) {
    $str = $obj->id;
    $part = explode("||", $str);
    $filename = $part[0];
    $description = isset($part[1])?urldecode($part[1]):"";
    print '<div class="item">';
    print '<img src="/your_site/uploaded_files/large/'.$filename.'" />';
    print '<div class="description">'.$description.'</div>';
    print '</div>';
  }
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
