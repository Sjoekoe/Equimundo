(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(["jquery"], function ($) {
            return (root.returnExportsGlobal = factory($));
        });
    } else if (typeof exports === 'object') {
        // Node. Does not work with strict CommonJS, but
        // only CommonJS-like enviroments that support module.exports,
        // like Node.
        module.exports = factory(require("jquery"));
    } else {
        factory(jQuery);
    }
}(this, function ($) {

//@ sourceMappingURL=jquery.caret.map
    /*
     Implement Github like autocomplete mentions
     http://ichord.github.com/At.js

     Copyright (c) 2013 chord.luo@gmail.com
     Licensed under the MIT license.
     */

    /*
     本插件操作 textarea 或者 input 内的插入符
     只实现了获得插入符在文本框中的位置，我设置
     插入符的位置.
     */

    "use strict";
    var EditableCaret, InputCaret, Mirror, Utils, discoveryIframeOf, methods, oDocument, oFrame, oWindow, pluginName, setContextBy;

    pluginName = 'caret';

    EditableCaret = (function() {
        function EditableCaret($inputor) {
            this.$inputor = $inputor;
            this.domInputor = this.$inputor[0];
        }

        EditableCaret.prototype.setPos = function(pos) {
            var fn, found, offset, sel;
            if (sel = oWindow.getSelection()) {
                offset = 0;
                found = false;
                (fn = function(pos, parent) {
                    var node, range, _i, _len, _ref, _results;
                    _ref = parent.childNodes;
                    _results = [];
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i];
                        if (found) {
                            break;
                        }
                        if (node.nodeType === 3) {
                            if (offset + node.length >= pos) {
                                found = true;
                                range = oDocument.createRange();
                                range.setStart(node, pos - offset);
                                sel.removeAllRanges();
                                sel.addRange(range);
                                break;
                            } else {
                                _results.push(offset += node.length);
                            }
                        } else {
                            _results.push(fn(pos, node));
                        }
                    }
                    return _results;
                })(pos, this.domInputor);
            }
            return this.domInputor;
        };

        EditableCaret.prototype.getIEPosition = function() {
            return this.getPosition();
        };

        EditableCaret.prototype.getPosition = function() {
            var inputor_offset, offset;
            offset = this.getOffset();
            inputor_offset = this.$inputor.offset();
            offset.left -= inputor_offset.left;
            offset.top -= inputor_offset.top;
            return offset;
        };

        EditableCaret.prototype.getOldIEPos = function() {
            var preCaretTextRange, textRange;
            textRange = oDocument.selection.createRange();
            preCaretTextRange = oDocument.body.createTextRange();
            preCaretTextRange.moveToElementText(this.domInputor);
            preCaretTextRange.setEndPoint("EndToEnd", textRange);
            return preCaretTextRange.text.length;
        };

        EditableCaret.prototype.getPos = function() {
            var clonedRange, pos, range;
            if (range = this.range()) {
                clonedRange = range.cloneRange();
                clonedRange.selectNodeContents(this.domInputor);
                clonedRange.setEnd(range.endContainer, range.endOffset);
                pos = clonedRange.toString().length;
                clonedRange.detach();
                return pos;
            } else if (oDocument.selection) {
                return this.getOldIEPos();
            }
        };

        EditableCaret.prototype.getOldIEOffset = function() {
            var range, rect;
            range = oDocument.selection.createRange().duplicate();
            range.moveStart("character", -1);
            rect = range.getBoundingClientRect();
            return {
                height: rect.bottom - rect.top,
                left: rect.left,
                top: rect.top
            };
        };

        EditableCaret.prototype.getOffset = function(pos) {
            var clonedRange, offset, range, rect, shadowCaret;
            if (oWindow.getSelection && (range = this.range())) {
                if (range.endOffset - 1 > 0 && range.endContainer !== this.domInputor) {
                    clonedRange = range.cloneRange();
                    clonedRange.setStart(range.endContainer, range.endOffset - 1);
                    clonedRange.setEnd(range.endContainer, range.endOffset);
                    rect = clonedRange.getBoundingClientRect();
                    offset = {
                        height: rect.height,
                        left: rect.left + rect.width,
                        top: rect.top
                    };
                    clonedRange.detach();
                }
                if (!offset || (offset != null ? offset.height : void 0) === 0) {
                    clonedRange = range.cloneRange();
                    shadowCaret = $(oDocument.createTextNode("|"));
                    clonedRange.insertNode(shadowCaret[0]);
                    clonedRange.selectNode(shadowCaret[0]);
                    rect = clonedRange.getBoundingClientRect();
                    offset = {
                        height: rect.height,
                        left: rect.left,
                        top: rect.top
                    };
                    shadowCaret.remove();
                    clonedRange.detach();
                }
            } else if (oDocument.selection) {
                offset = this.getOldIEOffset();
            }
            if (offset) {
                offset.top += $(oWindow).scrollTop();
                offset.left += $(oWindow).scrollLeft();
            }
            return offset;
        };

        EditableCaret.prototype.range = function() {
            var sel;
            if (!oWindow.getSelection) {
                return;
            }
            sel = oWindow.getSelection();
            if (sel.rangeCount > 0) {
                return sel.getRangeAt(0);
            } else {
                return null;
            }
        };

        return EditableCaret;

    })();

    InputCaret = (function() {
        function InputCaret($inputor) {
            this.$inputor = $inputor;
            this.domInputor = this.$inputor[0];
        }

        InputCaret.prototype.getIEPos = function() {
            var endRange, inputor, len, normalizedValue, pos, range, textInputRange;
            inputor = this.domInputor;
            range = oDocument.selection.createRange();
            pos = 0;
            if (range && range.parentElement() === inputor) {
                normalizedValue = inputor.value.replace(/\r\n/g, "\n");
                len = normalizedValue.length;
                textInputRange = inputor.createTextRange();
                textInputRange.moveToBookmark(range.getBookmark());
                endRange = inputor.createTextRange();
                endRange.collapse(false);
                if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1) {
                    pos = len;
                } else {
                    pos = -textInputRange.moveStart("character", -len);
                }
            }
            return pos;
        };

        InputCaret.prototype.getPos = function() {
            if (oDocument.selection) {
                return this.getIEPos();
            } else {
                return this.domInputor.selectionStart;
            }
        };

        InputCaret.prototype.setPos = function(pos) {
            var inputor, range;
            inputor = this.domInputor;
            if (oDocument.selection) {
                range = inputor.createTextRange();
                range.move("character", pos);
                range.select();
            } else if (inputor.setSelectionRange) {
                inputor.setSelectionRange(pos, pos);
            }
            return inputor;
        };

        InputCaret.prototype.getIEOffset = function(pos) {
            var h, textRange, x, y;
            textRange = this.domInputor.createTextRange();
            pos || (pos = this.getPos());
            textRange.move('character', pos);
            x = textRange.boundingLeft;
            y = textRange.boundingTop;
            h = textRange.boundingHeight;
            return {
                left: x,
                top: y,
                height: h
            };
        };

        InputCaret.prototype.getOffset = function(pos) {
            var $inputor, offset, position;
            $inputor = this.$inputor;
            if (oDocument.selection) {
                offset = this.getIEOffset(pos);
                offset.top += $(oWindow).scrollTop() + $inputor.scrollTop();
                offset.left += $(oWindow).scrollLeft() + $inputor.scrollLeft();
                return offset;
            } else {
                offset = $inputor.offset();
                position = this.getPosition(pos);
                return offset = {
                    left: offset.left + position.left - $inputor.scrollLeft(),
                    top: offset.top + position.top - $inputor.scrollTop(),
                    height: position.height
                };
            }
        };

        InputCaret.prototype.getPosition = function(pos) {
            var $inputor, at_rect, end_range, format, html, mirror, start_range;
            $inputor = this.$inputor;
            format = function(value) {
                value = value.replace(/<|>|`|"|&/g, '?').replace(/\r\n|\r|\n/g, "<br/>");
                if (/firefox/i.test(navigator.userAgent)) {
                    value = value.replace(/\s/g, '&nbsp;');
                }
                return value;
            };
            if (pos === void 0) {
                pos = this.getPos();
            }
            start_range = $inputor.val().slice(0, pos);
            end_range = $inputor.val().slice(pos);
            html = "<span style='position: relative; display: inline;'>" + format(start_range) + "</span>";
            html += "<span id='caret' style='position: relative; display: inline;'>|</span>";
            html += "<span style='position: relative; display: inline;'>" + format(end_range) + "</span>";
            mirror = new Mirror($inputor);
            return at_rect = mirror.create(html).rect();
        };

        InputCaret.prototype.getIEPosition = function(pos) {
            var h, inputorOffset, offset, x, y;
            offset = this.getIEOffset(pos);
            inputorOffset = this.$inputor.offset();
            x = offset.left - inputorOffset.left;
            y = offset.top - inputorOffset.top;
            h = offset.height;
            return {
                left: x,
                top: y,
                height: h
            };
        };

        return InputCaret;

    })();

    Mirror = (function() {
        Mirror.prototype.css_attr = ["borderBottomWidth", "borderLeftWidth", "borderRightWidth", "borderTopStyle", "borderRightStyle", "borderBottomStyle", "borderLeftStyle", "borderTopWidth", "boxSizing", "fontFamily", "fontSize", "fontWeight", "height", "letterSpacing", "lineHeight", "marginBottom", "marginLeft", "marginRight", "marginTop", "outlineWidth", "overflow", "overflowX", "overflowY", "paddingBottom", "paddingLeft", "paddingRight", "paddingTop", "textAlign", "textOverflow", "textTransform", "whiteSpace", "wordBreak", "wordWrap"];

        function Mirror($inputor) {
            this.$inputor = $inputor;
        }

        Mirror.prototype.mirrorCss = function() {
            var css,
                _this = this;
            css = {
                position: 'absolute',
                left: -9999,
                top: 0,
                zIndex: -20000
            };
            if (this.$inputor.prop('tagName') === 'TEXTAREA') {
                this.css_attr.push('width');
            }
            $.each(this.css_attr, function(i, p) {
                return css[p] = _this.$inputor.css(p);
            });
            return css;
        };

        Mirror.prototype.create = function(html) {
            this.$mirror = $('<div></div>');
            this.$mirror.css(this.mirrorCss());
            this.$mirror.html(html);
            this.$inputor.after(this.$mirror);
            return this;
        };

        Mirror.prototype.rect = function() {
            var $flag, pos, rect;
            $flag = this.$mirror.find("#caret");
            pos = $flag.position();
            rect = {
                left: pos.left,
                top: pos.top,
                height: $flag.height()
            };
            this.$mirror.remove();
            return rect;
        };

        return Mirror;

    })();

    Utils = {
        contentEditable: function($inputor) {
            return !!($inputor[0].contentEditable && $inputor[0].contentEditable === 'true');
        }
    };

    methods = {
        pos: function(pos) {
            if (pos || pos === 0) {
                return this.setPos(pos);
            } else {
                return this.getPos();
            }
        },
        position: function(pos) {
            if (oDocument.selection) {
                return this.getIEPosition(pos);
            } else {
                return this.getPosition(pos);
            }
        },
        offset: function(pos) {
            var offset;
            offset = this.getOffset(pos);
            return offset;
        }
    };

    oDocument = null;

    oWindow = null;

    oFrame = null;

    setContextBy = function(settings) {
        var iframe;
        if (iframe = settings != null ? settings.iframe : void 0) {
            oFrame = iframe;
            oWindow = iframe.contentWindow;
            return oDocument = iframe.contentDocument || oWindow.document;
        } else {
            oFrame = void 0;
            oWindow = window;
            return oDocument = document;
        }
    };

    discoveryIframeOf = function($dom) {
        var error;
        oDocument = $dom[0].ownerDocument;
        oWindow = oDocument.defaultView || oDocument.parentWindow;
        try {
            return oFrame = oWindow.frameElement;
        } catch (_error) {
            error = _error;
        }
    };

    $.fn.caret = function(method, value, settings) {
        var caret;
        if (methods[method]) {
            if ($.isPlainObject(value)) {
                setContextBy(value);
                value = void 0;
            } else {
                setContextBy(settings);
            }
            caret = Utils.contentEditable(this) ? new EditableCaret(this) : new InputCaret(this);
            return methods[method].apply(caret, [value]);
        } else {
            return $.error("Method " + method + " does not exist on jQuery.caret");
        }
    };

    $.fn.caret.EditableCaret = EditableCaret;

    $.fn.caret.InputCaret = InputCaret;

    $.fn.caret.Utils = Utils;

    $.fn.caret.apis = methods;


}));

/**
 * at.js - 1.5.0
 * Copyright (c) 2016 chord.luo <chord.luo@gmail.com>;
 * Homepage: http://ichord.github.com/At.js
 * License: MIT
 */
(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module unless amdModuleId is set
        define(["jquery"], function (a0) {
            return (factory(a0));
        });
    } else if (typeof exports === 'object') {
        // Node. Does not work with strict CommonJS, but
        // only CommonJS-like environments that support module.exports,
        // like Node.
        module.exports = factory(require("jquery"));
    } else {
        factory(jQuery);
    }
}(this, function ($) {
    var DEFAULT_CALLBACKS, KEY_CODE;

    KEY_CODE = {
        DOWN: 40,
        UP: 38,
        ESC: 27,
        TAB: 9,
        ENTER: 13,
        CTRL: 17,
        A: 65,
        P: 80,
        N: 78,
        LEFT: 37,
        UP: 38,
        RIGHT: 39,
        DOWN: 40,
        BACKSPACE: 8,
        SPACE: 32
    };

    DEFAULT_CALLBACKS = {
        beforeSave: function(data) {
            return Controller.arrayToDefaultHash(data);
        },
        matcher: function(flag, subtext, should_startWithSpace, acceptSpaceBar) {
            var _a, _y, match, regexp, space;
            flag = flag.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
            if (should_startWithSpace) {
                flag = '(?:^|\\s)' + flag;
            }
            _a = decodeURI("%C3%80");
            _y = decodeURI("%C3%BF");
            space = acceptSpaceBar ? "\ " : "";
            regexp = new RegExp(flag + "([A-Za-z" + _a + "-" + _y + "0-9_" + space + "\'\.\+\-]*)$|" + flag + "([^\\x00-\\xff]*)$", 'gi');
            match = regexp.exec(subtext);
            if (match) {
                return match[2] || match[1];
            } else {
                return null;
            }
        },
        filter: function(query, data, searchKey) {
            var _results, i, item, len;
            _results = [];
            for (i = 0, len = data.length; i < len; i++) {
                item = data[i];
                if (~new String(item[searchKey]).toLowerCase().indexOf(query.toLowerCase())) {
                    _results.push(item);
                }
            }
            return _results;
        },
        remoteFilter: null,
        sorter: function(query, items, searchKey) {
            var _results, i, item, len;
            if (!query) {
                return items;
            }
            _results = [];
            for (i = 0, len = items.length; i < len; i++) {
                item = items[i];
                item.atwho_order = new String(item[searchKey]).toLowerCase().indexOf(query.toLowerCase());
                if (item.atwho_order > -1) {
                    _results.push(item);
                }
            }
            return _results.sort(function(a, b) {
                return a.atwho_order - b.atwho_order;
            });
        },
        tplEval: function(tpl, map) {
            var error, error1, template;
            template = tpl;
            try {
                if (typeof tpl !== 'string') {
                    template = tpl(map);
                }
                return template.replace(/\$\{([^\}]*)\}/g, function(tag, key, pos) {
                    return map[key];
                });
            } catch (error1) {
                error = error1;
                return "";
            }
        },
        highlighter: function(li, query) {
            var regexp;
            if (!query) {
                return li;
            }
            regexp = new RegExp(">\\s*(\\w*?)(" + query.replace("+", "\\+") + ")(\\w*)\\s*<", 'ig');
            return li.replace(regexp, function(str, $1, $2, $3) {
                return '> ' + $1 + '<strong>' + $2 + '</strong>' + $3 + ' <';
            });
        },
        beforeInsert: function(value, $li, e) {
            return value;
        },
        beforeReposition: function(offset) {
            return offset;
        },
        afterMatchFailed: function(at, el) {}
    };

    var App;

    App = (function() {
        function App(inputor) {
            this.currentFlag = null;
            this.controllers = {};
            this.aliasMaps = {};
            this.$inputor = $(inputor);
            this.setupRootElement();
            this.listen();
        }

        App.prototype.createContainer = function(doc) {
            var ref;
            if ((ref = this.$el) != null) {
                ref.remove();
            }
            return $(doc.body).append(this.$el = $("<div class='atwho-container'></div>"));
        };

        App.prototype.setupRootElement = function(iframe, asRoot) {
            var error, error1;
            if (asRoot == null) {
                asRoot = false;
            }
            if (iframe) {
                this.window = iframe.contentWindow;
                this.document = iframe.contentDocument || this.window.document;
                this.iframe = iframe;
            } else {
                this.document = this.$inputor[0].ownerDocument;
                this.window = this.document.defaultView || this.document.parentWindow;
                try {
                    this.iframe = this.window.frameElement;
                } catch (error1) {
                    error = error1;
                    this.iframe = null;
                    if ($.fn.atwho.debug) {
                        throw new Error("iframe auto-discovery is failed.\nPlease use `setIframe` to set the target iframe manually.\n" + error);
                    }
                }
            }
            return this.createContainer((this.iframeAsRoot = asRoot) ? this.document : document);
        };

        App.prototype.controller = function(at) {
            var c, current, currentFlag, ref;
            if (this.aliasMaps[at]) {
                current = this.controllers[this.aliasMaps[at]];
            } else {
                ref = this.controllers;
                for (currentFlag in ref) {
                    c = ref[currentFlag];
                    if (currentFlag === at) {
                        current = c;
                        break;
                    }
                }
            }
            if (current) {
                return current;
            } else {
                return this.controllers[this.currentFlag];
            }
        };

        App.prototype.setContextFor = function(at) {
            this.currentFlag = at;
            return this;
        };

        App.prototype.reg = function(flag, setting) {
            var base, controller;
            controller = (base = this.controllers)[flag] || (base[flag] = this.$inputor.is('[contentEditable]') ? new EditableController(this, flag) : new TextareaController(this, flag));
            if (setting.alias) {
                this.aliasMaps[setting.alias] = flag;
            }
            controller.init(setting);
            return this;
        };

        App.prototype.listen = function() {
            return this.$inputor.on('compositionstart', (function(_this) {
                return function(e) {
                    var ref;
                    if ((ref = _this.controller()) != null) {
                        ref.view.hide();
                    }
                    _this.isComposing = true;
                    return null;
                };
            })(this)).on('compositionend', (function(_this) {
                return function(e) {
                    _this.isComposing = false;
                    return null;
                };
            })(this)).on('keyup.atwhoInner', (function(_this) {
                return function(e) {
                    return _this.onKeyup(e);
                };
            })(this)).on('keydown.atwhoInner', (function(_this) {
                return function(e) {
                    return _this.onKeydown(e);
                };
            })(this)).on('blur.atwhoInner', (function(_this) {
                return function(e) {
                    var c;
                    if (c = _this.controller()) {
                        c.expectedQueryCBId = null;
                        return c.view.hide(e, c.getOpt("displayTimeout"));
                    }
                };
            })(this)).on('click.atwhoInner', (function(_this) {
                return function(e) {
                    return _this.dispatch(e);
                };
            })(this)).on('scroll.atwhoInner', (function(_this) {
                return function() {
                    var lastScrollTop;
                    lastScrollTop = _this.$inputor.scrollTop();
                    return function(e) {
                        var currentScrollTop, ref;
                        currentScrollTop = e.target.scrollTop;
                        if (lastScrollTop !== currentScrollTop) {
                            if ((ref = _this.controller()) != null) {
                                ref.view.hide(e);
                            }
                        }
                        lastScrollTop = currentScrollTop;
                        return true;
                    };
                };
            })(this)());
        };

        App.prototype.shutdown = function() {
            var _, c, ref;
            ref = this.controllers;
            for (_ in ref) {
                c = ref[_];
                c.destroy();
                delete this.controllers[_];
            }
            this.$inputor.off('.atwhoInner');
            return this.$el.remove();
        };

        App.prototype.dispatch = function(e) {
            var _, c, ref, results;
            ref = this.controllers;
            results = [];
            for (_ in ref) {
                c = ref[_];
                results.push(c.lookUp(e));
            }
            return results;
        };

        App.prototype.onKeyup = function(e) {
            var ref;
            switch (e.keyCode) {
                case KEY_CODE.ESC:
                    e.preventDefault();
                    if ((ref = this.controller()) != null) {
                        ref.view.hide();
                    }
                    break;
                case KEY_CODE.DOWN:
                case KEY_CODE.UP:
                case KEY_CODE.CTRL:
                case KEY_CODE.ENTER:
                    $.noop();
                    break;
                case KEY_CODE.P:
                case KEY_CODE.N:
                    if (!e.ctrlKey) {
                        this.dispatch(e);
                    }
                    break;
                default:
                    this.dispatch(e);
            }
        };

        App.prototype.onKeydown = function(e) {
            var ref, view;
            view = (ref = this.controller()) != null ? ref.view : void 0;
            if (!(view && view.visible())) {
                return;
            }
            switch (e.keyCode) {
                case KEY_CODE.ESC:
                    e.preventDefault();
                    view.hide(e);
                    break;
                case KEY_CODE.UP:
                    e.preventDefault();
                    view.prev();
                    break;
                case KEY_CODE.DOWN:
                    e.preventDefault();
                    view.next();
                    break;
                case KEY_CODE.P:
                    if (!e.ctrlKey) {
                        return;
                    }
                    e.preventDefault();
                    view.prev();
                    break;
                case KEY_CODE.N:
                    if (!e.ctrlKey) {
                        return;
                    }
                    e.preventDefault();
                    view.next();
                    break;
                case KEY_CODE.TAB:
                case KEY_CODE.ENTER:
                case KEY_CODE.SPACE:
                    if (!view.visible()) {
                        return;
                    }
                    if (!this.controller().getOpt('spaceSelectsMatch') && e.keyCode === KEY_CODE.SPACE) {
                        return;
                    }
                    if (!this.controller().getOpt('tabSelectsMatch') && e.keyCode === KEY_CODE.TAB) {
                        return;
                    }
                    if (view.highlighted()) {
                        e.preventDefault();
                        view.choose(e);
                    } else {
                        view.hide(e);
                    }
                    break;
                default:
                    $.noop();
            }
        };

        return App;

    })();

    var Controller,
        slice = [].slice;

    Controller = (function() {
        Controller.prototype.uid = function() {
            return (Math.random().toString(16) + "000000000").substr(2, 8) + (new Date().getTime());
        };

        function Controller(app, at1) {
            this.app = app;
            this.at = at1;
            this.$inputor = this.app.$inputor;
            this.id = this.$inputor[0].id || this.uid();
            this.expectedQueryCBId = null;
            this.setting = null;
            this.query = null;
            this.pos = 0;
            this.range = null;
            if ((this.$el = $("#atwho-ground-" + this.id, this.app.$el)).length === 0) {
                this.app.$el.append(this.$el = $("<div id='atwho-ground-" + this.id + "'></div>"));
            }
            this.model = new Model(this);
            this.view = new View(this);
        }

        Controller.prototype.init = function(setting) {
            this.setting = $.extend({}, this.setting || $.fn.atwho["default"], setting);
            this.view.init();
            return this.model.reload(this.setting.data);
        };

        Controller.prototype.destroy = function() {
            this.trigger('beforeDestroy');
            this.model.destroy();
            this.view.destroy();
            return this.$el.remove();
        };

        Controller.prototype.callDefault = function() {
            var args, error, error1, funcName;
            funcName = arguments[0], args = 2 <= arguments.length ? slice.call(arguments, 1) : [];
            try {
                return DEFAULT_CALLBACKS[funcName].apply(this, args);
            } catch (error1) {
                error = error1;
                return $.error(error + " Or maybe At.js doesn't have function " + funcName);
            }
        };

        Controller.prototype.trigger = function(name, data) {
            var alias, eventName;
            if (data == null) {
                data = [];
            }
            data.push(this);
            alias = this.getOpt('alias');
            eventName = alias ? name + "-" + alias + ".atwho" : name + ".atwho";
            return this.$inputor.trigger(eventName, data);
        };

        Controller.prototype.callbacks = function(funcName) {
            return this.getOpt("callbacks")[funcName] || DEFAULT_CALLBACKS[funcName];
        };

        Controller.prototype.getOpt = function(at, default_value) {
            var e, error1;
            try {
                return this.setting[at];
            } catch (error1) {
                e = error1;
                return null;
            }
        };

        Controller.prototype.insertContentFor = function($li) {
            var data, tpl;
            tpl = this.getOpt('insertTpl');
            data = $.extend({}, $li.data('item-data'), {
                'atwho-at': this.at
            });
            return this.callbacks("tplEval").call(this, tpl, data, "onInsert");
        };

        Controller.prototype.renderView = function(data) {
            var searchKey;
            searchKey = this.getOpt("searchKey");
            data = this.callbacks("sorter").call(this, this.query.text, data.slice(0, 1001), searchKey);
            return this.view.render(data.slice(0, this.getOpt('limit')));
        };

        Controller.arrayToDefaultHash = function(data) {
            var i, item, len, results;
            if (!$.isArray(data)) {
                return data;
            }
            results = [];
            for (i = 0, len = data.length; i < len; i++) {
                item = data[i];
                if ($.isPlainObject(item)) {
                    results.push(item);
                } else {
                    results.push({
                        name: item
                    });
                }
            }
            return results;
        };

        Controller.prototype.lookUp = function(e) {
            var query, wait;
            if (e && e.type === 'click' && !this.getOpt('lookUpOnClick')) {
                return;
            }
            if (this.getOpt('suspendOnComposing') && this.app.isComposing) {
                return;
            }
            query = this.catchQuery(e);
            if (!query) {
                this.expectedQueryCBId = null;
                return query;
            }
            this.app.setContextFor(this.at);
            if (wait = this.getOpt('delay')) {
                this._delayLookUp(query, wait);
            } else {
                this._lookUp(query);
            }
            return query;
        };

        Controller.prototype._delayLookUp = function(query, wait) {
            var now, remaining;
            now = Date.now ? Date.now() : new Date().getTime();
            this.previousCallTime || (this.previousCallTime = now);
            remaining = wait - (now - this.previousCallTime);
            if ((0 < remaining && remaining < wait)) {
                this.previousCallTime = now;
                this._stopDelayedCall();
                return this.delayedCallTimeout = setTimeout((function(_this) {
                    return function() {
                        _this.previousCallTime = 0;
                        _this.delayedCallTimeout = null;
                        return _this._lookUp(query);
                    };
                })(this), wait);
            } else {
                this._stopDelayedCall();
                if (this.previousCallTime !== now) {
                    this.previousCallTime = 0;
                }
                return this._lookUp(query);
            }
        };

        Controller.prototype._stopDelayedCall = function() {
            if (this.delayedCallTimeout) {
                clearTimeout(this.delayedCallTimeout);
                return this.delayedCallTimeout = null;
            }
        };

        Controller.prototype._generateQueryCBId = function() {
            return {};
        };

        Controller.prototype._lookUp = function(query) {
            var _callback;
            _callback = function(queryCBId, data) {
                if (queryCBId !== this.expectedQueryCBId) {
                    return;
                }
                if (data && data.length > 0) {
                    return this.renderView(this.constructor.arrayToDefaultHash(data));
                } else {
                    return this.view.hide();
                }
            };
            this.expectedQueryCBId = this._generateQueryCBId();
            return this.model.query(query.text, $.proxy(_callback, this, this.expectedQueryCBId));
        };

        return Controller;

    })();

    var TextareaController,
        extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
        hasProp = {}.hasOwnProperty;

    TextareaController = (function(superClass) {
        extend(TextareaController, superClass);

        function TextareaController() {
            return TextareaController.__super__.constructor.apply(this, arguments);
        }

        TextareaController.prototype.catchQuery = function() {
            var caretPos, content, end, isString, query, start, subtext;
            content = this.$inputor.val();
            caretPos = this.$inputor.caret('pos', {
                iframe: this.app.iframe
            });
            subtext = content.slice(0, caretPos);
            query = this.callbacks("matcher").call(this, this.at, subtext, this.getOpt('startWithSpace'));
            isString = typeof query === 'string';
            if (isString && query.length < this.getOpt('minLen', 0)) {
                return;
            }
            if (isString && query.length <= this.getOpt('maxLen', 20)) {
                start = caretPos - query.length;
                end = start + query.length;
                this.pos = start;
                query = {
                    'text': query,
                    'headPos': start,
                    'endPos': end
                };
                this.trigger("matched", [this.at, query.text]);
            } else {
                query = null;
                this.view.hide();
            }
            return this.query = query;
        };

        TextareaController.prototype.rect = function() {
            var c, iframeOffset, scaleBottom;
            if (!(c = this.$inputor.caret('offset', this.pos - 1, {
                    iframe: this.app.iframe
                }))) {
                return;
            }
            if (this.app.iframe && !this.app.iframeAsRoot) {
                iframeOffset = $(this.app.iframe).offset();
                c.left += iframeOffset.left;
                c.top += iframeOffset.top;
            }
            scaleBottom = this.app.document.selection ? 0 : 2;
            return {
                left: c.left,
                top: c.top,
                bottom: c.top + c.height + scaleBottom
            };
        };

        TextareaController.prototype.insert = function(content, $li) {
            var $inputor, source, startStr, suffix, text;
            $inputor = this.$inputor;
            source = $inputor.val();
            startStr = source.slice(0, Math.max(this.query.headPos - this.at.length, 0));
            suffix = (suffix = this.getOpt('suffix')) === "" ? suffix : suffix || " ";
            content += suffix;
            text = "" + startStr + content + (source.slice(this.query['endPos'] || 0));
            $inputor.val(text);
            $inputor.caret('pos', startStr.length + content.length, {
                iframe: this.app.iframe
            });
            if (!$inputor.is(':focus')) {
                $inputor.focus();
            }
            return $inputor.change();
        };

        return TextareaController;

    })(Controller);

    var EditableController,
        extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
        hasProp = {}.hasOwnProperty;

    EditableController = (function(superClass) {
        extend(EditableController, superClass);

        function EditableController() {
            return EditableController.__super__.constructor.apply(this, arguments);
        }

        EditableController.prototype._getRange = function() {
            var sel;
            sel = this.app.window.getSelection();
            if (sel.rangeCount > 0) {
                return sel.getRangeAt(0);
            }
        };

        EditableController.prototype._setRange = function(position, node, range) {
            if (range == null) {
                range = this._getRange();
            }
            if (!range) {
                return;
            }
            node = $(node)[0];
            if (position === 'after') {
                range.setEndAfter(node);
                range.setStartAfter(node);
            } else {
                range.setEndBefore(node);
                range.setStartBefore(node);
            }
            range.collapse(false);
            return this._clearRange(range);
        };

        EditableController.prototype._clearRange = function(range) {
            var sel;
            if (range == null) {
                range = this._getRange();
            }
            sel = this.app.window.getSelection();
            if (this.ctrl_a_pressed == null) {
                sel.removeAllRanges();
                return sel.addRange(range);
            }
        };

        EditableController.prototype._movingEvent = function(e) {
            var ref;
            return e.type === 'click' || ((ref = e.which) === KEY_CODE.RIGHT || ref === KEY_CODE.LEFT || ref === KEY_CODE.UP || ref === KEY_CODE.DOWN);
        };

        EditableController.prototype._unwrap = function(node) {
            var next;
            node = $(node).unwrap().get(0);
            if ((next = node.nextSibling) && next.nodeValue) {
                node.nodeValue += next.nodeValue;
                $(next).remove();
            }
            return node;
        };

        EditableController.prototype.catchQuery = function(e) {
            var $inserted, $query, _range, index, inserted, isString, lastNode, matched, offset, query, query_content, range;
            if (!(range = this._getRange())) {
                return;
            }
            if (!range.collapsed) {
                return;
            }
            if (e.which === KEY_CODE.ENTER) {
                ($query = $(range.startContainer).closest('.atwho-query')).contents().unwrap();
                if ($query.is(':empty')) {
                    $query.remove();
                }
                ($query = $(".atwho-query", this.app.document)).text($query.text()).contents().last().unwrap();
                this._clearRange();
                return;
            }
            if (/firefox/i.test(navigator.userAgent)) {
                if ($(range.startContainer).is(this.$inputor)) {
                    this._clearRange();
                    return;
                }
                if (e.which === KEY_CODE.BACKSPACE && range.startContainer.nodeType === document.ELEMENT_NODE && (offset = range.startOffset - 1) >= 0) {
                    _range = range.cloneRange();
                    _range.setStart(range.startContainer, offset);
                    if ($(_range.cloneContents()).contents().last().is('.atwho-inserted')) {
                        inserted = $(range.startContainer).contents().get(offset);
                        this._setRange('after', $(inserted).contents().last());
                    }
                } else if (e.which === KEY_CODE.LEFT && range.startContainer.nodeType === document.TEXT_NODE) {
                    $inserted = $(range.startContainer.previousSibling);
                    if ($inserted.is('.atwho-inserted') && range.startOffset === 0) {
                        this._setRange('after', $inserted.contents().last());
                    }
                }
            }
            $(range.startContainer).closest('.atwho-inserted').addClass('atwho-query').siblings().removeClass('atwho-query');
            if (($query = $(".atwho-query", this.app.document)).length > 0 && $query.is(':empty') && $query.text().length === 0) {
                $query.remove();
            }
            if (!this._movingEvent(e)) {
                $query.removeClass('atwho-inserted');
            }
            if ($query.length > 0) {
                switch (e.which) {
                    case KEY_CODE.LEFT:
                        this._setRange('before', $query.get(0), range);
                        $query.removeClass('atwho-query');
                        return;
                    case KEY_CODE.RIGHT:
                        this._setRange('after', $query.get(0).nextSibling, range);
                        $query.removeClass('atwho-query');
                        return;
                }
            }
            if ($query.length > 0 && (query_content = $query.attr('data-atwho-at-query'))) {
                $query.empty().html(query_content).attr('data-atwho-at-query', null);
                this._setRange('after', $query.get(0), range);
            }
            _range = range.cloneRange();
            _range.setStart(range.startContainer, 0);
            matched = this.callbacks("matcher").call(this, this.at, _range.toString(), this.getOpt('startWithSpace'));
            isString = typeof matched === 'string';
            if ($query.length === 0 && isString && (index = range.startOffset - this.at.length - matched.length) >= 0) {
                range.setStart(range.startContainer, index);
                $query = $('<span/>', this.app.document).attr(this.getOpt("editableAtwhoQueryAttrs")).addClass('atwho-query');
                range.surroundContents($query.get(0));
                lastNode = $query.contents().last().get(0);
                if (/firefox/i.test(navigator.userAgent)) {
                    range.setStart(lastNode, lastNode.length);
                    range.setEnd(lastNode, lastNode.length);
                    this._clearRange(range);
                } else {
                    this._setRange('after', lastNode, range);
                }
            }
            if (isString && matched.length < this.getOpt('minLen', 0)) {
                return;
            }
            if (isString && matched.length <= this.getOpt('maxLen', 20)) {
                query = {
                    text: matched,
                    el: $query
                };
                this.trigger("matched", [this.at, query.text]);
                return this.query = query;
            } else {
                this.view.hide();
                this.query = {
                    el: $query
                };
                if ($query.text().indexOf(this.at) >= 0) {
                    if (this._movingEvent(e) && $query.hasClass('atwho-inserted')) {
                        $query.removeClass('atwho-query');
                    } else if (false !== this.callbacks('afterMatchFailed').call(this, this.at, $query)) {
                        this._setRange("after", this._unwrap($query.text($query.text()).contents().first()));
                    }
                }
                return null;
            }
        };

        EditableController.prototype.rect = function() {
            var $iframe, iframeOffset, rect;
            rect = this.query.el.offset();
            if (this.app.iframe && !this.app.iframeAsRoot) {
                iframeOffset = ($iframe = $(this.app.iframe)).offset();
                rect.left += iframeOffset.left - this.$inputor.scrollLeft();
                rect.top += iframeOffset.top - this.$inputor.scrollTop();
            }
            rect.bottom = rect.top + this.query.el.height();
            return rect;
        };

        EditableController.prototype.insert = function(content, $li) {
            var data, range, suffix, suffixNode;
            if (!this.$inputor.is(':focus')) {
                this.$inputor.focus();
            }
            suffix = (suffix = this.getOpt('suffix')) === "" ? suffix : suffix || "\u00A0";
            data = $li.data('item-data');
            this.query.el.removeClass('atwho-query').addClass('atwho-inserted').html(content).attr('data-atwho-at-query', "" + data['atwho-at'] + this.query.text);
            if (range = this._getRange()) {
                range.setEndAfter(this.query.el[0]);
                range.collapse(false);
                range.insertNode(suffixNode = this.app.document.createTextNode("\u200D" + suffix));
                this._setRange('after', suffixNode, range);
            }
            if (!this.$inputor.is(':focus')) {
                this.$inputor.focus();
            }
            return this.$inputor.change();
        };

        return EditableController;

    })(Controller);

    var Model;

    Model = (function() {
        function Model(context) {
            this.context = context;
            this.at = this.context.at;
            this.storage = this.context.$inputor;
        }

        Model.prototype.destroy = function() {
            return this.storage.data(this.at, null);
        };

        Model.prototype.saved = function() {
            return this.fetch() > 0;
        };

        Model.prototype.query = function(query, callback) {
            var _remoteFilter, data, searchKey;
            data = this.fetch();
            searchKey = this.context.getOpt("searchKey");
            data = this.context.callbacks('filter').call(this.context, query, data, searchKey) || [];
            _remoteFilter = this.context.callbacks('remoteFilter');
            if (data.length > 0 || (!_remoteFilter && data.length === 0)) {
                return callback(data);
            } else {
                return _remoteFilter.call(this.context, query, callback);
            }
        };

        Model.prototype.fetch = function() {
            return this.storage.data(this.at) || [];
        };

        Model.prototype.save = function(data) {
            return this.storage.data(this.at, this.context.callbacks("beforeSave").call(this.context, data || []));
        };

        Model.prototype.load = function(data) {
            if (!(this.saved() || !data)) {
                return this._load(data);
            }
        };

        Model.prototype.reload = function(data) {
            return this._load(data);
        };

        Model.prototype._load = function(data) {
            if (typeof data === "string") {
                return $.ajax(data, {
                    dataType: "json"
                }).done((function(_this) {
                    return function(data) {
                        return _this.save(data);
                    };
                })(this));
            } else {
                return this.save(data);
            }
        };

        return Model;

    })();

    var View;

    View = (function() {
        function View(context) {
            this.context = context;
            this.$el = $("<div class='atwho-view'><ul class='atwho-view-ul'></ul></div>");
            this.$elUl = this.$el.children();
            this.timeoutID = null;
            this.context.$el.append(this.$el);
            this.bindEvent();
        }

        View.prototype.init = function() {
            var header_tpl, id;
            id = this.context.getOpt("alias") || this.context.at.charCodeAt(0);
            header_tpl = this.context.getOpt("headerTpl");
            if (header_tpl && this.$el.children().length === 1) {
                this.$el.prepend(header_tpl);
            }
            return this.$el.attr({
                'id': "at-view-" + id
            });
        };

        View.prototype.destroy = function() {
            return this.$el.remove();
        };

        View.prototype.bindEvent = function() {
            var $menu, lastCoordX, lastCoordY;
            $menu = this.$el.find('ul');
            lastCoordX = 0;
            lastCoordY = 0;
            return $menu.on('mousemove.atwho-view', 'li', (function(_this) {
                return function(e) {
                    var $cur;
                    if (lastCoordX === e.clientX && lastCoordY === e.clientY) {
                        return;
                    }
                    lastCoordX = e.clientX;
                    lastCoordY = e.clientY;
                    $cur = $(e.currentTarget);
                    if ($cur.hasClass('cur')) {
                        return;
                    }
                    $menu.find('.cur').removeClass('cur');
                    return $cur.addClass('cur');
                };
            })(this)).on('click.atwho-view', 'li', (function(_this) {
                return function(e) {
                    $menu.find('.cur').removeClass('cur');
                    $(e.currentTarget).addClass('cur');
                    _this.choose(e);
                    return e.preventDefault();
                };
            })(this));
        };

        View.prototype.visible = function() {
            return this.$el.is(":visible");
        };

        View.prototype.highlighted = function() {
            return this.$el.find(".cur").length > 0;
        };

        View.prototype.choose = function(e) {
            var $li, content;
            if (($li = this.$el.find(".cur")).length) {
                content = this.context.insertContentFor($li);
                this.context._stopDelayedCall();
                this.context.insert(this.context.callbacks("beforeInsert").call(this.context, content, $li, e), $li);
                this.context.trigger("inserted", [$li, e]);
                this.hide(e);
            }
            if (this.context.getOpt("hideWithoutSuffix")) {
                return this.stopShowing = true;
            }
        };

        View.prototype.reposition = function(rect) {
            var _window, offset, overflowOffset, ref;
            _window = this.context.app.iframeAsRoot ? this.context.app.window : window;
            if (rect.bottom + this.$el.height() - $(_window).scrollTop() > $(_window).height()) {
                rect.bottom = rect.top - this.$el.height();
            }
            if (rect.left > (overflowOffset = $(_window).width() - this.$el.width() - 5)) {
                rect.left = overflowOffset;
            }
            offset = {
                left: rect.left,
                top: rect.bottom
            };
            if ((ref = this.context.callbacks("beforeReposition")) != null) {
                ref.call(this.context, offset);
            }
            this.$el.offset(offset);
            return this.context.trigger("reposition", [offset]);
        };

        View.prototype.next = function() {
            var cur, next, nextEl, offset;
            cur = this.$el.find('.cur').removeClass('cur');
            next = cur.next();
            if (!next.length) {
                next = this.$el.find('li:first');
            }
            next.addClass('cur');
            nextEl = next[0];
            offset = nextEl.offsetTop + nextEl.offsetHeight + (nextEl.nextSibling ? nextEl.nextSibling.offsetHeight : 0);
            return this.scrollTop(Math.max(0, offset - this.$el.height()));
        };

        View.prototype.prev = function() {
            var cur, offset, prev, prevEl;
            cur = this.$el.find('.cur').removeClass('cur');
            prev = cur.prev();
            if (!prev.length) {
                prev = this.$el.find('li:last');
            }
            prev.addClass('cur');
            prevEl = prev[0];
            offset = prevEl.offsetTop + prevEl.offsetHeight + (prevEl.nextSibling ? prevEl.nextSibling.offsetHeight : 0);
            return this.scrollTop(Math.max(0, offset - this.$el.height()));
        };

        View.prototype.scrollTop = function(scrollTop) {
            var scrollDuration;
            scrollDuration = this.context.getOpt('scrollDuration');
            if (scrollDuration) {
                return this.$elUl.animate({
                    scrollTop: scrollTop
                }, scrollDuration);
            } else {
                return this.$elUl.scrollTop(scrollTop);
            }
        };

        View.prototype.show = function() {
            var rect;
            if (this.stopShowing) {
                this.stopShowing = false;
                return;
            }
            if (!this.visible()) {
                this.$el.show();
                this.$el.scrollTop(0);
                this.context.trigger('shown');
            }
            if (rect = this.context.rect()) {
                return this.reposition(rect);
            }
        };

        View.prototype.hide = function(e, time) {
            var callback;
            if (!this.visible()) {
                return;
            }
            if (isNaN(time)) {
                this.$el.hide();
                return this.context.trigger('hidden', [e]);
            } else {
                callback = (function(_this) {
                    return function() {
                        return _this.hide();
                    };
                })(this);
                clearTimeout(this.timeoutID);
                return this.timeoutID = setTimeout(callback, time);
            }
        };

        View.prototype.render = function(list) {
            var $li, $ul, i, item, len, li, tpl;
            if (!($.isArray(list) && list.length > 0)) {
                this.hide();
                return;
            }
            this.$el.find('ul').empty();
            $ul = this.$el.find('ul');
            tpl = this.context.getOpt('displayTpl');
            for (i = 0, len = list.length; i < len; i++) {
                item = list[i];
                item = $.extend({}, item, {
                    'atwho-at': this.context.at
                });
                li = this.context.callbacks("tplEval").call(this.context, tpl, item, "onDisplay");
                $li = $(this.context.callbacks("highlighter").call(this.context, li, this.context.query.text));
                $li.data("item-data", item);
                $ul.append($li);
            }
            this.show();
            if (this.context.getOpt('highlightFirst')) {
                return $ul.find("li:first").addClass("cur");
            }
        };

        return View;

    })();

    var Api;

    Api = {
        load: function(at, data) {
            var c;
            if (c = this.controller(at)) {
                return c.model.load(data);
            }
        },
        isSelecting: function() {
            var ref;
            return !!((ref = this.controller()) != null ? ref.view.visible() : void 0);
        },
        hide: function() {
            var ref;
            return (ref = this.controller()) != null ? ref.view.hide() : void 0;
        },
        reposition: function() {
            var c;
            if (c = this.controller()) {
                return c.view.reposition(c.rect());
            }
        },
        setIframe: function(iframe, asRoot) {
            this.setupRootElement(iframe, asRoot);
            return null;
        },
        run: function() {
            return this.dispatch();
        },
        destroy: function() {
            this.shutdown();
            return this.$inputor.data('atwho', null);
        }
    };

    $.fn.atwho = function(method) {
        var _args, result;
        _args = arguments;
        result = null;
        this.filter('textarea, input, [contenteditable=""], [contenteditable=true]').each(function() {
            var $this, app;
            if (!(app = ($this = $(this)).data("atwho"))) {
                $this.data('atwho', (app = new App(this)));
            }
            if (typeof method === 'object' || !method) {
                return app.reg(method.at, method);
            } else if (Api[method] && app) {
                return result = Api[method].apply(app, Array.prototype.slice.call(_args, 1));
            } else {
                return $.error("Method " + method + " does not exist on jQuery.atwho");
            }
        });
        if (result != null) {
            return result;
        } else {
            return this;
        }
    };

    $.fn.atwho["default"] = {
        at: void 0,
        alias: void 0,
        data: null,
        displayTpl: "<li>${name}</li>",
        insertTpl: "${atwho-at}${name}",
        headerTpl: null,
        callbacks: DEFAULT_CALLBACKS,
        searchKey: "name",
        suffix: void 0,
        hideWithoutSuffix: false,
        startWithSpace: true,
        highlightFirst: true,
        limit: 5,
        maxLen: 20,
        minLen: 0,
        displayTimeout: 300,
        delay: null,
        spaceSelectsMatch: false,
        tabSelectsMatch: true,
        editableAtwhoQueryAttrs: {},
        scrollDuration: 150,
        suspendOnComposing: true,
        lookUpOnClick: true
    };

    $.fn.atwho.debug = false;

}));

!function(a){"use strict";"function"==typeof define&&define.amd?define(["./blueimp-helper"],a):(window.blueimp=window.blueimp||{},window.blueimp.Gallery=a(window.blueimp.helper||window.jQuery))}(function(a){"use strict";function b(a,c){return void 0===document.body.style.maxHeight?null:this&&this.options===b.prototype.options?a&&a.length?(this.list=a,this.num=a.length,this.initOptions(c),void this.initialize()):void this.console.log("blueimp Gallery: No or empty list provided as first argument.",a):new b(a,c)}return a.extend(b.prototype,{options:{container:"#blueimp-gallery",slidesContainer:"div",titleElement:"h3",displayClass:"blueimp-gallery-display",controlsClass:"blueimp-gallery-controls",singleClass:"blueimp-gallery-single",leftEdgeClass:"blueimp-gallery-left",rightEdgeClass:"blueimp-gallery-right",playingClass:"blueimp-gallery-playing",slideClass:"slide",slideLoadingClass:"slide-loading",slideErrorClass:"slide-error",slideContentClass:"slide-content",toggleClass:"toggle",prevClass:"prev",nextClass:"next",closeClass:"close",playPauseClass:"play-pause",typeProperty:"type",titleProperty:"title",urlProperty:"href",displayTransition:!0,clearSlides:!0,stretchImages:!1,toggleControlsOnReturn:!0,toggleSlideshowOnSpace:!0,enableKeyboardNavigation:!0,closeOnEscape:!0,closeOnSlideClick:!0,closeOnSwipeUpOrDown:!0,emulateTouchEvents:!0,stopTouchEventsPropagation:!1,hidePageScrollbars:!0,disableScroll:!0,carousel:!1,continuous:!0,unloadElements:!0,startSlideshow:!1,slideshowInterval:5e3,index:0,preloadRange:2,transitionSpeed:400,slideshowTransitionSpeed:void 0,event:void 0,onopen:void 0,onopened:void 0,onslide:void 0,onslideend:void 0,onslidecomplete:void 0,onclose:void 0,onclosed:void 0},carouselOptions:{hidePageScrollbars:!1,toggleControlsOnReturn:!1,toggleSlideshowOnSpace:!1,enableKeyboardNavigation:!1,closeOnEscape:!1,closeOnSlideClick:!1,closeOnSwipeUpOrDown:!1,disableScroll:!1,startSlideshow:!0},console:window.console&&"function"==typeof window.console.log?window.console:{log:function(){}},support:function(b){var c={touch:void 0!==window.ontouchstart||window.DocumentTouch&&document instanceof DocumentTouch},d={webkitTransition:{end:"webkitTransitionEnd",prefix:"-webkit-"},MozTransition:{end:"transitionend",prefix:"-moz-"},OTransition:{end:"otransitionend",prefix:"-o-"},transition:{end:"transitionend",prefix:""}},e=function(){var a,d,e=c.transition;document.body.appendChild(b),e&&(a=e.name.slice(0,-9)+"ransform",void 0!==b.style[a]&&(b.style[a]="translateZ(0)",d=window.getComputedStyle(b).getPropertyValue(e.prefix+"transform"),c.transform={prefix:e.prefix,name:a,translate:!0,translateZ:!!d&&"none"!==d})),void 0!==b.style.backgroundSize&&(c.backgroundSize={},b.style.backgroundSize="contain",c.backgroundSize.contain="contain"===window.getComputedStyle(b).getPropertyValue("background-size"),b.style.backgroundSize="cover",c.backgroundSize.cover="cover"===window.getComputedStyle(b).getPropertyValue("background-size")),document.body.removeChild(b)};return function(a,c){var d;for(d in c)if(c.hasOwnProperty(d)&&void 0!==b.style[d]){a.transition=c[d],a.transition.name=d;break}}(c,d),document.body?e():a(document).on("DOMContentLoaded",e),c}(document.createElement("div")),requestAnimationFrame:window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame,initialize:function(){return this.initStartIndex(),this.initWidget()===!1?!1:(this.initEventListeners(),this.onslide(this.index),this.ontransitionend(),void(this.options.startSlideshow&&this.play()))},slide:function(a,b){window.clearTimeout(this.timeout);var c,d,e,f=this.index;if(f!==a&&1!==this.num){if(b||(b=this.options.transitionSpeed),this.support.transform){for(this.options.continuous||(a=this.circle(a)),c=Math.abs(f-a)/(f-a),this.options.continuous&&(d=c,c=-this.positions[this.circle(a)]/this.slideWidth,c!==d&&(a=-c*this.num+a)),e=Math.abs(f-a)-1;e;)e-=1,this.move(this.circle((a>f?a:f)-e-1),this.slideWidth*c,0);a=this.circle(a),this.move(f,this.slideWidth*c,b),this.move(a,0,b),this.options.continuous&&this.move(this.circle(a-c),-(this.slideWidth*c),0)}else a=this.circle(a),this.animate(f*-this.slideWidth,a*-this.slideWidth,b);this.onslide(a)}},getIndex:function(){return this.index},getNumber:function(){return this.num},prev:function(){(this.options.continuous||this.index)&&this.slide(this.index-1)},next:function(){(this.options.continuous||this.index<this.num-1)&&this.slide(this.index+1)},play:function(a){var b=this;window.clearTimeout(this.timeout),this.interval=a||this.options.slideshowInterval,this.elements[this.index]>1&&(this.timeout=this.setTimeout(!this.requestAnimationFrame&&this.slide||function(a,c){b.animationFrameId=b.requestAnimationFrame.call(window,function(){b.slide(a,c)})},[this.index+1,this.options.slideshowTransitionSpeed],this.interval)),this.container.addClass(this.options.playingClass)},pause:function(){window.clearTimeout(this.timeout),this.interval=null,this.container.removeClass(this.options.playingClass)},add:function(a){var b;for(a.concat||(a=Array.prototype.slice.call(a)),this.list.concat||(this.list=Array.prototype.slice.call(this.list)),this.list=this.list.concat(a),this.num=this.list.length,this.num>2&&null===this.options.continuous&&(this.options.continuous=!0,this.container.removeClass(this.options.leftEdgeClass)),this.container.removeClass(this.options.rightEdgeClass).removeClass(this.options.singleClass),b=this.num-a.length;b<this.num;b+=1)this.addSlide(b),this.positionSlide(b);this.positions.length=this.num,this.initSlides(!0)},resetSlides:function(){this.slidesContainer.empty(),this.slides=[]},handleClose:function(){var a=this.options;this.destroyEventListeners(),this.pause(),this.container[0].style.display="none",this.container.removeClass(a.displayClass).removeClass(a.singleClass).removeClass(a.leftEdgeClass).removeClass(a.rightEdgeClass),a.hidePageScrollbars&&(document.body.style.overflow=this.bodyOverflowStyle),this.options.clearSlides&&this.resetSlides(),this.options.onclosed&&this.options.onclosed.call(this)},close:function(){var a=this,b=function(c){c.target===a.container[0]&&(a.container.off(a.support.transition.end,b),a.handleClose())};this.options.onclose&&this.options.onclose.call(this),this.support.transition&&this.options.displayTransition?(this.container.on(this.support.transition.end,b),this.container.removeClass(this.options.displayClass)):this.handleClose()},circle:function(a){return(this.num+a%this.num)%this.num},move:function(a,b,c){this.translateX(a,b,c),this.positions[a]=b},translate:function(a,b,c,d){var e=this.slides[a].style,f=this.support.transition,g=this.support.transform;e[f.name+"Duration"]=d+"ms",e[g.name]="translate("+b+"px, "+c+"px)"+(g.translateZ?" translateZ(0)":"")},translateX:function(a,b,c){this.translate(a,b,0,c)},translateY:function(a,b,c){this.translate(a,0,b,c)},animate:function(a,b,c){if(!c)return void(this.slidesContainer[0].style.left=b+"px");var d=this,e=(new Date).getTime(),f=window.setInterval(function(){var g=(new Date).getTime()-e;return g>c?(d.slidesContainer[0].style.left=b+"px",d.ontransitionend(),void window.clearInterval(f)):void(d.slidesContainer[0].style.left=(b-a)*(Math.floor(g/c*100)/100)+a+"px")},4)},preventDefault:function(a){a.preventDefault?a.preventDefault():a.returnValue=!1},stopPropagation:function(a){a.stopPropagation?a.stopPropagation():a.cancelBubble=!0},onresize:function(){this.initSlides(!0)},onmousedown:function(a){a.which&&1===a.which&&"VIDEO"!==a.target.nodeName&&(a.preventDefault(),(a.originalEvent||a).touches=[{pageX:a.pageX,pageY:a.pageY}],this.ontouchstart(a))},onmousemove:function(a){this.touchStart&&((a.originalEvent||a).touches=[{pageX:a.pageX,pageY:a.pageY}],this.ontouchmove(a))},onmouseup:function(a){this.touchStart&&(this.ontouchend(a),delete this.touchStart)},onmouseout:function(b){if(this.touchStart){var c=b.target,d=b.relatedTarget;(!d||d!==c&&!a.contains(c,d))&&this.onmouseup(b)}},ontouchstart:function(a){this.options.stopTouchEventsPropagation&&this.stopPropagation(a);var b=(a.originalEvent||a).touches[0];this.touchStart={x:b.pageX,y:b.pageY,time:Date.now()},this.isScrolling=void 0,this.touchDelta={}},ontouchmove:function(a){this.options.stopTouchEventsPropagation&&this.stopPropagation(a);var b,c,d=(a.originalEvent||a).touches[0],e=(a.originalEvent||a).scale,f=this.index;if(!(d.length>1||e&&1!==e))if(this.options.disableScroll&&a.preventDefault(),this.touchDelta={x:d.pageX-this.touchStart.x,y:d.pageY-this.touchStart.y},b=this.touchDelta.x,void 0===this.isScrolling&&(this.isScrolling=this.isScrolling||Math.abs(b)<Math.abs(this.touchDelta.y)),this.isScrolling)this.options.closeOnSwipeUpOrDown&&this.translateY(f,this.touchDelta.y+this.positions[f],0);else for(a.preventDefault(),window.clearTimeout(this.timeout),this.options.continuous?c=[this.circle(f+1),f,this.circle(f-1)]:(this.touchDelta.x=b/=!f&&b>0||f===this.num-1&&0>b?Math.abs(b)/this.slideWidth+1:1,c=[f],f&&c.push(f-1),f<this.num-1&&c.unshift(f+1));c.length;)f=c.pop(),this.translateX(f,b+this.positions[f],0)},ontouchend:function(a){this.options.stopTouchEventsPropagation&&this.stopPropagation(a);var b,c,d,e,f,g=this.index,h=this.options.transitionSpeed,i=this.slideWidth,j=Number(Date.now()-this.touchStart.time)<250,k=j&&Math.abs(this.touchDelta.x)>20||Math.abs(this.touchDelta.x)>i/2,l=!g&&this.touchDelta.x>0||g===this.num-1&&this.touchDelta.x<0,m=!k&&this.options.closeOnSwipeUpOrDown&&(j&&Math.abs(this.touchDelta.y)>20||Math.abs(this.touchDelta.y)>this.slideHeight/2);this.options.continuous&&(l=!1),b=this.touchDelta.x<0?-1:1,this.isScrolling?m?this.close():this.translateY(g,0,h):k&&!l?(c=g+b,d=g-b,e=i*b,f=-i*b,this.options.continuous?(this.move(this.circle(c),e,0),this.move(this.circle(g-2*b),f,0)):c>=0&&c<this.num&&this.move(c,e,0),this.move(g,this.positions[g]+e,h),this.move(this.circle(d),this.positions[this.circle(d)]+e,h),g=this.circle(d),this.onslide(g)):this.options.continuous?(this.move(this.circle(g-1),-i,h),this.move(g,0,h),this.move(this.circle(g+1),i,h)):(g&&this.move(g-1,-i,h),this.move(g,0,h),g<this.num-1&&this.move(g+1,i,h))},ontouchcancel:function(a){this.touchStart&&(this.ontouchend(a),delete this.touchStart)},ontransitionend:function(a){var b=this.slides[this.index];a&&b!==a.target||(this.interval&&this.play(),this.setTimeout(this.options.onslideend,[this.index,b]))},oncomplete:function(b){var c,d=b.target||b.srcElement,e=d&&d.parentNode;d&&e&&(c=this.getNodeIndex(e),a(e).removeClass(this.options.slideLoadingClass),"error"===b.type?(a(e).addClass(this.options.slideErrorClass),this.elements[c]=3):this.elements[c]=2,d.clientHeight>this.container[0].clientHeight&&(d.style.maxHeight=this.container[0].clientHeight),this.interval&&this.slides[this.index]===e&&this.play(),this.setTimeout(this.options.onslidecomplete,[c,e]))},onload:function(a){this.oncomplete(a)},onerror:function(a){this.oncomplete(a)},onkeydown:function(a){switch(a.which||a.keyCode){case 13:this.options.toggleControlsOnReturn&&(this.preventDefault(a),this.toggleControls());break;case 27:this.options.closeOnEscape&&this.close();break;case 32:this.options.toggleSlideshowOnSpace&&(this.preventDefault(a),this.toggleSlideshow());break;case 37:this.options.enableKeyboardNavigation&&(this.preventDefault(a),this.prev());break;case 39:this.options.enableKeyboardNavigation&&(this.preventDefault(a),this.next())}},handleClick:function(b){var c=this.options,d=b.target||b.srcElement,e=d.parentNode,f=function(b){return a(d).hasClass(b)||a(e).hasClass(b)};f(c.toggleClass)?(this.preventDefault(b),this.toggleControls()):f(c.prevClass)?(this.preventDefault(b),this.prev()):f(c.nextClass)?(this.preventDefault(b),this.next()):f(c.closeClass)?(this.preventDefault(b),this.close()):f(c.playPauseClass)?(this.preventDefault(b),this.toggleSlideshow()):e===this.slidesContainer[0]?(this.preventDefault(b),c.closeOnSlideClick?this.close():this.toggleControls()):e.parentNode&&e.parentNode===this.slidesContainer[0]&&(this.preventDefault(b),this.toggleControls())},onclick:function(a){return this.options.emulateTouchEvents&&this.touchDelta&&(Math.abs(this.touchDelta.x)>20||Math.abs(this.touchDelta.y)>20)?void delete this.touchDelta:this.handleClick(a)},updateEdgeClasses:function(a){a?this.container.removeClass(this.options.leftEdgeClass):this.container.addClass(this.options.leftEdgeClass),a===this.num-1?this.container.addClass(this.options.rightEdgeClass):this.container.removeClass(this.options.rightEdgeClass)},handleSlide:function(a){this.options.continuous||this.updateEdgeClasses(a),this.loadElements(a),this.options.unloadElements&&this.unloadElements(a),this.setTitle(a)},onslide:function(a){this.index=a,this.handleSlide(a),this.setTimeout(this.options.onslide,[a,this.slides[a]])},setTitle:function(a){var b=this.slides[a].firstChild.title,c=this.titleElement;c.length&&(this.titleElement.empty(),b&&c[0].appendChild(document.createTextNode(b)))},setTimeout:function(a,b,c){var d=this;return a&&window.setTimeout(function(){a.apply(d,b||[])},c||0)},imageFactory:function(b,c){var d,e,f,g=this,h=this.imagePrototype.cloneNode(!1),i=b,j=this.options.stretchImages,k=function(b){if(!d){if(b={type:b.type,target:e},!e.parentNode)return g.setTimeout(k,[b]);d=!0,a(h).off("load error",k),j&&"load"===b.type&&(e.style.background='url("'+i+'") center no-repeat',e.style.backgroundSize=j),c(b)}};return"string"!=typeof i&&(i=this.getItemProperty(b,this.options.urlProperty),f=this.getItemProperty(b,this.options.titleProperty)),j===!0&&(j="contain"),j=this.support.backgroundSize&&this.support.backgroundSize[j]&&j,j?e=this.elementPrototype.cloneNode(!1):(e=h,h.draggable=!1),f&&(e.title=f),a(h).on("load error",k),h.src=i,e},createElement:function(b,c){var d=b&&this.getItemProperty(b,this.options.typeProperty),e=d&&this[d.split("/")[0]+"Factory"]||this.imageFactory,f=b&&e.call(this,b,c);return f||(f=this.elementPrototype.cloneNode(!1),this.setTimeout(c,[{type:"error",target:f}])),a(f).addClass(this.options.slideContentClass),f},loadElement:function(b){this.elements[b]||(this.slides[b].firstChild?this.elements[b]=a(this.slides[b]).hasClass(this.options.slideErrorClass)?3:2:(this.elements[b]=1,a(this.slides[b]).addClass(this.options.slideLoadingClass),this.slides[b].appendChild(this.createElement(this.list[b],this.proxyListener))))},loadElements:function(a){var b,c=Math.min(this.num,2*this.options.preloadRange+1),d=a;for(b=0;c>b;b+=1)d+=b*(b%2===0?-1:1),d=this.circle(d),this.loadElement(d)},unloadElements:function(a){var b,c,d;for(b in this.elements)this.elements.hasOwnProperty(b)&&(d=Math.abs(a-b),d>this.options.preloadRange&&d+this.options.preloadRange<this.num&&(c=this.slides[b],c.removeChild(c.firstChild),delete this.elements[b]))},addSlide:function(a){var b=this.slidePrototype.cloneNode(!1);b.setAttribute("data-index",a),this.slidesContainer[0].appendChild(b),this.slides.push(b)},positionSlide:function(a){var b=this.slides[a];b.style.width=this.slideWidth+"px",this.support.transform&&(b.style.left=a*-this.slideWidth+"px",this.move(a,this.index>a?-this.slideWidth:this.index<a?this.slideWidth:0,0))},initSlides:function(b){var c,d;for(b||(this.positions=[],this.positions.length=this.num,this.elements={},this.imagePrototype=document.createElement("img"),this.elementPrototype=document.createElement("div"),this.slidePrototype=document.createElement("div"),a(this.slidePrototype).addClass(this.options.slideClass),this.slides=this.slidesContainer[0].children,c=this.options.clearSlides||this.slides.length!==this.num),this.slideWidth=this.container[0].offsetWidth,this.slideHeight=this.container[0].offsetHeight,this.slidesContainer[0].style.width=this.num*this.slideWidth+"px",c&&this.resetSlides(),d=0;d<this.num;d+=1)c&&this.addSlide(d),this.positionSlide(d);this.options.continuous&&this.support.transform&&(this.move(this.circle(this.index-1),-this.slideWidth,0),this.move(this.circle(this.index+1),this.slideWidth,0)),this.support.transform||(this.slidesContainer[0].style.left=this.index*-this.slideWidth+"px")},toggleControls:function(){var a=this.options.controlsClass;this.container.hasClass(a)?this.container.removeClass(a):this.container.addClass(a)},toggleSlideshow:function(){this.interval?this.pause():this.play()},getNodeIndex:function(a){return parseInt(a.getAttribute("data-index"),10)},getNestedProperty:function(a,b){return b.replace(/\[(?:'([^']+)'|"([^"]+)"|(\d+))\]|(?:(?:^|\.)([^\.\[]+))/g,function(b,c,d,e,f){var g=f||c||d||e&&parseInt(e,10);b&&a&&(a=a[g])}),a},getDataProperty:function(b,c){if(b.getAttribute){var d=b.getAttribute("data-"+c.replace(/([A-Z])/g,"-$1").toLowerCase());if("string"==typeof d){if(/^(true|false|null|-?\d+(\.\d+)?|\{[\s\S]*\}|\[[\s\S]*\])$/.test(d))try{return a.parseJSON(d)}catch(e){}return d}}},getItemProperty:function(a,b){var c=a[b];return void 0===c&&(c=this.getDataProperty(a,b),void 0===c&&(c=this.getNestedProperty(a,b))),c},initStartIndex:function(){var a,b=this.options.index,c=this.options.urlProperty;if(b&&"number"!=typeof b)for(a=0;a<this.num;a+=1)if(this.list[a]===b||this.getItemProperty(this.list[a],c)===this.getItemProperty(b,c)){b=a;break}this.index=this.circle(parseInt(b,10)||0)},initEventListeners:function(){var b=this,c=this.slidesContainer,d=function(a){var c=b.support.transition&&b.support.transition.end===a.type?"transitionend":a.type;b["on"+c](a)};a(window).on("resize",d),a(document.body).on("keydown",d),this.container.on("click",d),this.support.touch?c.on("touchstart touchmove touchend touchcancel",d):this.options.emulateTouchEvents&&this.support.transition&&c.on("mousedown mousemove mouseup mouseout",d),this.support.transition&&c.on(this.support.transition.end,d),this.proxyListener=d},destroyEventListeners:function(){var b=this.slidesContainer,c=this.proxyListener;a(window).off("resize",c),a(document.body).off("keydown",c),this.container.off("click",c),this.support.touch?b.off("touchstart touchmove touchend touchcancel",c):this.options.emulateTouchEvents&&this.support.transition&&b.off("mousedown mousemove mouseup mouseout",c),this.support.transition&&b.off(this.support.transition.end,c)},handleOpen:function(){this.options.onopened&&this.options.onopened.call(this)},initWidget:function(){var b=this,c=function(a){a.target===b.container[0]&&(b.container.off(b.support.transition.end,c),b.handleOpen())};return this.container=a(this.options.container),this.container.length?(this.slidesContainer=this.container.find(this.options.slidesContainer).first(),this.slidesContainer.length?(this.titleElement=this.container.find(this.options.titleElement).first(),1===this.num&&this.container.addClass(this.options.singleClass),this.options.onopen&&this.options.onopen.call(this),this.support.transition&&this.options.displayTransition?this.container.on(this.support.transition.end,c):this.handleOpen(),this.options.hidePageScrollbars&&(this.bodyOverflowStyle=document.body.style.overflow,document.body.style.overflow="hidden"),this.container[0].style.display="block",this.initSlides(),void this.container.addClass(this.options.displayClass)):(this.console.log("blueimp Gallery: Slides container not found.",this.options.slidesContainer),!1)):(this.console.log("blueimp Gallery: Widget container not found.",this.options.container),!1)},initOptions:function(b){this.options=a.extend({},this.options),(b&&b.carousel||this.options.carousel&&(!b||b.carousel!==!1))&&a.extend(this.options,this.carouselOptions),a.extend(this.options,b),this.num<3&&(this.options.continuous=this.options.continuous?null:!1),this.support.transition||(this.options.emulateTouchEvents=!1),this.options.event&&this.preventDefault(this.options.event)}}),b}),function(a){"use strict";"function"==typeof define&&define.amd?define(["./blueimp-helper","./blueimp-gallery"],a):a(window.blueimp.helper||window.jQuery,window.blueimp.Gallery)}(function(a,b){"use strict";a.extend(b.prototype.options,{fullScreen:!1});var c=b.prototype.initialize,d=b.prototype.close;return a.extend(b.prototype,{getFullScreenElement:function(){return document.fullscreenElement||document.webkitFullscreenElement||document.mozFullScreenElement||document.msFullscreenElement},requestFullScreen:function(a){a.requestFullscreen?a.requestFullscreen():a.webkitRequestFullscreen?a.webkitRequestFullscreen():a.mozRequestFullScreen?a.mozRequestFullScreen():a.msRequestFullscreen&&a.msRequestFullscreen()},exitFullScreen:function(){document.exitFullscreen?document.exitFullscreen():document.webkitCancelFullScreen?document.webkitCancelFullScreen():document.mozCancelFullScreen?document.mozCancelFullScreen():document.msExitFullscreen&&document.msExitFullscreen()},initialize:function(){c.call(this),this.options.fullScreen&&!this.getFullScreenElement()&&this.requestFullScreen(this.container[0])},close:function(){this.getFullScreenElement()===this.container[0]&&this.exitFullScreen(),d.call(this)}}),b}),function(a){"use strict";"function"==typeof define&&define.amd?define(["./blueimp-helper","./blueimp-gallery"],a):a(window.blueimp.helper||window.jQuery,window.blueimp.Gallery)}(function(a,b){"use strict";a.extend(b.prototype.options,{indicatorContainer:"ol",activeIndicatorClass:"active",thumbnailProperty:"thumbnail",thumbnailIndicators:!0});var c=b.prototype.initSlides,d=b.prototype.addSlide,e=b.prototype.resetSlides,f=b.prototype.handleClick,g=b.prototype.handleSlide,h=b.prototype.handleClose;return a.extend(b.prototype,{createIndicator:function(b){var c,d,e=this.indicatorPrototype.cloneNode(!1),f=this.getItemProperty(b,this.options.titleProperty),g=this.options.thumbnailProperty;return this.options.thumbnailIndicators&&(d=b.getElementsByTagName&&a(b).find("img")[0],d?c=d.src:g&&(c=this.getItemProperty(b,g)),c&&(e.style.backgroundImage='url("'+c+'")')),f&&(e.title=f),e},addIndicator:function(a){if(this.indicatorContainer.length){var b=this.createIndicator(this.list[a]);b.setAttribute("data-index",a),this.indicatorContainer[0].appendChild(b),this.indicators.push(b)}},setActiveIndicator:function(b){this.indicators&&(this.activeIndicator&&this.activeIndicator.removeClass(this.options.activeIndicatorClass),this.activeIndicator=a(this.indicators[b]),this.activeIndicator.addClass(this.options.activeIndicatorClass))},initSlides:function(a){a||(this.indicatorContainer=this.container.find(this.options.indicatorContainer),this.indicatorContainer.length&&(this.indicatorPrototype=document.createElement("li"),this.indicators=this.indicatorContainer[0].children)),c.call(this,a)},addSlide:function(a){d.call(this,a),this.addIndicator(a)},resetSlides:function(){e.call(this),this.indicatorContainer.empty(),this.indicators=[]},handleClick:function(a){var b=a.target||a.srcElement,c=b.parentNode;if(c===this.indicatorContainer[0])this.preventDefault(a),this.slide(this.getNodeIndex(b));else{if(c.parentNode!==this.indicatorContainer[0])return f.call(this,a);this.preventDefault(a),this.slide(this.getNodeIndex(c))}},handleSlide:function(a){g.call(this,a),this.setActiveIndicator(a)},handleClose:function(){this.activeIndicator&&this.activeIndicator.removeClass(this.options.activeIndicatorClass),h.call(this)}}),b}),function(a){"use strict";"function"==typeof define&&define.amd?define(["./blueimp-helper","./blueimp-gallery"],a):a(window.blueimp.helper||window.jQuery,window.blueimp.Gallery)}(function(a,b){"use strict";a.extend(b.prototype.options,{videoContentClass:"video-content",videoLoadingClass:"video-loading",videoPlayingClass:"video-playing",videoPosterProperty:"poster",videoSourcesProperty:"sources"});var c=b.prototype.handleSlide;return a.extend(b.prototype,{handleSlide:function(a){c.call(this,a),this.playingVideo&&this.playingVideo.pause()},videoFactory:function(b,c,d){var e,f,g,h,i,j=this,k=this.options,l=this.elementPrototype.cloneNode(!1),m=a(l),n=[{type:"error",target:l}],o=d||document.createElement("video"),p=this.getItemProperty(b,k.urlProperty),q=this.getItemProperty(b,k.typeProperty),r=this.getItemProperty(b,k.titleProperty),s=this.getItemProperty(b,k.videoPosterProperty),t=this.getItemProperty(b,k.videoSourcesProperty);if(m.addClass(k.videoContentClass),r&&(l.title=r),o.canPlayType)if(p&&q&&o.canPlayType(q))o.src=p;else for(;t&&t.length;)if(f=t.shift(),p=this.getItemProperty(f,k.urlProperty),q=this.getItemProperty(f,k.typeProperty),p&&q&&o.canPlayType(q)){o.src=p;break}return s&&(o.poster=s,e=this.imagePrototype.cloneNode(!1),a(e).addClass(k.toggleClass),e.src=s,e.draggable=!1,l.appendChild(e)),g=document.createElement("a"),g.setAttribute("target","_blank"),d||g.setAttribute("download",r),g.href=p,o.src&&(o.controls=!0,(d||a(o)).on("error",function(){j.setTimeout(c,n)}).on("pause",function(){h=!1,m.removeClass(j.options.videoLoadingClass).removeClass(j.options.videoPlayingClass),i&&j.container.addClass(j.options.controlsClass),delete j.playingVideo,j.interval&&j.play()}).on("playing",function(){h=!1,m.removeClass(j.options.videoLoadingClass).addClass(j.options.videoPlayingClass),j.container.hasClass(j.options.controlsClass)?(i=!0,j.container.removeClass(j.options.controlsClass)):i=!1}).on("play",function(){window.clearTimeout(j.timeout),h=!0,m.addClass(j.options.videoLoadingClass),j.playingVideo=o}),a(g).on("click",function(a){j.preventDefault(a),h?o.pause():o.play()}),l.appendChild(d&&d.element||o)),l.appendChild(g),this.setTimeout(c,[{type:"load",target:l}]),l}}),b}),function(a){"use strict";"function"==typeof define&&define.amd?define(["./blueimp-helper","./blueimp-gallery-video"],a):a(window.blueimp.helper||window.jQuery,window.blueimp.Gallery)}(function(a,b){"use strict";if(!window.postMessage)return b;a.extend(b.prototype.options,{vimeoVideoIdProperty:"vimeo",vimeoPlayerUrl:"//player.vimeo.com/video/VIDEO_ID?api=1&player_id=PLAYER_ID",vimeoPlayerIdPrefix:"vimeo-player-",vimeoClickToPlay:!0});var c=b.prototype.textFactory||b.prototype.imageFactory,d=function(a,b,c,d){this.url=a,this.videoId=b,this.playerId=c,this.clickToPlay=d,this.element=document.createElement("div"),this.listeners={}},e=0;return a.extend(d.prototype,{canPlayType:function(){return!0},on:function(a,b){return this.listeners[a]=b,this},loadAPI:function(){for(var b,c,d=this,e="//"+("https"===location.protocol?"secure-":"")+"a.vimeocdn.com/js/froogaloop2.min.js",f=document.getElementsByTagName("script"),g=f.length,h=function(){!c&&d.playOnReady&&d.play(),c=!0};g;)if(g-=1,f[g].src===e){b=f[g];break}b||(b=document.createElement("script"),b.src=e),a(b).on("load",h),f[0].parentNode.insertBefore(b,f[0]),/loaded|complete/.test(b.readyState)&&h()},onReady:function(){var a=this;this.ready=!0,this.player.addEvent("play",function(){a.hasPlayed=!0,a.onPlaying()}),this.player.addEvent("pause",function(){a.onPause()}),this.player.addEvent("finish",function(){a.onPause()}),this.playOnReady&&this.play()},onPlaying:function(){this.playStatus<2&&(this.listeners.playing(),this.playStatus=2)},onPause:function(){this.listeners.pause(),delete this.playStatus},insertIframe:function(){var a=document.createElement("iframe");a.src=this.url.replace("VIDEO_ID",this.videoId).replace("PLAYER_ID",this.playerId),a.id=this.playerId,this.element.parentNode.replaceChild(a,this.element),this.element=a},play:function(){var a=this;this.playStatus||(this.listeners.play(),this.playStatus=1),this.ready?!this.hasPlayed&&(this.clickToPlay||window.navigator&&/iP(hone|od|ad)/.test(window.navigator.platform))?this.onPlaying():this.player.api("play"):(this.playOnReady=!0,window.$f?this.player||(this.insertIframe(),this.player=$f(this.element),this.player.addEvent("ready",function(){a.onReady()})):this.loadAPI())},pause:function(){this.ready?this.player.api("pause"):this.playStatus&&(delete this.playOnReady,this.listeners.pause(),delete this.playStatus)}}),a.extend(b.prototype,{VimeoPlayer:d,textFactory:function(a,b){var f=this.options,g=this.getItemProperty(a,f.vimeoVideoIdProperty);return g?(void 0===this.getItemProperty(a,f.urlProperty)&&(a[f.urlProperty]="//vimeo.com/"+g),e+=1,this.videoFactory(a,b,new d(f.vimeoPlayerUrl,g,f.vimeoPlayerIdPrefix+e,f.vimeoClickToPlay))):c.call(this,a,b)}}),b}),function(a){"use strict";"function"==typeof define&&define.amd?define(["./blueimp-helper","./blueimp-gallery-video"],a):a(window.blueimp.helper||window.jQuery,window.blueimp.Gallery)}(function(a,b){"use strict";if(!window.postMessage)return b;a.extend(b.prototype.options,{youTubeVideoIdProperty:"youtube",youTubePlayerVars:{wmode:"transparent"},youTubeClickToPlay:!0});var c=b.prototype.textFactory||b.prototype.imageFactory,d=function(a,b,c){this.videoId=a,this.playerVars=b,this.clickToPlay=c,this.element=document.createElement("div"),this.listeners={}};return a.extend(d.prototype,{canPlayType:function(){return!0},on:function(a,b){return this.listeners[a]=b,this},loadAPI:function(){var a,b=this,c=window.onYouTubeIframeAPIReady,d="//www.youtube.com/iframe_api",e=document.getElementsByTagName("script"),f=e.length;for(window.onYouTubeIframeAPIReady=function(){c&&c.apply(this),b.playOnReady&&b.play()};f;)if(f-=1,e[f].src===d)return;a=document.createElement("script"),a.src=d,e[0].parentNode.insertBefore(a,e[0])},onReady:function(){this.ready=!0,this.playOnReady&&this.play()},onPlaying:function(){this.playStatus<2&&(this.listeners.playing(),this.playStatus=2)},onPause:function(){b.prototype.setTimeout.call(this,this.checkSeek,null,2e3)},checkSeek:function(){(this.stateChange===YT.PlayerState.PAUSED||this.stateChange===YT.PlayerState.ENDED)&&(this.listeners.pause(),delete this.playStatus)},onStateChange:function(a){switch(a.data){case YT.PlayerState.PLAYING:this.hasPlayed=!0,this.onPlaying();break;case YT.PlayerState.PAUSED:case YT.PlayerState.ENDED:this.onPause()}this.stateChange=a.data},onError:function(a){this.listeners.error(a)},play:function(){var a=this;this.playStatus||(this.listeners.play(),this.playStatus=1),this.ready?!this.hasPlayed&&(this.clickToPlay||window.navigator&&/iP(hone|od|ad)/.test(window.navigator.platform))?this.onPlaying():this.player.playVideo():(this.playOnReady=!0,window.YT&&YT.Player?this.player||(this.player=new YT.Player(this.element,{videoId:this.videoId,playerVars:this.playerVars,events:{onReady:function(){a.onReady()},onStateChange:function(b){a.onStateChange(b)},onError:function(b){a.onError(b)}}})):this.loadAPI())},pause:function(){this.ready?this.player.pauseVideo():this.playStatus&&(delete this.playOnReady,this.listeners.pause(),delete this.playStatus)}}),a.extend(b.prototype,{YouTubePlayer:d,textFactory:function(a,b){var e=this.options,f=this.getItemProperty(a,e.youTubeVideoIdProperty);return f?(void 0===this.getItemProperty(a,e.urlProperty)&&(a[e.urlProperty]="//www.youtube.com/watch?v="+f),void 0===this.getItemProperty(a,e.videoPosterProperty)&&(a[e.videoPosterProperty]="//img.youtube.com/vi/"+f+"/maxresdefault.jpg"),this.videoFactory(a,b,new d(f,e.youTubePlayerVars,e.youTubeClickToPlay))):c.call(this,a,b)}}),b}),function(a){"use strict";"function"==typeof define&&define.amd?define(["jquery","./blueimp-gallery"],a):a(window.jQuery,window.blueimp.Gallery)}(function(a,b){"use strict";a(document).on("click","[data-gallery]",function(c){var d=a(this).data("gallery"),e=a(d),f=e.length&&e||a(b.prototype.options.container),g={onopen:function(){f.data("gallery",this).trigger("open")},onopened:function(){f.trigger("opened")},onslide:function(){f.trigger("slide",arguments)},onslideend:function(){f.trigger("slideend",arguments)},onslidecomplete:function(){f.trigger("slidecomplete",arguments)},onclose:function(){f.trigger("close")},onclosed:function(){f.trigger("closed").removeData("gallery")}},h=a.extend(f.data(),{container:f[0],index:this,event:c},g),i=a('[data-gallery="'+d+'"]');return h.filter&&(i=i.filter(h.filter)),new b(i,h)})});

/* =========================================================
 * bootstrap-datepicker.js
 * Repo: https://github.com/eternicode/bootstrap-datepicker/
 * Demo: http://eternicode.github.io/bootstrap-datepicker/
 * Docs: http://bootstrap-datepicker.readthedocs.org/
 * Forked from http://www.eyecon.ro/bootstrap-datepicker
 * =========================================================
 * Started by Stefan Petre; improvements by Andrew Rowls + contributors
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */

(function($, undefined){

    var $window = $(window);

    function UTCDate(){
        return new Date(Date.UTC.apply(Date, arguments));
    }
    function UTCToday(){
        var today = new Date();
        return UTCDate(today.getFullYear(), today.getMonth(), today.getDate());
    }
    function alias(method){
        return function(){
            return this[method].apply(this, arguments);
        };
    }

    var DateArray = (function(){
        var extras = {
            get: function(i){
                return this.slice(i)[0];
            },
            contains: function(d){
                // Array.indexOf is not cross-browser;
                // $.inArray doesn't work with Dates
                var val = d && d.valueOf();
                for (var i=0, l=this.length; i < l; i++)
                    if (this[i].valueOf() === val)
                        return i;
                return -1;
            },
            remove: function(i){
                this.splice(i,1);
            },
            replace: function(new_array){
                if (!new_array)
                    return;
                if (!$.isArray(new_array))
                    new_array = [new_array];
                this.clear();
                this.push.apply(this, new_array);
            },
            clear: function(){
                this.length = 0;
            },
            copy: function(){
                var a = new DateArray();
                a.replace(this);
                return a;
            }
        };

        return function(){
            var a = [];
            a.push.apply(a, arguments);
            $.extend(a, extras);
            return a;
        };
    })();


    // Picker object

    var Datepicker = function(element, options){
        this.dates = new DateArray();
        this.viewDate = UTCToday();
        this.focusDate = null;

        this._process_options(options);

        this.element = $(element);
        this.isInline = false;
        this.isInput = this.element.is('input');
        this.component = this.element.is('.date') ? this.element.find('.add-on, .input-group-addon, .btn') : false;
        this.hasInput = this.component && this.element.find('input').length;
        if (this.component && this.component.length === 0)
            this.component = false;

        this.picker = $(DPGlobal.template);
        this._buildEvents();
        this._attachEvents();

        if (this.isInline){
            this.picker.addClass('datepicker-inline').appendTo(this.element);
        }
        else {
            this.picker.addClass('datepicker-dropdown dropdown-menu');
        }

        if (this.o.rtl){
            this.picker.addClass('datepicker-rtl');
        }

        this.viewMode = this.o.startView;

        if (this.o.calendarWeeks)
            this.picker.find('tfoot th.today, tfoot th.clear')
                .attr('colspan', function(i, val){
                    return parseInt(val) + 1;
                });

        this._allow_update = false;

        this.setStartDate(this._o.startDate);
        this.setEndDate(this._o.endDate);
        this.setDaysOfWeekDisabled(this.o.daysOfWeekDisabled);

        this.fillDow();
        this.fillMonths();

        this._allow_update = true;

        this.update();
        this.showMode();

        if (this.isInline){
            this.show();
        }
    };

    Datepicker.prototype = {
        constructor: Datepicker,

        _process_options: function(opts){
            // Store raw options for reference
            this._o = $.extend({}, this._o, opts);
            // Processed options
            var o = this.o = $.extend({}, this._o);

            // Check if "de-DE" style date is available, if not language should
            // fallback to 2 letter code eg "de"
            var lang = o.language;
            if (!dates[lang]){
                lang = lang.split('-')[0];
                if (!dates[lang])
                    lang = defaults.language;
            }
            o.language = lang;

            switch (o.startView){
                case 2:
                case 'decade':
                    o.startView = 2;
                    break;
                case 1:
                case 'year':
                    o.startView = 1;
                    break;
                default:
                    o.startView = 0;
            }

            switch (o.minViewMode){
                case 1:
                case 'months':
                    o.minViewMode = 1;
                    break;
                case 2:
                case 'years':
                    o.minViewMode = 2;
                    break;
                default:
                    o.minViewMode = 0;
            }

            o.startView = Math.max(o.startView, o.minViewMode);

            // true, false, or Number > 0
            if (o.multidate !== true){
                o.multidate = Number(o.multidate) || false;
                if (o.multidate !== false)
                    o.multidate = Math.max(0, o.multidate);
                else
                    o.multidate = 1;
            }
            o.multidateSeparator = String(o.multidateSeparator);

            o.weekStart %= 7;
            o.weekEnd = ((o.weekStart + 6) % 7);

            var format = DPGlobal.parseFormat(o.format);
            if (o.startDate !== -Infinity){
                if (!!o.startDate){
                    if (o.startDate instanceof Date)
                        o.startDate = this._local_to_utc(this._zero_time(o.startDate));
                    else
                        o.startDate = DPGlobal.parseDate(o.startDate, format, o.language);
                }
                else {
                    o.startDate = -Infinity;
                }
            }
            if (o.endDate !== Infinity){
                if (!!o.endDate){
                    if (o.endDate instanceof Date)
                        o.endDate = this._local_to_utc(this._zero_time(o.endDate));
                    else
                        o.endDate = DPGlobal.parseDate(o.endDate, format, o.language);
                }
                else {
                    o.endDate = Infinity;
                }
            }

            o.daysOfWeekDisabled = o.daysOfWeekDisabled||[];
            if (!$.isArray(o.daysOfWeekDisabled))
                o.daysOfWeekDisabled = o.daysOfWeekDisabled.split(/[,\s]*/);
            o.daysOfWeekDisabled = $.map(o.daysOfWeekDisabled, function(d){
                return parseInt(d, 10);
            });

            var plc = String(o.orientation).toLowerCase().split(/\s+/g),
                _plc = o.orientation.toLowerCase();
            plc = $.grep(plc, function(word){
                return (/^auto|left|right|top|bottom$/).test(word);
            });
            o.orientation = {x: 'auto', y: 'auto'};
            if (!_plc || _plc === 'auto')
                ; // no action
            else if (plc.length === 1){
                switch (plc[0]){
                    case 'top':
                    case 'bottom':
                        o.orientation.y = plc[0];
                        break;
                    case 'left':
                    case 'right':
                        o.orientation.x = plc[0];
                        break;
                }
            }
            else {
                _plc = $.grep(plc, function(word){
                    return (/^left|right$/).test(word);
                });
                o.orientation.x = _plc[0] || 'auto';

                _plc = $.grep(plc, function(word){
                    return (/^top|bottom$/).test(word);
                });
                o.orientation.y = _plc[0] || 'auto';
            }
        },
        _events: [],
        _secondaryEvents: [],
        _applyEvents: function(evs){
            for (var i=0, el, ch, ev; i < evs.length; i++){
                el = evs[i][0];
                if (evs[i].length === 2){
                    ch = undefined;
                    ev = evs[i][1];
                }
                else if (evs[i].length === 3){
                    ch = evs[i][1];
                    ev = evs[i][2];
                }
                el.on(ev, ch);
            }
        },
        _unapplyEvents: function(evs){
            for (var i=0, el, ev, ch; i < evs.length; i++){
                el = evs[i][0];
                if (evs[i].length === 2){
                    ch = undefined;
                    ev = evs[i][1];
                }
                else if (evs[i].length === 3){
                    ch = evs[i][1];
                    ev = evs[i][2];
                }
                el.off(ev, ch);
            }
        },
        _buildEvents: function(){
            if (this.isInput){ // single input
                this._events = [
                    [this.element, {
                        focus: $.proxy(this.show, this),
                        keyup: $.proxy(function(e){
                            if ($.inArray(e.keyCode, [27,37,39,38,40,32,13,9]) === -1)
                                this.update();
                        }, this),
                        keydown: $.proxy(this.keydown, this)
                    }]
                ];
            }
            else if (this.component && this.hasInput){ // component: input + button
                this._events = [
                    // For components that are not readonly, allow keyboard nav
                    [this.element.find('input'), {
                        focus: $.proxy(this.show, this),
                        keyup: $.proxy(function(e){
                            if ($.inArray(e.keyCode, [27,37,39,38,40,32,13,9]) === -1)
                                this.update();
                        }, this),
                        keydown: $.proxy(this.keydown, this)
                    }],
                    [this.component, {
                        click: $.proxy(this.show, this)
                    }]
                ];
            }
            else if (this.element.is('div')){  // inline datepicker
                this.isInline = true;
            }
            else {
                this._events = [
                    [this.element, {
                        click: $.proxy(this.show, this)
                    }]
                ];
            }
            this._events.push(
                // Component: listen for blur on element descendants
                [this.element, '*', {
                    blur: $.proxy(function(e){
                        this._focused_from = e.target;
                    }, this)
                }],
                // Input: listen for blur on element
                [this.element, {
                    blur: $.proxy(function(e){
                        this._focused_from = e.target;
                    }, this)
                }]
            );

            this._secondaryEvents = [
                [this.picker, {
                    click: $.proxy(this.click, this)
                }],
                [$(window), {
                    resize: $.proxy(this.place, this)
                }],
                [$(document), {
                    'mousedown touchstart': $.proxy(function(e){
                        // Clicked outside the datepicker, hide it
                        if (!(
                                this.element.is(e.target) ||
                                this.element.find(e.target).length ||
                                this.picker.is(e.target) ||
                                this.picker.find(e.target).length
                            )){
                            this.hide();
                        }
                    }, this)
                }]
            ];
        },
        _attachEvents: function(){
            this._detachEvents();
            this._applyEvents(this._events);
        },
        _detachEvents: function(){
            this._unapplyEvents(this._events);
        },
        _attachSecondaryEvents: function(){
            this._detachSecondaryEvents();
            this._applyEvents(this._secondaryEvents);
        },
        _detachSecondaryEvents: function(){
            this._unapplyEvents(this._secondaryEvents);
        },
        _trigger: function(event, altdate){
            var date = altdate || this.dates.get(-1),
                local_date = this._utc_to_local(date);

            this.element.trigger({
                type: event,
                date: local_date,
                dates: $.map(this.dates, this._utc_to_local),
                format: $.proxy(function(ix, format){
                    if (arguments.length === 0){
                        ix = this.dates.length - 1;
                        format = this.o.format;
                    }
                    else if (typeof ix === 'string'){
                        format = ix;
                        ix = this.dates.length - 1;
                    }
                    format = format || this.o.format;
                    var date = this.dates.get(ix);
                    return DPGlobal.formatDate(date, format, this.o.language);
                }, this)
            });
        },

        show: function(){
            if (!this.isInline)
                this.picker.appendTo('body');
            this.picker.show();
            this.place();
            this._attachSecondaryEvents();
            this._trigger('show');
        },

        hide: function(){
            if (this.isInline)
                return;
            if (!this.picker.is(':visible'))
                return;
            this.focusDate = null;
            this.picker.hide().detach();
            this._detachSecondaryEvents();
            this.viewMode = this.o.startView;
            this.showMode();

            if (
                this.o.forceParse &&
                (
                    this.isInput && this.element.val() ||
                    this.hasInput && this.element.find('input').val()
                )
            )
                this.setValue();
            this._trigger('hide');
        },

        remove: function(){
            this.hide();
            this._detachEvents();
            this._detachSecondaryEvents();
            this.picker.remove();
            delete this.element.data().datepicker;
            if (!this.isInput){
                delete this.element.data().date;
            }
        },

        _utc_to_local: function(utc){
            return utc && new Date(utc.getTime() + (utc.getTimezoneOffset()*60000));
        },
        _local_to_utc: function(local){
            return local && new Date(local.getTime() - (local.getTimezoneOffset()*60000));
        },
        _zero_time: function(local){
            return local && new Date(local.getFullYear(), local.getMonth(), local.getDate());
        },
        _zero_utc_time: function(utc){
            return utc && new Date(Date.UTC(utc.getUTCFullYear(), utc.getUTCMonth(), utc.getUTCDate()));
        },

        getDates: function(){
            return $.map(this.dates, this._utc_to_local);
        },

        getUTCDates: function(){
            return $.map(this.dates, function(d){
                return new Date(d);
            });
        },

        getDate: function(){
            return this._utc_to_local(this.getUTCDate());
        },

        getUTCDate: function(){
            return new Date(this.dates.get(-1));
        },

        setDates: function(){
            var args = $.isArray(arguments[0]) ? arguments[0] : arguments;
            this.update.apply(this, args);
            this._trigger('changeDate');
            this.setValue();
        },

        setUTCDates: function(){
            var args = $.isArray(arguments[0]) ? arguments[0] : arguments;
            this.update.apply(this, $.map(args, this._utc_to_local));
            this._trigger('changeDate');
            this.setValue();
        },

        setDate: alias('setDates'),
        setUTCDate: alias('setUTCDates'),

        setValue: function(){
            var formatted = this.getFormattedDate();
            if (!this.isInput){
                if (this.component){
                    this.element.find('input').val(formatted).change();
                }
            }
            else {
                this.element.val(formatted).change();
            }
        },

        getFormattedDate: function(format){
            if (format === undefined)
                format = this.o.format;

            var lang = this.o.language;
            return $.map(this.dates, function(d){
                return DPGlobal.formatDate(d, format, lang);
            }).join(this.o.multidateSeparator);
        },

        setStartDate: function(startDate){
            this._process_options({startDate: startDate});
            this.update();
            this.updateNavArrows();
        },

        setEndDate: function(endDate){
            this._process_options({endDate: endDate});
            this.update();
            this.updateNavArrows();
        },

        setDaysOfWeekDisabled: function(daysOfWeekDisabled){
            this._process_options({daysOfWeekDisabled: daysOfWeekDisabled});
            this.update();
            this.updateNavArrows();
        },

        place: function(){
            if (this.isInline)
                return;
            var calendarWidth = this.picker.outerWidth(),
                calendarHeight = this.picker.outerHeight(),
                visualPadding = 10,
                windowWidth = $window.width(),
                windowHeight = $window.height(),
                scrollTop = $window.scrollTop();

            var parentsZindex = [];
            this.element.parents().each(function() {
                var itemZIndex = $(this).css('z-index');
                if ( itemZIndex !== 'auto' && itemZIndex !== 0 ) parentsZindex.push( parseInt( itemZIndex ) );
            });
            var zIndex = Math.max.apply( Math, parentsZindex ) + 10;
            var offset = this.component ? this.component.parent().offset() : this.element.offset();
            var height = this.component ? this.component.outerHeight(true) : this.element.outerHeight(false);
            var width = this.component ? this.component.outerWidth(true) : this.element.outerWidth(false);
            var left = offset.left,
                top = offset.top;

            this.picker.removeClass(
                'datepicker-orient-top datepicker-orient-bottom '+
                'datepicker-orient-right datepicker-orient-left'
            );

            if (this.o.orientation.x !== 'auto'){
                this.picker.addClass('datepicker-orient-' + this.o.orientation.x);
                if (this.o.orientation.x === 'right')
                    left -= calendarWidth - width;
            }
            // auto x orientation is best-placement: if it crosses a window
            // edge, fudge it sideways
            else {
                // Default to left
                this.picker.addClass('datepicker-orient-left');
                if (offset.left < 0)
                    left -= offset.left - visualPadding;
                else if (offset.left + calendarWidth > windowWidth)
                    left = windowWidth - calendarWidth - visualPadding;
            }

            // auto y orientation is best-situation: top or bottom, no fudging,
            // decision based on which shows more of the calendar
            var yorient = this.o.orientation.y,
                top_overflow, bottom_overflow;
            if (yorient === 'auto'){
                top_overflow = -scrollTop + offset.top - calendarHeight;
                bottom_overflow = scrollTop + windowHeight - (offset.top + height + calendarHeight);
                if (Math.max(top_overflow, bottom_overflow) === bottom_overflow)
                    yorient = 'top';
                else
                    yorient = 'bottom';
            }
            this.picker.addClass('datepicker-orient-' + yorient);
            if (yorient === 'top')
                top += height;
            else
                top -= calendarHeight + parseInt(this.picker.css('padding-top'));

            this.picker.css({
                top: top,
                left: left,
                zIndex: zIndex
            });
        },

        _allow_update: true,
        update: function(){
            if (!this._allow_update)
                return;

            var oldDates = this.dates.copy(),
                dates = [],
                fromArgs = false;
            if (arguments.length){
                $.each(arguments, $.proxy(function(i, date){
                    if (date instanceof Date)
                        date = this._local_to_utc(date);
                    dates.push(date);
                }, this));
                fromArgs = true;
            }
            else {
                dates = this.isInput
                    ? this.element.val()
                    : this.element.data('date') || this.element.find('input').val();
                if (dates && this.o.multidate)
                    dates = dates.split(this.o.multidateSeparator);
                else
                    dates = [dates];
                delete this.element.data().date;
            }

            dates = $.map(dates, $.proxy(function(date){
                return DPGlobal.parseDate(date, this.o.format, this.o.language);
            }, this));
            dates = $.grep(dates, $.proxy(function(date){
                return (
                    date < this.o.startDate ||
                    date > this.o.endDate ||
                    !date
                );
            }, this), true);
            this.dates.replace(dates);

            if (this.dates.length)
                this.viewDate = new Date(this.dates.get(-1));
            else if (this.viewDate < this.o.startDate)
                this.viewDate = new Date(this.o.startDate);
            else if (this.viewDate > this.o.endDate)
                this.viewDate = new Date(this.o.endDate);

            if (fromArgs){
                // setting date by clicking
                this.setValue();
            }
            else if (dates.length){
                // setting date by typing
                if (String(oldDates) !== String(this.dates))
                    this._trigger('changeDate');
            }
            if (!this.dates.length && oldDates.length)
                this._trigger('clearDate');

            this.fill();
        },

        fillDow: function(){
            var dowCnt = this.o.weekStart,
                html = '<tr>';
            if (this.o.calendarWeeks){
                var cell = '<th class="cw">&nbsp;</th>';
                html += cell;
                this.picker.find('.datepicker-days thead tr:first-child').prepend(cell);
            }
            while (dowCnt < this.o.weekStart + 7){
                html += '<th class="dow">'+dates[this.o.language].daysMin[(dowCnt++)%7]+'</th>';
            }
            html += '</tr>';
            this.picker.find('.datepicker-days thead').append(html);
        },

        fillMonths: function(){
            var html = '',
                i = 0;
            while (i < 12){
                html += '<span class="month">'+dates[this.o.language].monthsShort[i++]+'</span>';
            }
            this.picker.find('.datepicker-months td').html(html);
        },

        setRange: function(range){
            if (!range || !range.length)
                delete this.range;
            else
                this.range = $.map(range, function(d){
                    return d.valueOf();
                });
            this.fill();
        },

        getClassNames: function(date){
            var cls = [],
                year = this.viewDate.getUTCFullYear(),
                month = this.viewDate.getUTCMonth(),
                today = new Date();
            if (date.getUTCFullYear() < year || (date.getUTCFullYear() === year && date.getUTCMonth() < month)){
                cls.push('old');
            }
            else if (date.getUTCFullYear() > year || (date.getUTCFullYear() === year && date.getUTCMonth() > month)){
                cls.push('new');
            }
            if (this.focusDate && date.valueOf() === this.focusDate.valueOf())
                cls.push('focused');
            // Compare internal UTC date with local today, not UTC today
            if (this.o.todayHighlight &&
                date.getUTCFullYear() === today.getFullYear() &&
                date.getUTCMonth() === today.getMonth() &&
                date.getUTCDate() === today.getDate()){
                cls.push('today');
            }
            if (this.dates.contains(date) !== -1)
                cls.push('active');
            if (date.valueOf() < this.o.startDate || date.valueOf() > this.o.endDate ||
                $.inArray(date.getUTCDay(), this.o.daysOfWeekDisabled) !== -1){
                cls.push('disabled');
            }
            if (this.range){
                if (date > this.range[0] && date < this.range[this.range.length-1]){
                    cls.push('range');
                }
                if ($.inArray(date.valueOf(), this.range) !== -1){
                    cls.push('selected');
                }
            }
            return cls;
        },

        fill: function(){
            var d = new Date(this.viewDate),
                year = d.getUTCFullYear(),
                month = d.getUTCMonth(),
                startYear = this.o.startDate !== -Infinity ? this.o.startDate.getUTCFullYear() : -Infinity,
                startMonth = this.o.startDate !== -Infinity ? this.o.startDate.getUTCMonth() : -Infinity,
                endYear = this.o.endDate !== Infinity ? this.o.endDate.getUTCFullYear() : Infinity,
                endMonth = this.o.endDate !== Infinity ? this.o.endDate.getUTCMonth() : Infinity,
                todaytxt = dates[this.o.language].today || dates['en'].today || '',
                cleartxt = dates[this.o.language].clear || dates['en'].clear || '',
                tooltip;
            if (isNaN(year) || isNaN(month)) return;
            this.picker.find('.datepicker-days thead th.datepicker-switch')
                .text(dates[this.o.language].months[month]+' '+year);
            this.picker.find('tfoot th.today')
                .text(todaytxt)
                .toggle(this.o.todayBtn !== false);
            this.picker.find('tfoot th.clear')
                .text(cleartxt)
                .toggle(this.o.clearBtn !== false);
            this.updateNavArrows();
            this.fillMonths();
            var prevMonth = UTCDate(year, month-1, 28),
                day = DPGlobal.getDaysInMonth(prevMonth.getUTCFullYear(), prevMonth.getUTCMonth());
            prevMonth.setUTCDate(day);
            prevMonth.setUTCDate(day - (prevMonth.getUTCDay() - this.o.weekStart + 7)%7);
            var nextMonth = new Date(prevMonth);
            nextMonth.setUTCDate(nextMonth.getUTCDate() + 42);
            nextMonth = nextMonth.valueOf();
            var html = [];
            var clsName;
            while (prevMonth.valueOf() < nextMonth){
                if (prevMonth.getUTCDay() === this.o.weekStart){
                    html.push('<tr>');
                    if (this.o.calendarWeeks){
                        // ISO 8601: First week contains first thursday.
                        // ISO also states week starts on Monday, but we can be more abstract here.
                        var
                        // Start of current week: based on weekstart/current date
                            ws = new Date(+prevMonth + (this.o.weekStart - prevMonth.getUTCDay() - 7) % 7 * 864e5),
                        // Thursday of this week
                            th = new Date(Number(ws) + (7 + 4 - ws.getUTCDay()) % 7 * 864e5),
                        // First Thursday of year, year from thursday
                            yth = new Date(Number(yth = UTCDate(th.getUTCFullYear(), 0, 1)) + (7 + 4 - yth.getUTCDay())%7*864e5),
                        // Calendar week: ms between thursdays, div ms per day, div 7 days
                            calWeek =  (th - yth) / 864e5 / 7 + 1;
                        html.push('<td class="cw">'+ calWeek +'</td>');

                    }
                }
                clsName = this.getClassNames(prevMonth);
                clsName.push('day');

                if (this.o.beforeShowDay !== $.noop){
                    var before = this.o.beforeShowDay(this._utc_to_local(prevMonth));
                    if (before === undefined)
                        before = {};
                    else if (typeof(before) === 'boolean')
                        before = {enabled: before};
                    else if (typeof(before) === 'string')
                        before = {classes: before};
                    if (before.enabled === false)
                        clsName.push('disabled');
                    if (before.classes)
                        clsName = clsName.concat(before.classes.split(/\s+/));
                    if (before.tooltip)
                        tooltip = before.tooltip;
                }

                clsName = $.unique(clsName);
                html.push('<td class="'+clsName.join(' ')+'"' + (tooltip ? ' title="'+tooltip+'"' : '') + '>'+prevMonth.getUTCDate() + '</td>');
                tooltip = null;
                if (prevMonth.getUTCDay() === this.o.weekEnd){
                    html.push('</tr>');
                }
                prevMonth.setUTCDate(prevMonth.getUTCDate()+1);
            }
            this.picker.find('.datepicker-days tbody').empty().append(html.join(''));

            var months = this.picker.find('.datepicker-months')
                .find('th:eq(1)')
                .text(year)
                .end()
                .find('span').removeClass('active');

            $.each(this.dates, function(i, d){
                if (d.getUTCFullYear() === year)
                    months.eq(d.getUTCMonth()).addClass('active');
            });

            if (year < startYear || year > endYear){
                months.addClass('disabled');
            }
            if (year === startYear){
                months.slice(0, startMonth).addClass('disabled');
            }
            if (year === endYear){
                months.slice(endMonth+1).addClass('disabled');
            }

            html = '';
            year = parseInt(year/10, 10) * 10;
            var yearCont = this.picker.find('.datepicker-years')
                .find('th:eq(1)')
                .text(year + '-' + (year + 9))
                .end()
                .find('td');
            year -= 1;
            var years = $.map(this.dates, function(d){
                    return d.getUTCFullYear();
                }),
                classes;
            for (var i = -1; i < 11; i++){
                classes = ['year'];
                if (i === -1)
                    classes.push('old');
                else if (i === 10)
                    classes.push('new');
                if ($.inArray(year, years) !== -1)
                    classes.push('active');
                if (year < startYear || year > endYear)
                    classes.push('disabled');
                html += '<span class="' + classes.join(' ') + '">'+year+'</span>';
                year += 1;
            }
            yearCont.html(html);
        },

        updateNavArrows: function(){
            if (!this._allow_update)
                return;

            var d = new Date(this.viewDate),
                year = d.getUTCFullYear(),
                month = d.getUTCMonth();
            switch (this.viewMode){
                case 0:
                    if (this.o.startDate !== -Infinity && year <= this.o.startDate.getUTCFullYear() && month <= this.o.startDate.getUTCMonth()){
                        this.picker.find('.prev').css({visibility: 'hidden'});
                    }
                    else {
                        this.picker.find('.prev').css({visibility: 'visible'});
                    }
                    if (this.o.endDate !== Infinity && year >= this.o.endDate.getUTCFullYear() && month >= this.o.endDate.getUTCMonth()){
                        this.picker.find('.next').css({visibility: 'hidden'});
                    }
                    else {
                        this.picker.find('.next').css({visibility: 'visible'});
                    }
                    break;
                case 1:
                case 2:
                    if (this.o.startDate !== -Infinity && year <= this.o.startDate.getUTCFullYear()){
                        this.picker.find('.prev').css({visibility: 'hidden'});
                    }
                    else {
                        this.picker.find('.prev').css({visibility: 'visible'});
                    }
                    if (this.o.endDate !== Infinity && year >= this.o.endDate.getUTCFullYear()){
                        this.picker.find('.next').css({visibility: 'hidden'});
                    }
                    else {
                        this.picker.find('.next').css({visibility: 'visible'});
                    }
                    break;
            }
        },

        click: function(e){
            e.preventDefault();
            var target = $(e.target).closest('span, td, th'),
                year, month, day;
            if (target.length === 1){
                switch (target[0].nodeName.toLowerCase()){
                    case 'th':
                        switch (target[0].className){
                            case 'datepicker-switch':
                                this.showMode(1);
                                break;
                            case 'prev':
                            case 'next':
                                var dir = DPGlobal.modes[this.viewMode].navStep * (target[0].className === 'prev' ? -1 : 1);
                                switch (this.viewMode){
                                    case 0:
                                        this.viewDate = this.moveMonth(this.viewDate, dir);
                                        this._trigger('changeMonth', this.viewDate);
                                        break;
                                    case 1:
                                    case 2:
                                        this.viewDate = this.moveYear(this.viewDate, dir);
                                        if (this.viewMode === 1)
                                            this._trigger('changeYear', this.viewDate);
                                        break;
                                }
                                this.fill();
                                break;
                            case 'today':
                                var date = new Date();
                                date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0);

                                this.showMode(-2);
                                var which = this.o.todayBtn === 'linked' ? null : 'view';
                                this._setDate(date, which);
                                break;
                            case 'clear':
                                var element;
                                if (this.isInput)
                                    element = this.element;
                                else if (this.component)
                                    element = this.element.find('input');
                                if (element)
                                    element.val("").change();
                                this.update();
                                this._trigger('changeDate');
                                if (this.o.autoclose)
                                    this.hide();
                                break;
                        }
                        break;
                    case 'span':
                        if (!target.is('.disabled')){
                            this.viewDate.setUTCDate(1);
                            if (target.is('.month')){
                                day = 1;
                                month = target.parent().find('span').index(target);
                                year = this.viewDate.getUTCFullYear();
                                this.viewDate.setUTCMonth(month);
                                this._trigger('changeMonth', this.viewDate);
                                if (this.o.minViewMode === 1){
                                    this._setDate(UTCDate(year, month, day));
                                }
                            }
                            else {
                                day = 1;
                                month = 0;
                                year = parseInt(target.text(), 10)||0;
                                this.viewDate.setUTCFullYear(year);
                                this._trigger('changeYear', this.viewDate);
                                if (this.o.minViewMode === 2){
                                    this._setDate(UTCDate(year, month, day));
                                }
                            }
                            this.showMode(-1);
                            this.fill();
                        }
                        break;
                    case 'td':
                        if (target.is('.day') && !target.is('.disabled')){
                            day = parseInt(target.text(), 10)||1;
                            year = this.viewDate.getUTCFullYear();
                            month = this.viewDate.getUTCMonth();
                            if (target.is('.old')){
                                if (month === 0){
                                    month = 11;
                                    year -= 1;
                                }
                                else {
                                    month -= 1;
                                }
                            }
                            else if (target.is('.new')){
                                if (month === 11){
                                    month = 0;
                                    year += 1;
                                }
                                else {
                                    month += 1;
                                }
                            }
                            this._setDate(UTCDate(year, month, day));
                        }
                        break;
                }
            }
            if (this.picker.is(':visible') && this._focused_from){
                $(this._focused_from).focus();
            }
            delete this._focused_from;
        },

        _toggle_multidate: function(date){
            var ix = this.dates.contains(date);
            if (!date){
                this.dates.clear();
            }
            if (this.o.multidate === 1 && ix === 0){
                // single datepicker, don't remove selected date
            }
            else if (ix !== -1){
                this.dates.remove(ix);
            }
            else {
                this.dates.push(date);
            }
            if (typeof this.o.multidate === 'number')
                while (this.dates.length > this.o.multidate)
                    this.dates.remove(0);
        },

        _setDate: function(date, which){
            if (!which || which === 'date')
                this._toggle_multidate(date && new Date(date));
            if (!which || which  === 'view')
                this.viewDate = date && new Date(date);

            this.fill();
            this.setValue();
            this._trigger('changeDate');
            var element;
            if (this.isInput){
                element = this.element;
            }
            else if (this.component){
                element = this.element.find('input');
            }
            if (element){
                element.change();
            }
            if (this.o.autoclose && (!which || which === 'date')){
                this.hide();
            }
        },

        moveMonth: function(date, dir){
            if (!date)
                return undefined;
            if (!dir)
                return date;
            var new_date = new Date(date.valueOf()),
                day = new_date.getUTCDate(),
                month = new_date.getUTCMonth(),
                mag = Math.abs(dir),
                new_month, test;
            dir = dir > 0 ? 1 : -1;
            if (mag === 1){
                test = dir === -1
                    // If going back one month, make sure month is not current month
                    // (eg, Mar 31 -> Feb 31 == Feb 28, not Mar 02)
                    ? function(){
                    return new_date.getUTCMonth() === month;
                }
                    // If going forward one month, make sure month is as expected
                    // (eg, Jan 31 -> Feb 31 == Feb 28, not Mar 02)
                    : function(){
                    return new_date.getUTCMonth() !== new_month;
                };
                new_month = month + dir;
                new_date.setUTCMonth(new_month);
                // Dec -> Jan (12) or Jan -> Dec (-1) -- limit expected date to 0-11
                if (new_month < 0 || new_month > 11)
                    new_month = (new_month + 12) % 12;
            }
            else {
                // For magnitudes >1, move one month at a time...
                for (var i=0; i < mag; i++)
                    // ...which might decrease the day (eg, Jan 31 to Feb 28, etc)...
                    new_date = this.moveMonth(new_date, dir);
                // ...then reset the day, keeping it in the new month
                new_month = new_date.getUTCMonth();
                new_date.setUTCDate(day);
                test = function(){
                    return new_month !== new_date.getUTCMonth();
                };
            }
            // Common date-resetting loop -- if date is beyond end of month, make it
            // end of month
            while (test()){
                new_date.setUTCDate(--day);
                new_date.setUTCMonth(new_month);
            }
            return new_date;
        },

        moveYear: function(date, dir){
            return this.moveMonth(date, dir*12);
        },

        dateWithinRange: function(date){
            return date >= this.o.startDate && date <= this.o.endDate;
        },

        keydown: function(e){
            if (this.picker.is(':not(:visible)')){
                if (e.keyCode === 27) // allow escape to hide and re-show picker
                    this.show();
                return;
            }
            var dateChanged = false,
                dir, newDate, newViewDate,
                focusDate = this.focusDate || this.viewDate;
            switch (e.keyCode){
                case 27: // escape
                    if (this.focusDate){
                        this.focusDate = null;
                        this.viewDate = this.dates.get(-1) || this.viewDate;
                        this.fill();
                    }
                    else
                        this.hide();
                    e.preventDefault();
                    break;
                case 37: // left
                case 39: // right
                    if (!this.o.keyboardNavigation)
                        break;
                    dir = e.keyCode === 37 ? -1 : 1;
                    if (e.ctrlKey){
                        newDate = this.moveYear(this.dates.get(-1) || UTCToday(), dir);
                        newViewDate = this.moveYear(focusDate, dir);
                        this._trigger('changeYear', this.viewDate);
                    }
                    else if (e.shiftKey){
                        newDate = this.moveMonth(this.dates.get(-1) || UTCToday(), dir);
                        newViewDate = this.moveMonth(focusDate, dir);
                        this._trigger('changeMonth', this.viewDate);
                    }
                    else {
                        newDate = new Date(this.dates.get(-1) || UTCToday());
                        newDate.setUTCDate(newDate.getUTCDate() + dir);
                        newViewDate = new Date(focusDate);
                        newViewDate.setUTCDate(focusDate.getUTCDate() + dir);
                    }
                    if (this.dateWithinRange(newDate)){
                        this.focusDate = this.viewDate = newViewDate;
                        this.setValue();
                        this.fill();
                        e.preventDefault();
                    }
                    break;
                case 38: // up
                case 40: // down
                    if (!this.o.keyboardNavigation)
                        break;
                    dir = e.keyCode === 38 ? -1 : 1;
                    if (e.ctrlKey){
                        newDate = this.moveYear(this.dates.get(-1) || UTCToday(), dir);
                        newViewDate = this.moveYear(focusDate, dir);
                        this._trigger('changeYear', this.viewDate);
                    }
                    else if (e.shiftKey){
                        newDate = this.moveMonth(this.dates.get(-1) || UTCToday(), dir);
                        newViewDate = this.moveMonth(focusDate, dir);
                        this._trigger('changeMonth', this.viewDate);
                    }
                    else {
                        newDate = new Date(this.dates.get(-1) || UTCToday());
                        newDate.setUTCDate(newDate.getUTCDate() + dir * 7);
                        newViewDate = new Date(focusDate);
                        newViewDate.setUTCDate(focusDate.getUTCDate() + dir * 7);
                    }
                    if (this.dateWithinRange(newDate)){
                        this.focusDate = this.viewDate = newViewDate;
                        this.setValue();
                        this.fill();
                        e.preventDefault();
                    }
                    break;
                case 32: // spacebar
                    // Spacebar is used in manually typing dates in some formats.
                    // As such, its behavior should not be hijacked.
                    break;
                case 13: // enter
                    focusDate = this.focusDate || this.dates.get(-1) || this.viewDate;
                    if (this.o.keyboardNavigation) {
                        this._toggle_multidate(focusDate);
                        dateChanged = true;
                    }
                    this.focusDate = null;
                    this.viewDate = this.dates.get(-1) || this.viewDate;
                    this.setValue();
                    this.fill();
                    if (this.picker.is(':visible')){
                        e.preventDefault();
                        if (this.o.autoclose)
                            this.hide();
                    }
                    break;
                case 9: // tab
                    this.focusDate = null;
                    this.viewDate = this.dates.get(-1) || this.viewDate;
                    this.fill();
                    this.hide();
                    break;
            }
            if (dateChanged){
                if (this.dates.length)
                    this._trigger('changeDate');
                else
                    this._trigger('clearDate');
                var element;
                if (this.isInput){
                    element = this.element;
                }
                else if (this.component){
                    element = this.element.find('input');
                }
                if (element){
                    element.change();
                }
            }
        },

        showMode: function(dir){
            if (dir){
                this.viewMode = Math.max(this.o.minViewMode, Math.min(2, this.viewMode + dir));
            }
            this.picker
                .find('>div')
                .hide()
                .filter('.datepicker-'+DPGlobal.modes[this.viewMode].clsName)
                .css('display', 'block');
            this.updateNavArrows();
        }
    };

    var DateRangePicker = function(element, options){
        this.element = $(element);
        this.inputs = $.map(options.inputs, function(i){
            return i.jquery ? i[0] : i;
        });
        delete options.inputs;

        $(this.inputs)
            .datepicker(options)
            .bind('changeDate', $.proxy(this.dateUpdated, this));

        this.pickers = $.map(this.inputs, function(i){
            return $(i).data('datepicker');
        });
        this.updateDates();
    };
    DateRangePicker.prototype = {
        updateDates: function(){
            this.dates = $.map(this.pickers, function(i){
                return i.getUTCDate();
            });
            this.updateRanges();
        },
        updateRanges: function(){
            var range = $.map(this.dates, function(d){
                return d.valueOf();
            });
            $.each(this.pickers, function(i, p){
                p.setRange(range);
            });
        },
        dateUpdated: function(e){
            // `this.updating` is a workaround for preventing infinite recursion
            // between `changeDate` triggering and `setUTCDate` calling.  Until
            // there is a better mechanism.
            if (this.updating)
                return;
            this.updating = true;

            var dp = $(e.target).data('datepicker'),
                new_date = dp.getUTCDate(),
                i = $.inArray(e.target, this.inputs),
                l = this.inputs.length;
            if (i === -1)
                return;

            $.each(this.pickers, function(i, p){
                if (!p.getUTCDate())
                    p.setUTCDate(new_date);
            });

            if (new_date < this.dates[i]){
                // Date being moved earlier/left
                while (i >= 0 && new_date < this.dates[i]){
                    this.pickers[i--].setUTCDate(new_date);
                }
            }
            else if (new_date > this.dates[i]){
                // Date being moved later/right
                while (i < l && new_date > this.dates[i]){
                    this.pickers[i++].setUTCDate(new_date);
                }
            }
            this.updateDates();

            delete this.updating;
        },
        remove: function(){
            $.map(this.pickers, function(p){ p.remove(); });
            delete this.element.data().datepicker;
        }
    };

    function opts_from_el(el, prefix){
        // Derive options from element data-attrs
        var data = $(el).data(),
            out = {}, inkey,
            replace = new RegExp('^' + prefix.toLowerCase() + '([A-Z])');
        prefix = new RegExp('^' + prefix.toLowerCase());
        function re_lower(_,a){
            return a.toLowerCase();
        }
        for (var key in data)
            if (prefix.test(key)){
                inkey = key.replace(replace, re_lower);
                out[inkey] = data[key];
            }
        return out;
    }

    function opts_from_locale(lang){
        // Derive options from locale plugins
        var out = {};
        // Check if "de-DE" style date is available, if not language should
        // fallback to 2 letter code eg "de"
        if (!dates[lang]){
            lang = lang.split('-')[0];
            if (!dates[lang])
                return;
        }
        var d = dates[lang];
        $.each(locale_opts, function(i,k){
            if (k in d)
                out[k] = d[k];
        });
        return out;
    }

    var old = $.fn.datepicker;
    $.fn.datepicker = function(option){
        var args = Array.apply(null, arguments);
        args.shift();
        var internal_return;
        this.each(function(){
            var $this = $(this),
                data = $this.data('datepicker'),
                options = typeof option === 'object' && option;
            if (!data){
                var elopts = opts_from_el(this, 'date'),
                // Preliminary otions
                    xopts = $.extend({}, defaults, elopts, options),
                    locopts = opts_from_locale(xopts.language),
                // Options priority: js args, data-attrs, locales, defaults
                    opts = $.extend({}, defaults, locopts, elopts, options);
                if ($this.is('.input-daterange') || opts.inputs){
                    var ropts = {
                        inputs: opts.inputs || $this.find('input').toArray()
                    };
                    $this.data('datepicker', (data = new DateRangePicker(this, $.extend(opts, ropts))));
                }
                else {
                    $this.data('datepicker', (data = new Datepicker(this, opts)));
                }
            }
            if (typeof option === 'string' && typeof data[option] === 'function'){
                internal_return = data[option].apply(data, args);
                if (internal_return !== undefined)
                    return false;
            }
        });
        if (internal_return !== undefined)
            return internal_return;
        else
            return this;
    };

    var defaults = $.fn.datepicker.defaults = {
        autoclose: false,
        beforeShowDay: $.noop,
        calendarWeeks: false,
        clearBtn: false,
        daysOfWeekDisabled: [],
        endDate: Infinity,
        forceParse: true,
        format: 'mm/dd/yyyy',
        keyboardNavigation: true,
        language: 'en',
        minViewMode: 0,
        multidate: false,
        multidateSeparator: ',',
        orientation: "auto",
        rtl: false,
        startDate: -Infinity,
        startView: 0,
        todayBtn: false,
        todayHighlight: false,
        weekStart: 0
    };
    var locale_opts = $.fn.datepicker.locale_opts = [
        'format',
        'rtl',
        'weekStart'
    ];
    $.fn.datepicker.Constructor = Datepicker;
    var dates = $.fn.datepicker.dates = {
        en: {
            days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
            daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
            daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
            months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            today: "Today",
            clear: "Clear"
        }
    };

    var DPGlobal = {
        modes: [
            {
                clsName: 'days',
                navFnc: 'Month',
                navStep: 1
            },
            {
                clsName: 'months',
                navFnc: 'FullYear',
                navStep: 1
            },
            {
                clsName: 'years',
                navFnc: 'FullYear',
                navStep: 10
            }],
        isLeapYear: function(year){
            return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
        },
        getDaysInMonth: function(year, month){
            return [31, (DPGlobal.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
        },
        validParts: /dd?|DD?|mm?|MM?|yy(?:yy)?/g,
        nonpunctuation: /[^ -\/:-@\[\u3400-\u9fff-`{-~\t\n\r]+/g,
        parseFormat: function(format){
            // IE treats \0 as a string end in inputs (truncating the value),
            // so it's a bad format delimiter, anyway
            var separators = format.replace(this.validParts, '\0').split('\0'),
                parts = format.match(this.validParts);
            if (!separators || !separators.length || !parts || parts.length === 0){
                throw new Error("Invalid date format.");
            }
            return {separators: separators, parts: parts};
        },
        parseDate: function(date, format, language){
            if (!date)
                return undefined;
            if (date instanceof Date)
                return date;
            if (typeof format === 'string')
                format = DPGlobal.parseFormat(format);
            var part_re = /([\-+]\d+)([dmwy])/,
                parts = date.match(/([\-+]\d+)([dmwy])/g),
                part, dir, i;
            if (/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/.test(date)){
                date = new Date();
                for (i=0; i < parts.length; i++){
                    part = part_re.exec(parts[i]);
                    dir = parseInt(part[1]);
                    switch (part[2]){
                        case 'd':
                            date.setUTCDate(date.getUTCDate() + dir);
                            break;
                        case 'm':
                            date = Datepicker.prototype.moveMonth.call(Datepicker.prototype, date, dir);
                            break;
                        case 'w':
                            date.setUTCDate(date.getUTCDate() + dir * 7);
                            break;
                        case 'y':
                            date = Datepicker.prototype.moveYear.call(Datepicker.prototype, date, dir);
                            break;
                    }
                }
                return UTCDate(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(), 0, 0, 0);
            }
            parts = date && date.match(this.nonpunctuation) || [];
            date = new Date();
            var parsed = {},
                setters_order = ['yyyy', 'yy', 'M', 'MM', 'm', 'mm', 'd', 'dd'],
                setters_map = {
                    yyyy: function(d,v){
                        return d.setUTCFullYear(v);
                    },
                    yy: function(d,v){
                        return d.setUTCFullYear(2000+v);
                    },
                    m: function(d,v){
                        if (isNaN(d))
                            return d;
                        v -= 1;
                        while (v < 0) v += 12;
                        v %= 12;
                        d.setUTCMonth(v);
                        while (d.getUTCMonth() !== v)
                            d.setUTCDate(d.getUTCDate()-1);
                        return d;
                    },
                    d: function(d,v){
                        return d.setUTCDate(v);
                    }
                },
                val, filtered;
            setters_map['M'] = setters_map['MM'] = setters_map['mm'] = setters_map['m'];
            setters_map['dd'] = setters_map['d'];
            date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0);
            var fparts = format.parts.slice();
            // Remove noop parts
            if (parts.length !== fparts.length){
                fparts = $(fparts).filter(function(i,p){
                    return $.inArray(p, setters_order) !== -1;
                }).toArray();
            }
            // Process remainder
            function match_part(){
                var m = this.slice(0, parts[i].length),
                    p = parts[i].slice(0, m.length);
                return m === p;
            }
            if (parts.length === fparts.length){
                var cnt;
                for (i=0, cnt = fparts.length; i < cnt; i++){
                    val = parseInt(parts[i], 10);
                    part = fparts[i];
                    if (isNaN(val)){
                        switch (part){
                            case 'MM':
                                filtered = $(dates[language].months).filter(match_part);
                                val = $.inArray(filtered[0], dates[language].months) + 1;
                                break;
                            case 'M':
                                filtered = $(dates[language].monthsShort).filter(match_part);
                                val = $.inArray(filtered[0], dates[language].monthsShort) + 1;
                                break;
                        }
                    }
                    parsed[part] = val;
                }
                var _date, s;
                for (i=0; i < setters_order.length; i++){
                    s = setters_order[i];
                    if (s in parsed && !isNaN(parsed[s])){
                        _date = new Date(date);
                        setters_map[s](_date, parsed[s]);
                        if (!isNaN(_date))
                            date = _date;
                    }
                }
            }
            return date;
        },
        formatDate: function(date, format, language){
            if (!date)
                return '';
            if (typeof format === 'string')
                format = DPGlobal.parseFormat(format);
            var val = {
                d: date.getUTCDate(),
                D: dates[language].daysShort[date.getUTCDay()],
                DD: dates[language].days[date.getUTCDay()],
                m: date.getUTCMonth() + 1,
                M: dates[language].monthsShort[date.getUTCMonth()],
                MM: dates[language].months[date.getUTCMonth()],
                yy: date.getUTCFullYear().toString().substring(2),
                yyyy: date.getUTCFullYear()
            };
            val.dd = (val.d < 10 ? '0' : '') + val.d;
            val.mm = (val.m < 10 ? '0' : '') + val.m;
            date = [];
            var seps = $.extend([], format.separators);
            for (var i=0, cnt = format.parts.length; i <= cnt; i++){
                if (seps.length)
                    date.push(seps.shift());
                date.push(val[format.parts[i]]);
            }
            return date.join('');
        },
        headTemplate: '<thead>'+
        '<tr>'+
        '<th class="prev">&laquo;</th>'+
        '<th colspan="5" class="datepicker-switch"></th>'+
        '<th class="next">&raquo;</th>'+
        '</tr>'+
        '</thead>',
        contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
        footTemplate: '<tfoot>'+
        '<tr>'+
        '<th colspan="7" class="today"></th>'+
        '</tr>'+
        '<tr>'+
        '<th colspan="7" class="clear"></th>'+
        '</tr>'+
        '</tfoot>'
    };
    DPGlobal.template = '<div class="datepicker">'+
        '<div class="datepicker-days">'+
        '<table class=" table-condensed">'+
        DPGlobal.headTemplate+
        '<tbody></tbody>'+
        DPGlobal.footTemplate+
        '</table>'+
        '</div>'+
        '<div class="datepicker-months">'+
        '<table class="table-condensed">'+
        DPGlobal.headTemplate+
        DPGlobal.contTemplate+
        DPGlobal.footTemplate+
        '</table>'+
        '</div>'+
        '<div class="datepicker-years">'+
        '<table class="table-condensed">'+
        DPGlobal.headTemplate+
        DPGlobal.contTemplate+
        DPGlobal.footTemplate+
        '</table>'+
        '</div>'+
        '</div>';

    $.fn.datepicker.DPGlobal = DPGlobal;


    /* DATEPICKER NO CONFLICT
     * =================== */

    $.fn.datepicker.noConflict = function(){
        $.fn.datepicker = old;
        return this;
    };


    /* DATEPICKER DATA-API
     * ================== */

    $(document).on(
        'focus.datepicker.data-api click.datepicker.data-api',
        '[data-provide="datepicker"]',
        function(e){
            var $this = $(this);
            if ($this.data('datepicker'))
                return;
            e.preventDefault();
            // component click requires us to explicitly show it
            $this.datepicker('show');
        }
    );
    $(function(){
        $('[data-provide="datepicker-inline"]').datepicker();
    });

}(window.jQuery));

