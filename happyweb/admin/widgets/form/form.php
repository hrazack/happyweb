<?php
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$domain = str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));
$domain = ($domain == "")?"test.com":$domain;
$default_email = "info@".$domain;

$email_from = ($action == "edit" && $data->email_from != "")?$data->email_from:$default_email;
$name_from = ($action == "edit" && $data->email_from != "")?$data->name_from:get_setting("site_name");
$email_to = ($action == "edit" && $data->email_to != "")?$data->email_to:"";
$submit_text = ($action == "edit" && $data->submit_text != "")?$data->submit_text:"Send enquiry";
$message = ($action == "edit" && $data->message != "")?$data->message:"Thank you for your enquiry. We will get back to you shortly.";
?>

<div class="form-item">
  <label>Email address to send form submissions to</label />
  <input name="email_to" placeholder="The email address to send the form submissions to" class="text" value="<?php print $email_to; ?>" required />
</div>

<div class="form-item">
  <label>Button text</label />
  <input name="submit_text" placeholder="The text of the submit button" class="text" value="<?php print $submit_text; ?>" required />
</div>

<div class="form-item">
  <label>Confirmation message</label />
  <textarea name="message" placeholder="The confirmation message that is displayed after the form is submitted" required><?php print $message; ?></textarea>
</div>

<p><a class="more"><i class="material-icons icon-open">arrow_right</i><i class="material-icons icon-close">arrow_drop_down</i> More options for this form</a></p>

<div id="options" style="display: none;">
  <div class="form-item">
    <label>From email address</label />
    <input name="email_from" placeholder="The email address that the form submissions will be sent from" class="text" value="<?php print $email_from; ?>" required />
  </div>

  <div class="form-item">
    <label>From name</label />
    <input name="name_from" placeholder="The name that the form submissions will be sent from" class="text" value="<?php print $name_from; ?>" required />
  </div>
</div>