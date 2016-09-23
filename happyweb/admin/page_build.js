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
    number_of_widgets = parseInt(current_column.find(".col-number-of-widgets").val());
    display_order = number_of_widgets + 1;
    index_row = row.find(".row-index").val();
    index_col = current_column.find(".col-display-order").val();
    if (is_display_form == "true") {
      // get the content of the widget form
      $.ajax({
        url: "/ajax/widget_form",
        method: "post",
        data: {action: "create", widget_type: widget_type, col_id: col_id, display_order: display_order, index_row: index_row, index_col: index_col},
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
          data: {action: "create", widget_type: widget_type, col_id: col_id, display_order: display_order, index_row: index_row, index_col: index_col},
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
    start: function (e, ui) {
      $(ui.item).find('textarea').each(function () {
        tinymce.execCommand('mceRemoveEditor', false, $(this).attr('id'));
        $(this).addClass("dragged"); 
      });
    },
    stop: function (e, ui) {
      $(ui.item).find('textarea').each(function () {
        tinymce.execCommand('mceAddEditor', true, $(this).attr('id'));
        $(this).removeClass("dragged"); 
      });
    },
    update: function(e, ui) {
      $(".widgets-container").children().each(function(i) {
        display_order = i+1;
        $(this).find(".widget-display-order").val(display_order);
      });
    }
  });
  $(".widgets-container").disableSelection();
  
  // inserts a widget in the current column (that's called after an ajax call to the widget submit form)
  function insert_widget(data) {
    // update the number of widgets for that column
    number_of_widgets = parseInt(current_column.find(".col-number-of-widgets").val());
    widget_display_order = number_of_widgets + 1;
    current_column.find(".col-number-of-widgets").val(widget_display_order);
    // insert the widget (the whole box)
    widget_container = current_column.find(".widgets-container");
    new_widget = $('<div/>').html(data.widget_box).contents();
    new_widget.hide().appendTo(widget_container).fadeIn();
    // register tooltip
    $('.tooltip').tooltipster(tooltip_options);
  }
  
});