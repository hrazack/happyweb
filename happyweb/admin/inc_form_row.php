<section id="row<?php print $index_row; ?>">
  
  <input type="hidden" name="rows[<?php print $index_row; ?>][number_of_columns]" class="row-number-of-columns" value="<?php print $row->number_of_columns; ?>" />
  <input type="hidden" name="rows[<?php print $index_row; ?>][display_order]" class="row-display-order" value="<?php print $row->display_order; ?>" />
  <input type="hidden" name="rows[<?php print $index_row; ?>][index]" class="row-index" value="<?php print $row->display_order; ?>" />
  <input type="hidden" name="rows[<?php print $index_row; ?>][id]" class="row-id" value="<?php print $row->id; ?>" />
  
  <div class="row-options">
    <h2>Magnificent options for this row</h2>
    <?php
    $checked_padding = ($row->no_padding == 1)?"checked":"";
    $checked_heading = ($row->center_heading == 1)?"checked":"";
    ?>
    <div class="form-item-radio">
      <input type="checkbox" name="rows[<?php print $index_row; ?>][options][no_padding]" value="1" <?php print $checked_padding; ?> />
      <label class="inline">Remove the top and bottom padding</label>
    </div>
    <div class="form-item">
      <input type="checkbox" name="rows[<?php print $index_row; ?>][options][center_heading]" value="1" <?php print $checked_heading; ?> />
      <label class="inline">Center the optional heading</label>
    </div>
  </div>
  
  <div class="row-toolbar toolbar">
    <div class="row-toolbar-columns">
      <?php 
      // display each column size button
      foreach($columns_sizes as $columns_size => $column_info) { 
        $checked = ($row->columns_size == $columns_size)?"checked":"";
        ?>
        <input type="radio" name="rows[<?php print $index_row; ?>][columns_size]" class="tooltip columns-size <?php print $columns_size; ?>" <?php print $checked; ?> title="Change to <?php print $column_info["description"]; ?>" value="<?php print $columns_size; ?>" data-number-col="<?php print $column_info["size"]; ?>" />
        <?php 
      }?>
    </div>
    <div class="row-toolbar-icons">
      <div class="toolbar-item settings"><a title="Some options for this row" class="tooltip icon row-options-button"><i class="material-icons">settings</i></a></div>
      <!--<div class="toolbar-item columns"><a title="Change the columns for this row" class="tooltip icon row-columns"><i class="material-icons">view_week</i></a></div>-->
      <div class="toolbar-item delete"><a title="Delete this row" class="tooltip icon delete-row"><i class="material-icons">delete</i></a></div>
      <div class="toolbar-item row-drag"><i class="material-icons">open_with</i></div>
    </div>
  </div>
  
  <div class="row-content">

    <div class="<?php print $row->columns_size; ?>" data-find="columns-container">
      
      <div class="form-item">
        <input type="text" class="text full-width big" name="rows[<?php print $index_row; ?>][heading]" value="<?php print $row->heading; ?>" placeholder="You can type an optional heading here" />
      </div>
      
      <?php
      // load columns for that row
      $columns = array();
      if (!$cols = $db->get_results("SELECT * FROM col WHERE row_id=".$row->id." ORDER BY display_order ASC")) {
        $cols = array();
      }
      else {
        foreach($cols as $col) {
          $columns[$col->display_order] = $col;
        }
      }

      // create empty columns if needed
      for($i=1; $i<=3; $i++) {
        if (!isset($columns[$i])) {
          $col = create_new_col($i);
          $columns[$i] = $col;
        }
      }
      
      // display the columns
      $index_col = 1;
      foreach($columns as $col) {
        include("inc_form_col.php");
        $index_col++;
      }
      
      ?>

    </div>
    
  </div>
  
</section>