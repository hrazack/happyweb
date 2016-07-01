$(document).ready(function() {
  
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