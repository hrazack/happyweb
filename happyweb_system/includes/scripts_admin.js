$(document).ready(function() {
  
  // close messages 
  $('.messages .close').click(function() {
    $(this).parent().slideUp();
    return false;
  });
  
});