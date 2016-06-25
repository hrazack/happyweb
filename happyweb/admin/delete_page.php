<?php

$page_id = arg(2);
$page = get_page($page_id);
if (!$page) exit();

$head_page_title = "Delete a page";

if (isset($_POST["action"])) {
  delete_page($page->id);
  set_message('The page <em>"'.$page->title.'"</em> has been deleted... So sad...');
  redirect('admin');
}

?>

<h2>Delete page <em>"<?php print $page->title; ?>"</em></h2>

<p>Err... Are you sure you want to delete that page?<br />It's a pretty cool page and you won't be able to recover it once you do so</p>

<form action="<?php print $url_info["path"];?>" method="post">
  <input type="submit" value="Oh yes, let's delete it!" class="submit with-cancel" />
  <a href="/admin" class="cancel"><i class="material-icons big">clear</i> What? No, please take me back!</a>
  <input type="hidden" name="action" value="delete_page" />
</form>