(function ($) {
    'use strict';

    //<editor-fold desc="Shims">
    if (!String.prototype.includes) {
        (function () {
            'use strict'; // needed to support `apply`/`call` with `undefined`/`null`
            var toString = {}.toString;
            var defineProperty = (function () {
                // IE 8 only supports `Object.defineProperty` on DOM elements
                try {
                    var object = {};
                    var $defineProperty = Object.defineProperty;
                    var result = $defineProperty(object, object, object) && $defineProperty;
                } catch (error) {
                }
                return result;
            }());
            var indexOf = ''.indexOf;
            var includes = function (search) {
                if (this == null) {
                    throw new TypeError();
                }
                var string = String(this);
                if (search && toString.call(search) == '[object RegExp]') {
                    throw new TypeError();
                }
                var stringLength = string.length;
                var searchString = String(search);
                var searchLength = searchString.length;
                var position = arguments.length > 1 ? arguments[1] : undefined;
                // `ToInteger`
                var pos = position ? Number(position) : 0;
                if (pos != pos) { // better `isNaN`
                    pos = 0;
                }
                var start = Math.min(Math.max(pos, 0), stringLength);
                // Avoid the `indexOf` call if no match is possible
                if (searchLength + start > stringLength) {
                    return false;
                }
                return indexOf.call(string, searchString, pos) != -1;
            };
            if (defineProperty) {
                defineProperty(String.prototype, 'includes', {
                    'value': includes,
                    'configurable': true,
                    'writable': true
                });
            } else {
                String.prototype.includes = includes;
            }
        }());
    }

    if (!String.prototype.startsWith) {
        (function () {
            'use strict'; // needed to support `apply`/`call` with `undefined`/`null`
            var defineProperty = (function () {
                // IE 8 only supports `Object.defineProperty` on DOM elements
                try {
                    var object = {};
                    var $defineProperty = Object.defineProperty;
                    var result = $defineProperty(object, object, object) && $defineProperty;
                } catch (error) {
                }
                return result;
            }());
            var toString = {}.toString;
            var startsWith = function (search) {
                if (this == null) {
                    throw new TypeError();
                }
                var string = String(this);
                if (search && toString.call(search) == '[object RegExp]') {
                    throw new TypeError();
                }
                var stringLength = string.length;
                var searchString = String(search);
                var searchLength = searchString.length;
                var position = arguments.length > 1 ? arguments[1] : undefined;
                // `ToInteger`
                var pos = position ? Number(position) : 0;
                if (pos != pos) { // better `isNaN`
                    pos = 0;
                }
                var start = Math.min(Math.max(pos, 0), stringLength);
                // Avoid the `indexOf` call if no match is possible
                if (searchLength + start > stringLength) {
                    return false;
                }
                var index = -1;
                while (++index < searchLength) {
                    if (string.charCodeAt(start + index) != searchString.charCodeAt(index)) {
                        return false;
                    }
                }
                return true;
            };
            if (defineProperty) {
                defineProperty(String.prototype, 'startsWith', {
                    'value': startsWith,
                    'configurable': true,
                    'writable': true
                });
            } else {
                String.prototype.startsWith = startsWith;
            }
        }());
    }

    if (!Object.keys) {
        Object.keys = function (
            o, // object
            k, // key
            r  // result array
        ){
            // initialize object and result
            r=[];
            // iterate over object keys
            for (k in o)
                // fill result array with non-prototypical keys
                r.hasOwnProperty.call(o, k) && r.push(k);
            // return result
            return r;
        };
    }

    $.fn.triggerNative = function (eventName) {
        var el = this[0],
            event;

        if (el.dispatchEvent) {
            if (typeof Event === 'function') {
                // For modern browsers
                event = new Event(eventName, {
                    bubbles: true
                });
            } else {
                // For IE since it doesn't support Event constructor
                event = document.createEvent('Event');
                event.initEvent(eventName, true, false);
            }

            el.dispatchEvent(event);
        } else {
            if (el.fireEvent) {
                event = document.createEventObject();
                event.eventType = eventName;
                el.fireEvent('on' + eventName, event);
            }

            this.trigger(eventName);
        }
    };
    //</editor-fold>

    // Case insensitive contains search
    $.expr[':'].icontains = function (obj, index, meta) {
        var $obj = $(obj);
        var haystack = ($obj.data('tokens') || $obj.text()).toUpperCase();
        return haystack.includes(meta[3].toUpperCase());
    };

    // Case insensitive begins search
    $.expr[':'].ibegins = function (obj, index, meta) {
        var $obj = $(obj);
        var haystack = ($obj.data('tokens') || $obj.text()).toUpperCase();
        return haystack.startsWith(meta[3].toUpperCase());
    };

    // Case and accent insensitive contains search
    $.expr[':'].aicontains = function (obj, index, meta) {
        var $obj = $(obj);
        var haystack = ($obj.data('tokens') || $obj.data('normalizedText') || $obj.text()).toUpperCase();
        return haystack.includes(meta[3].toUpperCase());
    };

    // Case and accent insensitive begins search
    $.expr[':'].aibegins = function (obj, index, meta) {
        var $obj = $(obj);
        var haystack = ($obj.data('tokens') || $obj.data('normalizedText') || $obj.text()).toUpperCase();
        return haystack.startsWith(meta[3].toUpperCase());
    };

    /**
     * Remove all diatrics from the given text.
     * @access private
     * @param {String} text
     * @returns {String}
     */
    function normalizeToBase(text) {
        var rExps = [
            {re: /[\xC0-\xC6]/g, ch: "A"},
            {re: /[\xE0-\xE6]/g, ch: "a"},
            {re: /[\xC8-\xCB]/g, ch: "E"},
            {re: /[\xE8-\xEB]/g, ch: "e"},
            {re: /[\xCC-\xCF]/g, ch: "I"},
            {re: /[\xEC-\xEF]/g, ch: "i"},
            {re: /[\xD2-\xD6]/g, ch: "O"},
            {re: /[\xF2-\xF6]/g, ch: "o"},
            {re: /[\xD9-\xDC]/g, ch: "U"},
            {re: /[\xF9-\xFC]/g, ch: "u"},
            {re: /[\xC7-\xE7]/g, ch: "c"},
            {re: /[\xD1]/g, ch: "N"},
            {re: /[\xF1]/g, ch: "n"}
        ];
        $.each(rExps, function () {
            text = text.replace(this.re, this.ch);
        });
        return text;
    }


    function htmlEscape(html) {
        var escapeMap = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#x27;',
            '`': '&#x60;'
        };
        var source = '(?:' + Object.keys(escapeMap).join('|') + ')',
            testRegexp = new RegExp(source),
            replaceRegexp = new RegExp(source, 'g'),
            string = html == null ? '' : '' + html;
        return testRegexp.test(string) ? string.replace(replaceRegexp, function (match) {
            return escapeMap[match];
        }) : string;
    }

    var Selectpicker = function (element, options, e) {
        if (e) {
            e.stopPropagation();
            e.preventDefault();
        }

        this.$element = $(element);
        this.$newElement = null;
        this.$button = null;
        this.$menu = null;
        this.$lis = null;
        this.options = options;

        // If we have no title yet, try to pull it from the html title attribute (jQuery doesnt' pick it up as it's not a
        // data-attribute)
        if (this.options.title === null) {
            this.options.title = this.$element.attr('title');
        }

        //Expose public methods
        this.val = Selectpicker.prototype.val;
        this.render = Selectpicker.prototype.render;
        this.refresh = Selectpicker.prototype.refresh;
        this.setStyle = Selectpicker.prototype.setStyle;
        this.selectAll = Selectpicker.prototype.selectAll;
        this.deselectAll = Selectpicker.prototype.deselectAll;
        this.destroy = Selectpicker.prototype.destroy;
        this.remove = Selectpicker.prototype.remove;
        this.show = Selectpicker.prototype.show;
        this.hide = Selectpicker.prototype.hide;

        this.init();
    };

    Selectpicker.VERSION = '1.9.3';

    // part of this is duplicated in i18n/defaults-en_US.js. Make sure to update both.
    Selectpicker.DEFAULTS = {
        noneSelectedText: 'Nothing selected',
        noneResultsText: 'No results matched {0}',
        countSelectedText: function (numSelected, numTotal) {
            return (numSelected == 1) ? "{0} item selected" : "{0} items selected";
        },
        maxOptionsText: function (numAll, numGroup) {
            return [
                (numAll == 1) ? 'Limit reached ({n} item max)' : 'Limit reached ({n} items max)',
                (numGroup == 1) ? 'Group limit reached ({n} item max)' : 'Group limit reached ({n} items max)'
            ];
        },
        selectAllText: 'Select All',
        deselectAllText: 'Deselect All',
        doneButton: false,
        doneButtonText: 'Close',
        multipleSeparator: ', ',
        styleBase: 'btn',
        style: 'btn-default',
        size: 'auto',
        title: null,
        selectedTextFormat: 'values',
        width: false,
        container: false,
        hideDisabled: false,
        showSubtext: false,
        showIcon: true,
        showContent: true,
        dropupAuto: true,
        header: false,
        liveSearch: false,
        liveSearchPlaceholder: null,
        liveSearchNormalize: false,
        liveSearchStyle: 'contains',
        actionsBox: false,
        iconBase: 'glyphicon',
        tickIcon: 'glyphicon-ok',
        template: {
            caret: '<span class="caret"></span>'
        },
        maxOptions: false,
        mobile: false,
        selectOnTab: false,
        dropdownAlignRight: false
    };

    Selectpicker.prototype = {

        constructor: Selectpicker,

        init: function () {
            var that = this,
                id = this.$element.attr('id');

            // store originalIndex (key) and newIndex (value) in this.liObj for fast accessibility
            // allows us to do this.$lis.eq(that.liObj[index]) instead of this.$lis.filter('[data-original-index="' + index + '"]')
            this.liObj = {};
            this.multiple = this.$element.prop('multiple');
            this.autofocus = this.$element.prop('autofocus');
            this.$newElement = this.createView();
            this.$element
                .after(this.$newElement)
                .appendTo(this.$newElement);
            this.$button = this.$newElement.children('button');
            this.$menu = this.$newElement.children('.dropdown-menu');
            this.$menuInner = this.$menu.children('.inner');
            this.$searchbox = this.$menu.find('input');

            if (this.options.dropdownAlignRight)
                this.$menu.addClass('dropdown-menu-right');

            if (typeof id !== 'undefined') {
                this.$button.attr('data-id', id);
                $('label[for="' + id + '"]').click(function (e) {
                    e.preventDefault();
                    that.$button.focus();
                });
            }

            this.checkDisabled();
            this.clickListener();
            if (this.options.liveSearch) this.liveSearchListener();
            this.render();
            this.setStyle();
            this.setWidth();
            if (this.options.container) this.selectPosition();
            this.$menu.data('this', this);
            this.$newElement.data('this', this);
            if (this.options.mobile) this.mobile();

            this.$newElement.on({
                'hide.bs.dropdown': function (e) {
                    that.$element.trigger('hide.bs.select', e);
                },
                'hidden.bs.dropdown': function (e) {
                    that.$element.trigger('hidden.bs.select', e);
                },
                'show.bs.dropdown': function (e) {
                    that.$element.trigger('show.bs.select', e);
                },
                'shown.bs.dropdown': function (e) {
                    that.$element.trigger('shown.bs.select', e);
                }
            });

            if (that.$element[0].hasAttribute('required')) {
                this.$element.on('invalid', function () {
                    that.$button
                        .addClass('bs-invalid')
                        .focus();

                    that.$element.on({
                        'focus.bs.select': function () {
                            that.$button.focus();
                            that.$element.off('focus.bs.select');
                        },
                        'shown.bs.select': function () {
                            that.$element
                                .val(that.$element.val()) // set the value to hide the validation message in Chrome when menu is opened
                                .off('shown.bs.select');
                        },
                        'rendered.bs.select': function () {
                            // if select is no longer invalid, remove the bs-invalid class
                            if (this.validity.valid) that.$button.removeClass('bs-invalid');
                            that.$element.off('rendered.bs.select');
                        }
                    });

                });
            }

            setTimeout(function () {
                that.$element.trigger('loaded.bs.select');
            });
        },

        createDropdown: function () {
            // Options
            // If we are multiple, then add the show-tick class by default
            var multiple = this.multiple ? ' show-tick' : '',
                inputGroup = this.$element.parent().hasClass('input-group') ? ' input-group-btn' : '',
                autofocus = this.autofocus ? ' autofocus' : '';
            // Elements
            var header = this.options.header ? '<div class="popover-title"><button type="button" class="close" aria-hidden="true">&times;</button>' + this.options.header + '</div>' : '';
            var searchbox = this.options.liveSearch ?
            '<div class="bs-searchbox">' +
            '<input type="text" class="form-control" autocomplete="off"' +
            (null === this.options.liveSearchPlaceholder ? '' : ' placeholder="' + htmlEscape(this.options.liveSearchPlaceholder) + '"') + '>' +
            '</div>'
                : '';
            var actionsbox = this.multiple && this.options.actionsBox ?
            '<div class="bs-actionsbox">' +
            '<div class="btn-group btn-group-sm btn-block">' +
            '<button type="button" class="actions-btn bs-select-all btn btn-default">' +
            this.options.selectAllText +
            '</button>' +
            '<button type="button" class="actions-btn bs-deselect-all btn btn-default">' +
            this.options.deselectAllText +
            '</button>' +
            '</div>' +
            '</div>'
                : '';
            var donebutton = this.multiple && this.options.doneButton ?
            '<div class="bs-donebutton">' +
            '<div class="btn-group btn-block">' +
            '<button type="button" class="btn btn-sm btn-default">' +
            this.options.doneButtonText +
            '</button>' +
            '</div>' +
            '</div>'
                : '';
            var drop =
                '<div class="btn-group bootstrap-select' + multiple + inputGroup + '">' +
                '<button type="button" class="' + this.options.styleBase + ' dropdown-toggle" data-toggle="dropdown"' + autofocus + '>' +
                '<span class="filter-option pull-left"></span>&nbsp;' +
                '<span class="bs-caret">' +
                this.options.template.caret +
                '</span>' +
                '</button>' +
                '<div class="dropdown-menu open">' +
                header +
                searchbox +
                actionsbox +
                '<ul class="dropdown-menu inner" role="menu">' +
                '</ul>' +
                donebutton +
                '</div>' +
                '</div>';

            return $(drop);
        },

        createView: function () {
            var $drop = this.createDropdown(),
                li = this.createLi();

            $drop.find('ul')[0].innerHTML = li;
            return $drop;
        },

        reloadLi: function () {
            //Remove all children.
            this.destroyLi();
            //Re build
            var li = this.createLi();
            this.$menuInner[0].innerHTML = li;
        },

        destroyLi: function () {
            this.$menu.find('li').remove();
        },

        createLi: function () {
            var that = this,
                _li = [],
                optID = 0,
                titleOption = document.createElement('option'),
                liIndex = -1; // increment liIndex whenever a new <li> element is created to ensure liObj is correct

            // Helper functions
            /**
             * @param content
             * @param [index]
             * @param [classes]
             * @param [optgroup]
             * @returns {string}
             */
            var generateLI = function (content, index, classes, optgroup) {
                return '<li' +
                    ((typeof classes !== 'undefined' & '' !== classes) ? ' class="' + classes + '"' : '') +
                    ((typeof index !== 'undefined' & null !== index) ? ' data-original-index="' + index + '"' : '') +
                    ((typeof optgroup !== 'undefined' & null !== optgroup) ? 'data-optgroup="' + optgroup + '"' : '') +
                    '>' + content + '</li>';
            };

            /**
             * @param text
             * @param [classes]
             * @param [inline]
             * @param [tokens]
             * @returns {string}
             */
            var generateA = function (text, classes, inline, tokens) {
                return '<a tabindex="0"' +
                    (typeof classes !== 'undefined' ? ' class="' + classes + '"' : '') +
                    (typeof inline !== 'undefined' ? ' style="' + inline + '"' : '') +
                    (that.options.liveSearchNormalize ? ' data-normalized-text="' + normalizeToBase(htmlEscape(text)) + '"' : '') +
                    (typeof tokens !== 'undefined' || tokens !== null ? ' data-tokens="' + tokens + '"' : '') +
                    '>' + text +
                    '<span class="' + that.options.iconBase + ' ' + that.options.tickIcon + ' check-mark"></span>' +
                    '</a>';
            };

            if (this.options.title && !this.multiple) {
                // this option doesn't create a new <li> element, but does add a new option, so liIndex is decreased
                // since liObj is recalculated on every refresh, liIndex needs to be decreased even if the titleOption is already appended
                liIndex--;

                if (!this.$element.find('.bs-title-option').length) {
                    // Use native JS to prepend option (faster)
                    var element = this.$element[0];
                    titleOption.className = 'bs-title-option';
                    titleOption.appendChild(document.createTextNode(this.options.title));
                    titleOption.value = '';
                    element.insertBefore(titleOption, element.firstChild);
                    // Check if selected attribute is already set on an option. If not, select the titleOption option.
                    if ($(element.options[element.selectedIndex]).attr('selected') === undefined) titleOption.selected = true;
                }
            }

            this.$element.find('option').each(function (index) {
                var $this = $(this);

                liIndex++;

                if ($this.hasClass('bs-title-option')) return;

                // Get the class and text for the option
                var optionClass = this.className || '',
                    inline = this.style.cssText,
                    text = $this.data('content') ? $this.data('content') : $this.html(),
                    tokens = $this.data('tokens') ? $this.data('tokens') : null,
                    subtext = typeof $this.data('subtext') !== 'undefined' ? '<small class="text-muted">' + $this.data('subtext') + '</small>' : '',
                    icon = typeof $this.data('icon') !== 'undefined' ? '<span class="' + that.options.iconBase + ' ' + $this.data('icon') + '"></span> ' : '',
                    isDisabled = this.disabled || (this.parentNode.tagName === 'OPTGROUP' && this.parentNode.disabled);

                if (icon !== '' && isDisabled) {
                    icon = '<span>' + icon + '</span>';
                }

                if (that.options.hideDisabled && isDisabled) {
                    liIndex--;
                    return;
                }

                if (!$this.data('content')) {
                    // Prepend any icon and append any subtext to the main text.
                    text = icon + '<span class="text">' + text + subtext + '</span>';
                }

                if (this.parentNode.tagName === 'OPTGROUP' && $this.data('divider') !== true) {
                    var optGroupClass = ' ' + this.parentNode.className || '';

                    if ($this.index() === 0) { // Is it the first option of the optgroup?
                        optID += 1;

                        // Get the opt group label
                        var label = this.parentNode.label,
                            labelSubtext = typeof $this.parent().data('subtext') !== 'undefined' ? '<small class="text-muted">' + $this.parent().data('subtext') + '</small>' : '',
                            labelIcon = $this.parent().data('icon') ? '<span class="' + that.options.iconBase + ' ' + $this.parent().data('icon') + '"></span> ' : '';

                        label = labelIcon + '<span class="text">' + label + labelSubtext + '</span>';

                        if (index !== 0 && _li.length > 0) { // Is it NOT the first option of the select && are there elements in the dropdown?
                            liIndex++;
                            _li.push(generateLI('', null, 'divider', optID + 'div'));
                        }
                        liIndex++;
                        _li.push(generateLI(label, null, 'dropdown-header' + optGroupClass, optID));
                    }
                    _li.push(generateLI(generateA(text, 'opt ' + optionClass + optGroupClass, inline, tokens), index, '', optID));
                } else if ($this.data('divider') === true) {
                    _li.push(generateLI('', index, 'divider'));
                } else if ($this.data('hidden') === true) {
                    _li.push(generateLI(generateA(text, optionClass, inline, tokens), index, 'hidden is-hidden'));
                } else {
                    if (this.previousElementSibling && this.previousElementSibling.tagName === 'OPTGROUP') {
                        liIndex++;
                        _li.push(generateLI('', null, 'divider', optID + 'div'));
                    }
                    _li.push(generateLI(generateA(text, optionClass, inline, tokens), index));
                }

                that.liObj[index] = liIndex;
            });

            //If we are not multiple, we don't have a selected item, and we don't have a title, select the first element so something is set in the button
            if (!this.multiple && this.$element.find('option:selected').length === 0 && !this.options.title) {
                this.$element.find('option').eq(0).prop('selected', true).attr('selected', 'selected');
            }

            return _li.join('');
        },

        findLis: function () {
            if (this.$lis == null) this.$lis = this.$menu.find('li');
            return this.$lis;
        },

        /**
         * @param [updateLi] defaults to true
         */
        render: function (updateLi) {
            var that = this,
                notDisabled;

            //Update the LI to match the SELECT
            if (updateLi !== false) {
                this.$element.find('option').each(function (index) {
                    var $lis = that.findLis().eq(that.liObj[index]);

                    that.setDisabled(index, this.disabled || this.parentNode.tagName === 'OPTGROUP' && this.parentNode.disabled, $lis);
                    that.setSelected(index, this.selected, $lis);
                });
            }

            this.tabIndex();

            var selectedItems = this.$element.find('option').map(function () {
                if (this.selected) {
                    if (that.options.hideDisabled && (this.disabled || this.parentNode.tagName === 'OPTGROUP' && this.parentNode.disabled)) return;

                    var $this = $(this),
                        icon = $this.data('icon') && that.options.showIcon ? '<i class="' + that.options.iconBase + ' ' + $this.data('icon') + '"></i> ' : '',
                        subtext;

                    if (that.options.showSubtext && $this.data('subtext') && !that.multiple) {
                        subtext = ' <small class="text-muted">' + $this.data('subtext') + '</small>';
                    } else {
                        subtext = '';
                    }
                    if (typeof $this.attr('title') !== 'undefined') {
                        return $this.attr('title');
                    } else if ($this.data('content') && that.options.showContent) {
                        return $this.data('content');
                    } else {
                        return icon + $this.html() + subtext;
                    }
                }
            }).toArray();

            //Fixes issue in IE10 occurring when no default option is selected and at least one option is disabled
            //Convert all the values into a comma delimited string
            var title = !this.multiple ? selectedItems[0] : selectedItems.join(this.options.multipleSeparator);

            //If this is multi select, and the selectText type is count, the show 1 of 2 selected etc..
            if (this.multiple && this.options.selectedTextFormat.indexOf('count') > -1) {
                var max = this.options.selectedTextFormat.split('>');
                if ((max.length > 1 && selectedItems.length > max[1]) || (max.length == 1 && selectedItems.length >= 2)) {
                    notDisabled = this.options.hideDisabled ? ', [disabled]' : '';
                    var totalCount = this.$element.find('option').not('[data-divider="true"], [data-hidden="true"]' + notDisabled).length,
                        tr8nText = (typeof this.options.countSelectedText === 'function') ? this.options.countSelectedText(selectedItems.length, totalCount) : this.options.countSelectedText;
                    title = tr8nText.replace('{0}', selectedItems.length.toString()).replace('{1}', totalCount.toString());
                }
            }

            if (this.options.title == undefined) {
                this.options.title = this.$element.attr('title');
            }

            if (this.options.selectedTextFormat == 'static') {
                title = this.options.title;
            }

            //If we dont have a title, then use the default, or if nothing is set at all, use the not selected text
            if (!title) {
                title = typeof this.options.title !== 'undefined' ? this.options.title : this.options.noneSelectedText;
            }

            //strip all html-tags and trim the result
            this.$button.attr('title', $.trim(title.replace(/<[^>]*>?/g, '')));
            this.$button.children('.filter-option').html(title);

            this.$element.trigger('rendered.bs.select');
        },

        /**
         * @param [style]
         * @param [status]
         */
        setStyle: function (style, status) {
            if (this.$element.attr('class')) {
                this.$newElement.addClass(this.$element.attr('class').replace(/selectpicker|mobile-device|bs-select-hidden|validate\[.*\]/gi, ''));
            }

            var buttonClass = style ? style : this.options.style;

            if (status == 'add') {
                this.$button.addClass(buttonClass);
            } else if (status == 'remove') {
                this.$button.removeClass(buttonClass);
            } else {
                this.$button.removeClass(this.options.style);
                this.$button.addClass(buttonClass);
            }
        },

        liHeight: function (refresh) {
            if (!refresh && (this.options.size === false || this.sizeInfo)) return;

            var newElement = document.createElement('div'),
                menu = document.createElement('div'),
                menuInner = document.createElement('ul'),
                divider = document.createElement('li'),
                li = document.createElement('li'),
                a = document.createElement('a'),
                text = document.createElement('span'),
                header = this.options.header && this.$menu.find('.popover-title').length > 0 ? this.$menu.find('.popover-title')[0].cloneNode(true) : null,
                search = this.options.liveSearch ? document.createElement('div') : null,
                actions = this.options.actionsBox && this.multiple && this.$menu.find('.bs-actionsbox').length > 0 ? this.$menu.find('.bs-actionsbox')[0].cloneNode(true) : null,
                doneButton = this.options.doneButton && this.multiple && this.$menu.find('.bs-donebutton').length > 0 ? this.$menu.find('.bs-donebutton')[0].cloneNode(true) : null;

            text.className = 'text';
            newElement.className = this.$menu[0].parentNode.className + ' open';
            menu.className = 'dropdown-menu open';
            menuInner.className = 'dropdown-menu inner';
            divider.className = 'divider';

            text.appendChild(document.createTextNode('Inner text'));
            a.appendChild(text);
            li.appendChild(a);
            menuInner.appendChild(li);
            menuInner.appendChild(divider);
            if (header) menu.appendChild(header);
            if (search) {
                // create a span instead of input as creating an input element is slower
                var input = document.createElement('span');
                search.className = 'bs-searchbox';
                input.className = 'form-control';
                search.appendChild(input);
                menu.appendChild(search);
            }
            if (actions) menu.appendChild(actions);
            menu.appendChild(menuInner);
            if (doneButton) menu.appendChild(doneButton);
            newElement.appendChild(menu);

            document.body.appendChild(newElement);

            var liHeight = a.offsetHeight,
                headerHeight = header ? header.offsetHeight : 0,
                searchHeight = search ? search.offsetHeight : 0,
                actionsHeight = actions ? actions.offsetHeight : 0,
                doneButtonHeight = doneButton ? doneButton.offsetHeight : 0,
                dividerHeight = $(divider).outerHeight(true),
            // fall back to jQuery if getComputedStyle is not supported
                menuStyle = typeof getComputedStyle === 'function' ? getComputedStyle(menu) : false,
                $menu = menuStyle ? null : $(menu),
                menuPadding = parseInt(menuStyle ? menuStyle.paddingTop : $menu.css('paddingTop')) +
                    parseInt(menuStyle ? menuStyle.paddingBottom : $menu.css('paddingBottom')) +
                    parseInt(menuStyle ? menuStyle.borderTopWidth : $menu.css('borderTopWidth')) +
                    parseInt(menuStyle ? menuStyle.borderBottomWidth : $menu.css('borderBottomWidth')),
                menuExtras =  menuPadding +
                    parseInt(menuStyle ? menuStyle.marginTop : $menu.css('marginTop')) +
                    parseInt(menuStyle ? menuStyle.marginBottom : $menu.css('marginBottom')) + 2;

            document.body.removeChild(newElement);

            this.sizeInfo = {
                liHeight: liHeight,
                headerHeight: headerHeight,
                searchHeight: searchHeight,
                actionsHeight: actionsHeight,
                doneButtonHeight: doneButtonHeight,
                dividerHeight: dividerHeight,
                menuPadding: menuPadding,
                menuExtras: menuExtras
            };
        },

        setSize: function () {
            this.findLis();
            this.liHeight();

            if (this.options.header) this.$menu.css('padding-top', 0);
            if (this.options.size === false) return;

            var that = this,
                $menu = this.$menu,
                $menuInner = this.$menuInner,
                $window = $(window),
                selectHeight = this.$newElement[0].offsetHeight,
                liHeight = this.sizeInfo['liHeight'],
                headerHeight = this.sizeInfo['headerHeight'],
                searchHeight = this.sizeInfo['searchHeight'],
                actionsHeight = this.sizeInfo['actionsHeight'],
                doneButtonHeight = this.sizeInfo['doneButtonHeight'],
                divHeight = this.sizeInfo['dividerHeight'],
                menuPadding = this.sizeInfo['menuPadding'],
                menuExtras = this.sizeInfo['menuExtras'],
                notDisabled = this.options.hideDisabled ? '.disabled' : '',
                menuHeight,
                getHeight,
                selectOffsetTop,
                selectOffsetBot,
                posVert = function () {
                    selectOffsetTop = that.$newElement.offset().top - $window.scrollTop();
                    selectOffsetBot = $window.height() - selectOffsetTop - selectHeight;
                };

            posVert();

            if (this.options.size === 'auto') {
                var getSize = function () {
                    var minHeight,
                        hasClass = function (className, include) {
                            return function (element) {
                                if (include) {
                                    return (element.classList ? element.classList.contains(className) : $(element).hasClass(className));
                                } else {
                                    return !(element.classList ? element.classList.contains(className) : $(element).hasClass(className));
                                }
                            };
                        },
                        lis = that.$menuInner[0].getElementsByTagName('li'),
                        lisVisible = Array.prototype.filter ? Array.prototype.filter.call(lis, hasClass('hidden', false)) : that.$lis.not('.hidden'),
                        optGroup = Array.prototype.filter ? Array.prototype.filter.call(lisVisible, hasClass('dropdown-header', true)) : lisVisible.filter('.dropdown-header');

                    posVert();
                    menuHeight = selectOffsetBot - menuExtras;

                    if (that.options.container) {
                        if (!$menu.data('height')) $menu.data('height', $menu.height());
                        getHeight = $menu.data('height');
                    } else {
                        getHeight = $menu.height();
                    }

                    if (that.options.dropupAuto) {
                        that.$newElement.toggleClass('dropup', selectOffsetTop > selectOffsetBot && (menuHeight - menuExtras) < getHeight);
                    }
                    if (that.$newElement.hasClass('dropup')) {
                        menuHeight = selectOffsetTop - menuExtras;
                    }

                    if ((lisVisible.length + optGroup.length) > 3) {
                        minHeight = liHeight * 3 + menuExtras - 2;
                    } else {
                        minHeight = 0;
                    }

                    $menu.css({
                        'max-height': menuHeight + 'px',
                        'overflow': 'hidden',
                        'min-height': minHeight + headerHeight + searchHeight + actionsHeight + doneButtonHeight + 'px'
                    });
                    $menuInner.css({
                        'max-height': menuHeight - headerHeight - searchHeight - actionsHeight - doneButtonHeight - menuPadding + 'px',
                        'overflow-y': 'auto',
                        'min-height': Math.max(minHeight - menuPadding, 0) + 'px'
                    });
                };
                getSize();
                this.$searchbox.off('input.getSize propertychange.getSize').on('input.getSize propertychange.getSize', getSize);
                $window.off('resize.getSize scroll.getSize').on('resize.getSize scroll.getSize', getSize);
            } else if (this.options.size && this.options.size != 'auto' && this.$lis.not(notDisabled).length > this.options.size) {
                var optIndex = this.$lis.not('.divider').not(notDisabled).children().slice(0, this.options.size).last().parent().index(),
                    divLength = this.$lis.slice(0, optIndex + 1).filter('.divider').length;
                menuHeight = liHeight * this.options.size + divLength * divHeight + menuPadding;

                if (that.options.container) {
                    if (!$menu.data('height')) $menu.data('height', $menu.height());
                    getHeight = $menu.data('height');
                } else {
                    getHeight = $menu.height();
                }

                if (that.options.dropupAuto) {
                    //noinspection JSUnusedAssignment
                    this.$newElement.toggleClass('dropup', selectOffsetTop > selectOffsetBot && (menuHeight - menuExtras) < getHeight);
                }
                $menu.css({
                    'max-height': menuHeight + headerHeight + searchHeight + actionsHeight + doneButtonHeight + 'px',
                    'overflow': 'hidden',
                    'min-height': ''
                });
                $menuInner.css({
                    'max-height': menuHeight - menuPadding + 'px',
                    'overflow-y': 'auto',
                    'min-height': ''
                });
            }
        },

        setWidth: function () {
            if (this.options.width === 'auto') {
                this.$menu.css('min-width', '0');

                // Get correct width if element is hidden
                var $selectClone = this.$menu.parent().clone().appendTo('body'),
                    $selectClone2 = this.options.container ? this.$newElement.clone().appendTo('body') : $selectClone,
                    ulWidth = $selectClone.children('.dropdown-menu').outerWidth(),
                    btnWidth = $selectClone2.css('width', 'auto').children('button').outerWidth();

                $selectClone.remove();
                $selectClone2.remove();

                // Set width to whatever's larger, button title or longest option
                this.$newElement.css('width', Math.max(ulWidth, btnWidth) + 'px');
            } else if (this.options.width === 'fit') {
                // Remove inline min-width so width can be changed from 'auto'
                this.$menu.css('min-width', '');
                this.$newElement.css('width', '').addClass('fit-width');
            } else if (this.options.width) {
                // Remove inline min-width so width can be changed from 'auto'
                this.$menu.css('min-width', '');
                this.$newElement.css('width', this.options.width);
            } else {
                // Remove inline min-width/width so width can be changed
                this.$menu.css('min-width', '');
                this.$newElement.css('width', '');
            }
            // Remove fit-width class if width is changed programmatically
            if (this.$newElement.hasClass('fit-width') && this.options.width !== 'fit') {
                this.$newElement.removeClass('fit-width');
            }
        },

        selectPosition: function () {
            this.$bsContainer = $('<div class="bs-container" />');

            var that = this,
                pos,
                actualHeight,
                getPlacement = function ($element) {
                    that.$bsContainer.addClass($element.attr('class').replace(/form-control|fit-width/gi, '')).toggleClass('dropup', $element.hasClass('dropup'));
                    pos = $element.offset();
                    actualHeight = $element.hasClass('dropup') ? 0 : $element[0].offsetHeight;
                    that.$bsContainer.css({
                        'top': pos.top + actualHeight,
                        'left': pos.left,
                        'width': $element[0].offsetWidth
                    });
                };

            this.$button.on('click', function () {
                var $this = $(this);

                if (that.isDisabled()) {
                    return;
                }

                getPlacement(that.$newElement);

                that.$bsContainer
                    .appendTo(that.options.container)
                    .toggleClass('open', !$this.hasClass('open'))
                    .append(that.$menu);
            });

            $(window).on('resize scroll', function () {
                getPlacement(that.$newElement);
            });

            this.$element.on('hide.bs.select', function () {
                that.$menu.data('height', that.$menu.height());
                that.$bsContainer.detach();
            });
        },

        setSelected: function (index, selected, $lis) {
            if (!$lis) {
                $lis = this.findLis().eq(this.liObj[index]);
            }

            $lis.toggleClass('selected', selected);
        },

        setDisabled: function (index, disabled, $lis) {
            if (!$lis) {
                $lis = this.findLis().eq(this.liObj[index]);
            }

            if (disabled) {
                $lis.addClass('disabled').children('a').attr('href', '#').attr('tabindex', -1);
            } else {
                $lis.removeClass('disabled').children('a').removeAttr('href').attr('tabindex', 0);
            }
        },

        isDisabled: function () {
            return this.$element[0].disabled;
        },

        checkDisabled: function () {
            var that = this;

            if (this.isDisabled()) {
                this.$newElement.addClass('disabled');
                this.$button.addClass('disabled').attr('tabindex', -1);
            } else {
                if (this.$button.hasClass('disabled')) {
                    this.$newElement.removeClass('disabled');
                    this.$button.removeClass('disabled');
                }

                if (this.$button.attr('tabindex') == -1 && !this.$element.data('tabindex')) {
                    this.$button.removeAttr('tabindex');
                }
            }

            this.$button.click(function () {
                return !that.isDisabled();
            });
        },

        tabIndex: function () {
            if (this.$element.data('tabindex') !== this.$element.attr('tabindex') &&
                (this.$element.attr('tabindex') !== -98 && this.$element.attr('tabindex') !== '-98')) {
                this.$element.data('tabindex', this.$element.attr('tabindex'));
                this.$button.attr('tabindex', this.$element.data('tabindex'));
            }

            this.$element.attr('tabindex', -98);
        },

        clickListener: function () {
            var that = this,
                $document = $(document);

            this.$newElement.on('touchstart.dropdown', '.dropdown-menu', function (e) {
                e.stopPropagation();
            });

            $document.data('spaceSelect', false);

            this.$button.on('keyup', function (e) {
                if (/(32)/.test(e.keyCode.toString(10)) && $document.data('spaceSelect')) {
                    e.preventDefault();
                    $document.data('spaceSelect', false);
                }
            });

            this.$button.on('click', function () {
                that.setSize();
                that.$element.on('shown.bs.select', function () {
                    if (!that.options.liveSearch && !that.multiple) {
                        that.$menuInner.find('.selected a').focus();
                    } else if (!that.multiple) {
                        var selectedIndex = that.liObj[that.$element[0].selectedIndex];

                        if (typeof selectedIndex !== 'number' || that.options.size === false) return;

                        // scroll to selected option
                        var offset = that.$lis.eq(selectedIndex)[0].offsetTop - that.$menuInner[0].offsetTop;
                        offset = offset - that.$menuInner[0].offsetHeight/2 + that.sizeInfo.liHeight/2;
                        that.$menuInner[0].scrollTop = offset;
                    }
                });
            });

            this.$menuInner.on('click', 'li a', function (e) {
                var $this = $(this),
                    clickedIndex = $this.parent().data('originalIndex'),
                    prevValue = that.$element.val(),
                    prevIndex = that.$element.prop('selectedIndex');

                // Don't close on multi choice menu
                if (that.multiple) {
                    e.stopPropagation();
                }

                e.preventDefault();

                //Don't run if we have been disabled
                if (!that.isDisabled() && !$this.parent().hasClass('disabled')) {
                    var $options = that.$element.find('option'),
                        $option = $options.eq(clickedIndex),
                        state = $option.prop('selected'),
                        $optgroup = $option.parent('optgroup'),
                        maxOptions = that.options.maxOptions,
                        maxOptionsGrp = $optgroup.data('maxOptions') || false;

                    if (!that.multiple) { // Deselect all others if not multi select box
                        $options.prop('selected', false);
                        $option.prop('selected', true);
                        that.$menuInner.find('.selected').removeClass('selected');
                        that.setSelected(clickedIndex, true);
                    } else { // Toggle the one we have chosen if we are multi select.
                        $option.prop('selected', !state);
                        that.setSelected(clickedIndex, !state);
                        $this.blur();

                        if (maxOptions !== false || maxOptionsGrp !== false) {
                            var maxReached = maxOptions < $options.filter(':selected').length,
                                maxReachedGrp = maxOptionsGrp < $optgroup.find('option:selected').length;

                            if ((maxOptions && maxReached) || (maxOptionsGrp && maxReachedGrp)) {
                                if (maxOptions && maxOptions == 1) {
                                    $options.prop('selected', false);
                                    $option.prop('selected', true);
                                    that.$menuInner.find('.selected').removeClass('selected');
                                    that.setSelected(clickedIndex, true);
                                } else if (maxOptionsGrp && maxOptionsGrp == 1) {
                                    $optgroup.find('option:selected').prop('selected', false);
                                    $option.prop('selected', true);
                                    var optgroupID = $this.parent().data('optgroup');
                                    that.$menuInner.find('[data-optgroup="' + optgroupID + '"]').removeClass('selected');
                                    that.setSelected(clickedIndex, true);
                                } else {
                                    var maxOptionsArr = (typeof that.options.maxOptionsText === 'function') ?
                                            that.options.maxOptionsText(maxOptions, maxOptionsGrp) : that.options.maxOptionsText,
                                        maxTxt = maxOptionsArr[0].replace('{n}', maxOptions),
                                        maxTxtGrp = maxOptionsArr[1].replace('{n}', maxOptionsGrp),
                                        $notify = $('<div class="notify"></div>');
                                    // If {var} is set in array, replace it
                                    /** @deprecated */
                                    if (maxOptionsArr[2]) {
                                        maxTxt = maxTxt.replace('{var}', maxOptionsArr[2][maxOptions > 1 ? 0 : 1]);
                                        maxTxtGrp = maxTxtGrp.replace('{var}', maxOptionsArr[2][maxOptionsGrp > 1 ? 0 : 1]);
                                    }

                                    $option.prop('selected', false);

                                    that.$menu.append($notify);

                                    if (maxOptions && maxReached) {
                                        $notify.append($('<div>' + maxTxt + '</div>'));
                                        that.$element.trigger('maxReached.bs.select');
                                    }

                                    if (maxOptionsGrp && maxReachedGrp) {
                                        $notify.append($('<div>' + maxTxtGrp + '</div>'));
                                        that.$element.trigger('maxReachedGrp.bs.select');
                                    }

                                    setTimeout(function () {
                                        that.setSelected(clickedIndex, false);
                                    }, 10);

                                    $notify.delay(750).fadeOut(300, function () {
                                        $(this).remove();
                                    });
                                }
                            }
                        }
                    }

                    if (!that.multiple) {
                        that.$button.focus();
                    } else if (that.options.liveSearch) {
                        that.$searchbox.focus();
                    }

                    // Trigger select 'change'
                    if ((prevValue != that.$element.val() && that.multiple) || (prevIndex != that.$element.prop('selectedIndex') && !that.multiple)) {
                        that.$element.triggerNative('change');
                        // $option.prop('selected') is current option state (selected/unselected). state is previous option state.
                        that.$element.trigger('changed.bs.select', [clickedIndex, $option.prop('selected'), state]);
                    }
                }
            });

            this.$menu.on('click', 'li.disabled a, .popover-title, .popover-title :not(.close)', function (e) {
                if (e.currentTarget == this) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (that.options.liveSearch && !$(e.target).hasClass('close')) {
                        that.$searchbox.focus();
                    } else {
                        that.$button.focus();
                    }
                }
            });

            this.$menuInner.on('click', '.divider, .dropdown-header', function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (that.options.liveSearch) {
                    that.$searchbox.focus();
                } else {
                    that.$button.focus();
                }
            });

            this.$menu.on('click', '.popover-title .close', function () {
                that.$button.click();
            });

            this.$searchbox.on('click', function (e) {
                e.stopPropagation();
            });

            this.$menu.on('click', '.actions-btn', function (e) {
                if (that.options.liveSearch) {
                    that.$searchbox.focus();
                } else {
                    that.$button.focus();
                }

                e.preventDefault();
                e.stopPropagation();

                if ($(this).hasClass('bs-select-all')) {
                    that.selectAll();
                } else {
                    that.deselectAll();
                }
                that.$element.triggerNative('change');
            });

            this.$element.change(function () {
                that.render(false);
            });
        },

        liveSearchListener: function () {
            var that = this,
                $no_results = $('<li class="no-results"></li>');

            this.$button.on('click.dropdown.data-api touchstart.dropdown.data-api', function () {
                that.$menuInner.find('.active').removeClass('active');
                if (!!that.$searchbox.val()) {
                    that.$searchbox.val('');
                    that.$lis.not('.is-hidden').removeClass('hidden');
                    if (!!$no_results.parent().length) $no_results.remove();
                }
                if (!that.multiple) that.$menuInner.find('.selected').addClass('active');
                setTimeout(function () {
                    that.$searchbox.focus();
                }, 10);
            });

            this.$searchbox.on('click.dropdown.data-api focus.dropdown.data-api touchend.dropdown.data-api', function (e) {
                e.stopPropagation();
            });

            this.$searchbox.on('input propertychange', function () {
                if (that.$searchbox.val()) {
                    var $searchBase = that.$lis.not('.is-hidden').removeClass('hidden').children('a');
                    if (that.options.liveSearchNormalize) {
                        $searchBase = $searchBase.not(':a' + that._searchStyle() + '("' + normalizeToBase(that.$searchbox.val()) + '")');
                    } else {
                        $searchBase = $searchBase.not(':' + that._searchStyle() + '("' + that.$searchbox.val() + '")');
                    }
                    $searchBase.parent().addClass('hidden');

                    that.$lis.filter('.dropdown-header').each(function () {
                        var $this = $(this),
                            optgroup = $this.data('optgroup');

                        if (that.$lis.filter('[data-optgroup=' + optgroup + ']').not($this).not('.hidden').length === 0) {
                            $this.addClass('hidden');
                            that.$lis.filter('[data-optgroup=' + optgroup + 'div]').addClass('hidden');
                        }
                    });

                    var $lisVisible = that.$lis.not('.hidden');

                    // hide divider if first or last visible, or if followed by another divider
                    $lisVisible.each(function (index) {
                        var $this = $(this);

                        if ($this.hasClass('divider') && (
                            $this.index() === $lisVisible.first().index() ||
                            $this.index() === $lisVisible.last().index() ||
                            $lisVisible.eq(index + 1).hasClass('divider'))) {
                            $this.addClass('hidden');
                        }
                    });

                    if (!that.$lis.not('.hidden, .no-results').length) {
                        if (!!$no_results.parent().length) {
                            $no_results.remove();
                        }
                        $no_results.html(that.options.noneResultsText.replace('{0}', '"' + htmlEscape(that.$searchbox.val()) + '"')).show();
                        that.$menuInner.append($no_results);
                    } else if (!!$no_results.parent().length) {
                        $no_results.remove();
                    }
                } else {
                    that.$lis.not('.is-hidden').removeClass('hidden');
                    if (!!$no_results.parent().length) {
                        $no_results.remove();
                    }
                }

                that.$lis.filter('.active').removeClass('active');
                if (that.$searchbox.val()) that.$lis.not('.hidden, .divider, .dropdown-header').eq(0).addClass('active').children('a').focus();
                $(this).focus();
            });
        },

        _searchStyle: function () {
            var styles = {
                begins: 'ibegins',
                startsWith: 'ibegins'
            };

            return styles[this.options.liveSearchStyle] || 'icontains';
        },

        val: function (value) {
            if (typeof value !== 'undefined') {
                this.$element.val(value);
                this.render();

                return this.$element;
            } else {
                return this.$element.val();
            }
        },

        changeAll: function (status) {
            if (typeof status === 'undefined') status = true;

            this.findLis();

            var $options = this.$element.find('option'),
                $lisVisible = this.$lis.not('.divider, .dropdown-header, .disabled, .hidden').toggleClass('selected', status),
                lisVisLen = $lisVisible.length,
                selectedOptions = [];

            for (var i = 0; i < lisVisLen; i++) {
                var origIndex = $lisVisible[i].getAttribute('data-original-index');
                selectedOptions[selectedOptions.length] = $options.eq(origIndex)[0];
            }

            $(selectedOptions).prop('selected', status);

            this.render(false);
        },

        selectAll: function () {
            return this.changeAll(true);
        },

        deselectAll: function () {
            return this.changeAll(false);
        },

        keydown: function (e) {
            var $this = $(this),
                $parent = $this.is('input') ? $this.parent().parent() : $this.parent(),
                $items,
                that = $parent.data('this'),
                index,
                next,
                first,
                last,
                prev,
                nextPrev,
                prevIndex,
                isActive,
                selector = ':not(.disabled, .hidden, .dropdown-header, .divider)',
                keyCodeMap = {
                    32: ' ',
                    48: '0',
                    49: '1',
                    50: '2',
                    51: '3',
                    52: '4',
                    53: '5',
                    54: '6',
                    55: '7',
                    56: '8',
                    57: '9',
                    59: ';',
                    65: 'a',
                    66: 'b',
                    67: 'c',
                    68: 'd',
                    69: 'e',
                    70: 'f',
                    71: 'g',
                    72: 'h',
                    73: 'i',
                    74: 'j',
                    75: 'k',
                    76: 'l',
                    77: 'm',
                    78: 'n',
                    79: 'o',
                    80: 'p',
                    81: 'q',
                    82: 'r',
                    83: 's',
                    84: 't',
                    85: 'u',
                    86: 'v',
                    87: 'w',
                    88: 'x',
                    89: 'y',
                    90: 'z',
                    96: '0',
                    97: '1',
                    98: '2',
                    99: '3',
                    100: '4',
                    101: '5',
                    102: '6',
                    103: '7',
                    104: '8',
                    105: '9'
                };

            if (that.options.liveSearch) $parent = $this.parent().parent();

            if (that.options.container) $parent = that.$menu;

            $items = $('[role=menu] li', $parent);

            isActive = that.$newElement.hasClass('open');

            if (!isActive && (e.keyCode >= 48 && e.keyCode <= 57 || e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode >= 65 && e.keyCode <= 90)) {
                if (!that.options.container) {
                    that.setSize();
                    that.$menu.parent().addClass('open');
                    isActive = true;
                } else {
                    that.$button.trigger('click');
                }
                that.$searchbox.focus();
            }

            if (that.options.liveSearch) {
                if (/(^9$|27)/.test(e.keyCode.toString(10)) && isActive && that.$menu.find('.active').length === 0) {
                    e.preventDefault();
                    that.$menu.parent().removeClass('open');
                    if (that.options.container) that.$newElement.removeClass('open');
                    that.$button.focus();
                }
                // $items contains li elements when liveSearch is enabled
                $items = $('[role=menu] li' + selector, $parent);
                if (!$this.val() && !/(38|40)/.test(e.keyCode.toString(10))) {
                    if ($items.filter('.active').length === 0) {
                        $items = that.$menuInner.find('li');
                        if (that.options.liveSearchNormalize) {
                            $items = $items.filter(':a' + that._searchStyle() + '(' + normalizeToBase(keyCodeMap[e.keyCode]) + ')');
                        } else {
                            $items = $items.filter(':' + that._searchStyle() + '(' + keyCodeMap[e.keyCode] + ')');
                        }
                    }
                }
            }

            if (!$items.length) return;

            if (/(38|40)/.test(e.keyCode.toString(10))) {
                index = $items.index($items.find('a').filter(':focus').parent());
                first = $items.filter(selector).first().index();
                last = $items.filter(selector).last().index();
                next = $items.eq(index).nextAll(selector).eq(0).index();
                prev = $items.eq(index).prevAll(selector).eq(0).index();
                nextPrev = $items.eq(next).prevAll(selector).eq(0).index();

                if (that.options.liveSearch) {
                    $items.each(function (i) {
                        if (!$(this).hasClass('disabled')) {
                            $(this).data('index', i);
                        }
                    });
                    index = $items.index($items.filter('.active'));
                    first = $items.first().data('index');
                    last = $items.last().data('index');
                    next = $items.eq(index).nextAll().eq(0).data('index');
                    prev = $items.eq(index).prevAll().eq(0).data('index');
                    nextPrev = $items.eq(next).prevAll().eq(0).data('index');
                }

                prevIndex = $this.data('prevIndex');

                if (e.keyCode == 38) {
                    if (that.options.liveSearch) index--;
                    if (index != nextPrev && index > prev) index = prev;
                    if (index < first) index = first;
                    if (index == prevIndex) index = last;
                } else if (e.keyCode == 40) {
                    if (that.options.liveSearch) index++;
                    if (index == -1) index = 0;
                    if (index != nextPrev && index < next) index = next;
                    if (index > last) index = last;
                    if (index == prevIndex) index = first;
                }

                $this.data('prevIndex', index);

                if (!that.options.liveSearch) {
                    $items.eq(index).children('a').focus();
                } else {
                    e.preventDefault();
                    if (!$this.hasClass('dropdown-toggle')) {
                        $items.removeClass('active').eq(index).addClass('active').children('a').focus();
                        $this.focus();
                    }
                }

            } else if (!$this.is('input')) {
                var keyIndex = [],
                    count,
                    prevKey;

                $items.each(function () {
                    if (!$(this).hasClass('disabled')) {
                        if ($.trim($(this).children('a').text().toLowerCase()).substring(0, 1) == keyCodeMap[e.keyCode]) {
                            keyIndex.push($(this).index());
                        }
                    }
                });

                count = $(document).data('keycount');
                count++;
                $(document).data('keycount', count);

                prevKey = $.trim($(':focus').text().toLowerCase()).substring(0, 1);

                if (prevKey != keyCodeMap[e.keyCode]) {
                    count = 1;
                    $(document).data('keycount', count);
                } else if (count >= keyIndex.length) {
                    $(document).data('keycount', 0);
                    if (count > keyIndex.length) count = 1;
                }

                $items.eq(keyIndex[count - 1]).children('a').focus();
            }

            // Select focused option if "Enter", "Spacebar" or "Tab" (when selectOnTab is true) are pressed inside the menu.
            if ((/(13|32)/.test(e.keyCode.toString(10)) || (/(^9$)/.test(e.keyCode.toString(10)) && that.options.selectOnTab)) && isActive) {
                if (!/(32)/.test(e.keyCode.toString(10))) e.preventDefault();
                if (!that.options.liveSearch) {
                    var elem = $(':focus');
                    elem.click();
                    // Bring back focus for multiselects
                    elem.focus();
                    // Prevent screen from scrolling if the user hit the spacebar
                    e.preventDefault();
                    // Fixes spacebar selection of dropdown items in FF & IE
                    $(document).data('spaceSelect', true);
                } else if (!/(32)/.test(e.keyCode.toString(10))) {
                    that.$menuInner.find('.active a').click();
                    $this.focus();
                }
                $(document).data('keycount', 0);
            }

            if ((/(^9$|27)/.test(e.keyCode.toString(10)) && isActive && (that.multiple || that.options.liveSearch)) || (/(27)/.test(e.keyCode.toString(10)) && !isActive)) {
                that.$menu.parent().removeClass('open');
                if (that.options.container) that.$newElement.removeClass('open');
                that.$button.focus();
            }
        },

        mobile: function () {
            this.$element.addClass('mobile-device');
        },

        refresh: function () {
            this.$lis = null;
            this.liObj = {};
            this.reloadLi();
            this.render();
            this.checkDisabled();
            this.liHeight(true);
            this.setStyle();
            this.setWidth();
            if (this.$lis) this.$searchbox.trigger('propertychange');

            this.$element.trigger('refreshed.bs.select');
        },

        hide: function () {
            this.$newElement.hide();
        },

        show: function () {
            this.$newElement.show();
        },

        remove: function () {
            this.$newElement.remove();
            this.$element.remove();
        },

        destroy: function () {
            this.$newElement.remove();

            if (this.$bsContainer) {
                this.$bsContainer.remove();
            } else {
                this.$menu.remove();
            }

            this.$element
                .off('.bs.select')
                .removeData('selectpicker')
                .removeClass('bs-select-hidden selectpicker');
        }
    };

    // SELECTPICKER PLUGIN DEFINITION
    // ==============================
    function Plugin(option, event) {
        // get the args of the outer function..
        var args = arguments;
        // The arguments of the function are explicitly re-defined from the argument list, because the shift causes them
        // to get lost/corrupted in android 2.3 and IE9 #715 #775
        var _option = option,
            _event = event;
        [].shift.apply(args);

        var value;
        var chain = this.each(function () {
            var $this = $(this);
            if ($this.is('select')) {
                var data = $this.data('selectpicker'),
                    options = typeof _option == 'object' && _option;

                if (!data) {
                    var config = $.extend({}, Selectpicker.DEFAULTS, $.fn.selectpicker.defaults || {}, $this.data(), options);
                    config.template = $.extend({}, Selectpicker.DEFAULTS.template, ($.fn.selectpicker.defaults ? $.fn.selectpicker.defaults.template : {}), $this.data().template, options.template);
                    $this.data('selectpicker', (data = new Selectpicker(this, config, _event)));
                } else if (options) {
                    for (var i in options) {
                        if (options.hasOwnProperty(i)) {
                            data.options[i] = options[i];
                        }
                    }
                }

                if (typeof _option == 'string') {
                    if (data[_option] instanceof Function) {
                        value = data[_option].apply(data, args);
                    } else {
                        value = data.options[_option];
                    }
                }
            }
        });

        if (typeof value !== 'undefined') {
            //noinspection JSUnusedAssignment
            return value;
        } else {
            return chain;
        }
    }

    var old = $.fn.selectpicker;
    $.fn.selectpicker = Plugin;
    $.fn.selectpicker.Constructor = Selectpicker;

    // SELECTPICKER NO CONFLICT
    // ========================
    $.fn.selectpicker.noConflict = function () {
        $.fn.selectpicker = old;
        return this;
    };

    $(document)
        .data('keycount', 0)
        .on('keydown.bs.select', '.bootstrap-select [data-toggle=dropdown], .bootstrap-select [role="menu"], .bs-searchbox input', Selectpicker.prototype.keydown)
        .on('focusin.modal', '.bootstrap-select [data-toggle=dropdown], .bootstrap-select [role="menu"], .bs-searchbox input', function (e) {
            e.stopPropagation();
        });

    // SELECTPICKER DATA-API
    // =====================
    $(window).on('load.bs.select.data-api', function () {
        $('.selectpicker').each(function () {
            var $selectpicker = $(this);
            Plugin.call($selectpicker, $selectpicker.data());
        })
    });
})(jQuery);

