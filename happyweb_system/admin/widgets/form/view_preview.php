<?php
$email_to = (isset($data->email_to))?$data->email_to:"";
?>

<div class="form">
  A contact form that will send an email to <?php print $data->email_to; ?>
</div>
