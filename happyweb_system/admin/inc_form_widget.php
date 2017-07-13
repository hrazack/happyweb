<div class="widget <?php print $widget->type; ?>">
  
  <input type="hidden" name="widgets[<?php print $widget->id; ?>][id]" class="widget-id" value="<?php print $widget->id; ?>" />
  <input type="hidden" name="widgets[<?php print $widget->id; ?>][col_id]" class="widget-col-id" value="<?php print $widget->col_id; ?>" />
  <input type="hidden" name="widgets[<?php print $widget->id; ?>][widget_index]" class="widget-index" value="<?php print $widget->widget_index; ?>" />
  
  <div class="widget-toolbar toolbar">
    <?php if ($widget->type != "text" && $widget->type != "navigation") { ?>
    <div class="toolbar-item edit"><a title="Edit this <?php print $widget->type; ?>" class="edit-widget icon tooltip"><i class="material-icons">create</i></a></div>
    <?php } ?>
    <div class="toolbar-item delete"><a title="Delete this <?php print $widget->type; ?>" class="delete-widget icon tooltip"><i class="material-icons">delete</i></a></div>
    <?php //if ($widget->type != "text") { ?>
    <div class="toolbar-item widget-drag"><i class="material-icons handle">open_with</i></div>
    <?php //} ?>
  </div>
  
  <div class="widget-info">
    <?php print $widget->type; ?>
  </div>
  
  <div class="widget-overview">
    <?php print build_widget_overview($widget); ?>
  </div>
  
</div>