/*
 * bootstrap-tagsinput v0.4.2 by Tim Schlechter
 *
 */

!function(a){"use strict";function b(b,c){this.itemsArray=[],this.$element=a(b),this.$element.hide(),this.isSelect="SELECT"===b.tagName,this.multiple=this.isSelect&&b.hasAttribute("multiple"),this.objectItems=c&&c.itemValue,this.placeholderText=b.hasAttribute("placeholder")?this.$element.attr("placeholder"):"",this.inputSize=Math.max(1,this.placeholderText.length),this.$container=a('<div class="bootstrap-tagsinput"></div>'),this.$input=a('<input type="text" placeholder="'+this.placeholderText+'"/>').appendTo(this.$container),this.$element.after(this.$container);var d=(this.inputSize<3?3:this.inputSize)+"em";this.$input.get(0).style.cssText="width: "+d+" !important;",this.build(c)}function c(a,b){if("function"!=typeof a[b]){var c=a[b];a[b]=function(a){return a[c]}}}function d(a,b){if("function"!=typeof a[b]){var c=a[b];a[b]=function(){return c}}}function e(a){return a?i.text(a).html():""}function f(a){var b=0;if(document.selection){a.focus();var c=document.selection.createRange();c.moveStart("character",-a.value.length),b=c.text.length}else(a.selectionStart||"0"==a.selectionStart)&&(b=a.selectionStart);return b}function g(b,c){var d=!1;return a.each(c,function(a,c){if("number"==typeof c&&b.which===c)return d=!0,!1;if(b.which===c.which){var e=!c.hasOwnProperty("altKey")||b.altKey===c.altKey,f=!c.hasOwnProperty("shiftKey")||b.shiftKey===c.shiftKey,g=!c.hasOwnProperty("ctrlKey")||b.ctrlKey===c.ctrlKey;if(e&&f&&g)return d=!0,!1}}),d}var h={tagClass:function(){return"label label-primary"},itemValue:function(a){return a?a.toString():a},itemText:function(a){return this.itemValue(a)},freeInput:!0,addOnBlur:!0,maxTags:void 0,maxChars:void 0,confirmKeys:[13,44],onTagExists:function(a,b){b.hide().fadeIn()},trimValue:!1,allowDuplicates:!1};b.prototype={constructor:b,add:function(b,c){var d=this;if(!(d.options.maxTags&&d.itemsArray.length>=d.options.maxTags||b!==!1&&!b)){if("string"==typeof b&&d.options.trimValue&&(b=a.trim(b)),"object"==typeof b&&!d.objectItems)throw"Can't add objects when itemValue option is not set";if(!b.toString().match(/^\s*$/)){if(d.isSelect&&!d.multiple&&d.itemsArray.length>0&&d.remove(d.itemsArray[0]),"string"==typeof b&&"INPUT"===this.$element[0].tagName){var f=b.split(",");if(f.length>1){for(var g=0;g<f.length;g++)this.add(f[g],!0);return void(c||d.pushVal())}}var h=d.options.itemValue(b),i=d.options.itemText(b),j=d.options.tagClass(b),k=a.grep(d.itemsArray,function(a){return d.options.itemValue(a)===h})[0];if(!k||d.options.allowDuplicates){if(!(d.items().toString().length+b.length+1>d.options.maxInputLength)){var l=a.Event("beforeItemAdd",{item:b,cancel:!1});if(d.$element.trigger(l),!l.cancel){d.itemsArray.push(b);var m=a('<span class="tag '+e(j)+'">'+e(i)+'<span data-role="remove"></span></span>');if(m.data("item",b),d.findInputWrapper().before(m),m.after(" "),d.isSelect&&!a('option[value="'+encodeURIComponent(h)+'"]',d.$element)[0]){var n=a("<option selected>"+e(i)+"</option>");n.data("item",b),n.attr("value",h),d.$element.append(n)}c||d.pushVal(),(d.options.maxTags===d.itemsArray.length||d.items().toString().length===d.options.maxInputLength)&&d.$container.addClass("bootstrap-tagsinput-max"),d.$element.trigger(a.Event("itemAdded",{item:b}))}}}else if(d.options.onTagExists){var o=a(".tag",d.$container).filter(function(){return a(this).data("item")===k});d.options.onTagExists(b,o)}}}},remove:function(b,c){var d=this;if(d.objectItems&&(b="object"==typeof b?a.grep(d.itemsArray,function(a){return d.options.itemValue(a)==d.options.itemValue(b)}):a.grep(d.itemsArray,function(a){return d.options.itemValue(a)==b}),b=b[b.length-1]),b){var e=a.Event("beforeItemRemove",{item:b,cancel:!1});if(d.$element.trigger(e),e.cancel)return;a(".tag",d.$container).filter(function(){return a(this).data("item")===b}).remove(),a("option",d.$element).filter(function(){return a(this).data("item")===b}).remove(),-1!==a.inArray(b,d.itemsArray)&&d.itemsArray.splice(a.inArray(b,d.itemsArray),1)}c||d.pushVal(),d.options.maxTags>d.itemsArray.length&&d.$container.removeClass("bootstrap-tagsinput-max"),d.$element.trigger(a.Event("itemRemoved",{item:b}))},removeAll:function(){var b=this;for(a(".tag",b.$container).remove(),a("option",b.$element).remove();b.itemsArray.length>0;)b.itemsArray.pop();b.pushVal()},refresh:function(){var b=this;a(".tag",b.$container).each(function(){var c=a(this),d=c.data("item"),f=b.options.itemValue(d),g=b.options.itemText(d),h=b.options.tagClass(d);if(c.attr("class",null),c.addClass("tag "+e(h)),c.contents().filter(function(){return 3==this.nodeType})[0].nodeValue=e(g),b.isSelect){var i=a("option",b.$element).filter(function(){return a(this).data("item")===d});i.attr("value",f)}})},items:function(){return this.itemsArray},pushVal:function(){var b=this,c=a.map(b.items(),function(a){return b.options.itemValue(a).toString()});b.$element.val(c,!0).trigger("change")},build:function(b){var e=this;if(e.options=a.extend({},h,b),e.objectItems&&(e.options.freeInput=!1),c(e.options,"itemValue"),c(e.options,"itemText"),d(e.options,"tagClass"),e.options.typeahead){var i=e.options.typeahead||{};d(i,"source"),e.$input.typeahead(a.extend({},i,{source:function(b,c){function d(a){for(var b=[],d=0;d<a.length;d++){var g=e.options.itemText(a[d]);f[g]=a[d],b.push(g)}c(b)}this.map={};var f=this.map,g=i.source(b);a.isFunction(g.success)?g.success(d):a.isFunction(g.then)?g.then(d):a.when(g).then(d)},updater:function(a){e.add(this.map[a])},matcher:function(a){return-1!==a.toLowerCase().indexOf(this.query.trim().toLowerCase())},sorter:function(a){return a.sort()},highlighter:function(a){var b=new RegExp("("+this.query+")","gi");return a.replace(b,"<strong>$1</strong>")}}))}if(e.options.typeaheadjs){var j=e.options.typeaheadjs||{};e.$input.typeahead(null,j).on("typeahead:selected",a.proxy(function(a,b){e.add(j.valueKey?b[j.valueKey]:b),e.$input.typeahead("val","")},e))}e.$container.on("click",a.proxy(function(){e.$element.attr("disabled")||e.$input.removeAttr("disabled"),e.$input.focus()},e)),e.options.addOnBlur&&e.options.freeInput&&e.$input.on("focusout",a.proxy(function(){0===a(".typeahead, .twitter-typeahead",e.$container).length&&(e.add(e.$input.val()),e.$input.val(""))},e)),e.$container.on("keydown","input",a.proxy(function(b){var c=a(b.target),d=e.findInputWrapper();if(e.$element.attr("disabled"))return void e.$input.attr("disabled","disabled");switch(b.which){case 8:if(0===f(c[0])){var g=d.prev();g&&e.remove(g.data("item"))}break;case 46:if(0===f(c[0])){var h=d.next();h&&e.remove(h.data("item"))}break;case 37:var i=d.prev();0===c.val().length&&i[0]&&(i.before(d),c.focus());break;case 39:var j=d.next();0===c.val().length&&j[0]&&(j.after(d),c.focus())}{var k=c.val().length;Math.ceil(k/5)}c.attr("size",Math.max(this.inputSize,c.val().length))},e)),e.$container.on("keypress","input",a.proxy(function(b){var c=a(b.target);if(e.$element.attr("disabled"))return void e.$input.attr("disabled","disabled");var d=c.val(),f=e.options.maxChars&&d.length>=e.options.maxChars;e.options.freeInput&&(g(b,e.options.confirmKeys)||f)&&(e.add(f?d.substr(0,e.options.maxChars):d),c.val(""),b.preventDefault());{var h=c.val().length;Math.ceil(h/5)}c.attr("size",Math.max(this.inputSize,c.val().length))},e)),e.$container.on("click","[data-role=remove]",a.proxy(function(b){e.$element.attr("disabled")||e.remove(a(b.target).closest(".tag").data("item"))},e)),e.options.itemValue===h.itemValue&&("INPUT"===e.$element[0].tagName?e.add(e.$element.val()):a("option",e.$element).each(function(){e.add(a(this).attr("value"),!0)}))},destroy:function(){var a=this;a.$container.off("keypress","input"),a.$container.off("click","[role=remove]"),a.$container.remove(),a.$element.removeData("tagsinput"),a.$element.show()},focus:function(){this.$input.focus()},input:function(){return this.$input},findInputWrapper:function(){for(var b=this.$input[0],c=this.$container[0];b&&b.parentNode!==c;)b=b.parentNode;return a(b)}},a.fn.tagsinput=function(c,d){var e=[];return this.each(function(){var f=a(this).data("tagsinput");if(f)if(c||d){if(void 0!==f[c]){var g=f[c](d);void 0!==g&&e.push(g)}}else e.push(f);else f=new b(this,c),a(this).data("tagsinput",f),e.push(f),"SELECT"===this.tagName&&a("option",a(this)).attr("selected","selected"),a(this).val(a(this).val())}),"string"==typeof c?e.length>1?e:e[0]:e},a.fn.tagsinput.Constructor=b;var i=a("<div />");a(function(){a("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput()})}(window.jQuery);

function hideButtons() {
    $('.confirmation-buttons').hide();
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var coverPanel = $('.panel-bg-cover');
        var bg = $(coverPanel).css('background-image');
        var originalImage = bg.replace('url(','').replace(')','');

        reader.onload = function (e) {
            coverPanel.css(
                'background-image', 'url("' + e.target.result + '")'
            );
            $('.confirmation-buttons').show();
        }

        reader.readAsDataURL(input.files[0]);

        $('#heading-cancel-button').on('click', function() {
           coverPanel.css(
               'background-image', 'url("' + originalImage + '")'
           );
            hideButtons();
        });
    }
}

$("#header_picture").change(function(){
    readURL(this);
});



/*! iCheck v1.0.2 by Damir Sultanov, http://git.io/arlzeA, MIT Licensed */
(function(f){function A(a,b,d){var c=a[0],g=/er/.test(d)?_indeterminate:/bl/.test(d)?n:k,e=d==_update?{checked:c[k],disabled:c[n],indeterminate:"true"==a.attr(_indeterminate)||"false"==a.attr(_determinate)}:c[g];if(/^(ch|di|in)/.test(d)&&!e)x(a,g);else if(/^(un|en|de)/.test(d)&&e)q(a,g);else if(d==_update)for(var f in e)e[f]?x(a,f,!0):q(a,f,!0);else if(!b||"toggle"==d){if(!b)a[_callback]("ifClicked");e?c[_type]!==r&&q(a,g):x(a,g)}}function x(a,b,d){var c=a[0],g=a.parent(),e=b==k,u=b==_indeterminate,
    v=b==n,s=u?_determinate:e?y:"enabled",F=l(a,s+t(c[_type])),B=l(a,b+t(c[_type]));if(!0!==c[b]){if(!d&&b==k&&c[_type]==r&&c.name){var w=a.closest("form"),p='input[name="'+c.name+'"]',p=w.length?w.find(p):f(p);p.each(function(){this!==c&&f(this).data(m)&&q(f(this),b)})}u?(c[b]=!0,c[k]&&q(a,k,"force")):(d||(c[b]=!0),e&&c[_indeterminate]&&q(a,_indeterminate,!1));D(a,e,b,d)}c[n]&&l(a,_cursor,!0)&&g.find("."+C).css(_cursor,"default");g[_add](B||l(a,b)||"");g.attr("role")&&!u&&g.attr("aria-"+(v?n:k),"true");
    g[_remove](F||l(a,s)||"")}function q(a,b,d){var c=a[0],g=a.parent(),e=b==k,f=b==_indeterminate,m=b==n,s=f?_determinate:e?y:"enabled",q=l(a,s+t(c[_type])),r=l(a,b+t(c[_type]));if(!1!==c[b]){if(f||!d||"force"==d)c[b]=!1;D(a,e,s,d)}!c[n]&&l(a,_cursor,!0)&&g.find("."+C).css(_cursor,"pointer");g[_remove](r||l(a,b)||"");g.attr("role")&&!f&&g.attr("aria-"+(m?n:k),"false");g[_add](q||l(a,s)||"")}function E(a,b){if(a.data(m)){a.parent().html(a.attr("style",a.data(m).s||""));if(b)a[_callback](b);a.off(".i").unwrap();
    f(_label+'[for="'+a[0].id+'"]').add(a.closest(_label)).off(".i")}}function l(a,b,f){if(a.data(m))return a.data(m).o[b+(f?"":"Class")]}function t(a){return a.charAt(0).toUpperCase()+a.slice(1)}function D(a,b,f,c){if(!c){if(b)a[_callback]("ifToggled");a[_callback]("ifChanged")[_callback]("if"+t(f))}}var m="iCheck",C=m+"-helper",r="radio",k="checked",y="un"+k,n="disabled";_determinate="determinate";_indeterminate="in"+_determinate;_update="update";_type="type";_click="click";_touch="touchbegin.i touchend.i";
    _add="addClass";_remove="removeClass";_callback="trigger";_label="label";_cursor="cursor";_mobile=/ipad|iphone|ipod|android|blackberry|windows phone|opera mini|silk/i.test(navigator.userAgent);f.fn[m]=function(a,b){var d='input[type="checkbox"], input[type="'+r+'"]',c=f(),g=function(a){a.each(function(){var a=f(this);c=a.is(d)?c.add(a):c.add(a.find(d))})};if(/^(check|uncheck|toggle|indeterminate|determinate|disable|enable|update|destroy)$/i.test(a))return a=a.toLowerCase(),g(this),c.each(function(){var c=
        f(this);"destroy"==a?E(c,"ifDestroyed"):A(c,!0,a);f.isFunction(b)&&b()});if("object"!=typeof a&&a)return this;var e=f.extend({checkedClass:k,disabledClass:n,indeterminateClass:_indeterminate,labelHover:!0},a),l=e.handle,v=e.hoverClass||"hover",s=e.focusClass||"focus",t=e.activeClass||"active",B=!!e.labelHover,w=e.labelHoverClass||"hover",p=(""+e.increaseArea).replace("%","")|0;if("checkbox"==l||l==r)d='input[type="'+l+'"]';-50>p&&(p=-50);g(this);return c.each(function(){var a=f(this);E(a);var c=this,
        b=c.id,g=-p+"%",d=100+2*p+"%",d={position:"absolute",top:g,left:g,display:"block",width:d,height:d,margin:0,padding:0,background:"#fff",border:0,opacity:0},g=_mobile?{position:"absolute",visibility:"hidden"}:p?d:{position:"absolute",opacity:0},l="checkbox"==c[_type]?e.checkboxClass||"icheckbox":e.radioClass||"i"+r,z=f(_label+'[for="'+b+'"]').add(a.closest(_label)),u=!!e.aria,y=m+"-"+Math.random().toString(36).substr(2,6),h='<div class="'+l+'" '+(u?'role="'+c[_type]+'" ':"");u&&z.each(function(){h+=
        'aria-labelledby="';this.id?h+=this.id:(this.id=y,h+=y);h+='"'});h=a.wrap(h+"/>")[_callback]("ifCreated").parent().append(e.insert);d=f('<ins class="'+C+'"/>').css(d).appendTo(h);a.data(m,{o:e,s:a.attr("style")}).css(g);e.inheritClass&&h[_add](c.className||"");e.inheritID&&b&&h.attr("id",m+"-"+b);"static"==h.css("position")&&h.css("position","relative");A(a,!0,_update);if(z.length)z.on(_click+".i mouseover.i mouseout.i "+_touch,function(b){var d=b[_type],e=f(this);if(!c[n]){if(d==_click){if(f(b.target).is("a"))return;
        A(a,!1,!0)}else B&&(/ut|nd/.test(d)?(h[_remove](v),e[_remove](w)):(h[_add](v),e[_add](w)));if(_mobile)b.stopPropagation();else return!1}});a.on(_click+".i focus.i blur.i keyup.i keydown.i keypress.i",function(b){var d=b[_type];b=b.keyCode;if(d==_click)return!1;if("keydown"==d&&32==b)return c[_type]==r&&c[k]||(c[k]?q(a,k):x(a,k)),!1;if("keyup"==d&&c[_type]==r)!c[k]&&x(a,k);else if(/us|ur/.test(d))h["blur"==d?_remove:_add](s)});d.on(_click+" mousedown mouseup mouseover mouseout "+_touch,function(b){var d=
        b[_type],e=/wn|up/.test(d)?t:v;if(!c[n]){if(d==_click)A(a,!1,!0);else{if(/wn|er|in/.test(d))h[_add](e);else h[_remove](e+" "+t);if(z.length&&B&&e==v)z[/ut|nd/.test(d)?_remove:_add](w)}if(_mobile)b.stopPropagation();else return!1}})})}})(window.jQuery||window.Zepto);

$(document).ready(function () {


    // Add body-small class if window less than 768px
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }

    // MetsiMenu
    $('#side-menu').metisMenu();

    // Collapse ibox function
    $('.collapse-link').click(function () {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        var content = ibox.find('div.ibox-content');
        content.slideToggle(200);
        button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        ibox.toggleClass('').toggleClass('border-bottom');
        setTimeout(function () {
            ibox.resize();
            ibox.find('[id^=map-]').resize();
        }, 50);
    });

    // Close ibox function
    $('.close-link').click(function () {
        var content = $(this).closest('div.ibox');
        content.remove();
    });

    // Fullscreen ibox function
    $('.fullscreen-link').click(function () {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        $('body').toggleClass('fullscreen-ibox-mode');
        button.toggleClass('fa-expand').toggleClass('fa-compress');
        ibox.toggleClass('fullscreen');
        setTimeout(function () {
            $(window).trigger('resize');
        }, 100);
    });

    // Close menu in canvas mode
    $('.close-canvas-menu').click(function () {
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();
    });

    // Run menu of canvas
    $('body.canvas-menu .sidebar-collapse').slimScroll({
        height: '100%',
        railOpacity: 0.9
    });

    // Open close right sidebar
    $('.right-sidebar-toggle').click(function () {
        $('#right-sidebar').toggleClass('sidebar-open');
    });

    // Initialize slimscroll for right sidebar
    $('.sidebar-container').slimScroll({
        height: '100%',
        railOpacity: 0.4,
        wheelStep: 10
    });

    // Open close small chat
    $('.open-small-chat').click(function () {
        $(this).children().toggleClass('fa-comments').toggleClass('fa-remove');
        $('.small-chat-box').toggleClass('active');
    });

    // Initialize slimscroll for small chat
    $('.small-chat-box .content').slimScroll({
        height: '234px',
        railOpacity: 0.4
    });

    // Small todo handler
    $('.check-link').click(function () {
        var button = $(this).find('i');
        var label = $(this).next('span');
        button.toggleClass('fa-check-square').toggleClass('fa-square-o');
        label.toggleClass('todo-completed');
        return false;
    });

    // Minimalize menu
    $('.navbar-minimalize').click(function () {
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();

    });

    // Tooltips demo
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    // Move modal to body
    // Fix Bootstrap backdrop issu with animation.css
    $('.modal').appendTo("body");

    // Full height of sidebar
    function fix_height() {
        var heightWithoutNavbar = $("body > #wrapper").height() - 61;
        $(".sidebard-panel").css("min-height", heightWithoutNavbar + "px");

        var navbarHeigh = $('nav.navbar-default').height();
        var wrapperHeigh = $('#page-wrapper').height();

        if (navbarHeigh > wrapperHeigh) {
            $('#page-wrapper').css("min-height", navbarHeigh + "px");
        }

        if (navbarHeigh < wrapperHeigh) {
            $('#page-wrapper').css("min-height", $(window).height() + "px");
        }

        if ($('body').hasClass('fixed-nav')) {
            if (navbarHeigh > wrapperHeigh) {
                $('#page-wrapper').css("min-height", navbarHeigh - 60 + "px");
            } else {
                $('#page-wrapper').css("min-height", $(window).height() - 60 + "px");
            }
        }

    }

    fix_height();

    // Fixed Sidebar
    $(window).bind("load", function () {
        if ($("body").hasClass('fixed-sidebar')) {
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });
        }
    });

    // Move right sidebar top after scroll
    $(window).scroll(function () {
        if ($(window).scrollTop() > 0 && !$('body').hasClass('fixed-nav')) {
            $('#right-sidebar').addClass('sidebar-top');
        } else {
            $('#right-sidebar').removeClass('sidebar-top');
        }
    });

    $(window).bind("load resize scroll", function () {
        if (!$("body").hasClass('body-small')) {
            fix_height();
        }
    });

    $("[data-toggle=popover]")
        .popover();

    // Add slimscroll to element
    $('.full-height-scroll').slimscroll({
        height: '100%'
    })
});


