<?php
$head_page_title = "Fantabulous fonts";
$display_navigation = true;
if (isset($_POST["action"])) {
  
  update_setting("font_headings", $_POST["font_headings"]);
  update_setting("font_text", $_POST["font_text"]);
  update_setting("size_heading", $_POST["size_heading"]);
  update_setting("size_text", $_POST["size_text"]);
  set_message('The fonts have been updated!');
  redirect('admin/fonts');

}   
?>

<div class="help"><i class="material-icons">info_outline</i>
  By default your site comes with the best fonts known to mankind.<br />
  However fear not! You can override them if you find the font of your dreams.<br />

  <ol>
  <li>Go to <a href="https://fonts.google.com/" target="new">Google fonts</a> and choose a font you like.</li>
  <li>Once you find a font you like, simply paste its name in the boxes below. For example, "Roboto", or "Open Sans Condensed"</li>
  <li>Choose the size of the font. Each font render a bit differently, so you will need to check what works. Usually start with "16" for text and "30" for headings.</li>
  <li>Click on "Save fonts", et voilà!</li>
  </ol>
  
  <p>(To go back to the default fonts, just empty the boxes)</p>

</div>


<form action="<?php print $url_info["path"];?>" method="post">

  <div class="form-item">
    <label>Font for headings:</label>
    <input type="text" class="text" name="font_headings" placeholder="Paste the name of the font here" value="<?php print get_setting("font_headings"); ?>" />
  </div>
  
  <div class="form-item">
    <label>Font for text:</label>
    <input type="text" class="text" name="font_text" placeholder="Paste the name of the font here" value="<?php print get_setting("font_text"); ?>" />
  </div>
  
  <div class="form-item">
    <label>Heading size:</label>
    <input type="text" class="text" name="size_heading" placeholder="Usually something around 30" value="<?php print get_setting("size_heading"); ?>" />
  </div>
  
  <div class="form-item">
    <label>Text size:</label>
    <input type="text" class="text" name="size_text" placeholder="Usually something around 16" value="<?php print get_setting("size_text"); ?>" />
  </div>
  
  <input type="submit" class="submit" value="Save fonts" />
  <input type="hidden" name="action" value="save_fonts" />
  
</form>
