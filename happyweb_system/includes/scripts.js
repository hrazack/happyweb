$(document).ready(function() {
  
  // close messages 
  $('.messages .close').click(function() {
    $(this).parent().slideUp();
    return false;
  });
  
  // video colorbox
  $('a.colorbox').colorbox({iframe: true, innerWidth: 640, innerHeight: 390});
  
  // open mobile menu
  $('#mobile-nav-button').click(function() {
    $("nav").animate({right: '0px'}, 500);
    return false;
  });
  
  // close mobile menu
  $('#mobile-nav-close').click(function() {
    $("nav").animate({right: '-300px'}, 500);
    return false;
  });
  
});