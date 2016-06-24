$(document).ready(function() {
  
  var current_column;
  var current_widget;
  
  // form validation
  $("form").validate();
  
  
  /************/
  /* rows     */
  /************/
  
  // adding a row
  $("#add-row").click(function() {
    $(this).addClass("loader");
    number_of_rows = $("input[name='number_of_rows']").val();
    number_of_rows++;
    index = number_of_rows;
    $("input[name='number_of_rows']").val(number_of_rows);
    $.ajax({
      url: "/ajax/new_row",
      data: {index: index},
      success: function(string) {
        new_row = $('<div/>').html(string).contents();
        new_row.hide().appendTo("#rows-container").slideDown();
        $("#add-row").removeClass("loader");
      }
    });
  });
  
  // deleting a row
  var delete_row_dialog = $('<div></div>').html('<p>What, shall we really delete this row?</p>').dialog({
    autoOpen: false,
    modal: true,
    width: 500
  });
  $(document).on("click", ".delete-row", function() {
    row = $(this).parents("section");
    row_id = row.find(".row-id").val();
    delete_row_dialog.dialog({
      buttons: [
      {
        text: "Yes, delete it!",
        click: function() {
          // update the number of rows
          number_of_rows = $("input[name='number_of_rows']").val();
          number_of_rows--;
          $("input[name='number_of_rows']").val(number_of_rows);
          // keep track of the rows that we have deleted
          if (row_id != 0) { // we ignore new rows
            deleted_rows = $("input[name='deleted_rows']").val();
            deleted_rows += row_id+",";
            $("input[name='deleted_rows']").val(deleted_rows);
          }
          // remove the row
          row.fadeOut(function() {
            $(this).remove();
          });
          $(this).dialog("close");
        }
      },
      {
        text: "Cancel",
        click: function() {
          $(this).dialog("close");
        }
      }
    ]
    });
    delete_row_dialog.dialog("open");
  });
  
  // sortable rows
  $("#rows-container").sortable({
    handle: ".row-drag",
    axis: "y",
    update: function(event, ui) {
      $("#rows-container").children().each(function(i) {
        display_order = i+1;
        $(this).find(".row-display-order").val(display_order);
      });
    }
  });
  $("#rows-container").disableSelection();
  
  
  /************/
  /* columns  */
  /************/
  
  // changing the columns size in a row
  $(document).on("click", "input.columns-size", function() {
    // first, we set the proper class to the column container
    columns_class = $(this).val();
    columns_amount = $(this).attr("data-number-col");
    columns_container = $(this).parent().next().find("[data-find='columns-container']").first();
    columns_container.removeClass();
    columns_container.addClass(columns_class);
    // update the number of columns for that row
    $(this).parent().parent().find(".row-number-of-columns").first().val(columns_amount);
    // then we show or hide the columns
    if (columns_amount == 1) {
      columns_container.find(".column2").addClass("disabled");
      columns_container.find(".column3").addClass("disabled");
    }
    if (columns_amount == 2) {
      columns_container.find(".column2").removeClass("disabled");
      columns_container.find(".column3").addClass("disabled");
    }
    if (columns_amount == 3) {
      columns_container.find(".column2").removeClass("disabled");
      columns_container.find(".column3").removeClass("disabled");
    }
  });
  

  /************/
  /* widgets  */
  /************/
  
  // show list of widgets
  $(document).on("click", ".add-widget", function() {
    $(".widget-list").hide();
    $(this).next().slideToggle();
  });
  
  // hide list of widgets
  $(document).on("click", function(event) {
    if (event.target.className != "add-widget icon grey") {
      $(".widget-list").hide();
    }
  });
  
  // widget dialog
  var widget_dialog = $('<div id="widget_dialog"></div>').dialog({
    autoOpen: false,
    modal: true,
    width: 500,
    buttons: [
      {
        text: "Save",
        click: function() {
          // submit the widget form
          $("form[name='widget']").submit();
          //$(this).dialog("destroy");
        }
      },
      {
        text: "Cancel",
        click: function() {
          $(this).dialog("close");
        }
      }
    ]
  });
  
  // adding a widget
  $(document).on("click", ".widget-link", function() {
    widget_type = $(this).attr("data-widget-type");
    current_column = $(this).parents(".column");
    row = current_column.parents("section");
    // update the number of widgets for the current column
    col_id = current_column.find(".col-id").val();
    number_of_widgets = parseInt(current_column.find(".col-number-of-widgets").val());
    display_order = number_of_widgets + 1;
    index_row = row.find(".row-index").val();
    index_col = current_column.find(".col-display-order").val();
    // get the content of the widget form
    $.ajax({
      url: "/ajax/widget_form",
      context: current_column,
      data: {action: "create", widget_type: widget_type, col_id: col_id, display_order: display_order, index_row: index_row, index_col: index_col},
      success: function(string) {
        // open the widget form in a dialog
        $("#widget_dialog").html(string);
        widget_dialog.dialog("open");
      }
    });
  });
  
  // editing a widget
  $(document).on("click", ".edit-widget", function() {
    current_widget = $(this).parents(".widget");
    widget_id = current_widget.find(".widget-id").val();
    // get the content of the widget form
    $.ajax({
      url: "/ajax/widget_form",
      data: {action: "edit", widget_id: widget_id},
      success: function(string) {
        // open the widget form in a dialog
        $("#widget_dialog").html(string);
        widget_dialog.dialog("open");
      }
    });
  });
  
  // submitting widget form (called form the widget dialog) (for adding)
  $(document).on("submit", "form[name='widget']", function(event) {
    event.preventDefault();
    $("form[name='widget']").addClass("loader grey");
    $.ajax({
      url: "/ajax/widget_submit",
      data: $("form[name='widget']").serialize(),
      dataType: "json",
      success: function(data) {
        if (data.action == "create") {
          // update the number of widgets for that column
          number_of_widgets = parseInt(current_column.find(".col-number-of-widgets").val());
          widget_display_order = number_of_widgets + 1;
          current_column.find(".col-number-of-widgets").val(widget_display_order);
          // insert the widget
          widget_container = current_column.find(".widgets-container");
          new_widget = $('<div/>').html(data.widget_box).contents();
          new_widget.hide().appendTo(widget_container).slideDown();
        }
        else {
          // update the widget
          widget_overview = current_widget.find(".widget-overview");// TODO
          widget_overview.html(data.widget_overview);
        }
        // close dialog
        widget_dialog.dialog("close");
      }
    });
    return false;
  });
  
  // deleting a widget
  var delete_widget_dialog = $('<div></div>').html('<p>Shall we get rid of this content?</p>').dialog({
    autoOpen: false,
    modal: true,
    width: 500
  });
  $(document).on("click", ".delete-widget", function() {
    widget = $(this).parents(".widget");
    widget_id = widget.find(".widget-id").val();
    column = widget.parents(".column");
    delete_widget_dialog.dialog({
      buttons: [
      {
        text: "Yes, delete it!",
        click: function() {
          // update the number of widgets
          number_of_widgets = column.find(".col-number-of-widgets").val();
          number_of_widgets--;
          column.find(".col-number-of-widgets").val(number_of_widgets);
          // keep track of the widgets that we have deleted
          deleted_widgets = $("input[name='deleted_widgets']").val();
          deleted_widgets += widget_id+",";
          $("input[name='deleted_widgets']").val(deleted_widgets);
          // remove the widget
          widget.fadeOut(function() {
            $(this).remove();
          });
          $(this).dialog("close");
        }
      },
      {
        text: "Cancel",
        click: function() {
          $(this).dialog("close");
        }
      }
    ]
    });
    delete_widget_dialog.dialog("open");
  });
  
  // sortable widgets
  $(".widgets-container").sortable({
    handle: ".widget-drag",
    axis: "y",
    update: function(event, ui) {
      $(".widgets-container").children().each(function(i) {
        display_order = i+1;
        $(this).find(".widget-display-order").val(display_order);
      });
    }
  });
  $(".widgets-container").disableSelection();
  
});