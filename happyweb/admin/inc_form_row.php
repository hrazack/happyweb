<section id="row<?php print $index_row; ?>">
  
  <input type="hidden" name="rows[<?php print $index_row; ?>][number_of_columns]" class="row-number-of-columns" value="<?php print $row->number_of_columns; ?>" />
  <input type="hidden" name="rows[<?php print $index_row; ?>][display_order]" class="row-display-order" value="<?php print $row->display_order; ?>" />
  <input type="hidden" name="rows[<?php print $index_row; ?>][index]" class="row-index" value="<?php print $row->display_order; ?>" />
  <input type="hidden" name="rows[<?php print $index_row; ?>][id]" class="row-id" value="<?php print $row->id; ?>" />
  
  <div class="row-toolbar toolbar">
    <?php 
    // display each column size button
    foreach($columns_sizes as $columns_size => $number_of_columns) { 
      $checked = ($row->columns_size == $columns_size)?"checked":"";
      ?>
      <input type="radio" name="rows[<?php print $index_row; ?>][columns_size]" class="columns-size <?php print $columns_size; ?>" <?php print $checked; ?> value="<?php print $columns_size; ?>" data-number-col="<?php print $number_of_columns; ?>" />
      <?php 
    }?>
    <div class="row-toolbar-icons">
      <!--<div class="settings"><a title="Row settings"><i class="material-icons">settings</i></a></div>-->
      <div class="delete"><a title="Delete this row" class="icon delete-row"><i class="material-icons">delete</i></a></div>
      <div class="row-drag"><i class="material-icons">open_with</i></div>
    </div>
  </div>
  
  <div class="row-content">

    <div class="<?php print $row->columns_size; ?>" data-find="columns-container">
      
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
        //print "Checking column ".$i." - ";
        if (!isset($columns[$i])) {
          //print "It doesn't exist, so we create it<br />";
          $col = create_new_col($i);
          $columns[$i] = $col;
        }
        else {
          //print "It exists!<br />";
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