// Minimalize menu when screen is less than 768px
$(window).bind("resize", function () {
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }
});

function SmoothlyMenu() {
    if (!$('body').hasClass('mini-navbar') || $('body').hasClass('body-small')) {
        // Hide menu in order to smoothly turn on when maximize menu
        $('#side-menu').hide();
        // For smoothly turn on menu
        setTimeout(
            function () {
                $('#side-menu').fadeIn(400);
            }, 200);
    } else if ($('body').hasClass('fixed-sidebar')) {
        $('#side-menu').hide();
        setTimeout(
            function () {
                $('#side-menu').fadeIn(400);
            }, 100);
    } else {
        // Remove all inline style from jquery fadeIn function to reset menu state
        $('#side-menu').removeAttr('style');
    }
}


!function (n, t, e) {
    "use strict";
    var i, a, o, s, l, r, c, f, d, u, h, v, p, g, m, y, C, b, w, T, S, x, N, k, A, E, H, O, I, M, $;
    N = {
        paneClass: "nano-pane",
        sliderClass: "nano-slider",
        contentClass: "nano-content",
        iOSNativeScrolling: !1,
        preventPageScrolling: !1,
        disableResize: !1,
        alwaysVisible: !1,
        flashDelay: 1500,
        sliderMinHeight: 20,
        sliderMaxHeight: null,
        documentContext: null,
        windowContext: null
    }, b = "scrollbar", C = "scroll", d = "mousedown", u = "mouseenter", h = "mousemove", p = "mousewheel", v = "mouseup", y = "resize", l = "drag", r = "enter", T = "up", m = "panedown", o = "DOMMouseScroll", s = "down", S = "wheel", c = "keydown", f = "keyup", w = "touchmove", i = "Microsoft Internet Explorer" === t.navigator.appName && /msie 7./i.test(t.navigator.appVersion) && t.ActiveXObject, a = null, H = t.requestAnimationFrame, x = t.cancelAnimationFrame, I = e.createElement("div").style, $ = function () {
        var n, t, e, i, a, o;
        for (i = ["t", "webkitT", "MozT", "msT", "OT"], n = a = 0, o = i.length; o > a; n = ++a)if (e = i[n], t = i[n] + "ransform", t in I)return i[n].substr(0, i[n].length - 1);
        return !1
    }(), M = function (n) {
        return $ === !1 ? !1 : "" === $ ? n : $ + n.charAt(0).toUpperCase() + n.substr(1)
    }, O = M("transform"), A = O !== !1, k = function () {
        var n, t, i;
        return n = e.createElement("div"), t = n.style, t.position = "absolute", t.width = "100px", t.height = "100px", t.overflow = C, t.top = "-9999px", e.body.appendChild(n), i = n.offsetWidth - n.clientWidth, e.body.removeChild(n), i
    }, E = function () {
        var n, e, i;
        return e = t.navigator.userAgent, (n = /(?=.+Mac OS X)(?=.+Firefox)/.test(e)) ? (i = /Firefox\/\d{2}\./.exec(e), i && (i = i[0].replace(/\D+/g, "")), n && +i > 23) : !1
    }, g = function () {
        function c(i, o) {
            this.el = i, this.options = o, a || (a = k()), this.$el = n(this.el), this.doc = n(this.options.documentContext || e), this.win = n(this.options.windowContext || t), this.body = this.doc.find("body"), this.$content = this.$el.children("." + o.contentClass), this.$content.attr("tabindex", this.options.tabIndex || 0), this.content = this.$content[0], this.previousPosition = 0, this.options.iOSNativeScrolling && null != this.el.style.WebkitOverflowScrolling ? this.nativeScrolling() : this.generate(), this.createEvents(), this.addEvents(), this.reset()
        }

        return c.prototype.preventScrolling = function (n, t) {
            if (this.isActive)if (n.type === o)(t === s && n.originalEvent.detail > 0 || t === T && n.originalEvent.detail < 0) && n.preventDefault(); else if (n.type === p) {
                if (!n.originalEvent || !n.originalEvent.wheelDelta)return;
                (t === s && n.originalEvent.wheelDelta < 0 || t === T && n.originalEvent.wheelDelta > 0) && n.preventDefault()
            }
        }, c.prototype.nativeScrolling = function () {
            this.$content.css({WebkitOverflowScrolling: "touch"}), this.iOSNativeScrolling = !0, this.isActive = !0
        }, c.prototype.updateScrollValues = function () {
            var n, t;
            n = this.content, this.maxScrollTop = n.scrollHeight - n.clientHeight, this.prevScrollTop = this.contentScrollTop || 0, this.contentScrollTop = n.scrollTop, t = this.contentScrollTop > this.previousPosition ? "down" : this.contentScrollTop < this.previousPosition ? "up" : "same", this.previousPosition = this.contentScrollTop, "same" !== t && this.$el.trigger("update", {
                position: this.contentScrollTop,
                maximum: this.maxScrollTop,
                direction: t
            }), this.iOSNativeScrolling || (this.maxSliderTop = this.paneHeight - this.sliderHeight, this.sliderTop = 0 === this.maxScrollTop ? 0 : this.contentScrollTop * this.maxSliderTop / this.maxScrollTop)
        }, c.prototype.setOnScrollStyles = function () {
            var n;
            A ? (n = {}, n[O] = "translate(0, " + this.sliderTop + "px)") : n = {top: this.sliderTop}, H ? (x && this.scrollRAF && x(this.scrollRAF), this.scrollRAF = H(function (t) {
                return function () {
                    return t.scrollRAF = null, t.slider.css(n)
                }
            }(this))) : this.slider.css(n)
        }, c.prototype.createEvents = function () {
            this.events = {
                down: function (n) {
                    return function (t) {
                        return n.isBeingDragged = !0, n.offsetY = t.pageY - n.slider.offset().top, n.slider.is(t.target) || (n.offsetY = 0), n.pane.addClass("active"), n.doc.bind(h, n.events[l]).bind(v, n.events[T]), n.body.bind(u, n.events[r]), !1
                    }
                }(this), drag: function (n) {
                    return function (t) {
                        return n.sliderY = t.pageY - n.$el.offset().top - n.paneTop - (n.offsetY || .5 * n.sliderHeight), n.scroll(), n.contentScrollTop >= n.maxScrollTop && n.prevScrollTop !== n.maxScrollTop ? n.$el.trigger("scrollend") : 0 === n.contentScrollTop && 0 !== n.prevScrollTop && n.$el.trigger("scrolltop"), !1
                    }
                }(this), up: function (n) {
                    return function () {
                        return n.isBeingDragged = !1, n.pane.removeClass("active"), n.doc.unbind(h, n.events[l]).unbind(v, n.events[T]), n.body.unbind(u, n.events[r]), !1
                    }
                }(this), resize: function (n) {
                    return function () {
                        n.reset()
                    }
                }(this), panedown: function (n) {
                    return function (t) {
                        return n.sliderY = (t.offsetY || t.originalEvent.layerY) - .5 * n.sliderHeight, n.scroll(), n.events.down(t), !1
                    }
                }(this), scroll: function (n) {
                    return function (t) {
                        n.updateScrollValues(), n.isBeingDragged || (n.iOSNativeScrolling || (n.sliderY = n.sliderTop, n.setOnScrollStyles()), null != t && (n.contentScrollTop >= n.maxScrollTop ? (n.options.preventPageScrolling && n.preventScrolling(t, s), n.prevScrollTop !== n.maxScrollTop && n.$el.trigger("scrollend")) : 0 === n.contentScrollTop && (n.options.preventPageScrolling && n.preventScrolling(t, T), 0 !== n.prevScrollTop && n.$el.trigger("scrolltop"))))
                    }
                }(this), wheel: function (n) {
                    return function (t) {
                        var e;
                        return null != t ? (e = t.delta || t.wheelDelta || t.originalEvent && t.originalEvent.wheelDelta || -t.detail || t.originalEvent && -t.originalEvent.detail, e && (n.sliderY += -e / 3), n.scroll(), !1) : void 0
                    }
                }(this), enter: function (n) {
                    return function (t) {
                        var e;
                        return n.isBeingDragged && 1 !== (t.buttons || t.which) ? (e = n.events)[T].apply(e, arguments) : void 0
                    }
                }(this)
            }
        }, c.prototype.addEvents = function () {
            var n;
            this.removeEvents(), n = this.events, this.options.disableResize || this.win.bind(y, n[y]), this.iOSNativeScrolling || (this.slider.bind(d, n[s]), this.pane.bind(d, n[m]).bind("" + p + " " + o, n[S])), this.$content.bind("" + C + " " + p + " " + o + " " + w, n[C])
        }, c.prototype.removeEvents = function () {
            var n;
            n = this.events, this.win.unbind(y, n[y]), this.iOSNativeScrolling || (this.slider.unbind(), this.pane.unbind()), this.$content.unbind("" + C + " " + p + " " + o + " " + w, n[C])
        }, c.prototype.generate = function () {
            var n, e, i, o, s, l, r;
            return o = this.options, l = o.paneClass, r = o.sliderClass, n = o.contentClass, (s = this.$el.children("." + l)).length || s.children("." + r).length || this.$el.append('<div class="' + l + '"><div class="' + r + '" /></div>'), this.pane = this.$el.children("." + l), this.slider = this.pane.find("." + r), 0 === a && E() ? (i = t.getComputedStyle(this.content, null).getPropertyValue("padding-right").replace(/[^0-9.]+/g, ""), e = {
                right: -14,
                paddingRight: +i + 14
            }) : a && (e = {right: -a}, this.$el.addClass("has-scrollbar")), null != e && this.$content.css(e), this
        }, c.prototype.restore = function () {
            this.stopped = !1, this.iOSNativeScrolling || this.pane.show(), this.addEvents()
        }, c.prototype.reset = function () {
            var n, t, e, o, s, l, r, c, f, d, u, h;
            return this.iOSNativeScrolling ? void(this.contentHeight = this.content.scrollHeight) : (this.$el.find("." + this.options.paneClass).length || this.generate().stop(), this.stopped && this.restore(), n = this.content, o = n.style, s = o.overflowY, i && this.$content.css({height: this.$content.height()}), t = n.scrollHeight + a, d = parseInt(this.$el.css("max-height"), 10), d > 0 && (this.$el.height(""), this.$el.height(n.scrollHeight > d ? d : n.scrollHeight)), r = this.pane.outerHeight(!1), f = parseInt(this.pane.css("top"), 10), l = parseInt(this.pane.css("bottom"), 10), c = r + f + l, h = Math.round(c / t * c), h < this.options.sliderMinHeight ? h = this.options.sliderMinHeight : null != this.options.sliderMaxHeight && h > this.options.sliderMaxHeight && (h = this.options.sliderMaxHeight), s === C && o.overflowX !== C && (h += a), this.maxSliderTop = c - h, this.contentHeight = t, this.paneHeight = r, this.paneOuterHeight = c, this.sliderHeight = h, this.paneTop = f, this.slider.height(h), this.events.scroll(), this.pane.show(), this.isActive = !0, n.scrollHeight === n.clientHeight || this.pane.outerHeight(!0) >= n.scrollHeight && s !== C ? (this.pane.hide(), this.isActive = !1) : this.el.clientHeight === n.scrollHeight && s === C ? this.slider.hide() : this.slider.show(), this.pane.css({
                opacity: this.options.alwaysVisible ? 1 : "",
                visibility: this.options.alwaysVisible ? "visible" : ""
            }), e = this.$content.css("position"), ("static" === e || "relative" === e) && (u = parseInt(this.$content.css("right"), 10), u && this.$content.css({
                right: "",
                marginRight: u
            })), this)
        }, c.prototype.scroll = function () {
            return this.isActive ? (this.sliderY = Math.max(0, this.sliderY), this.sliderY = Math.min(this.maxSliderTop, this.sliderY), this.$content.scrollTop(this.maxScrollTop * this.sliderY / this.maxSliderTop), this.iOSNativeScrolling || (this.updateScrollValues(), this.setOnScrollStyles()), this) : void 0
        }, c.prototype.scrollBottom = function (n) {
            return this.isActive ? (this.$content.scrollTop(this.contentHeight - this.$content.height() - n).trigger(p), this.stop().restore(), this) : void 0
        }, c.prototype.scrollTop = function (n) {
            return this.isActive ? (this.$content.scrollTop(+n).trigger(p), this.stop().restore(), this) : void 0
        }, c.prototype.scrollTo = function (n) {
            return this.isActive ? (this.scrollTop(this.$el.find(n).get(0).offsetTop), this) : void 0
        }, c.prototype.stop = function () {
            return x && this.scrollRAF && (x(this.scrollRAF), this.scrollRAF = null), this.stopped = !0, this.removeEvents(), this.iOSNativeScrolling || this.pane.hide(), this
        }, c.prototype.destroy = function () {
            return this.stopped || this.stop(), !this.iOSNativeScrolling && this.pane.length && this.pane.remove(), i && this.$content.height(""), this.$content.removeAttr("tabindex"), this.$el.hasClass("has-scrollbar") && (this.$el.removeClass("has-scrollbar"), this.$content.css({right: ""})), this
        }, c.prototype.flash = function () {
            return !this.iOSNativeScrolling && this.isActive ? (this.reset(), this.pane.addClass("flashed"), setTimeout(function (n) {
                return function () {
                    n.pane.removeClass("flashed")
                }
            }(this), this.options.flashDelay), this) : void 0
        }, c
    }(), n.fn.nanoScroller = function (t) {
        return this.each(function () {
            var e, i;
            if ((i = this.nanoscroller) || (e = n.extend({}, N, t), this.nanoscroller = i = new g(this, e)), t && "object" == typeof t) {
                if (n.extend(i.options, t), null != t.scrollBottom)return i.scrollBottom(t.scrollBottom);
                if (null != t.scrollTop)return i.scrollTop(t.scrollTop);
                if (t.scrollTo)return i.scrollTo(t.scrollTo);
                if ("bottom" === t.scroll)return i.scrollBottom(0);
                if ("top" === t.scroll)return i.scrollTop(0);
                if (t.scroll && t.scroll instanceof n)return i.scrollTo(t.scroll);
                if (t.stop)return i.stop();
                if (t.destroy)return i.destroy();
                if (t.flash)return i.flash()
            }
            return i.reset()
        })
    }, n.fn.nanoScroller.Constructor = g
}(jQuery, window, document), !function (n, t, e) {
    function i(t, e) {
        this.element = n(t), this.settings = n.extend({}, o, e), this._defaults = o, this._name = a, this.init()
    }

    var a = "metisMenu", o = {toggle: !0, doubleTapToGo: !1};
    i.prototype = {
        init: function () {
            var t = this.element, i = this.settings.toggle, o = this;
            this.isIE() <= 9 ? (t.find("li.active").has("ul").children("ul").collapse("show"), t.find("li").not(".active").has("ul").children("ul").collapse("hide")) : (t.find("li.active").has("ul").children("ul").addClass("collapse in"), t.find("li").not(".active").has("ul").children("ul").addClass("collapse")), o.settings.doubleTapToGo && t.find("li.active").has("ul").children("a").addClass("doubleTapToGo"), t.find("li").has("ul").children("a").on("click." + a, function (t) {
                return t.preventDefault(), o.settings.doubleTapToGo && o.doubleTapToGo(n(this)) && "#" !== n(this).attr("href") && "" !== n(this).attr("href") ? (t.stopPropagation(), void(e.location = n(this).attr("href"))) : (n(this).parent("li").toggleClass("active").children("ul").collapse("toggle"), void(i && n(this).parent("li").siblings().removeClass("active").children("ul.in").collapse("hide")))
            })
        }, isIE: function () {
            for (var n, t = 3, i = e.createElement("div"), a = i.getElementsByTagName("i"); i.innerHTML = "<!--[if gt IE " + ++t + "]><i></i><![endif]-->", a[0];)return t > 4 ? t : n
        }, doubleTapToGo: function (n) {
            var t = this.element;
            return n.hasClass("doubleTapToGo") ? (n.removeClass("doubleTapToGo"), !0) : n.parent().children("ul").length ? (t.find(".doubleTapToGo").removeClass("doubleTapToGo"), n.addClass("doubleTapToGo"), !1) : void 0
        }, remove: function () {
            this.element.off("." + a), this.element.removeData(a)
        }
    }, n.fn[a] = function (t) {
        return this.each(function () {
            var e = n(this);
            e.data(a) && e.data(a).remove(), e.data(a, new i(this, t))
        }), this
    }
}(jQuery, window, document), !function (n) {
    "use strict";
    window.nifty = {
        container: n("#container"),
        contentContainer: n("#content-container"),
        navbar: n("#navbar"),
        mainNav: n("#mainnav-container"),
        aside: n("#aside-container"),
        footer: n("#footer"),
        scrollTop: n("#scroll-top"),
        window: n(window),
        body: n("body"),
        bodyHtml: n("body, html"),
        document: n(document),
        screenSize: "",
        isMobile: function () {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
        }(),
        randomInt: function (n, t) {
            return Math.floor(Math.random() * (t - n + 1) + n)
        },
        transition: function () {
            var n = document.body || document.documentElement, t = n.style, e = void 0 !== t.transition || void 0 !== t.WebkitTransition;
            return e
        }()
    }, nifty.document.ready(function () {
        nifty.document.trigger("nifty.ready")
    }), nifty.document.on("nifty.ready", function () {
        var t = n(".add-tooltip");
        t.length && t.tooltip();
        var e = n(".add-popover");
        e.length && e.popover();
        var i = n(".nano");
        i.length && i.nanoScroller({preventPageScrolling: !0}), n("#navbar-container .navbar-top-links").on("shown.bs.dropdown", ".dropdown", function () {
            n(this).find(".nano").nanoScroller({preventPageScrolling: !0})
        }), nifty.body.addClass("nifty-ready")
    })
}(jQuery), !function (n) {
    "use strict";
    var t = null, e = function (n) {
        {
            var t = n.find(".mega-dropdown-toggle");
            n.find(".mega-dropdown-menu")
        }
        t.on("click", function (t) {
            t.preventDefault(), n.toggleClass("open")
        })
    }, i = {
        toggle: function () {
            return this.toggleClass("open"), null
        }, show: function () {
            return this.addClass("open"), null
        }, hide: function () {
            return this.removeClass("open"), null
        }
    };
    n.fn.niftyMega = function (t) {
        var a = !1;
        return this.each(function () {
            i[t] ? a = i[t].apply(n(this).find("input"), Array.prototype.slice.call(arguments, 1)) : "object" != typeof t && t || e(n(this))
        }), a
    }, nifty.document.on("nifty.ready", function () {
        t = n(".mega-dropdown"), t.length && t.niftyMega(), n("html").on("click", function (e) {
            t.length && (n(e.target).closest(".mega-dropdown").length || t.removeClass("open"))
        })
    })
}(jQuery), !function (n) {
    "use strict";
    nifty.document.on("nifty.ready", function () {
        var t = n('[data-dismiss="panel"]');
        t.length && t.one("click", function (t) {
            t.preventDefault();
            var e = n(this).parents(".panel");
            e.addClass("remove").on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function (n) {
                "opacity" == n.originalEvent.propertyName && e.remove()
            })
        })
    })
}(jQuery), !function () {
    "use strict";
    nifty.document.one("nifty.ready", function () {
        if (nifty.scrollTop.length && !nifty.isMobile) {
            var n = !0, t = 250;
            nifty.window.scroll(function () {
                nifty.window.scrollTop() > t && !n ? (nifty.navbar.addClass("shadow"), nifty.scrollTop.addClass("in"), n = !0) : nifty.window.scrollTop() < t && n && (nifty.navbar.removeClass("shadow"), nifty.scrollTop.removeClass("in"), n = !1)
            }), nifty.scrollTop.on("click", function (n) {
                n.preventDefault(), nifty.bodyHtml.animate({scrollTop: 0}, 500)
            })
        }
    })
}(jQuery), !function (n) {
    "use strict";
    var t = {
        displayIcon: !0,
        iconColor: "text-dark",
        iconClass: "fa fa-refresh fa-spin fa-2x",
        title: "",
        desc: ""
    }, e = function () {
        return (65536 * (1 + Math.random()) | 0).toString(16).substring(1)
    }, i = {
        show: function (t) {
            var i = n(t.attr("data-target")), a = "nifty-overlay-" + e() + e() + "-" + e(), o = n('<div id="' + a + '" class="panel-overlay"></div>');
            return t.prop("disabled", !0).data("niftyOverlay", a), i.addClass("panel-overlay-wrap"), o.appendTo(i).html(t.data("overlayTemplate")), null
        }, hide: function (t) {
            var e = n(t.attr("data-target")), i = n("#" + t.data("niftyOverlay"));
            return i.length && (t.prop("disabled", !1), e.removeClass("panel-overlay-wrap"), i.hide().remove()), null
        }
    }, a = function (e, i) {
        if (e.data("overlayTemplate"))return null;
        var a = n.extend({}, t, i), o = a.displayIcon ? '<span class="panel-overlay-icon ' + a.iconColor + '"><i class="' + a.iconClass + '"></i></span>' : "";
        return e.data("overlayTemplate", '<div class="panel-overlay-content pad-all unselectable">' + o + '<h4 class="panel-overlay-title">' + a.title + "</h4><p>" + a.desc + "</p></div>"), null
    };
    n.fn.niftyOverlay = function (t) {
        return i[t] ? i[t](this) : "object" != typeof t && t ? null : this.each(function () {
            a(n(this), t)
        })
    }
}(jQuery), !function (n) {
    "use strict";
    var t, i, e = {}, a = !1;
    n.niftyNoty = function (o) {
        {
            var f, s = {
                type: "primary",
                icon: "",
                title: "",
                message: "",
                closeBtn: !0,
                container: "page",
                floating: {position: "top-right", animationIn: "jellyIn", animationOut: "fadeOut"},
                html: null,
                focus: !0,
                timer: 0
            }, l = n.extend({}, s, o), r = n('<div class="alert-wrap"></div>'), c = function () {
                var n = "";
                return o && o.icon && (n = '<div class="media-left"><span class="icon-wrap icon-wrap-xs icon-circle alert-icon"><i class="' + l.icon + '"></i></span></div>'), n
            }, d = function () {
                var n = l.closeBtn ? '<button class="close" type="button"><i class="fa fa-times-circle"></i></button>' : "", t = '<div class="alert alert-' + l.type + '" role="alert">' + n + '<div class="media">';
                return l.html ? t + l.html + "</div></div>" : t + c() + '<div class="media-body"><h4 class="alert-title">' + l.title + '</h4><p class="alert-message">' + l.message + "</p></div></div>"
            }(), u = function () {
                return "floating" === l.container && l.floating.animationOut && (r.removeClass(l.floating.animationIn).addClass(l.floating.animationOut), nifty.transition || r.remove()), r.removeClass("in").on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function (n) {
                    "max-height" == n.originalEvent.propertyName && r.remove()
                }), clearInterval(f), null
            }, h = function (n) {
                nifty.bodyHtml.animate({scrollTop: n}, 300, function () {
                    r.addClass("in")
                })
            };
            !function () {
                if ("page" === l.container)t || (t = n('<div id="page-alert"></div>'), nifty.contentContainer.prepend(t)), i = t, l.focus && h(0); else if ("floating" === l.container)e[l.floating.position] || (e[l.floating.position] = n('<div id="floating-' + l.floating.position + '" class="floating-container"></div>'), nifty.container.append(e[l.floating.position])), i = e[l.floating.position], l.floating.animationIn && r.addClass("in animated " + l.floating.animationIn), l.focus = !1; else {
                    var o = n(l.container), s = o.children(".panel-alert"), c = o.children(".panel-heading");
                    if (!o.length)return a = !1, !1;
                    s.length ? i = s : (i = n('<div class="panel-alert"></div>'), c.length ? c.after(i) : o.prepend(i)), l.focus && h(o.offset().top - 30)
                }
                return a = !0, !1
            }()
        }
        if (a && (i.append(r.html(d)), r.find('[data-dismiss="noty"]').one("click", u), l.closeBtn && r.find(".close").one("click", u), l.timer > 0 && (f = setInterval(u, l.timer)), !l.focus))var p = setInterval(function () {
            r.addClass("in"), clearInterval(p)
        }, 200)
    }
}(jQuery), !function (n) {
    "use strict";
    var t, e = function (t) {
        if (!t.data("nifty-check")) {
            t.data("nifty-check", !0), t.text().trim().length ? t.addClass("form-text") : t.removeClass("form-text");
            var e = t.find("input")[0], i = e.name, a = function () {
                return "radio" == e.type && i ? n(".form-radio").not(t).find("input").filter('input[name="' + i + '"]').parent() : !1
            }(), o = function () {
                "radio" == e.type && a.length && a.each(function () {
                    var t = n(this);
                    t.hasClass("active") && t.trigger("nifty.ch.unchecked"), t.removeClass("active")
                }), e.checked ? t.addClass("active").trigger("nifty.ch.checked") : t.removeClass("active").trigger("nifty.ch.unchecked")
            };
            e.checked ? t.addClass("active") : t.removeClass("active"), n(e).on("change", o)
        }
    }, i = {
        isChecked: function () {
            return this[0].checked
        }, toggle: function () {
            return this[0].checked = !this[0].checked, this.trigger("change"), null
        }, toggleOn: function () {
            return this[0].checked || (this[0].checked = !0, this.trigger("change")), null
        }, toggleOff: function () {
            return this[0].checked && "checkbox" == this[0].type && (this[0].checked = !1, this.trigger("change")), null
        }
    }, a = function () {
        t = n(".form-checkbox, .form-radio"), t.length && t.niftyCheck()
    };
    n.fn.niftyCheck = function (t) {
        var a = !1;
        return this.each(function () {
            i[t] ? a = i[t].apply(n(this).find("input"), Array.prototype.slice.call(arguments, 1)) : "object" != typeof t && t || e(n(this))
        }), a
    }, nifty.document.on("nifty.ready", a).on("change", ".form-checkbox, .form-radio", a), nifty.document.on("change", ".btn-file :file", function () {
        var t = n(this), e = t.get(0).files ? t.get(0).files.length : 1, i = t.val().replace(/\\/g, "/").replace(/.*\//, ""), a = function () {
            try {
                return t[0].files[0].size
            } catch (n) {
                return "Nan"
            }
        }(), o = function () {
            if ("Nan" == a)return "Unknown";
            var n = Math.floor(Math.log(a) / Math.log(1024));
            return 1 * (a / Math.pow(1024, n)).toFixed(2) + " " + ["B", "kB", "MB", "GB", "TB"][n]
        }();
        t.trigger("fileselect", [e, i, o])
    })
}(jQuery), !function (n) {
    nifty.document.on("nifty.ready", function () {
        var t = n("#mainnav-shortcut");
        t.length && t.find("li").each(function () {
            var t = n(this);
            t.popover({
                animation: !1,
                trigger: "hover focus",
                placement: "bottom",
                container: "#mainnav-container",
                template: '<div class="popover mainnav-shortcut"><div class="arrow"></div><div class="popover-content"></div>'
            })
        })
    })
}(jQuery), !function (n, t) {
    var e = {};
    e.eventName = "resizeEnd", e.delay = 250, e.poll = function () {
        var i = n(this), a = i.data(e.eventName);
        a.timeoutId && t.clearTimeout(a.timeoutId), a.timeoutId = t.setTimeout(function () {
            i.trigger(e.eventName)
        }, e.delay)
    }, n.event.special[e.eventName] = {
        setup: function () {
            var t = n(this);
            t.data(e.eventName, {}), t.on("resize", e.poll)
        }, teardown: function () {
            var i = n(this), a = i.data(e.eventName);
            a.timeoutId && t.clearTimeout(a.timeoutId), i.removeData(e.eventName), i.off("resize", e.poll)
        }
    }, n.fn[e.eventName] = function (n, t) {
        return arguments.length > 0 ? this.on(e.eventName, null, n, t) : this.trigger(e.eventName)
    }
}(jQuery, this), !function (n) {
    "use strict";
    var t = n('#mainnav-menu > li > a, #mainnav-menu-wrap .mainnav-widget a[data-toggle="menu-widget"]'), e = n("#mainnav").height(), i = null, a = !1, o = !1, s = null, r = function () {
        var t, e = n('#mainnav-menu > li > a, #mainnav-menu-wrap .mainnav-widget a[data-toggle="menu-widget"]');
        e.each(function () {
            var i = n(this), a = i.children(".menu-title"), o = i.siblings(".collapse"), s = n(i.attr("data-target")), l = s.length ? s.parent() : null, r = null, c = null, f = null, d = null, g = (i.outerHeight() - i.height() / 4, function () {
                return s.length && i.on("click", function (n) {
                    n.preventDefault()
                }), o.length ? (i.on("click", function (n) {
                    n.preventDefault()
                }).parent("li").removeClass("active"), !0) : !1
            }()), m = null, y = function (n) {
                clearInterval(m), m = setInterval(function () {
                    n.nanoScroller({preventPageScrolling: !0, alwaysVisible: !0}), clearInterval(m)
                }, 700)
            };
            n(document).click(function (t) {
                n(t.target).closest("#mainnav-container").length || i.removeClass("hover").popover("hide")
            }), n("#mainnav-menu-wrap > .nano").on("update", function () {
                i.removeClass("hover").popover("hide")
            }), i.popover({
                animation: !1,
                trigger: "manual",
                container: "#mainnav",
                viewport: i,
                html: !0,
                title: function () {
                    return g ? a.html() : null
                },
                content: function () {
                    var t;
                    return g ? (t = n('<div class="sub-menu"></div>'), o.addClass("pop-in").wrap('<div class="nano-content"></div>').parent().appendTo(t)) : s.length ? (t = n('<div class="sidebar-widget-popover"></div>'), s.wrap('<div class="nano-content"></div>').parent().appendTo(t)) : t = '<span class="single-content">' + a.html() + "</span>", t
                },
                template: '<div class="popover menu-popover"><h4 class="popover-title"></h4><div class="popover-content"></div></div>'
            }).on("show.bs.popover", function () {
                if (!r) {
                    if (r = i.data("bs.popover").tip(), c = r.find(".popover-title"), f = r.children(".popover-content"), !g && 0 == s.length)return;
                    d = f.children(".sub-menu")
                }
                !g && 0 == s.length
            }).on("shown.bs.popover", function () {
                if (!g && 0 == s.length) {
                    var t = 0 - .5 * i.outerHeight();
                    return void f.css({"margin-top": t + "px", width: "auto"})
                }
                var e = parseInt(r.css("top")), a = i.outerHeight(), o = function () {
                    return nifty.container.hasClass("mainnav-fixed") ? n(window).outerHeight() - e - a : n(document).height() - e - a
                }(), l = f.find(".nano-content").children().css("height", "auto").outerHeight();
                f.find(".nano-content").children().css("height", ""), e > o ? (c.length && !c.is(":visible") && (a = Math.round(0 - .5 * a)), e -= 5, f.css({
                    top: "",
                    bottom: a + "px",
                    height: e
                }).children().addClass("nano").css({width: "100%"}).nanoScroller({preventPageScrolling: !0}), y(f.find(".nano"))) : (!nifty.container.hasClass("navbar-fixed") && nifty.mainNav.hasClass("affix-top") && (o -= 50), l > o ? ((nifty.container.hasClass("navbar-fixed") || nifty.mainNav.hasClass("affix-top")) && (o -= a + 5), o -= 5, f.css({
                    top: a + "px",
                    bottom: "",
                    height: o
                }).children().addClass("nano").css({width: "100%"}).nanoScroller({preventPageScrolling: !0}), y(f.find(".nano"))) : (c.length && !c.is(":visible") && (a = Math.round(0 - .5 * a)), f.css({
                    top: a + "px",
                    bottom: "",
                    height: "auto"
                }))), c.length && c.css("height", i.outerHeight()), f.on("click", function () {
                    f.find(".nano-pane").hide(), y(f.find(".nano"))
                })
            }).on("hidden.bs.popover", function () {
                i.removeClass("hover"), g ? o.removeAttr("style").appendTo(i.parent()) : s.length && s.appendTo(l), clearInterval(t)
            }).on("click", function () {
                nifty.container.hasClass("mainnav-sm") && (e.popover("hide"), i.addClass("hover").popover("show"))
            }).hover(function () {
                e.popover("hide"), i.addClass("hover").popover("show")
            }, function () {
                clearInterval(t), t = setInterval(function () {
                    r && (r.one("mouseleave", function () {
                        i.removeClass("hover").popover("hide")
                    }), r.is(":hover") || i.removeClass("hover").popover("hide")), clearInterval(t)
                }, 500)
            })
        }), o = !0
    }, c = function () {
        var e = n("#mainnav-menu").find(".collapse");
        e.length && e.each(function () {
            var t = n(this);
            t.hasClass("in") ? t.parent("li").addClass("active") : t.parent("li").removeClass("active")
        }), null != i && i.length && i.nanoScroller({stop: !0}), t.popover("destroy").unbind("mouseenter mouseleave"), o = !1
    }, f = function () {
        var e, t = nifty.container.width();
        e = 740 >= t ? "xs" : t > 740 && 992 > t ? "sm" : t >= 992 && 1200 >= t ? "md" : "lg", s != e && (s = e, nifty.screenSize = e, "sm" == nifty.screenSize && nifty.container.hasClass("mainnav-lg") && n.niftyNav("collapse"))
    }, d = function () {
        return nifty.mainNav.niftyAffix("update"), c(), f(), ("collapse" == a || nifty.container.hasClass("mainnav-sm")) && (nifty.container.removeClass("mainnav-in mainnav-out mainnav-lg"), r()), e = n("#mainnav").height(), a = !1, null
    }, h = {
        revealToggle: function () {
            nifty.container.hasClass("reveal") || nifty.container.addClass("reveal"), nifty.container.toggleClass("mainnav-in mainnav-out").removeClass("mainnav-lg mainnav-sm"), o && c()
        }, revealIn: function () {
            nifty.container.hasClass("reveal") || nifty.container.addClass("reveal"), nifty.container.addClass("mainnav-in").removeClass("mainnav-out mainnav-lg mainnav-sm"), o && c()
        }, revealOut: function () {
            nifty.container.hasClass("reveal") || nifty.container.addClass("reveal"), nifty.container.removeClass("mainnav-in mainnav-lg mainnav-sm").addClass("mainnav-out"), o && c()
        }, slideToggle: function () {
            nifty.container.hasClass("slide") || nifty.container.addClass("slide"), nifty.container.toggleClass("mainnav-in mainnav-out").removeClass("mainnav-lg mainnav-sm"), o && c()
        }, slideIn: function () {
            nifty.container.hasClass("slide") || nifty.container.addClass("slide"), nifty.container.addClass("mainnav-in").removeClass("mainnav-out mainnav-lg mainnav-sm"), o && c()
        }, slideOut: function () {
            nifty.container.hasClass("slide") || nifty.container.addClass("slide"), nifty.container.removeClass("mainnav-in mainnav-lg mainnav-sm").addClass("mainnav-out"), o && c()
        }, pushToggle: function () {
            nifty.container.toggleClass("mainnav-in mainnav-out").removeClass("mainnav-lg mainnav-sm"), nifty.container.hasClass("mainnav-in mainnav-out") && nifty.container.removeClass("mainnav-in"), o && c()
        }, pushIn: function () {
            nifty.container.addClass("mainnav-in").removeClass("mainnav-out mainnav-lg mainnav-sm"), o && c()
        }, pushOut: function () {
            nifty.container.removeClass("mainnav-in mainnav-lg mainnav-sm").addClass("mainnav-out"), o && c()
        }, colExpToggle: function () {
            return nifty.container.hasClass("mainnav-lg mainnav-sm") && nifty.container.removeClass("mainnav-lg"), nifty.container.toggleClass("mainnav-lg mainnav-sm").removeClass("mainnav-in mainnav-out"), nifty.window.trigger("resize")
        }, collapse: function () {
            return nifty.container.addClass("mainnav-sm").removeClass("mainnav-lg mainnav-in mainnav-out"), a = "collapse", nifty.window.trigger("resize")
        }, expand: function () {
            return nifty.container.removeClass("mainnav-sm mainnav-in mainnav-out").addClass("mainnav-lg"), nifty.window.trigger("resize")
        }, togglePosition: function () {
            nifty.container.toggleClass("mainnav-fixed"), nifty.mainNav.niftyAffix("update")
        }, fixedPosition: function () {
            nifty.container.addClass("mainnav-fixed"), nifty.mainNav.niftyAffix("update")
        }, staticPosition: function () {
            nifty.container.removeClass("mainnav-fixed"), nifty.mainNav.niftyAffix("update")
        }, update: d, forceUpdate: f, getScreenSize: function () {
            return s
        }
    };
    n.niftyNav = function (n, t) {
        if (h[n]) {
            ("colExpToggle" == n || "expand" == n || "collapse" == n) && ("xs" == nifty.screenSize && "collapse" == n ? n = "pushOut" : "xs" != nifty.screenSize && "sm" != nifty.screenSize || "colExpToggle" != n && "expand" != n || !nifty.container.hasClass("mainnav-sm") || (n = "pushIn"));
            var e = h[n].apply(this, Array.prototype.slice.call(arguments, 1));
            if (t)return t();
            if (e)return e
        }
        return null
    }, n.fn.isOnScreen = function () {
        var n = {top: nifty.window.scrollTop(), left: nifty.window.scrollLeft()};
        n.right = n.left + nifty.window.width(), n.bottom = n.top + nifty.window.height();
        var t = this.offset();
        return t.right = t.left + this.outerWidth(), t.bottom = t.top + this.outerHeight(), !(n.right < t.left || n.left > t.right || n.bottom < t.bottom || n.top > t.top)
    }, nifty.window.on("resizeEnd", d).trigger("resize"), nifty.document.on("nifty.ready", function () {
        var t = n(".mainnav-toggle");
        t.length && t.on("click", function (e) {
            e.preventDefault(), n.niftyNav(t.hasClass("push") ? "pushToggle" : t.hasClass("slide") ? "slideToggle" : t.hasClass("reveal") ? "revealToggle" : "colExpToggle")
        });
        var e = n("#mainnav-menu");
        e.length && (n("#mainnav-menu").metisMenu({toggle: !0}), i = nifty.mainNav.find(".nano"), i.length && i.nanoScroller({preventPageScrolling: !0}))
    })
}(jQuery), !function (n) {
    "use strict";
    var t = {
        toggleHideShow: function () {
            nifty.container.toggleClass("aside-in"), nifty.window.trigger("resize"), nifty.container.hasClass("aside-in") && e()
        }, show: function () {
            nifty.container.addClass("aside-in"), nifty.window.trigger("resize"), e()
        }, hide: function () {
            nifty.container.removeClass("aside-in"), nifty.window.trigger("resize")
        }, toggleAlign: function () {
            nifty.container.toggleClass("aside-left"), nifty.aside.niftyAffix("update")
        }, alignLeft: function () {
            nifty.container.addClass("aside-left"), nifty.aside.niftyAffix("update")
        }, alignRight: function () {
            nifty.container.removeClass("aside-left"), nifty.aside.niftyAffix("update")
        }, togglePosition: function () {
            nifty.container.toggleClass("aside-fixed"), nifty.aside.niftyAffix("update")
        }, fixedPosition: function () {
            nifty.container.addClass("aside-fixed"), nifty.aside.niftyAffix("update")
        }, staticPosition: function () {
            nifty.container.removeClass("aside-fixed"), nifty.aside.niftyAffix("update")
        }, toggleTheme: function () {
            nifty.container.toggleClass("aside-bright")
        }, brightTheme: function () {
            nifty.container.addClass("aside-bright")
        }, darkTheme: function () {
            nifty.container.removeClass("aside-bright")
        }
    }, e = function () {
        nifty.container.hasClass("mainnav-in") && "xs" != nifty.screenSize && ("sm" == nifty.screenSize ? n.niftyNav("collapse") : nifty.container.removeClass("mainnav-in mainnav-lg mainnav-sm").addClass("mainnav-out"))
    };
    n.niftyAside = function (n, e) {
        return t[n] && (t[n].apply(this, Array.prototype.slice.call(arguments, 1)), e) ? e() : null
    }, nifty.document.on("nifty.ready", function () {
        if (nifty.aside.length) {
            nifty.aside.find(".nano").nanoScroller({preventPageScrolling: !0, alwaysVisible: !1});
            var t = n(".aside-toggle");
            t.length && t.on("click", function () {
                n.niftyAside("toggleHideShow")
            })
        }
    })
}(jQuery), !function (n) {
    "use strict";
    var t = {dynamicMode: !0, selectedOn: null, onChange: null}, e = function (e, i) {
        var a = n.extend({}, t, i), o = e.find(".lang-selected"), s = o.parent(".lang-selector").siblings(".dropdown-menu"), l = s.find("a"), r = l.filter(".active").find(".lang-id").text(), c = l.filter(".active").find(".lang-name").text(), f = function (n) {
            l.removeClass("active"), n.addClass("active"), o.html(n.html()), r = n.find(".lang-id").text(), c = n.find(".lang-name").text(), e.trigger("onChange", [{
                id: r,
                name: c
            }]), "function" == typeof a.onChange && a.onChange.call(this, {id: r, name: c})
        };
        l.on("click", function (t) {
            a.dynamicMode && (t.preventDefault(), t.stopPropagation()), e.dropdown("toggle"), f(n(this))
        }), a.selectedOn && f(n(a.selectedOn))
    }, i = {
        getSelectedID: function () {
            return n(this).find(".lang-id").text()
        }, getSelectedName: function () {
            return n(this).find(".lang-name").text()
        }, getSelected: function () {
            var t = n(this);
            return {id: t.find(".lang-id").text(), name: t.find(".lang-name").text()}
        }, setDisable: function () {
            return n(this).addClass("disabled"), null
        }, setEnable: function () {
            return n(this).removeClass("disabled"), null
        }
    };
    n.fn.niftyLanguage = function (t) {
        var a = !1;
        return this.each(function () {
            i[t] ? a = i[t].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof t && t || e(n(this), t)
        }), a
    }
}(jQuery), !function (n) {
    "use strict";
    n.fn.niftyAffix = function (t) {
        return this.each(function () {
            var i, e = n(this);
            "object" != typeof t && t ? "update" == t && (i = e.data("nifty.af.class")) : (i = t.className, e.data("nifty.af.class", t.className)), nifty.container.hasClass(i) && !nifty.container.hasClass("navbar-fixed") ? e.affix({offset: {top: n("#navbar").outerHeight()}}) : (!nifty.container.hasClass(i) || nifty.container.hasClass("navbar-fixed")) && (nifty.window.off(e.attr("id") + ".affix"), e.removeClass("affix affix-top affix-bottom").removeData("bs.affix"))
        })
    }, nifty.document.on("nifty.ready", function () {
        nifty.mainNav.length && nifty.mainNav.niftyAffix({className: "mainnav-fixed"}), nifty.aside.length && nifty.aside.niftyAffix({className: "aside-fixed"})
    })
}(jQuery);

