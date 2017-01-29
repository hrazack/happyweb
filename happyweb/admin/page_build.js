$(document).ready(function() {
  
  var current_row;
  var current_column;
  var current_widget;

  // add "Heading" plugin to TinyMCE
  tinyMCE.PluginManager.add('heading', function(editor, url) {
    editor.addButton("heading", {
      tooltip: "Heading",
      text: "H",
      onClick: function() { editor.execCommand('mceToggleFormat', false, "h2"); },
      onPostRender: function() {
        var self = this, setup = function() {
          editor.formatter.formatChanged("h2", function(state) {
            self.active(state);
          });
        };
        editor.formatter ? setup() : editor.on('init', setup);
      },
    })
  });

  // wysiwyg editor options
  editor_options = {
    selector: '.formatted',
    menubar: false,
    statusbar: false,
    plugins: 'paste autolink code heading autoresize',
    external_plugins: {
      "happylink": "/happyweb/includes/tinymce_plugins/happylink.js"
    },
    autoresize_max_height: 800,
    paste_as_text: true,
    relative_urls: false,
    link_class_list: [
      {title: 'Regular link', value: ''},
      {title: 'Button link', value: 'button'}
    ],
    height: 400,
    toolbar: 'heading bold italic underline strikethrough | bullist numlist | alignleft aligncenter alignright | happylink | code',
    content_css: '/happyweb/themes/basic/styles.css',
    setup: function(editor) {
      editor.on('change', function () {
        editor.save();
      });
    }
  };
  tinymce.init(editor_options);
  
  // Make sure jquery_ui doesn't block TinyMCE
  $.widget("ui.dialog", $.ui.dialog, {
    _allowInteraction: function(event) {
      return !!$(event.target).closest(".mce-container").length || this._super( event );
    }
  });
        
  // form validation
  $("form").validate({
    invalidHandler: function(event, validator) {
      $("#loader").hide();
    }
  });
  
  // tooltip options
  tooltip_options = {
    animation: 'grow',
    theme: 'tooltipster-borderless',
    delay: 0,
    maxWidth: 400
  };
  
  // tooltips
  $('.tooltip').tooltipster(tooltip_options);
  
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
    number_of_rows = $("section").length;
    number_of_rows++;
    row_index = number_of_rows;
    page_id = $("input[name=page_id]").val();
    $("input[name='number_of_rows']").val(number_of_rows);
    $.ajax({
      url: "/ajax/new_row",
      data: {row_index: row_index, page_id: page_id},
      success: function(string) {
        new_row = $('<div/>').html(string).contents();
        new_row.hide().appendTo("#rows-container").slideDown();
        $("#add-row").removeClass("loader");
        $('.tooltip').tooltipster(tooltip_options);
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
          // keep track of the rows that we have deleted
          if (row_id.indexOf("new") == -1) { 
            // if it's an existing row, add it to the list of deleted rows. That will delete all the columns and widgets in that row
            deleted_rows = $("input[name='deleted_rows']").val();
            deleted_rows += row_id+",";
            $("input[name='deleted_rows']").val(deleted_rows);
          }
          else {
            // if it's a new row, add all the widgets to the list of deleted widgets
            deleted_widgets = $("input[name='deleted_widgets']").val();
            row.find(".widget").each(function() {
              widget_id = $(this).find(".widget-id").val();
              deleted_widgets += widget_id+",";
            });
            $("input[name='deleted_widgets']").val(deleted_widgets);
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
    current_row = $(this).parents("section");
    current_row.find(".row-content").hide();
  });
  $(document).on("mouseup", ".row-drag", function() {
    row = $(this).parents("section");
    row.find(".row-content").show();
  });
  $("#rows-container").sortable({
    handle: ".row-drag",
    axis: "y",
    start: function (e, ui) {
      $(ui.item).find('textarea').each(function () {
        tinymce.execCommand('mceRemoveEditor', false, $(this).attr('id'));
      });
    },
    beforeStop: function(event, ui) {
      ui.helper.find(".row-content").show();
      $("#rows-container").children().each(function(i) {
        display_order = i+1;
        $(this).find(".row-display-order").val(display_order);
      });
    },
    stop: function (e, ui) {
      $(ui.item).find('textarea').each(function () {
        tinymce.execCommand('mceAddEditor', true, $(this).attr('id'));
      });
      // update rows with proper index
      $("section").each(function(i) {
        row_index = i+1;
        $(this).find(".row-index").val(row_index);
      });
    },
  });
  $("#rows-container").disableSelection();
  
  // row options
  $(document).on("click", ".row-options-button", function() {
    current_row = $(this).parents("section");
    row_options = current_row.find('.row-options');
    row_options.dialog({
      autoOpen: true,
      modal: true,
      width: 800,
      buttons: [
        {
          text: "Save",
          click: function() {
            $(this).dialog("destroy");
          }
        }
      ],
      close: function() {
        $(this).dialog("destroy");
      }
    });
    row_options.dialog("open");
  });
  
  
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
    is_display_form = $(this).attr("data-require-form");
    row = current_column.parents("section");
    col_id = current_column.find(".col-id").val();
    widget_index = current_column.find(".widget").length + 1;
    if (is_display_form == "true") {
      // get the content of the widget form
      $.ajax({
        url: "/ajax/widget_form",
        method: "post",
        data: {action: "create", widget_type: widget_type, col_id: col_id, widget_index: widget_index},
        success: function(string) {
          $("#loader").hide();
          // open the widget form in a dialog
          $("#widget_form_dialog").html(string);
          tinymce.init(editor_options);
          widget_list_dialog.dialog("close");
          widget_form_dialog.dialog("open");
        }
      });
    }
    else {
      // if the widget doesn't require a form, we insert the widget overview straightaway
      $.ajax({
          url: "/ajax/widget_submit",
          type: "POST",
          data: {action: "create", widget_type: widget_type, col_id: col_id, widget_index: widget_index},
          success: function(data, status) {
            data = jQuery.parseJSON(data);
            insert_widget(data);
            tinymce.init(editor_options);
            $("#loader").hide();
          }
      });
    }
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
        tinymce.init(editor_options);
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
      data: new FormData(this),
      dataType: "json",
      processData: false,
      contentType: false,
      cache: false,
      success: function(data, status) {
        if (data.status != "error") {
          if (data.action == "create") {
            insert_widget(data);
          }
          else {
            // update the widget (just the overview)
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
  var containers = $(".widgets-container");
  var dragObject = dragula({
    isContainer: function (el) {
      return el.classList.contains('widgets-container');
    },
    moves: function (el, container, handle) {
      return handle.classList.contains('handle');
    }
  });
  dragObject.on("drag", function(widget, source) {
    $(widget).find('textarea').each(function () {
      tinymce.execCommand('mceRemoveEditor', false, $(this).attr('id'));
      $(this).addClass("dragged"); 
    });
  });
  dragObject.on("dragend", function(widget) {
    $(widget).find('textarea').each(function () {
      tinymce.execCommand('mceAddEditor', true, $(this).attr('id'));
      $(this).removeClass("dragged"); 
    });
  });
  dragObject.on("drop", function(widget, target, source, sibling) {
    var old_column = $(source).parent();
    var new_column = $(target).parent();
    var new_row = new_column.parents("section");
    // recalculate the index of each widget in the source column
    $(source).children().each(function(i) {
      widget_index = i+1;
      $(this).find(".widget-index").val(widget_index);
    });
    // recalculate the index of each widget in the target column
    $(target).children().each(function(i) {
      widget_index = i+1;
      $(this).find(".widget-index").val(widget_index);
    });
    // update the widget with the new column reference
    new_col_id = new_column.find('.col-id').val();
    $(widget).find('.widget-col-id').val(new_col_id);
  });

  // inserts a widget in the current column (that's called after an ajax call to the widget submit form)
  function insert_widget(data) {
    // insert the widget (the whole box)
    widget_container = current_column.find(".widgets-container");
    new_widget = $('<div/>').html(data.widget_box).contents();
    new_widget.hide().appendTo(widget_container).fadeIn();
    // register tooltip
    $('.tooltip').tooltipster(tooltip_options);
  }
  
});