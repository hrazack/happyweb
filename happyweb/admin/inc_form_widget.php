<div class="widget">
  <div class="widget-toolbar toolbar">
    <div class="edit"><a title="Edit this content" class="edit-widget icon"><i class="material-icons">create</i></a></div>
    <div class="delete"><a title="Delete this content" class="delete-widget icon"><i class="material-icons">delete</i></a></div>
    <div class="widget-drag"><i class="material-icons">open_with</i></div>
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