(function() {
    $('.selectPicker').selectpicker({
        style: 'btn-default',
        size: 4
    });
})();

/*! Copyright (c) 2011 Piotr Rochala (http://rocha.la)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Version: 1.3.6
 *
 */
(function(e){e.fn.extend({slimScroll:function(g){var a=e.extend({width:"auto",height:"250px",size:"7px",color:"#000",position:"right",distance:"1px",start:"top",opacity:.4,alwaysVisible:!1,disableFadeOut:!1,railVisible:!1,railColor:"#333",railOpacity:.2,railDraggable:!0,railClass:"slimScrollRail",barClass:"slimScrollBar",wrapperClass:"slimScrollDiv",allowPageScroll:!1,wheelStep:20,touchScrollStep:200,borderRadius:"7px",railBorderRadius:"7px"},g);this.each(function(){function v(d){if(r){d=d||window.event;
    var c=0;d.wheelDelta&&(c=-d.wheelDelta/120);d.detail&&(c=d.detail/3);e(d.target||d.srcTarget||d.srcElement).closest("."+a.wrapperClass).is(b.parent())&&m(c,!0);d.preventDefault&&!k&&d.preventDefault();k||(d.returnValue=!1)}}function m(d,e,g){k=!1;var f=d,h=b.outerHeight()-c.outerHeight();e&&(f=parseInt(c.css("top"))+d*parseInt(a.wheelStep)/100*c.outerHeight(),f=Math.min(Math.max(f,0),h),f=0<d?Math.ceil(f):Math.floor(f),c.css({top:f+"px"}));l=parseInt(c.css("top"))/(b.outerHeight()-c.outerHeight());
    f=l*(b[0].scrollHeight-b.outerHeight());g&&(f=d,d=f/b[0].scrollHeight*b.outerHeight(),d=Math.min(Math.max(d,0),h),c.css({top:d+"px"}));b.scrollTop(f);b.trigger("slimscrolling",~~f);w();p()}function x(){u=Math.max(b.outerHeight()/b[0].scrollHeight*b.outerHeight(),30);c.css({height:u+"px"});var a=u==b.outerHeight()?"none":"block";c.css({display:a})}function w(){x();clearTimeout(B);l==~~l?(k=a.allowPageScroll,C!=l&&b.trigger("slimscroll",0==~~l?"top":"bottom")):k=!1;C=l;u>=b.outerHeight()?k=!0:(c.stop(!0,
    !0).fadeIn("fast"),a.railVisible&&h.stop(!0,!0).fadeIn("fast"))}function p(){a.alwaysVisible||(B=setTimeout(function(){a.disableFadeOut&&r||y||z||(c.fadeOut("slow"),h.fadeOut("slow"))},1E3))}var r,y,z,B,A,u,l,C,k=!1,b=e(this);if(b.parent().hasClass(a.wrapperClass)){var n=b.scrollTop(),c=b.closest("."+a.barClass),h=b.closest("."+a.railClass);x();if(e.isPlainObject(g)){if("height"in g&&"auto"==g.height){b.parent().css("height","auto");b.css("height","auto");var q=b.parent().parent().height();b.parent().css("height",
    q);b.css("height",q)}if("scrollTo"in g)n=parseInt(a.scrollTo);else if("scrollBy"in g)n+=parseInt(a.scrollBy);else if("destroy"in g){c.remove();h.remove();b.unwrap();return}m(n,!1,!0)}}else if(!(e.isPlainObject(g)&&"destroy"in g)){a.height="auto"==a.height?b.parent().height():a.height;n=e("<div></div>").addClass(a.wrapperClass).css({position:"relative",overflow:"hidden",width:a.width,height:a.height});b.css({overflow:"hidden",width:a.width,height:a.height});var h=e("<div></div>").addClass(a.railClass).css({width:a.size,
    height:"100%",position:"absolute",top:0,display:a.alwaysVisible&&a.railVisible?"block":"none","border-radius":a.railBorderRadius,background:a.railColor,opacity:a.railOpacity,zIndex:90}),c=e("<div></div>").addClass(a.barClass).css({background:a.color,width:a.size,position:"absolute",top:0,opacity:a.opacity,display:a.alwaysVisible?"block":"none","border-radius":a.borderRadius,BorderRadius:a.borderRadius,MozBorderRadius:a.borderRadius,WebkitBorderRadius:a.borderRadius,zIndex:99}),q="right"==a.position?
{right:a.distance}:{left:a.distance};h.css(q);c.css(q);b.wrap(n);b.parent().append(c);b.parent().append(h);a.railDraggable&&c.bind("mousedown",function(a){var b=e(document);z=!0;t=parseFloat(c.css("top"));pageY=a.pageY;b.bind("mousemove.slimscroll",function(a){currTop=t+a.pageY-pageY;c.css("top",currTop);m(0,c.position().top,!1)});b.bind("mouseup.slimscroll",function(a){z=!1;p();b.unbind(".slimscroll")});return!1}).bind("selectstart.slimscroll",function(a){a.stopPropagation();a.preventDefault();return!1});
    h.hover(function(){w()},function(){p()});c.hover(function(){y=!0},function(){y=!1});b.hover(function(){r=!0;w();p()},function(){r=!1;p()});b.bind("touchstart",function(a,b){a.originalEvent.touches.length&&(A=a.originalEvent.touches[0].pageY)});b.bind("touchmove",function(b){k||b.originalEvent.preventDefault();b.originalEvent.touches.length&&(m((A-b.originalEvent.touches[0].pageY)/a.touchScrollStep,!0),A=b.originalEvent.touches[0].pageY)});x();"bottom"===a.start?(c.css({top:b.outerHeight()-c.outerHeight()}),
        m(0,!0)):"top"!==a.start&&(m(e(a.start).position().top,null,!0),a.alwaysVisible||c.hide());window.addEventListener?(this.addEventListener("DOMMouseScroll",v,!1),this.addEventListener("mousewheel",v,!1)):document.attachEvent("onmousewheel",v)}});return this}});e.fn.extend({slimscroll:e.fn.slimScroll})})(jQuery);

