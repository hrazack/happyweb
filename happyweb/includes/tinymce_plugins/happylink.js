tinymce.PluginManager.add('happylink', function(editor) {

  this.showDialog = showDialog;
  
  editor.addButton('happylink', {
		icon: 'link',
		tooltip: 'Add/edit a link',
		onclick: showDialog,
		stateSelector: 'a[href]'
	});
  
  // populate the list of pages
  var pages, pages_url;
  $.ajax({
    url: "/ajax/list_pages",
    type: "POST",
    success: function(data, status) {
      data = jQuery.parseJSON(data);
      pages = data.pages;
      pages_url = data.pages_url;
      page_select = {text: '- Please choose -', value: ''};
      page_external = {text: '* A page outside of the site', value: 'external-url'};
      pages.unshift(page_external);
      pages.unshift(page_select);
    }
  });
  
  function buildListItems(inputList, itemCallback, startItems) {
		function appendItems(values, output) {
			output = output || [];
			tinymce.each(values, function(item) {
				var menuItem = {text: item.text || item.title};
				if (item.menu) {
					menuItem.menu = appendItems(item.menu);
				} else {
					menuItem.value = item.value;
					if (itemCallback) {
						itemCallback(menuItem);
					}
				}
				output.push(menuItem);
			});
			return output;
		}
		return appendItems(inputList, startItems || []);
	}
  
      
	function showDialog() {
		var data = {}, selection = editor.selection, dom = editor.dom, selectedElm, anchorElm, initialText;
		var win, onlyText, textListCtrl, classListCtrl, value;
		selectedElm = selection.getNode();
		anchorElm = dom.getParent(selectedElm, 'a[href]');
		onlyText = isOnlyTextSelected();

		data.text = initialText = anchorElm ? (anchorElm.innerText || anchorElm.textContent) : selection.getContent({format: 'text'});
		data.href = anchorElm ? dom.getAttrib(anchorElm, 'href') : '';
    is_external_url = (pages_url.indexOf(data.href) == -1);
    if (!is_external_url) {
      data.page = data.href;
      data.href = "";
    }
    else if (data.href == '') {
      data.page = "";
    }
    else {
      data.page = "external-url";
    }
        
		if (anchorElm) {
			data.target = dom.getAttrib(anchorElm, 'target');
		}

		if ((value = dom.getAttrib(anchorElm, 'rel'))) {
			data.rel = value;
		}

		if ((value = dom.getAttrib(anchorElm, 'class'))) {
			data['class'] = value;
		}

		if ((value = dom.getAttrib(anchorElm, 'title'))) {
			data.title = value;
		}

		if (onlyText && data.text == "") {
			textListCtrl = {
				name: 'text',
				type: 'textbox',
				size: 40,
				label: 'Text:',
				onchange: function() {
					data.text = this.value();
				}
			};
		}
    
    if (editor.settings.link_class_list) {
			classListCtrl = {
				name: 'class',
				type: 'listbox',
				label: 'Visual style:',
				values: buildListItems(
					editor.settings.link_class_list,
					function(item) {
						if (item.value) {
							item.textStyle = function() {
								return editor.formatter.getCssText({inline: 'a', classes: [item.value]});
							};
						}
					}
				)
			};
		}

		win = editor.windowManager.open({
			title: 'Insert link',
			data: data,
			body: [
        {
          name: 'page', 
          type: 'listbox', 
          label: 'Select a page:',
          minWidth: 300,
          values: pages,
          value: data.page,
          onselect: linkListChangeHandler
        },
				{
					name: 'href',
					type: 'filepicker',
          label: 'Url:',
					filetype: 'file',
					size: 40
				},
				textListCtrl,
        classListCtrl
			],
      onOpen: function(e) {
        if (data.page != "external-url" || data.page == "") {
          url_widget = win.find('#href').parent();
          url_widget.hide();
        }
      },
			onSubmit: function(e) {
				var href;
				data = tinymce.extend(data, e.data);        
        href = (data.page != "external-url")?data.page:data.href;

				if (!href) {
					editor.execCommand('unlink');
					return;
				}

				if (href.indexOf('@') > 0 && href.indexOf('//') == -1 && href.indexOf('mailto:') == -1) {
          href = 'mailto:' + href;
        }

				if ((editor.settings.link_assume_external_targets && !/^\w+:/i.test(href)) || (!editor.settings.link_assume_external_targets && /^\s*www[\.|\d\.]/i.test(href))) {
					href = 'http://' + href;
        }
        
        // insert link
        var linkAttrs = {
          href: href,
          target: data.target ? data.target : null,
          rel: data.rel ? data.rel : null,
          "class": data["class"] ? data["class"] : null,
          title: data.title ? data.title : null
        };
        if (anchorElm) {
          editor.focus();
          dom.setAttribs(anchorElm, linkAttrs);
          selection.select(anchorElm);
          editor.undoManager.add();
        } else {
          if (onlyText) {
            editor.insertContent(dom.createHTML('a', linkAttrs, dom.encode(data.text)));
          } else {
            editor.execCommand('mceInsertLink', false, linkAttrs);
          }
        }

			} // onsubmit
		});
    
    function linkListChangeHandler(e) {
      value = e.control.value();
      url_widget = win.find('#href').parent();
      if (value == "external-url") {
        url_widget.show();
      }
      else {
        url_widget.hide();
      }
    }

    function isOnlyTextSelected(anchorElm) {
      var html = selection.getContent();
      // Partial html and not a fully selected anchor element
      if (/</.test(html) && (!/^<a [^>]+>[^<]+<\/a>$/.test(html) || html.indexOf('href=') == -1)) {
        return false;
      }
      if (anchorElm) {
        var nodes = anchorElm.childNodes, i;
        if (nodes.length === 0) {
          return false;
        }
        for (i = nodes.length - 1; i >= 0; i--) {
          if (nodes[i].nodeType != 3) {
            return false;
          }
        }
      }
      return true;
    }
    
	} // showdialog
  
});
