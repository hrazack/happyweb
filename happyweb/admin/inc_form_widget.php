<div class="widget <?php print $widget->type; ?>">

  <div class="widget-toolbar toolbar">
    <?php if ($widget->type != "text" && $widget->type != "navigation") { ?>
    <div class="toolbar-item edit"><a title="Edit this <?php print $widget->type; ?>" class="edit-widget icon tooltip"><i class="material-icons">create</i></a></div>
    <?php } ?>
    <div class="toolbar-item delete"><a title="Delete this <?php print $widget->type; ?>" class="delete-widget icon tooltip"><i class="material-icons">delete</i></a></div>
    <?php //if ($widget->type != "text") { ?>
    <div class="toolbar-item widget-drag"><i class="material-icons">open_with</i></div>
    <?php //} ?>
  </div>
  
  <div class="widget-info">
    <?php print $widget->type; ?>
  </div>
  
  <div class="widget-overview">
    <?php print build_widget_overview($widget); ?>
  </div>
  
  <input type="hidden" name="rows[<?php print $index_row; ?>][cols][<?php print $index_col; ?>][widgets][<?php print $index_widget; ?>][id]" class="widget-id" value="<?php print $widget->id; ?>" />
  <input type="hidden" name="rows[<?php print $index_row; ?>][cols][<?php print $index_col; ?>][widgets][<?php print $index_widget; ?>][display_order]" class="widget-display-order" value="<?php print $widget->display_order; ?>" />
  
</div>