(function(){function require(name){var module=require.modules[name];if(!module)throw new Error('failed to require "'+name+'"');if(!("exports"in module)&&typeof module.definition==="function"){module.client=module.component=true;module.definition.call(this,module.exports={},module);delete module.definition}return module.exports}require.loader="component";require.helper={};require.helper.semVerSort=function(a,b){var aArray=a.version.split(".");var bArray=b.version.split(".");for(var i=0;i<aArray.length;++i){var aInt=parseInt(aArray[i],10);var bInt=parseInt(bArray[i],10);if(aInt===bInt){var aLex=aArray[i].substr((""+aInt).length);var bLex=bArray[i].substr((""+bInt).length);if(aLex===""&&bLex!=="")return 1;if(aLex!==""&&bLex==="")return-1;if(aLex!==""&&bLex!=="")return aLex>bLex?1:-1;continue}else if(aInt>bInt){return 1}else{return-1}}return 0};require.latest=function(name,returnPath){function showError(name){throw new Error('failed to find latest module of "'+name+'"')}var versionRegexp=/(.*)~(.*)@v?(\d+\.\d+\.\d+[^\/]*)$/;var remoteRegexp=/(.*)~(.*)/;if(!remoteRegexp.test(name))showError(name);var moduleNames=Object.keys(require.modules);var semVerCandidates=[];var otherCandidates=[];for(var i=0;i<moduleNames.length;i++){var moduleName=moduleNames[i];if(new RegExp(name+"@").test(moduleName)){var version=moduleName.substr(name.length+1);var semVerMatch=versionRegexp.exec(moduleName);if(semVerMatch!=null){semVerCandidates.push({version:version,name:moduleName})}else{otherCandidates.push({version:version,name:moduleName})}}}if(semVerCandidates.concat(otherCandidates).length===0){showError(name)}if(semVerCandidates.length>0){var module=semVerCandidates.sort(require.helper.semVerSort).pop().name;if(returnPath===true){return module}return require(module)}var module=otherCandidates.pop().name;if(returnPath===true){return module}return require(module)};require.modules={};require.register=function(name,definition){require.modules[name]={definition:definition}};require.define=function(name,exports){require.modules[name]={exports:exports}};require.register("abpetkov~transitionize@0.0.3",function(exports,module){module.exports=Transitionize;function Transitionize(element,props){if(!(this instanceof Transitionize))return new Transitionize(element,props);this.element=element;this.props=props||{};this.init()}Transitionize.prototype.isSafari=function(){return/Safari/.test(navigator.userAgent)&&/Apple Computer/.test(navigator.vendor)};Transitionize.prototype.init=function(){var transitions=[];for(var key in this.props){transitions.push(key+" "+this.props[key])}this.element.style.transition=transitions.join(", ");if(this.isSafari())this.element.style.webkitTransition=transitions.join(", ")}});require.register("ftlabs~fastclick@v0.6.11",function(exports,module){function FastClick(layer){"use strict";var oldOnClick,self=this;this.trackingClick=false;this.trackingClickStart=0;this.targetElement=null;this.touchStartX=0;this.touchStartY=0;this.lastTouchIdentifier=0;this.touchBoundary=10;this.layer=layer;if(!layer||!layer.nodeType){throw new TypeError("Layer must be a document node")}this.onClick=function(){return FastClick.prototype.onClick.apply(self,arguments)};this.onMouse=function(){return FastClick.prototype.onMouse.apply(self,arguments)};this.onTouchStart=function(){return FastClick.prototype.onTouchStart.apply(self,arguments)};this.onTouchMove=function(){return FastClick.prototype.onTouchMove.apply(self,arguments)};this.onTouchEnd=function(){return FastClick.prototype.onTouchEnd.apply(self,arguments)};this.onTouchCancel=function(){return FastClick.prototype.onTouchCancel.apply(self,arguments)};if(FastClick.notNeeded(layer)){return}if(this.deviceIsAndroid){layer.addEventListener("mouseover",this.onMouse,true);layer.addEventListener("mousedown",this.onMouse,true);layer.addEventListener("mouseup",this.onMouse,true)}layer.addEventListener("click",this.onClick,true);layer.addEventListener("touchstart",this.onTouchStart,false);layer.addEventListener("touchmove",this.onTouchMove,false);layer.addEventListener("touchend",this.onTouchEnd,false);layer.addEventListener("touchcancel",this.onTouchCancel,false);if(!Event.prototype.stopImmediatePropagation){layer.removeEventListener=function(type,callback,capture){var rmv=Node.prototype.removeEventListener;if(type==="click"){rmv.call(layer,type,callback.hijacked||callback,capture)}else{rmv.call(layer,type,callback,capture)}};layer.addEventListener=function(type,callback,capture){var adv=Node.prototype.addEventListener;if(type==="click"){adv.call(layer,type,callback.hijacked||(callback.hijacked=function(event){if(!event.propagationStopped){callback(event)}}),capture)}else{adv.call(layer,type,callback,capture)}}}if(typeof layer.onclick==="function"){oldOnClick=layer.onclick;layer.addEventListener("click",function(event){oldOnClick(event)},false);layer.onclick=null}}FastClick.prototype.deviceIsAndroid=navigator.userAgent.indexOf("Android")>0;FastClick.prototype.deviceIsIOS=/iP(ad|hone|od)/.test(navigator.userAgent);FastClick.prototype.deviceIsIOS4=FastClick.prototype.deviceIsIOS&&/OS 4_\d(_\d)?/.test(navigator.userAgent);FastClick.prototype.deviceIsIOSWithBadTarget=FastClick.prototype.deviceIsIOS&&/OS ([6-9]|\d{2})_\d/.test(navigator.userAgent);FastClick.prototype.needsClick=function(target){"use strict";switch(target.nodeName.toLowerCase()){case"button":case"select":case"textarea":if(target.disabled){return true}break;case"input":if(this.deviceIsIOS&&target.type==="file"||target.disabled){return true}break;case"label":case"video":return true}return/\bneedsclick\b/.test(target.className)};FastClick.prototype.needsFocus=function(target){"use strict";switch(target.nodeName.toLowerCase()){case"textarea":return true;case"select":return!this.deviceIsAndroid;case"input":switch(target.type){case"button":case"checkbox":case"file":case"image":case"radio":case"submit":return false}return!target.disabled&&!target.readOnly;default:return/\bneedsfocus\b/.test(target.className)}};FastClick.prototype.sendClick=function(targetElement,event){"use strict";var clickEvent,touch;if(document.activeElement&&document.activeElement!==targetElement){document.activeElement.blur()}touch=event.changedTouches[0];clickEvent=document.createEvent("MouseEvents");clickEvent.initMouseEvent(this.determineEventType(targetElement),true,true,window,1,touch.screenX,touch.screenY,touch.clientX,touch.clientY,false,false,false,false,0,null);clickEvent.forwardedTouchEvent=true;targetElement.dispatchEvent(clickEvent)};FastClick.prototype.determineEventType=function(targetElement){"use strict";if(this.deviceIsAndroid&&targetElement.tagName.toLowerCase()==="select"){return"mousedown"}return"click"};FastClick.prototype.focus=function(targetElement){"use strict";var length;if(this.deviceIsIOS&&targetElement.setSelectionRange&&targetElement.type.indexOf("date")!==0&&targetElement.type!=="time"){length=targetElement.value.length;targetElement.setSelectionRange(length,length)}else{targetElement.focus()}};FastClick.prototype.updateScrollParent=function(targetElement){"use strict";var scrollParent,parentElement;scrollParent=targetElement.fastClickScrollParent;if(!scrollParent||!scrollParent.contains(targetElement)){parentElement=targetElement;do{if(parentElement.scrollHeight>parentElement.offsetHeight){scrollParent=parentElement;targetElement.fastClickScrollParent=parentElement;break}parentElement=parentElement.parentElement}while(parentElement)}if(scrollParent){scrollParent.fastClickLastScrollTop=scrollParent.scrollTop}};FastClick.prototype.getTargetElementFromEventTarget=function(eventTarget){"use strict";if(eventTarget.nodeType===Node.TEXT_NODE){return eventTarget.parentNode}return eventTarget};FastClick.prototype.onTouchStart=function(event){"use strict";var targetElement,touch,selection;if(event.targetTouches.length>1){return true}targetElement=this.getTargetElementFromEventTarget(event.target);touch=event.targetTouches[0];if(this.deviceIsIOS){selection=window.getSelection();if(selection.rangeCount&&!selection.isCollapsed){return true}if(!this.deviceIsIOS4){if(touch.identifier===this.lastTouchIdentifier){event.preventDefault();return false}this.lastTouchIdentifier=touch.identifier;this.updateScrollParent(targetElement)}}this.trackingClick=true;this.trackingClickStart=event.timeStamp;this.targetElement=targetElement;this.touchStartX=touch.pageX;this.touchStartY=touch.pageY;if(event.timeStamp-this.lastClickTime<200){event.preventDefault()}return true};FastClick.prototype.touchHasMoved=function(event){"use strict";var touch=event.changedTouches[0],boundary=this.touchBoundary;if(Math.abs(touch.pageX-this.touchStartX)>boundary||Math.abs(touch.pageY-this.touchStartY)>boundary){return true}return false};FastClick.prototype.onTouchMove=function(event){"use strict";if(!this.trackingClick){return true}if(this.targetElement!==this.getTargetElementFromEventTarget(event.target)||this.touchHasMoved(event)){this.trackingClick=false;this.targetElement=null}return true};FastClick.prototype.findControl=function(labelElement){"use strict";if(labelElement.control!==undefined){return labelElement.control}if(labelElement.htmlFor){return document.getElementById(labelElement.htmlFor)}return labelElement.querySelector("button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea")};FastClick.prototype.onTouchEnd=function(event){"use strict";var forElement,trackingClickStart,targetTagName,scrollParent,touch,targetElement=this.targetElement;if(!this.trackingClick){return true}if(event.timeStamp-this.lastClickTime<200){this.cancelNextClick=true;return true}this.cancelNextClick=false;this.lastClickTime=event.timeStamp;trackingClickStart=this.trackingClickStart;this.trackingClick=false;this.trackingClickStart=0;if(this.deviceIsIOSWithBadTarget){touch=event.changedTouches[0];targetElement=document.elementFromPoint(touch.pageX-window.pageXOffset,touch.pageY-window.pageYOffset)||targetElement;targetElement.fastClickScrollParent=this.targetElement.fastClickScrollParent}targetTagName=targetElement.tagName.toLowerCase();if(targetTagName==="label"){forElement=this.findControl(targetElement);if(forElement){this.focus(targetElement);if(this.deviceIsAndroid){return false}targetElement=forElement}}else if(this.needsFocus(targetElement)){if(event.timeStamp-trackingClickStart>100||this.deviceIsIOS&&window.top!==window&&targetTagName==="input"){this.targetElement=null;return false}this.focus(targetElement);if(!this.deviceIsIOS4||targetTagName!=="select"){this.targetElement=null;event.preventDefault()}return false}if(this.deviceIsIOS&&!this.deviceIsIOS4){scrollParent=targetElement.fastClickScrollParent;if(scrollParent&&scrollParent.fastClickLastScrollTop!==scrollParent.scrollTop){return true}}if(!this.needsClick(targetElement)){event.preventDefault();this.sendClick(targetElement,event)}return false};FastClick.prototype.onTouchCancel=function(){"use strict";this.trackingClick=false;this.targetElement=null};FastClick.prototype.onMouse=function(event){"use strict";if(!this.targetElement){return true}if(event.forwardedTouchEvent){return true}if(!event.cancelable){return true}if(!this.needsClick(this.targetElement)||this.cancelNextClick){if(event.stopImmediatePropagation){event.stopImmediatePropagation()}else{event.propagationStopped=true}event.stopPropagation();event.preventDefault();return false}return true};FastClick.prototype.onClick=function(event){"use strict";var permitted;if(this.trackingClick){this.targetElement=null;this.trackingClick=false;return true}if(event.target.type==="submit"&&event.detail===0){return true}permitted=this.onMouse(event);if(!permitted){this.targetElement=null}return permitted};FastClick.prototype.destroy=function(){"use strict";var layer=this.layer;if(this.deviceIsAndroid){layer.removeEventListener("mouseover",this.onMouse,true);layer.removeEventListener("mousedown",this.onMouse,true);layer.removeEventListener("mouseup",this.onMouse,true)}layer.removeEventListener("click",this.onClick,true);layer.removeEventListener("touchstart",this.onTouchStart,false);layer.removeEventListener("touchmove",this.onTouchMove,false);layer.removeEventListener("touchend",this.onTouchEnd,false);layer.removeEventListener("touchcancel",this.onTouchCancel,false)};FastClick.notNeeded=function(layer){"use strict";var metaViewport;var chromeVersion;if(typeof window.ontouchstart==="undefined"){return true}chromeVersion=+(/Chrome\/([0-9]+)/.exec(navigator.userAgent)||[,0])[1];if(chromeVersion){if(FastClick.prototype.deviceIsAndroid){metaViewport=document.querySelector("meta[name=viewport]");if(metaViewport){if(metaViewport.content.indexOf("user-scalable=no")!==-1){return true}if(chromeVersion>31&&window.innerWidth<=window.screen.width){return true}}}else{return true}}if(layer.style.msTouchAction==="none"){return true}return false};FastClick.attach=function(layer){"use strict";return new FastClick(layer)};if(typeof define!=="undefined"&&define.amd){define(function(){"use strict";return FastClick})}else if(typeof module!=="undefined"&&module.exports){module.exports=FastClick.attach;module.exports.FastClick=FastClick}else{window.FastClick=FastClick}});require.register("component~indexof@0.0.3",function(exports,module){module.exports=function(arr,obj){if(arr.indexOf)return arr.indexOf(obj);for(var i=0;i<arr.length;++i){if(arr[i]===obj)return i}return-1}});require.register("component~classes@1.2.1",function(exports,module){var index=require("component~indexof@0.0.3");var re=/\s+/;var toString=Object.prototype.toString;module.exports=function(el){return new ClassList(el)};function ClassList(el){if(!el)throw new Error("A DOM element reference is required");this.el=el;this.list=el.classList}ClassList.prototype.add=function(name){if(this.list){this.list.add(name);return this}var arr=this.array();var i=index(arr,name);if(!~i)arr.push(name);this.el.className=arr.join(" ");return this};ClassList.prototype.remove=function(name){if("[object RegExp]"==toString.call(name)){return this.removeMatching(name)}if(this.list){this.list.remove(name);return this}var arr=this.array();var i=index(arr,name);if(~i)arr.splice(i,1);this.el.className=arr.join(" ");return this};ClassList.prototype.removeMatching=function(re){var arr=this.array();for(var i=0;i<arr.length;i++){if(re.test(arr[i])){this.remove(arr[i])}}return this};ClassList.prototype.toggle=function(name,force){if(this.list){if("undefined"!==typeof force){if(force!==this.list.toggle(name,force)){this.list.toggle(name)}}else{this.list.toggle(name)}return this}if("undefined"!==typeof force){if(!force){this.remove(name)}else{this.add(name)}}else{if(this.has(name)){this.remove(name)}else{this.add(name)}}return this};ClassList.prototype.array=function(){var str=this.el.className.replace(/^\s+|\s+$/g,"");var arr=str.split(re);if(""===arr[0])arr.shift();return arr};ClassList.prototype.has=ClassList.prototype.contains=function(name){return this.list?this.list.contains(name):!!~index(this.array(),name)}});require.register("switchery",function(exports,module){var transitionize=require("abpetkov~transitionize@0.0.3"),fastclick=require("ftlabs~fastclick@v0.6.11"),classes=require("component~classes@1.2.1");module.exports=Switchery;var defaults={color:"#64bd63",secondaryColor:"#dfdfdf",jackColor:"#fff",className:"switchery",disabled:false,disabledOpacity:.5,speed:"0.4s",size:"default"};function Switchery(element,options){if(!(this instanceof Switchery))return new Switchery(element,options);this.element=element;this.options=options||{};for(var i in defaults){if(this.options[i]==null){this.options[i]=defaults[i]}}if(this.element!=null&&this.element.type=="checkbox")this.init()}Switchery.prototype.hide=function(){this.element.style.display="none"};Switchery.prototype.show=function(){var switcher=this.create();this.insertAfter(this.element,switcher)};Switchery.prototype.create=function(){this.switcher=document.createElement("span");this.jack=document.createElement("small");this.switcher.appendChild(this.jack);this.switcher.className=this.options.className;return this.switcher};Switchery.prototype.insertAfter=function(reference,target){reference.parentNode.insertBefore(target,reference.nextSibling)};Switchery.prototype.isChecked=function(){return this.element.checked};Switchery.prototype.isDisabled=function(){return this.options.disabled||this.element.disabled||this.element.readOnly};Switchery.prototype.setPosition=function(clicked){var checked=this.isChecked(),switcher=this.switcher,jack=this.jack;if(clicked&&checked)checked=false;else if(clicked&&!checked)checked=true;if(checked===true){this.element.checked=true;if(window.getComputedStyle)jack.style.left=parseInt(window.getComputedStyle(switcher).width)-parseInt(window.getComputedStyle(jack).width)+"px";else jack.style.left=parseInt(switcher.currentStyle["width"])-parseInt(jack.currentStyle["width"])+"px";if(this.options.color)this.colorize();this.setSpeed()}else{jack.style.left=0;this.element.checked=false;this.switcher.style.boxShadow="inset 0 0 0 0 "+this.options.secondaryColor;this.switcher.style.borderColor=this.options.secondaryColor;this.switcher.style.backgroundColor=this.options.secondaryColor!==defaults.secondaryColor?this.options.secondaryColor:"#fff";this.jack.style.backgroundColor=this.options.jackColor;this.setSpeed()}};Switchery.prototype.setSpeed=function(){var switcherProp={},jackProp={left:this.options.speed.replace(/[a-z]/,"")/2+"s"};if(this.isChecked()){switcherProp={border:this.options.speed,"box-shadow":this.options.speed,"background-color":this.options.speed.replace(/[a-z]/,"")*3+"s"}}else{switcherProp={border:this.options.speed,"box-shadow":this.options.speed}}transitionize(this.switcher,switcherProp);transitionize(this.jack,jackProp)};Switchery.prototype.setSize=function(){var small="switchery-small",normal="switchery-default",large="switchery-large";switch(this.options.size){case"small":classes(this.switcher).add(small);break;case"large":classes(this.switcher).add(large);break;default:classes(this.switcher).add(normal);break}};Switchery.prototype.colorize=function(){var switcherHeight=this.switcher.offsetHeight/2;this.switcher.style.backgroundColor=this.options.color;this.switcher.style.borderColor=this.options.color;this.switcher.style.boxShadow="inset 0 0 0 "+switcherHeight+"px "+this.options.color;this.jack.style.backgroundColor=this.options.jackColor};Switchery.prototype.handleOnchange=function(state){if(document.dispatchEvent){var event=document.createEvent("HTMLEvents");event.initEvent("change",true,true);this.element.dispatchEvent(event)}else{this.element.fireEvent("onchange")}};Switchery.prototype.handleChange=function(){var self=this,el=this.element;if(el.addEventListener){el.addEventListener("change",function(){self.setPosition()})}else{el.attachEvent("onchange",function(){self.setPosition()})}};Switchery.prototype.handleClick=function(){var self=this,switcher=this.switcher,parent=self.element.parentNode.tagName.toLowerCase(),labelParent=parent==="label"?false:true;if(this.isDisabled()===false){fastclick(switcher);if(switcher.addEventListener){switcher.addEventListener("click",function(e){self.setPosition(labelParent);self.handleOnchange(self.element.checked)})}else{switcher.attachEvent("onclick",function(){self.setPosition(labelParent);self.handleOnchange(self.element.checked)})}}else{this.element.disabled=true;this.switcher.style.opacity=this.options.disabledOpacity}};Switchery.prototype.markAsSwitched=function(){this.element.setAttribute("data-switchery",true)};Switchery.prototype.markedAsSwitched=function(){return this.element.getAttribute("data-switchery")};Switchery.prototype.init=function(){this.hide();this.show();this.setSize();this.setPosition();this.markAsSwitched();this.handleChange();this.handleClick()}});if(typeof exports=="object"){module.exports=require("switchery")}else if(typeof define=="function"&&define.amd){define("Switchery",[],function(){return require("switchery")})}else{(this||window)["Switchery"]=require("switchery")}})();

