<div class="column column<?php print $col->col_index; ?> <?php print ($row->number_of_columns < $col->col_index)?"disabled":""; ?>">
  
  <input type="hidden" name="cols[<?php print $row->row_index."_".$col->col_index; ?>][id]" class="col-id" value="<?php print $col->id; ?>" />
  <input type="hidden" name="cols[<?php print $row->row_index."_".$col->col_index; ?>][row_id]" class="col-row-id" value="<?php print $col->row_id; ?>" />
  <input type="hidden" name="cols[<?php print $row->row_index."_".$col->col_index; ?>][col_index]" class="col-index" value="<?php print $col->col_index; ?>" />

  <div class="widgets-container" id="widgets-container-col<?php print $col->col_index; ?>">
  <?php
  $is_new_col = (strpos($col->id, "new") !== false);
  if (!$is_new_col) {
    $index_widget = 1;
    if ($widgets = $db->get_results("SELECT * FROM widget WHERE col_id=".$col->id." ORDER BY widget_index ASC")) {
      foreach($widgets as $widget) {
        include("inc_form_widget.php");
        $index_widget++;
      }
    }
  }
  ?>
  </div>
   
  <a class="add-widget icon grey tooltip" title="Add something to this column">Add something</a>
 
</div>