<?php
$head_page_title = "Fix bug";
$page_title = "";
$page_url = "";
$browser_title = "";
$description = "";

if (isset($_POST["action"])) {
  foreach($_POST["widget"] as $widget_id => $col_id) {
    $db->query("UPDATE widget SET col_id=".$col_id." WHERE id=".$widget_id);
  }
  set_message("Changes saved successfully");
  redirect("admin/fix_bug");
}
else {
?>

<br />
<form action="<?php print $url_info["path"];?>" method="post">
  <input type="submit" value="Save" />
  <br /><br />
  <table>
    <tr>
      <td>id</td>
      <td>Type</td>
      <td>Content</td>
      <td>Column #</td>
    </tr>
    <?php
    $widgets = $db->get_results("SELECT * FROM widget WHERE col_id != 0");
    foreach($widgets as $widget) {
      $data = $db->get_row("SELECT * FROM widget_".$widget->type." WHERE widget_id=".$widget->id);
      switch($widget->type) {
        case 'text': $desc = $data->text; break;
        case 'image': $desc = "<img src='/my_website/uploaded_files/".$data->size."/".$data->file."' width='150'/>".$data->description; break;
        case 'video': $desc = $data->video_description." -- ".$data->video_url; break;
        default: $desc = "";
      }
      ?>
      <tr>
        <td><?php print $widget->id; ?></td>
        <td><?php print $widget->type; ?></td>
        <td><?php print $desc; ?></td>
        <td><input type="text" class="text small" name="widget[<?php print $widget->id; ?>]" value="<?php print $widget->col_id; ?>" /></td>
      </tr>
      <?php
    }
    ?>
  </table>
  <br />
  <input type="submit" value="Save" />
  <input type="hidden" name="action" value="save" />
</form>

<?php } ?>