/*! WOW - v1.0.2 - 2014-10-28
 * Copyright (c) 2014 Matthieu Aussaguel; Licensed MIT */(function(){var a,b,c,d,e,f=function(a,b){return function(){return a.apply(b,arguments)}},g=[].indexOf||function(a){for(var b=0,c=this.length;c>b;b++)if(b in this&&this[b]===a)return b;return-1};b=function(){function a(){}return a.prototype.extend=function(a,b){var c,d;for(c in b)d=b[c],null==a[c]&&(a[c]=d);return a},a.prototype.isMobile=function(a){return/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(a)},a.prototype.addEvent=function(a,b,c){return null!=a.addEventListener?a.addEventListener(b,c,!1):null!=a.attachEvent?a.attachEvent("on"+b,c):a[b]=c},a.prototype.removeEvent=function(a,b,c){return null!=a.removeEventListener?a.removeEventListener(b,c,!1):null!=a.detachEvent?a.detachEvent("on"+b,c):delete a[b]},a.prototype.innerHeight=function(){return"innerHeight"in window?window.innerHeight:document.documentElement.clientHeight},a}(),c=this.WeakMap||this.MozWeakMap||(c=function(){function a(){this.keys=[],this.values=[]}return a.prototype.get=function(a){var b,c,d,e,f;for(f=this.keys,b=d=0,e=f.length;e>d;b=++d)if(c=f[b],c===a)return this.values[b]},a.prototype.set=function(a,b){var c,d,e,f,g;for(g=this.keys,c=e=0,f=g.length;f>e;c=++e)if(d=g[c],d===a)return void(this.values[c]=b);return this.keys.push(a),this.values.push(b)},a}()),a=this.MutationObserver||this.WebkitMutationObserver||this.MozMutationObserver||(a=function(){function a(){"undefined"!=typeof console&&null!==console&&console.warn("MutationObserver is not supported by your browser."),"undefined"!=typeof console&&null!==console&&console.warn("WOW.js cannot detect dom mutations, please call .sync() after loading new content.")}return a.notSupported=!0,a.prototype.observe=function(){},a}()),d=this.getComputedStyle||function(a){return this.getPropertyValue=function(b){var c;return"float"===b&&(b="styleFloat"),e.test(b)&&b.replace(e,function(a,b){return b.toUpperCase()}),(null!=(c=a.currentStyle)?c[b]:void 0)||null},this},e=/(\-([a-z]){1})/g,this.WOW=function(){function e(a){null==a&&(a={}),this.scrollCallback=f(this.scrollCallback,this),this.scrollHandler=f(this.scrollHandler,this),this.start=f(this.start,this),this.scrolled=!0,this.config=this.util().extend(a,this.defaults),this.animationNameCache=new c}return e.prototype.defaults={boxClass:"wow",animateClass:"animated",offset:0,mobile:!0,live:!0},e.prototype.init=function(){var a;return this.element=window.document.documentElement,"interactive"===(a=document.readyState)||"complete"===a?this.start():this.util().addEvent(document,"DOMContentLoaded",this.start),this.finished=[]},e.prototype.start=function(){var b,c,d,e;if(this.stopped=!1,this.boxes=function(){var a,c,d,e;for(d=this.element.querySelectorAll("."+this.config.boxClass),e=[],a=0,c=d.length;c>a;a++)b=d[a],e.push(b);return e}.call(this),this.all=function(){var a,c,d,e;for(d=this.boxes,e=[],a=0,c=d.length;c>a;a++)b=d[a],e.push(b);return e}.call(this),this.boxes.length)if(this.disabled())this.resetStyle();else for(e=this.boxes,c=0,d=e.length;d>c;c++)b=e[c],this.applyStyle(b,!0);return this.disabled()||(this.util().addEvent(window,"scroll",this.scrollHandler),this.util().addEvent(window,"resize",this.scrollHandler),this.interval=setInterval(this.scrollCallback,50)),this.config.live?new a(function(a){return function(b){var c,d,e,f,g;for(g=[],e=0,f=b.length;f>e;e++)d=b[e],g.push(function(){var a,b,e,f;for(e=d.addedNodes||[],f=[],a=0,b=e.length;b>a;a++)c=e[a],f.push(this.doSync(c));return f}.call(a));return g}}(this)).observe(document.body,{childList:!0,subtree:!0}):void 0},e.prototype.stop=function(){return this.stopped=!0,this.util().removeEvent(window,"scroll",this.scrollHandler),this.util().removeEvent(window,"resize",this.scrollHandler),null!=this.interval?clearInterval(this.interval):void 0},e.prototype.sync=function(){return a.notSupported?this.doSync(this.element):void 0},e.prototype.doSync=function(a){var b,c,d,e,f;if(null==a&&(a=this.element),1===a.nodeType){for(a=a.parentNode||a,e=a.querySelectorAll("."+this.config.boxClass),f=[],c=0,d=e.length;d>c;c++)b=e[c],g.call(this.all,b)<0?(this.boxes.push(b),this.all.push(b),this.stopped||this.disabled()?this.resetStyle():this.applyStyle(b,!0),f.push(this.scrolled=!0)):f.push(void 0);return f}},e.prototype.show=function(a){return this.applyStyle(a),a.className=""+a.className+" "+this.config.animateClass},e.prototype.applyStyle=function(a,b){var c,d,e;return d=a.getAttribute("data-wow-duration"),c=a.getAttribute("data-wow-delay"),e=a.getAttribute("data-wow-iteration"),this.animate(function(f){return function(){return f.customStyle(a,b,d,c,e)}}(this))},e.prototype.animate=function(){return"requestAnimationFrame"in window?function(a){return window.requestAnimationFrame(a)}:function(a){return a()}}(),e.prototype.resetStyle=function(){var a,b,c,d,e;for(d=this.boxes,e=[],b=0,c=d.length;c>b;b++)a=d[b],e.push(a.style.visibility="visible");return e},e.prototype.customStyle=function(a,b,c,d,e){return b&&this.cacheAnimationName(a),a.style.visibility=b?"hidden":"visible",c&&this.vendorSet(a.style,{animationDuration:c}),d&&this.vendorSet(a.style,{animationDelay:d}),e&&this.vendorSet(a.style,{animationIterationCount:e}),this.vendorSet(a.style,{animationName:b?"none":this.cachedAnimationName(a)}),a},e.prototype.vendors=["moz","webkit"],e.prototype.vendorSet=function(a,b){var c,d,e,f;f=[];for(c in b)d=b[c],a[""+c]=d,f.push(function(){var b,f,g,h;for(g=this.vendors,h=[],b=0,f=g.length;f>b;b++)e=g[b],h.push(a[""+e+c.charAt(0).toUpperCase()+c.substr(1)]=d);return h}.call(this));return f},e.prototype.vendorCSS=function(a,b){var c,e,f,g,h,i;for(e=d(a),c=e.getPropertyCSSValue(b),i=this.vendors,g=0,h=i.length;h>g;g++)f=i[g],c=c||e.getPropertyCSSValue("-"+f+"-"+b);return c},e.prototype.animationName=function(a){var b;try{b=this.vendorCSS(a,"animation-name").cssText}catch(c){b=d(a).getPropertyValue("animation-name")}return"none"===b?"":b},e.prototype.cacheAnimationName=function(a){return this.animationNameCache.set(a,this.animationName(a))},e.prototype.cachedAnimationName=function(a){return this.animationNameCache.get(a)},e.prototype.scrollHandler=function(){return this.scrolled=!0},e.prototype.scrollCallback=function(){var a;return!this.scrolled||(this.scrolled=!1,this.boxes=function(){var b,c,d,e;for(d=this.boxes,e=[],b=0,c=d.length;c>b;b++)a=d[b],a&&(this.isVisible(a)?this.show(a):e.push(a));return e}.call(this),this.boxes.length||this.config.live)?void 0:this.stop()},e.prototype.offsetTop=function(a){for(var b;void 0===a.offsetTop;)a=a.parentNode;for(b=a.offsetTop;a=a.offsetParent;)b+=a.offsetTop;return b},e.prototype.isVisible=function(a){var b,c,d,e,f;return c=a.getAttribute("data-wow-offset")||this.config.offset,f=window.pageYOffset,e=f+Math.min(this.element.clientHeight,this.util().innerHeight())-c,d=this.offsetTop(a),b=d+a.clientHeight,e>=d&&b>=f},e.prototype.util=function(){return null!=this._util?this._util:this._util=new b},e.prototype.disabled=function(){return!this.config.mobile&&this.util().isMobile(navigator.userAgent)},e}()}).call(this);

//# sourceMappingURL=all.js.map
