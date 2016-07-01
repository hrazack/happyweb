<div class="column column<?php print $index_col; ?> <?php print ($row->number_of_columns < $index_col)?"disabled":""; ?>">
  
  <input type="hidden" name="rows[<?php print $index_row; ?>][cols][<?php print $index_col; ?>][id]" class="col-id" value="<?php print $col->id; ?>" />
  <input type="hidden" name="rows[<?php print $index_row; ?>][cols][<?php print $index_col; ?>][display_order]" class="col-display-order" value="<?php print $col->display_order; ?>" />
  <input type="hidden" name="rows[<?php print $index_row; ?>][cols][<?php print $index_col; ?>][number_of_widgets]" class="col-number-of-widgets" value="<?php print $col->number_of_widgets; ?>" />
  
  <div class="widgets-container" id="widgets-container-col<?php print $index_col; ?>">
  <?php
  if ($col->id != 0) {
    $index_widget = 1;
    if ($widgets = $db->get_results("SELECT * FROM widget WHERE col_id=".$col->id." ORDER BY display_order ASC")) {
      foreach($widgets as $widget) {
        include("inc_form_widget.php");
        $index_widget++;
      }
    }
  }
  ?>
  </div>
  
  
  <a class="add-widget grey" title="Add something here"><i class="material-icons">add_circle</i>Add some content here</a>
  
</div>