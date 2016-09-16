
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
