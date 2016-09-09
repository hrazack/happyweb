<?php
$files = json_decode($data->filenames);
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

<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
<script>
$(document).ready(function(){
  $('.slideshow-full').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    infinite: false,
    adaptiveHeight: true,
    autoplay: true,
    autoplaySpeed: 5000,
    dots: true,
    //variableWidth: true
    //asNavFor: '.slideshow-nav'
  });
  /*
  $('.slideshow-nav').slick({
    slidesToShow: 8,
    slidesToScroll: 1,
    asNavFor: '.slideshow-full',
    dots: true,
    arrows: false,
    infinite: false,
    autoplay: true,
    autoplaySpeed: 5000,
    focusOnSelect: true
  });*/
});
</script>