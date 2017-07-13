<?php
$email_from = (isset($data->email_from))?$data->email_from:"";
$name_from = (isset($data->name_from))?$data->name_from:"";
$email_to = (isset($data->email_to))?$data->email_to:"";
$submit_text = (isset($data->submit_text))?$data->submit_text:"";
$message = (isset($data->message))?$data->message:"";

if (isset($_POST["name"]) && (isset($_POST["yep"]) && $_POST["yep"] == "")) { // that "yep" thing is to prevent bots from posting (it's a hidden textarea)
  $name = $_POST["name"];
  $email = $_POST["email"];
  $comment = $_POST["comment"];
  $content = '
New enquiry from the website:

Name: '.$name.'
Email: '.$email.'  
Comment or question:
'.$comment.'
';
  $headers = 
    "From: $name_from <$email_from>\r\n". 
    "Reply-To: $email_from\r\n".
    "X-Mailer: PHP/".phpversion();
  mail($email_to, "Enquiry from website", $content, $headers, '-f'.$email_from);
  print $message;
}
else {
?>

<form name="contact" action="" method="post">

  <div class="form-item">
    <input type="text" name="name" class="text" placeholder="Your name" />
  </div>

  <div class="form-item">
    <input type="text" name="email" class="text" placeholder="Your email address" />
  </div>

  <div class="form-item">
    <textarea name="comment" placeholder="Comment or question" /></textarea>
  </div>
  
  <div class="form-item yep" style="display: none;">
    <textarea name="yep" placeholder="Yep" /></textarea>
  </div>

  <input type="submit" class="submit" value="<?php print $submit_text; ?>" />

</form>
<?php } ?>