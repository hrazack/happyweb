/** Trumbowyg v2.1.0 - A lightweight WYSIWYG editor - alex-d.github.io/Trumbowyg - License MIT - Author : Alexandre Demode (Alex-D) / alex-d.fr */
jQuery.trumbowyg = {
        langs: {
            en: {
                viewHTML: "View HTML",
                undo: "Undo",
                redo: "Redo",
                formatting: "Formatting",
                p: "Paragraph",
                blockquote: "Quote",
                code: "Code",
                header: "Header",
                bold: "Bold",
                italic: "Italic",
                strikethrough: "Stroke",
                underline: "Underline",
                strong: "Strong",
                em: "Emphasis",
                del: "Deleted",
                superscript: "Superscript",
                subscript: "Subscript",
                unorderedList: "Unordered list",
                orderedList: "Ordered list",
                insertImage: "Insert Image",
                link: "Link",
                createLink: "Insert link",
                unlink: "Remove link",
                justifyLeft: "Align Left",
                justifyCenter: "Align Center",
                justifyRight: "Align Right",
                justifyFull: "Align Justify",
                horizontalRule: "Insert horizontal rule",
                removeformat: "Remove format",
                fullscreen: "Fullscreen",
                close: "Close",
                submit: "Confirm",
                reset: "Cancel",
                required: "Required",
                description: "Description",
                title: "Title",
                text: "Text",
                target: "Target"
            }
        },
        plugins: {},
        svgPath: null
    },
    function(e, t, n, a) {
        "use strict";
        a.fn.trumbowyg = function(e, t) {
            var n = "trumbowyg";
            if (e === Object(e) || !e) return this.each(function() {
                a(this).data(n) || a(this).data(n, new o(this, e))
            });
            if (1 === this.length) try {
                var r = a(this).data(n);
                switch (e) {
                    case "execCmd":
                        return r.execCmd(t.cmd, t.param, t.forceCss);
                    case "openModal":
                        return r.openModal(t.title, t.content);
                    case "closeModal":
                        return r.closeModal();
                    case "openModalInsert":
                        return r.openModalInsert(t.title, t.fields, t.callback);
                    case "saveRange":
                        return r.saveRange();
                    case "getRange":
                        return r.range;
                    case "getRangeText":
                        return r.getRangeText();
                    case "restoreRange":
                        return r.restoreRange();
                    case "enable":
                        return r.toggleDisable(!1);
                    case "disable":
                        return r.toggleDisable(!0);
                    case "destroy":
                        return r.destroy();
                    case "empty":
                        return r.empty();
                    case "html":
                        return r.html(t)
                }
            } catch (i) {}
            return !1
        };
        var o = function(e, o) {
            var r = this,
                i = "trumbowyg-icons";
            r.doc = e.ownerDocument || n, r.$ta = a(e), r.$c = a(e), o = o || {}, null != o.lang || null != a.trumbowyg.langs[o.lang] ? r.lang = a.extend(!0, {}, a.trumbowyg.langs.en, a.trumbowyg.langs[o.lang]) : r.lang = a.trumbowyg.langs.en;
            var s = null != a.trumbowyg.svgPath ? a.trumbowyg.svgPath : o.svgPath;
            if (r.hasSvg = s !== !1, r.svgPath = r.doc.querySelector("base") ? t.location : "", 0 === a("#" + i, r.doc).length && s !== !1) {
                if (null == s) try {
                    throw new Error
                } catch (l) {
                    var d = l.stack.split("\n");
                    for (var c in d)
                        if (d[c].match(/http[s]?:\/\//)) {
                            s = d[Number(c)].match(/((http[s]?:\/\/.+\/)([^\/]+\.js)):/)[1].split("/"), s.pop(), s = s.join("/") + "/icons.svg";
                            break
                        }
                }
                var u = r.doc.createElement("div");
                u.id = i, r.doc.body.insertBefore(u, r.doc.body.childNodes[0]), a.get(s, function(e) {
                    u.innerHTML = (new XMLSerializer).serializeToString(e.documentElement)
                })
            }
            var g = r.lang.header,
                f = function() {
                    return (t.chrome || t.Intl && Intl.v8BreakIterator) && "CSS" in t
                };
            r.btnsDef = {
                viewHTML: {
                    fn: "toggle"
                },
                undo: {
                    isSupported: f,
                    key: "Z"
                },
                redo: {
                    isSupported: f,
                    key: "Y"
                },
                p: {
                    fn: "formatBlock"
                },
                h2: {
                    fn: "formatBlock",
                    title: "Heading"
                },
                subscript: {
                    tag: "sub"
                },
                superscript: {
                    tag: "sup"
                },
                bold: {
                    key: "B"
                },
                italic: {
                    key: "I"
                },
                underline: {
                    tag: "u"
                },
                strikethrough: {
                    tag: "strike"
                },
                strong: {
                    fn: "bold",
                    key: "B"
                },
                em: {
                    fn: "italic",
                    key: "I"
                },
                del: {
                    fn: "strikethrough"
                },
                createLink: {
                    key: "K",
                    tag: "a"
                },
                unlink: {},
                insertImage: {},
                justifyLeft: {
                    tag: "left",
                    forceCss: !0
                },
                justifyCenter: {
                    tag: "center",
                    forceCss: !0
                },
                justifyRight: {
                    tag: "right",
                    forceCss: !0
                },
                justifyFull: {
                    tag: "justify",
                    forceCss: !0
                },
                unorderedList: {
                    fn: "insertUnorderedList",
                    tag: "ul"
                },
                orderedList: {
                    fn: "insertOrderedList",
                    tag: "ol"
                },
                horizontalRule: {
                    fn: "insertHorizontalRule"
                },
                removeformat: {},
                fullscreen: {
                    "class": "trumbowyg-not-disable"
                },
                close: {
                    fn: "destroy",
                    "class": "trumbowyg-not-disable"
                },
                formatting: {
                    dropdown: ["p", "blockquote", "h1", "h2", "h3", "h4"],
                    ico: "p"
                },
                link: {
                    dropdown: ["createLink", "unlink"]
                }
            }, r.o = a.extend(!0, {}, {
                lang: "en",
                fixedBtnPane: !1,
                fixedFullWidth: !1,
                autogrow: !1,
                prefix: "trumbowyg-",
                semantic: !0,
                resetCss: !1,
                removeformatPasted: !1,
                tagsToRemove: [],
                btnsGrps: {
                    design: ["bold", "italic", "underline", "strikethrough"],
                    semantic: ["strong", "em", "del"],
                    justify: ["justifyLeft", "justifyCenter", "justifyRight", "justifyFull"],
                    lists: ["unorderedList", "orderedList"]
                },
                btns: [
                    ["viewHTML"],
                    ["undo", "redo"],
                    ["formatting"], "btnGrp-semantic", ["superscript", "subscript"],
                    ["link"],
                    ["insertImage"], "btnGrp-justify", "btnGrp-lists", ["horizontalRule"],
                    ["removeformat"],
                    ["fullscreen"]
                ],
                btnsDef: {},
                inlineElementsSelector: "a,abbr,acronym,b,caption,cite,code,col,dfn,dir,dt,dd,em,font,hr,i,kbd,li,q,span,strikeout,strong,sub,sup,u",
                pasteHandlers: [],
                imgDblClickHandler: function() {
                    var e = a(this),
                        t = e.attr("src"),
                        n = "(Base64)";
                    return 0 === t.indexOf("data:image") && (t = n), r.openModalInsert(r.lang.insertImage, {
                        url: {
                            label: "URL",
                            value: t,
                            required: !0
                        },
                        alt: {
                            label: r.lang.description,
                            value: e.attr("alt")
                        }
                    }, function(t) {
                        return t.src !== n && e.attr({
                            src: t.src
                        }), e.attr({
                            alt: t.alt
                        }), !0
                    }), !1
                },
                plugins: {}
            }, o), r.disabled = r.o.disabled || "TEXTAREA" === e.nodeName && e.disabled, o.btns ? r.o.btns = o.btns : r.o.semantic || (r.o.btns[4] = "btnGrp-design"), a.each(r.o.btnsDef, function(e, t) {
                r.addBtnDef(e, t)
            }), r.keys = [], r.tagToButton = {}, r.tagHandlers = [], r.pasteHandlers = [].concat(r.o.pasteHandlers), r.init()
        };
        o.prototype = {
            init: function() {
                var e = this;
                e.height = e.$ta.height(), e.initPlugins(), e.doc.execCommand("enableObjectResizing", !1, !1), e.doc.execCommand("defaultParagraphSeparator", !1, "p"), e.buildEditor(), e.buildBtnPane(), e.fixedBtnPaneEvents(), e.buildOverlay(), setTimeout(function() {
                    e.disabled && e.toggleDisable(!0), e.$c.trigger("tbwinit")
                })
            },
            addBtnDef: function(e, t) {
                this.btnsDef[e] = t
            },
            buildEditor: function() {
                var e = this,
                    n = e.o.prefix,
                    o = "";
                e.$box = a("<div/>", {
                    "class": n + "box " + n + "editor-visible " + n + e.o.lang + " trumbowyg"
                }), e.isTextarea = e.$ta.is("textarea"), e.isTextarea ? (o = e.$ta.val(), e.$ed = a("<div/>"), e.$box.insertAfter(e.$ta).append(e.$ed, e.$ta)) : (e.$ed = e.$ta, o = e.$ed.html(), e.$ta = a("<textarea/>", {
                    name: e.$ta.attr("id"),
                    height: e.height
                }).val(o), e.$box.insertAfter(e.$ed).append(e.$ta, e.$ed), e.syncCode()), e.$ta.addClass(n + "textarea").attr("tabindex", -1), e.$ed.addClass(n + "editor").attr({
                    contenteditable: !0,
                    dir: e.lang._dir || "ltr"
                }).html(o), e.o.tabindex && e.$ed.attr("tabindex", e.o.tabindex), e.$c.is("[placeholder]") && e.$ed.attr("placeholder", e.$c.attr("placeholder")), e.o.resetCss && e.$ed.addClass(n + "reset-css"), e.o.autogrow || e.$ta.add(e.$ed).css({
                    height: e.height
                }), e.semanticCode(), e._ctrl = !1, e.$ed.on("dblclick", "img", e.o.imgDblClickHandler).on("keydown", function(t) {
                    if (e._composition = 229 === t.which, t.ctrlKey) {
                        e._ctrl = !0;
                        var n = e.keys[String.fromCharCode(t.which).toUpperCase()];
                        try {
                            return e.execCmd(n.fn, n.param), !1
                        } catch (a) {}
                    }
                }).on("keyup", function(t) {
                    t.which >= 37 && t.which <= 40 || (!t.ctrlKey || 89 !== t.which && 90 !== t.which ? e._ctrl || 17 === t.which || e._composition || (e.semanticCode(!1, 13 === t.which), e.$c.trigger("tbwchange")) : e.$c.trigger("tbwchange"), setTimeout(function() {
                        e._ctrl = !1
                    }, 200))
                }).on("mouseup keydown keyup", function() {
                    e.updateButtonPaneStatus()
                }).on("focus blur", function(t) {
                    e.$c.trigger("tbw" + t.type), "blur" === t.type && a("." + n + "active-button", e.$btnPane).removeClass(n + "active-button " + n + "active")
                }).on("cut", function() {
                    e.$c.trigger("tbwchange")
                }).on("paste", function(n) {
                    if (e.o.removeformatPasted) {
                        n.preventDefault();
                        try {
                            var o = t.clipboardData.getData("Text");
                            try {
                                e.doc.selection.createRange().pasteHTML(o)
                            } catch (r) {
                                e.doc.getSelection().getRangeAt(0).insertNode(e.doc.createTextNode(o))
                            }
                        } catch (i) {
                            e.execCmd("insertText", (n.originalEvent || n).clipboardData.getData("text/plain"))
                        }
                    }
                    a.each(e.pasteHandlers, function(e, t) {
                        t(n)
                    }), setTimeout(function() {
                        e.o.semantic ? e.semanticCode(!1, !0) : e.syncCode(), e.$c.trigger("tbwpaste", n)
                    }, 0)
                }), e.$ta.on("keyup paste", function() {
                    e.$c.trigger("tbwchange")
                }), a(e.doc).on("keydown", function(t) {
                    return 27 === t.which ? (e.closeModal(), !1) : void 0
                })
            },
            buildBtnPane: function() {
                var e = this,
                    t = e.o.prefix,
                    n = e.$btnPane = a("<div/>", {
                        "class": t + "button-pane"
                    });
                a.each(e.o.btns, function(o, r) {
                    try {
                        var i = r.split("btnGrp-");
                        null != i[1] && (r = e.o.btnsGrps[i[1]])
                    } catch (s) {}
                    a.isArray(r) || (r = [r]);
                    var l = a("<div/>", {
                        "class": t + "button-group " + (r.indexOf("fullscreen") >= 0 ? t + "right" : "")
                    });
                    a.each(r, function(t, n) {
                        try {
                            var a;
                            e.isSupportedBtn(n) && (a = e.buildBtn(n)), l.append(a)
                        } catch (o) {}
                    }), n.append(l)
                }), e.$box.prepend(n)
            },
            buildBtn: function(e) {
                var t = this,
                    n = t.o.prefix,
                    o = t.btnsDef[e],
                    r = o.dropdown,
                    i = t.lang[e] || e,
                    s = a("<button/>", {
                        type: "button",
                        "class": n + e + "-button " + (o["class"] || ""),
                        html: t.hasSvg ? '<svg><use xlink:href="' + t.svgPath + "#" + n + (o.ico || e).replace(/([A-Z]+)/g, "-$1").toLowerCase() + '"/></svg>' : "",
                        title: (o.title || o.text || i) + (o.key ? " (Ctrl + " + o.key + ")" : ""),
                        tabindex: -1,
                        mousedown: function() {
                            return (!r || a("." + e + "-" + n + "dropdown", t.$box).is(":hidden")) && a("body", t.doc).trigger("mousedown"), !t.$btnPane.hasClass(n + "disable") || a(this).hasClass(n + "active") || a(this).hasClass(n + "not-disable") ? (t.execCmd((r ? "dropdown" : !1) || o.fn || e, o.param || e, o.forceCss || !1), !1) : !1
                        }
                    });
                if (r) {
                    s.addClass(n + "open-dropdown");
                    var l = n + "dropdown",
                        d = a("<div/>", {
                            "class": l + "-" + e + " " + l + " " + n + "fixed-top",
                            "data-dropdown": e
                        });
                    a.each(r, function(e, n) {
                        t.btnsDef[n] && t.isSupportedBtn(n) && d.append(t.buildSubBtn(n))
                    }), t.$box.append(d.hide())
                } else o.key && (t.keys[o.key] = {
                    fn: o.fn || e,
                    param: o.param || e
                });
                return r || (t.tagToButton[(o.tag || e).toLowerCase()] = e), s
            },
            buildSubBtn: function(e) {
                var t = this,
                    n = t.o.prefix,
                    o = t.btnsDef[e];
                return o.key && (t.keys[o.key] = {
                    fn: o.fn || e,
                    param: o.param || e
                }), t.tagToButton[(o.tag || e).toLowerCase()] = e, a("<button/>", {
                    type: "button",
                    "class": n + e + "-dropdown-button" + (o.ico ? " " + n + o.ico + "-button" : ""),
                    html: t.hasSvg ? '<svg><use xlink:href="' + t.svgPath + "#" + n + (o.ico || e).replace(/([A-Z]+)/g, "-$1").toLowerCase() + '"/></svg>' + (o.text || o.title || t.lang[e] || e) : "",
                    title: o.key ? " (Ctrl + " + o.key + ")" : null,
                    style: o.style || null,
                    mousedown: function() {
                        return a("body", t.doc).trigger("mousedown"), t.execCmd(o.fn || e, o.param || e, o.forceCss || !1), !1
                    }
                })
            },
            isSupportedBtn: function(e) {
                try {
                    return this.btnsDef[e].isSupported()
                } catch (t) {}
                return !0
            },
            buildOverlay: function() {
                var e = this;
                return e.$overlay = a("<div/>", {
                    "class": e.o.prefix + "overlay"
                }).css({
                    top: e.$btnPane.outerHeight(),
                    height: e.$ed.outerHeight() + 1 + "px"
                }).appendTo(e.$box), e.$overlay
            },
            showOverlay: function() {
                var e = this;
                a(t).trigger("scroll"), e.$overlay.fadeIn(200), e.$box.addClass(e.o.prefix + "box-blur")
            },
            hideOverlay: function() {
                var e = this;
                e.$overlay.fadeOut(50), e.$box.removeClass(e.o.prefix + "box-blur")
            },
            fixedBtnPaneEvents: function() {
                var e = this,
                    n = e.o.fixedFullWidth,
                    o = e.$box;
                e.o.fixedBtnPane && (e.isFixed = !1, a(t).on("scroll resize", function() {
                    if (o) {
                        e.syncCode();
                        var r = a(t).scrollTop(),
                            i = o.offset().top + 1,
                            s = e.$btnPane,
                            l = s.outerHeight() - 2;
                        r - i > 0 && r - i - e.height < 0 ? (e.isFixed || (e.isFixed = !0, s.css({
                            position: "fixed",
                            top: 0,
                            left: n ? "0" : "auto",
                            zIndex: 7
                        }), a([e.$ta, e.$ed]).css({
                            marginTop: s.height()
                        })), s.css({
                            width: n ? "100%" : o.width() - 1 + "px"
                        }), a("." + e.o.prefix + "fixed-top", o).css({
                            position: n ? "fixed" : "absolute",
                            top: n ? l : l + (r - i) + "px",
                            zIndex: 15
                        })) : e.isFixed && (e.isFixed = !1, s.removeAttr("style"), a([e.$ta, e.$ed]).css({
                            marginTop: 0
                        }), a("." + e.o.prefix + "fixed-top", o).css({
                            position: "absolute",
                            top: l
                        }))
                    }
                }))
            },
            toggleDisable: function(e) {
                var t = this,
                    n = t.o.prefix;
                t.disabled = e, e ? t.$ta.attr("disabled", !0) : t.$ta.removeAttr("disabled"), t.$box.toggleClass(n + "disabled", e), t.$ed.attr("contenteditable", !e)
            },
            destroy: function() {
                var e = this,
                    t = e.o.prefix,
                    n = e.height;
                e.isTextarea ? e.$box.after(e.$ta.css({
                    height: n
                }).val(e.html()).removeClass(t + "textarea").show()) : e.$box.after(e.$ed.css({
                    height: n
                }).removeClass(t + "editor").removeAttr("contenteditable").html(e.html()).show()), e.$ed.off("dblclick", "img"), e.destroyPlugins(), e.$box.remove(), e.$c.removeData("trumbowyg"), a("body").removeClass(t + "body-fullscreen")
            },
            empty: function() {
                this.$ta.val(""), this.syncCode(!0)
            },
            toggle: function() {
                var e = this,
                    t = e.o.prefix;
                e.semanticCode(!1, !0), setTimeout(function() {
                    e.doc.activeElement.blur(), e.$box.toggleClass(t + "editor-hidden " + t + "editor-visible"), e.$btnPane.toggleClass(t + "disable"), a("." + t + "viewHTML-button", e.$btnPane).toggleClass(t + "active"), e.$box.hasClass(t + "editor-visible") ? e.$ta.attr("tabindex", -1) : e.$ta.removeAttr("tabindex")
                }, 0)
            },
            dropdown: function(e) {
                var n = this,
                    o = n.doc,
                    r = n.o.prefix,
                    i = a("[data-dropdown=" + e + "]", n.$box),
                    s = a("." + r + e + "-button", n.$btnPane),
                    l = i.is(":hidden");
                if (a("body", o).trigger("mousedown"), l) {
                    var d = s.offset().left;
                    s.addClass(r + "active"), i.css({
                        position: "absolute",
                        top: s.offset().top - n.$btnPane.offset().top + s.outerHeight(),
                        left: n.o.fixedFullWidth && n.isFixed ? d + "px" : d - n.$btnPane.offset().left + "px"
                    }).show(), a(t).trigger("scroll"), a("body", o).on("mousedown", function() {
                        a("." + r + "dropdown", o).hide(), a("." + r + "active", o).removeClass(r + "active"), a("body", o).off("mousedown")
                    })
                }
            },
            html: function(e) {
                var t = this;
                return null != e ? (t.$ta.val(e), t.syncCode(!0), t) : t.$ta.val()
            },
            syncTextarea: function() {
                var e = this;
                e.$ta.val(e.$ed.text().trim().length > 0 || e.$ed.find("hr,img,embed,input").length > 0 ? e.$ed.html() : "")
            },
            syncCode: function(e) {
                var t = this;
                !e && t.$ed.is(":visible") ? t.syncTextarea() : t.$ed.html(t.$ta.val()), t.o.autogrow && (t.height = t.$ed.height(), t.height !== t.$ta.css("height") && (t.$ta.css({
                    height: t.height
                }), t.$c.trigger("tbwresize")))
            },
            semanticCode: function(e, t) {
                var n = this;
                if (n.saveRange(), n.syncCode(e), a(n.o.tagsToRemove.join(","), n.$ed).remove(), n.o.semantic) {
                    if (n.semanticTag("b", "strong"), n.semanticTag("i", "em"), n.semanticTag("strike", "del"), t) {
                        var o = n.o.inlineElementsSelector,
                            r = ":not(" + o + ")";
                        n.$ed.contents().filter(function() {
                            return 3 === this.nodeType && this.nodeValue.trim().length > 0
                        }).wrap("<span data-tbw/>");
                        var i = function(e) {
                            if (0 !== e.length) {
                                var t = e.nextUntil(r).andSelf().wrapAll("<p/>").parent(),
                                    n = t.nextAll(o).first();
                                t.next("br").remove(), i(n)
                            }
                        };
                        i(n.$ed.children(o).first()), n.semanticTag("div", "p", !0), n.$ed.find("p").filter(function() {
                            return n.range && this === n.range.startContainer ? !1 : 0 === a(this).text().trim().length && 0 === a(this).children().not("br,span").length
                        }).contents().unwrap(), a("[data-tbw]", n.$ed).contents().unwrap(), n.$ed.find("p:empty").remove()
                    }
                    n.restoreRange(), n.syncTextarea()
                }
            },
            semanticTag: function(e, t, n) {
                a(e, this.$ed).each(function() {
                    var e = a(this);
                    e.wrap("<" + t + "/>"), n && a.each(e.prop("attributes"), function() {
                        e.parent().attr(this.name, this.value)
                    }), e.contents().unwrap()
                })
            },
            createLink: function() {
                for (var e, t, n, o = this, r = o.doc.getSelection(), i = r.focusNode;
                    ["A", "DIV"].indexOf(i.nodeName) < 0;) i = i.parentNode;
                if (i && "A" === i.nodeName) {
                    var s = a(i);
                    e = s.attr("href"), t = s.attr("title"), n = s.attr("target");
                    var l = o.doc.createRange();
                    l.selectNode(i), r.addRange(l)
                }
                o.saveRange(), o.openModalInsert(o.lang.createLink, {
                    url: {
                        label: "URL",
                        required: !0,
                        value: e
                    },
                    /*title: {
                        label: o.lang.title,
                        value: t
                    },*/
                    text: {
                        label: o.lang.text,
                        value: o.getRangeText()
                    },
                    /*target: {
                        label: o.lang.target,
                        value: n
                    }*/
                }, function(e) {
                    var t = a(['<a href="', e.url, '">', e.text, "</a>"].join(""));
                    e.title=""; e.target="";
                    return e.title.length > 0 && t.attr("title", e.title), e.target.length > 0 && t.attr("target", e.target), o.range.deleteContents(), o.range.insertNode(t[0]), !0
                })
            },
            unlink: function() {
                var e = this,
                    t = e.doc.getSelection(),
                    n = t.focusNode;
                if (t.isCollapsed) {
                    for (;
                        ["A", "DIV"].indexOf(n.nodeName) < 0;) n = n.parentNode;
                    if (n && "A" === n.nodeName) {
                        var a = e.doc.createRange();
                        a.selectNode(n), t.addRange(a)
                    }
                }
                e.execCmd("unlink", void 0, void 0, !0)
            },
            insertImage: function() {
                var e = this;
                e.saveRange(), e.openModalInsert(e.lang.insertImage, {
                    url: {
                        label: "URL",
                        required: !0
                    },
                    alt: {
                        label: e.lang.description,
                        value: e.getRangeText()
                    }
                }, function(t) {
                    return e.execCmd("insertImage", t.url), a('img[src="' + t.url + '"]:not([alt])', e.$box).attr("alt", t.alt), !0
                })
            },
            fullscreen: function() {
                var e, n = this,
                    o = n.o.prefix,
                    r = o + "fullscreen";
                n.$box.toggleClass(r), e = n.$box.hasClass(r), a("body").toggleClass(o + "body-fullscreen", e), a(t).trigger("scroll"), n.$c.trigger("tbw" + (e ? "open" : "close") + "fullscreen")
            },
            execCmd: function(t, n, a, o) {
                var r = this;
                o = !!o || "", "dropdown" !== t && r.$ed.focus(), r.doc.execCommand("styleWithCSS", !1, a || !1);
                try {
                    r[t + o](n)
                } catch (i) {
                    try {
                        t(n)
                    } catch (s) {
                        "insertHorizontalRule" === t ? n = void 0 : "formatBlock" !== t || -1 === e.userAgent.indexOf("MSIE") && -1 === e.appVersion.indexOf("Trident/") || (n = "<" + n + ">"), r.doc.execCommand(t, !1, n), r.syncCode(), r.semanticCode(!1, !0)
                    }
                    "dropdown" !== t && (r.updateButtonPaneStatus(), r.$c.trigger("tbwchange"))
                }
            },
            openModal: function(e, n) {
                var o = this,
                    r = o.o.prefix;
                if (a("." + r + "modal-box", o.$box).length > 0) return !1;
                o.saveRange(), o.showOverlay(), o.$btnPane.addClass(r + "disable");
                var i = a("<div/>", {
                    "class": r + "modal " + r + "fixed-top"
                }).css({
                    top: o.$btnPane.height()
                }).appendTo(o.$box);
                o.$overlay.one("click", function() {
                    return i.trigger("tbwcancel"), !1
                });
                var s = a("<form/>", {
                        action: "",
                        html: n
                    }).on("submit", function() {
                        return i.trigger("tbwconfirm"), !1
                    }).on("reset", function() {
                        return i.trigger("tbwcancel"), !1
                    }),
                    l = a("<div/>", {
                        "class": r + "modal-box",
                        html: s
                    }).css({
                        top: "-" + o.$btnPane.outerHeight() + "px",
                        opacity: 0
                    }).appendTo(i).animate({
                        top: 0,
                        opacity: 1
                    }, 100);
                return a("<span/>", {
                    text: e,
                    "class": r + "modal-title"
                }).prependTo(l), i.height(l.outerHeight() + 10), a("input:first", l).focus(), o.buildModalBtn("submit", l), o.buildModalBtn("reset", l), a(t).trigger("scroll"), i
            },
            buildModalBtn: function(e, t) {
                var n = this,
                    o = n.o.prefix;
                return a("<button/>", {
                    "class": o + "modal-button " + o + "modal-" + e,
                    type: e,
                    text: n.lang[e] || e
                }).appendTo(a("form", t))
            },
            closeModal: function() {
                var e = this,
                    t = e.o.prefix;
                e.$btnPane.removeClass(t + "disable"), e.$overlay.off();
                var n = a("." + t + "modal-box", e.$box);
                n.animate({
                    top: "-" + n.height()
                }, 100, function() {
                    n.parent().remove(), e.hideOverlay()
                }), e.restoreRange()
            },
            openModalInsert: function(e, t, n) {
                var o = this,
                    r = o.o.prefix,
                    i = o.lang,
                    s = "",
                    l = "tbwconfirm";
                return a.each(t, function(e, t) {
                    var n = t.label,
                        a = t.name || e;
                    //s += '<label><input type="' + (t.type || "text") + '" name="' + a + '" value="' + (t.value || "").replace(/"/g, "&quot;") + '"><span class="' + r + 'input-infos"><span>' + (n ? i[n] ? i[n] : n : i[e] ? i[e] : e) + "</span></span></label>"
                    s += '<div class="form-item"><label>'+ (n ? i[n] ? i[n] : n : i[e] ? i[e] : e) +'</label><input class="text" type="' + (t.type || "text") + '" name="' + a + '" value="' + (t.value || "").replace(/"/g, "&quot;") + '"></div>';
                }), o.openModal(e, s).on(l, function() {
                    var e = a("form", a(this)),
                        r = !0,
                        i = {};
                    a.each(t, function(t, n) {
                        var s = a('input[name="' + t + '"]', e);
                        i[t] = a.trim(s.val()), n.required && "" === i[t] ? (r = !1, o.addErrorOnModalField(s, o.lang.required)) : n.pattern && !n.pattern.test(i[t]) && (r = !1, o.addErrorOnModalField(s, n.patternError))
                    }), r && (o.restoreRange(), n(i, t) && (o.syncCode(), o.$c.trigger("tbwchange"), o.closeModal(), a(this).off(l)))
                }).one("tbwcancel", function() {
                    a(this).off(l), o.closeModal()
                })
            },
            addErrorOnModalField: function(e, t) {
                var n = this.o.prefix,
                    o = e.parent();
                e.on("change keyup", function() {
                    o.removeClass(n + "input-error")
                }), o.addClass(n + "input-error").find("input+span").append(a("<span/>", {
                    "class": n + "msg-error",
                    text: t
                }))
            },
            saveRange: function() {
                var e = this,
                    t = e.doc.getSelection();
                if (e.range = null, t.rangeCount) {
                    var n, a = e.range = t.getRangeAt(0),
                        o = e.doc.createRange();
                    o.selectNodeContents(e.$ed[0]), o.setEnd(a.startContainer, a.startOffset), n = (o + "").length, e.metaRange = {
                        start: n,
                        end: n + (a + "").length
                    }
                }
            },
            restoreRange: function() {
                var e, t = this,
                    n = t.metaRange,
                    a = t.range,
                    o = t.doc.getSelection();
                if (a) {
                    if (n && n.start !== n.end) {
                        var r, i = 0,
                            s = [t.$ed[0]],
                            l = !1,
                            d = !1;
                        for (e = t.doc.createRange(); !d && (r = s.pop());)
                            if (3 === r.nodeType) {
                                var c = i + r.length;
                                !l && n.start >= i && n.start <= c && (e.setStart(r, n.start - i), l = !0), l && n.end >= i && n.end <= c && (e.setEnd(r, n.end - i), d = !0), i = c
                            } else
                                for (var u = r.childNodes, g = u.length; g > 0;) g -= 1, s.push(u[g])
                    }
                    o.removeAllRanges(), o.addRange(e || a)
                }
            },
            getRangeText: function() {
                return this.range + ""
            },
            updateButtonPaneStatus: function() {
                var e = this,
                    t = e.o.prefix,
                    n = e.getTagsRecursive(e.doc.getSelection().focusNode.parentNode),
                    o = t + "active-button " + t + "active";
                a("." + t + "active-button", e.$btnPane).removeClass(o), a.each(n, function(n, r) {
                    var i = e.tagToButton[r.toLowerCase()],
                        s = a("." + t + i + "-button", e.$btnPane);
                    if (s.length > 0) s.addClass(o);
                    else try {
                        s = a("." + t + "dropdown ." + t + i + "-dropdown-button", e.$box);
                        var l = s.parent().data("dropdown");
                        a("." + t + l + "-button", e.$box).addClass(o)
                    } catch (d) {}
                })
            },
            getTagsRecursive: function(e, t) {
                var n = this;
                t = t || [];
                var o = e.tagName;
                return "DIV" === o ? t : ("P" === o && "" !== e.style.textAlign && t.push(e.style.textAlign), a.each(n.tagHandlers, function(a, o) {
                    t = t.concat(o(e, n))
                }), t.push(o), n.getTagsRecursive(e.parentNode, t))
            },
            initPlugins: function() {
                var e = this;
                e.loadedPlugins = [], a.each(a.trumbowyg.plugins, function(t, n) {
                    (!n.shouldInit || n.shouldInit(e)) && (n.init(e), n.tagHandler && e.tagHandlers.push(n.tagHandler), e.loadedPlugins.push(n))
                })
            },
            destroyPlugins: function() {
                a.each(this.loadedPlugins, function(e, t) {
                    t.destroy && t.destroy()
                })
            }
        }
    }(navigator, window, document, jQuery);