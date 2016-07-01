$(document).ready(function() {
  
  var current_column;
  var current_widget;
  
  // wysiwyg editor options
  editor_options = {
    btns: [['formatting'], ['strong', 'em', 'underline', 'strikethrough'], ['justifyLeft', 'justifyCenter', 'justifyRight'], ['unorderedList', 'orderedList'], 'link', 'viewHTML'],
    removeformatPasted: true,
    //autogrow: true
  };
  
  // form validation
  $("form").validate({
    invalidHandler: function(event, validator) {
      $("#loader").hide();
    }
  });
  
  // page submit
  $(".submit.page").click(function() {
    $("#loader").show();
    $("#loader-anim").position({my: 'center', at: 'center', of: window, collision: 'fit'});
  });
  
  // page options
  $(document).on("click", ".more", function() {
    $(this).toggleClass("opened");
    $(this).parent().next().slideToggle();
  });
  
  
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
  $(document).on("mousedown", ".row-drag", function() {
    row = $(this).parents("section");
    row.find(".row-content").hide();
  });
  $(document).on("mouseup", ".row-drag", function() {
    row = $(this).parents("section");
    row.find(".row-content").show();
  });
  $("#rows-container").sortable({
    handle: ".row-drag",
    axis: "y",
    beforeStop: function(event, ui) {
      ui.helper.find(".row-content").show();
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
    columns_container = $(this).parent().parent().next().find("[data-find='columns-container']").first();
    columns_container.removeClass();
    columns_container.addClass(columns_class);
    // update the number of columns for that row
    $(this).parents("section").find(".row-number-of-columns").first().val(columns_amount);
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
    current_column = $(this).parents(".column");
    widget_list_dialog.dialog("open");
  });
  
  // widget list dialog
  var widget_list_dialog = $("#widget-list").dialog({
    autoOpen: false,
    modal: true,
    width: 560
  });
  
  // widget form dialog
  var widget_form_dialog = $('<div id="widget_form_dialog"></div>').dialog({
    autoOpen: false,
    modal: true,
    width: 800,
    buttons: [
      {
        text: "Save",
        click: function() {
          // submit the widget form
          $("form[name='widget']").submit();
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
  $(document).on("click", ".widget-list a", function() {
    $("#loader").show();
    $("#loader-anim").position({my: 'center', at: 'center', of: window, collision: 'fit'});
    widget_list_dialog.dialog("close");
    widget_type = $(this).attr("data-widget-type");
    row = current_column.parents("section");
    col_id = current_column.find(".col-id").val();
    number_of_widgets = current_column.find(".col-number-of-widgets").val();
    display_order = number_of_widgets + 1;
    index_row = row.find(".row-index").val();
    index_col = current_column.find(".col-display-order").val();
    // get the content of the widget form
    $.ajax({
      url: "/ajax/widget_form",
      method: "post",
      data: {action: "create", widget_type: widget_type, col_id: col_id, display_order: display_order, index_row: index_row, index_col: index_col},
      success: function(string) {
        $("#loader").hide();
        // open the widget form in a dialog
        $("#widget_form_dialog").html(string);
        $('.ui-dialog textarea').trumbowyg(editor_options);
        widget_list_dialog.dialog("close");
        widget_form_dialog.dialog("open");
      }
    });
  });
  
  // editing a widget
  $(document).on("click", ".edit-widget", function() {
    $("#loader").show();
    $("#loader-anim").position({my: 'center', at: 'center', of: window, collision: 'fit'});
    current_widget = $(this).parents(".widget");
    widget_id = current_widget.find(".widget-id").val();
    // get the content of the widget form
    $.ajax({
      url: "/ajax/widget_form",
      method: "post",
      data: {action: "edit", widget_id: widget_id},
      success: function(string) {
        $("#loader").hide();
        // open the widget form in a dialog
        $("#widget_form_dialog").html(string);
        $('.ui-dialog textarea').trumbowyg(editor_options);
        widget_form_dialog.dialog("open");
      }
    });
  });
  
  // submitting widget form (called from the widget dialog)
  $(document).on("submit", "form[name='widget']", function(event) {
    event.preventDefault();
    $("#loader").show();
    $("#loader-anim").position({my: 'center', at: 'center', of: window, collision: 'fit'});
    widget_form_dialog.dialog("close");
    $.ajax({
      url: "/ajax/widget_submit",
      type: "post",
      data: new FormData(this), //$("form[name='widget']").serialize(),
      dataType: "json",
      processData: false,
      contentType: false,
      cache: false,
      success: function(data, status) {
        if (data.status != "error") {
          if (data.action == "create") {
            // update the number of widgets for that column
            number_of_widgets = parseInt(current_column.find(".col-number-of-widgets").val());
            widget_display_order = number_of_widgets + 1;
            current_column.find(".col-number-of-widgets").val(widget_display_order);
            // insert the widget
            widget_container = current_column.find(".widgets-container");
            new_widget = $('<div/>').html(data.widget_box).contents();
            new_widget.hide().appendTo(widget_container).fadeIn();
          }
          else {
            // update the widget
            widget_overview = current_widget.find(".widget-overview");
            widget_overview.html(data.widget_overview);
          }
        }
        else {
          // display error message
          $('<div></div>').html(data.errorMessage).dialog({
            modal: true,
            width: 500,
            close: function(event, ui) {$(this).dialog("destroy");}
          });
        }
        $("#loader").hide();
      }
    });
    return false;
  });
  
  // deleting a widget
  var delete_widget_form_dialog = $('<div></div>').html('<p>Shall we get rid of this content?</p>').dialog({
    autoOpen: false,
    modal: true,
    width: 500
  });
  $(document).on("click", ".delete-widget", function() {
    widget = $(this).parents(".widget");
    widget_id = widget.find(".widget-id").val();
    column = widget.parents(".column");
    delete_widget_form_dialog.dialog({
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
    delete_widget_form_dialog.dialog("open");
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