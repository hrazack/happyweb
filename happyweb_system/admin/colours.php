<?php
$head_page_title = "Wondrous colours";
$display_navigation = true;
if (isset($_POST["action"])) {
  
  update_setting("colour_h1", $_POST["colour_h1"]);
  update_setting("colour_h2", $_POST["colour_h2"]);
  update_setting("colour_h3", $_POST["colour_h3"]);
  update_setting("colour_links", $_POST["colour_links"]);
  update_setting("colour_header_text", $_POST["colour_header_text"]);
  update_setting("colour_header_bg", $_POST["colour_header_bg"]);
  update_setting("colour_nav_text", $_POST["colour_nav_text"]);
  update_setting("colour_nav_bg", $_POST["colour_nav_bg"]);
  update_setting("colour_footer_text", $_POST["colour_footer_text"]);
  update_setting("colour_footer_bg", $_POST["colour_footer_bg"]);
  set_message('The colours have been updated!');
  redirect('admin/colours');

}   
?>

<p class="help"><i class="material-icons">info_outline</i>By default your website comes with some mind-blowing predefined colours.<br />However you can change them here if you wish.<br />(When one of the colours below is transparent it means it will be using the predefined colour)</p>

<form action="<?php print $url_info["path"];?>" method="post">
  
  <table>
    <tr>
      <td>Background colour for the header</td>
      <td><input type="text" class="text colour" name="colour_header_bg" value="<?php print get_setting("colour_header_bg"); ?>" /></td>
    </tr>
    <tr>
      <td>Text in the header</td>
      <td><input type="text" class="text colour" name="colour_header_text" value="<?php print get_setting("colour_header_text"); ?>" /></td>
    </tr>
    <tr>
      <td>Background colour for the navigation</td>
      <td><input type="text" class="text colour" name="colour_nav_bg" value="<?php print get_setting("colour_nav_bg"); ?>" /></td>
    </tr>
    <tr>
      <td>Text in the navigation</td>
      <td><input type="text" class="text colour" name="colour_nav_text" value="<?php print get_setting("colour_nav_text"); ?>" /></td>
    </tr>
    <tr>
      <td>Background colour for the footer</td>
      <td><input type="text" class="text colour" name="colour_footer_bg" value="<?php print get_setting("colour_footer_bg"); ?>" /></td>
    </tr>
    <tr>
      <td>Text in the footer</td>
      <td><input type="text" class="text colour" name="colour_footer_text" value="<?php print get_setting("colour_footer_text"); ?>" /></td>
    </tr>
    <tr>
      <td>Row heading<br /><span class="comment">(that's the optional heading at the top of each row)</span></td>
      <td><input type="text" class="text colour" name="colour_h1" value="<?php print get_setting("colour_h1"); ?>" /></td>
    </tr>
    <tr>
      <td>Heading 2<br /><span class="comment">(that's the "H2" button when you edit some text)</span></td>
      <td><input type="text" class="text colour" name="colour_h2" value="<?php print get_setting("colour_h2"); ?>" /></td>
    </tr>
    <tr>
      <td>Heading 3<br /><span class="comment">(that's the "H3" button when you edit some text)</span></td>
      <td><input type="text" class="text colour" name="colour_h3" value="<?php print get_setting("colour_h3"); ?>" /></td>
    </tr>
    <tr>
      <td>Links in the text</td>
      <td><input type="text" class="text colour" name="colour_links" value="<?php print get_setting("colour_links"); ?>" /></td>
    </tr>
  </table>
  <br />
  
  <input type="submit" class="submit" value="Save colours" />
  <input type="hidden" name="action" value="save_colours" />
  
  <!--
  <br /><br /><br />
  <p>Here is a little preview of what it will look like if you change the default colours:</p>
  
  <div class="colours-preview">
    <div class="colours-preview-header" style="background: <?php print get_setting("colour_header_bg"); ?>; color: <?php print get_setting("colour_header_text"); ?>">Header</div>
    <div class="colours-preview-nav" style="background: <?php print get_setting("colour_nav_bg"); ?>;">
      <a style="color: <?php print get_setting("colour_nav_text"); ?>;">Link 1</a>
      <a style="color: <?php print get_setting("colour_nav_text"); ?>;">Link 2</a>
      <a style="color: <?php print get_setting("colour_nav_text"); ?>;">Link 3</a>
    </div>
    <div class="colours-preview-content">
      <div class="colours-preview-section">
        <h2>Row heading</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href="">Aenean leo dolor</a>, consectetur non maximus at, consequat vitae nibh. Morbi a metus vel magna ultricies ultricies.</p>
      </div>
      <div class="colours-preview-section">
        <h2>Row heading</h2>
        <p>Praesent vel dignissim ante. Fusce fringilla tortor quis ipsum aliquet finibus. Nam ac sem turpis. Nunc bibendum commodo lorem. Aenean dictum enim ac nunc malesuada, vulputate efficitur tortor commodo.</p>
      </div>
    </div>
    <div class="colours-preview-footer">Footer</div>
  </div>
  -->
  
</form>

<script>
  $(document).ready(function() {
    $(".colour").spectrum({
      allowEmpty: true,
      preferredFormat: "hex",
    });
  });
</script>