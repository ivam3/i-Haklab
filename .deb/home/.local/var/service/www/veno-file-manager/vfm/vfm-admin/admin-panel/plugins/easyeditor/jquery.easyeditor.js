(function($, document, window){
    'use strict';

    function EasyEditor( element, options ){
        this.elem = element;
        options = options || {};
        this.className = options.className || 'easyeditor';

        // 'bold', 'italic', 'link', 'h2', 'h3', 'h4', 'alignleft', 'aligncenter', 'alignright', 'quote', 'code', 'list', 'x', 'source'
        var defaultButtons = ['bold', 'italic', 'link', 'h2', 'h3', 'h4', 'alignleft', 'aligncenter', 'alignright'];
        this.buttons = options.buttons || defaultButtons;
        this.buttonsHtml = options.buttonsHtml || null;
        this.overwriteButtonSettings = options.overwriteButtonSettings || null;
        this.css = options.css || null;
        this.onLoaded = typeof options.onLoaded === 'function' ? options.onLoaded : null;
        this.randomString = Math.random().toString(36).substring(7);
        this.theme = options.theme || null;
        this.dropdown = options.dropdown || {};
        this.characterLimit = options.characterLimit || null;
        this.characterLimitText = options.characterLimitText || null;
        this.characterLimitPreventKeypress = options.characterLimitPreventKeypress || false;

        this.attachEvents();
    }

    // initialize
    EasyEditor.prototype.attachEvents = function() {
        this.bootstrap();
        this.addToolbar();
        this.handleKeypress();
        this.handleResizeImage();
        this.utils();

        if(this.onLoaded !== null) {
            this.onLoaded.call(this, this);
        }
        
        if (this.characterLimit) {
            this.enableCharacterLimit();
        }
    };

    // destory editor
    EasyEditor.prototype.detachEvents = function() {
        var _this = this;
        var $container = $(_this.elem).closest('.' + _this.className +'-wrapper');
        var $toolbar = $container.find('.' + _this.className +'-toolbar');

        $toolbar.remove();
        $(_this.elem).removeClass(_this.className).removeAttr('contenteditable').unwrap();
    };

    // Adding necessary classes and attributes in editor
    EasyEditor.prototype.bootstrap = function() {
        var _this = this;
        var tag = $(_this.elem).prop('tagName').toLowerCase();

        if(tag === 'textarea' || tag === 'input') {
            var placeholderText = $(_this.elem).attr('placeholder') || '';

            var marginTop = $(_this.elem).css('marginTop') || 0;
            var marginBottom = $(_this.elem).css('marginBottom') || 0;
            var style = '';
            if(marginTop.length > 0 || marginBottom.length > 0) {
                style = ' style="margin-top: ' + marginTop + '; margin-bottom: ' + marginBottom + '" ';
            }

            $(_this.elem).after('<div id="' + _this.randomString + '-editor" placeholder="' + placeholderText + '">' + $(_this.elem).val() + '</div>');
            $(_this.elem).hide().addClass(_this.randomString + '-bind');

            _this.elem = document.getElementById(_this.randomString + '-editor');
            $(_this.elem).attr('contentEditable', true).addClass(_this.className).wrap('<div class="'+ _this.className +'-wrapper"' + style + '></div>');
        }
        else {
            $(_this.elem).attr('contentEditable', true).addClass(_this.className).wrap('<div class="'+ _this.className +'-wrapper"></div>');
        }

        this.$wrapperElem = $(_this.elem).parent();

        if(_this.css !== null) {
            $(_this.elem).css(_this.css);
        }

        this.containerClass = '.' + _this.className +'-wrapper';

        if(typeof _this.elem === 'string') {
            _this.elem = $(_this.elem).get(0);
        }

        if(_this.theme !== null) {
            $(_this.elem).closest(_this.containerClass).addClass(_this.theme);
        }
    };

    // enter and paste key handler
    EasyEditor.prototype.handleKeypress = function(){
        var _this = this;

        $(_this.elem).keydown(function(e) {
            if(e.keyCode === 13 && _this.isSelectionInsideElement('li') === false) {
                e.preventDefault();

                if(e.shiftKey === true) {
                    document.execCommand('insertHTML', false, '<br>');
                }
                else {
                    document.execCommand('insertHTML', false, '<br><br>');
                }

                return false;
            }
        });

        _this.elem.addEventListener('paste', function(e) {
            e.preventDefault();
            var text = e.clipboardData.getData('text/plain').replace(/\n/ig, '<br>');
            document.execCommand('insertHTML', false, text);
        });

    };

    EasyEditor.prototype.isSelectionInsideElement = function(tagName) {
        var sel, containerNode;
        tagName = tagName.toUpperCase();
        if (window.getSelection) {
            sel = window.getSelection();
            if (sel.rangeCount > 0) {
                containerNode = sel.getRangeAt(0).commonAncestorContainer;
            }
        } else if ( (sel = document.selection) && sel.type != "Control" ) {
            containerNode = sel.createRange().parentElement();
        }
        while (containerNode) {
            if (containerNode.nodeType == 1 && containerNode.tagName == tagName) {
                return true;
            }
            containerNode = containerNode.parentNode;
        }
        return false;
    };

    // adding toolbar
    EasyEditor.prototype.addToolbar = function(){
        var _this = this;

        $(_this.elem).before('<div class="'+ _this.className +'-toolbar"><ul></ul></div>');
        this.$toolbarContainer = this.$wrapperElem.find('.' + _this.className +'-toolbar');

        this.populateButtons();
    };

    // inejct button events
    EasyEditor.prototype.injectButton = function(settings){
        var _this = this;

        // overwritting default button settings
        if(_this.overwriteButtonSettings !== null && _this.overwriteButtonSettings[settings.buttonIdentifier] !== undefined) {
            var newSettings = $.extend({}, settings, _this.overwriteButtonSettings[settings.buttonIdentifier]);
            settings = newSettings;
        }

        // if button html exists overwrite default button html
        if(_this.buttonsHtml !== null && _this.buttonsHtml[settings.buttonIdentifier] !== undefined) {
            settings.buttonHtml = _this.buttonsHtml[settings.buttonIdentifier];
        }

        // if buttonTitle parameter exists
        var buttonTitle;
        if(settings.buttonTitle) {
            buttonTitle = settings.buttonTitle;
        }
        else {
            buttonTitle = settings.buttonIdentifier.replace(/\W/g, ' ');
        }

        // adding button html
        if(settings.buttonHtml) {
            if(settings.childOf !== undefined) {
                var $parentContainer = _this.$toolbarContainer.find('.toolbar-' + settings.childOf).parent('li');

                if($parentContainer.find('ul').length === 0) {
                    $parentContainer.append('<ul></ul>');
                }

                $parentContainer = $parentContainer.find('ul');
                $parentContainer.append('<li><button type="button" class="toolbar-'+ settings.buttonIdentifier +'" title="'+ buttonTitle +'">'+ settings.buttonHtml +'</button></li>');
            }
            else {
                _this.$toolbarContainer.children('ul').append('<li><button type="button" class="toolbar-'+ settings.buttonIdentifier +'" title="'+ buttonTitle +'">'+ settings.buttonHtml +'</button></li>');
            }
        }

        // bind click event
        if(typeof settings.clickHandler === 'function') {
            $('html').find(_this.elem).closest(_this.containerClass).on('click', '.toolbar-'+ settings.buttonIdentifier, function(event){
                if(typeof settings.hasChild !== undefined && settings.hasChild === true) {
                    event.stopPropagation();
                }
                else {
                    event.preventDefault();
                }

                settings.clickHandler.call(this, this);
                $(_this.elem).trigger('keyup');
            });
        }
    };

    // open dropdown
    EasyEditor.prototype.openDropdownOf = function(identifier){
        var _this = this;
        $(_this.elem).closest(_this.containerClass).find('.toolbar-' + identifier).parent().children('ul').show();
    };

    // bidning all buttons
    EasyEditor.prototype.populateButtons = function(){
        var _this = this;

        $.each(_this.buttons, function(index, button) {
            if(typeof _this[button] === 'function'){
                _this[button]();
            }
        });

    };

    // allowing resizing image
    EasyEditor.prototype.handleResizeImage = function(){
        var _this = this;

        $('html').on('click', _this.containerClass + ' figure', function(event) {
            event.stopPropagation();
            $(this).addClass('is-resizable');
        });

        $('html').on('mousemove', _this.containerClass + ' figure.is-resizable', function(event) {
            $(this).find('img').css({ 'width' : $(this).width() + 'px' });
        });

        $(document).click(function() {
            $(_this.elem).find('figure').removeClass('is-resizable');
        });
    };

    // get selection
    EasyEditor.prototype.getSelection = function(){
        if (window.getSelection) {
            var selection = window.getSelection();

            if (selection.rangeCount) {
                return selection;
            }
        }

        return false;
    };

    // remove formatting
    EasyEditor.prototype.removeFormatting = function(arg){
        var _this = this;
        var inFullArea = arg.inFullArea;

        if(_this.isSelectionOutsideOfEditor() === true) {
            return false;
        }

        if(inFullArea === false) {
            var selection = _this.getSelection();
            var selectedText = selection.toString();

            if(selection && selectedText.length > 0) {

                var range = selection.getRangeAt(0);
                var $parent = $(range.commonAncestorContainer.parentNode);

                if($parent.attr('class') === _this.className || $parent.attr('class') === _this.className + '-wrapper') {
                    var node = document.createElement('span');
                    $(node).attr('data-value', 'temp').html(selectedText.replace(/\n/ig, '<br>'));
                    range.deleteContents();
                    range.insertNode(node);

                    $('[data-value="temp"]').contents().unwrap();
                }
                else {

                    var topMostParent;
                    var hasParentNode = false;
                    $.each($parent.parentsUntil(_this.elem), function(index, el) {
                        topMostParent = el;
                        hasParentNode = true;
                    });

                    if(hasParentNode === true) {
                        $(topMostParent).html($(topMostParent).text().replace(/\n/ig, '<br>')).contents().unwrap();
                    }
                    else {
                        $parent.contents().unwrap();
                    }

                }

            }
        }
        else {
            $(_this.elem).html($(_this.elem).text().replace(/\n/ig, '<br>'));
        }

        // _this.removeEmptyTags();
    };

    // removing empty tags
    EasyEditor.prototype.removeEmptyTags = function(){
        var _this = this;
        $(_this.elem).html( $(_this.elem).html().replace(/(<(?!\/)[^>]+>)+(<\/[^>]+>)+/, '') );
    };

    // remove block elemenet from selection
    EasyEditor.prototype.removeBlockElementFromSelection = function(selection, removeBr){
        var _this = this;
        var result;

        removeBr = removeBr === undefined ? false : removeBr;
        var removeBrNode = '';
        if(removeBr === true) {
            removeBrNode = ', br';
        }

        var range = selection.getRangeAt(0);
        var selectedHtml = range.cloneContents();
        var temp = document.createElement('temp');
        $(temp).html(selectedHtml);
        $(temp).find('h1, h2, h3, h4, h5, h6, p, div' + removeBrNode).each(function() { $(this).replaceWith(this.childNodes); });
        result = $(temp).html();

        return result;
    };

    // wrap selction with a tag
    EasyEditor.prototype.wrapSelectionWithNodeName = function(arg){
        var _this = this;
        if(_this.isSelectionOutsideOfEditor() === true) {
            return false;
        }

        var node = {
            name: 'span',
            blockElement: false,
            style: null,
            class: null,
            attribute: null,
            keepHtml: false
        };

        if(typeof arg === 'string') {
            node.name = arg;
        }
        else {
            node.name = arg.nodeName || node.name;
            node.blockElement = arg.blockElement || node.blockElement;
            node.style = arg.style || node.style;
            node.class = arg.class || node.class;
            node.attribute = arg.attribute || node.attribute;
            node.keepHtml = arg.keepHtml || node.keepHtml;
        }

        var selection = _this.getSelection();

        if(selection && selection.toString().length > 0 && selection.rangeCount) {
            // checking if already wrapped
            var isWrapped = _this.isAlreadyWrapped(selection, node);

            // wrap node
            var range = selection.getRangeAt(0).cloneRange();
            var tag = document.createElement(node.name);

                // adding necessary attribute to tag
                if(node.style !== null || node.class !== null || node.attribute !== null) {
                    tag = _this.addAttribute(tag, node);
                }

            // if selection contains html, surround contents has some problem with pre html tag and raw text selection
            if(_this.selectionContainsHtml(range)) {
                range = selection.getRangeAt(0);

                if(node.keepHtml === true) {
                    var clonedSelection = range.cloneContents();
                    var div = document.createElement('div');
                    div.appendChild(clonedSelection);
                    $(tag).html(div.innerHTML);
                }
                else {
                    tag.textContent = selection.toString();
                }

                range.deleteContents();
                range.insertNode(tag);

                if(range.commonAncestorContainer.localName === node.name) {
                    $(range.commonAncestorContainer).contents().unwrap();
                    _this.removeEmptyTags();
                }
            }
            else {
                range.surroundContents(tag);
                selection.removeAllRanges();
                selection.addRange(range);
            }

            if(isWrapped === true) {
                _this.removeWrappedDuplicateTag(tag);
            }

            _this.removeEmptyTags();
            selection.removeAllRanges();
        }
    };

    // wrap selection with unordered list
    EasyEditor.prototype.wrapSelectionWithList = function(tagname){
        var _this = this;
        tagname = tagname || 'ul';

        // preventing outside selection
        if(_this.isSelectionOutsideOfEditor() === true) {
            return false;
        }

        // if text selected
        var selection = _this.getSelection();
        if(selection && selection.toString().length > 0 && selection.rangeCount) {
            var selectedHtml = _this.removeBlockElementFromSelection(selection, true);
            var listArray = selectedHtml.split('\n').filter(function(v){return v!=='';});
            var wrappedListHtml = $.map(listArray, function(item) {
                return '<li>' + $.trim(item) + '</li>';
            });

            var node = document.createElement(tagname);
            $(node).html(wrappedListHtml);

            var range = selection.getRangeAt(0);
            range.deleteContents();
            range.insertNode(node);

            selection.removeAllRanges();
        }

    };

    // if selection contains html tag, surround content fails if selection contains html
    EasyEditor.prototype.selectionContainsHtml = function(range){
        var _this = this;
        if(range.startContainer.parentNode.className === _this.className + '-wrapper') return false;
        else return true;
    };

    // if already wrapped with same tag
    EasyEditor.prototype.isAlreadyWrapped = function(selection, node){
        var _this = this;
        var range = selection.getRangeAt(0);
        var el = $(range.commonAncestorContainer);
        var result = false;

        if( el.parent().prop('tagName').toLowerCase() === node.name && el.parent().hasClass(_this.className) === false ) {
            result = true;
        }
        else if(node.blockElement === true) {
            $.each(el.parentsUntil(_this.elem), function(index, el) {
                var tag = el.tagName.toLowerCase();
                if( $.inArray(tag, ['h1', 'h2', 'h3', 'h4', 'h5', 'h6']) !== -1 ) {
                    result = true;
                }
            });
        }
        else {
            $.each(el.parentsUntil(_this.elem), function(index, el) {
                var tag = el.tagName.toLowerCase();
                if( tag === node.name ) {
                    result = true;
                }
            });
        }

        return result;
    };

    // remove wrap if already wrapped with same tag
    EasyEditor.prototype.removeWrappedDuplicateTag = function(tag){
        var _this = this;
        var tagName = tag.tagName;

        $(tag).unwrap();

        if($(tag).prop('tagName') === tagName && $(tag).parent().hasClass(_this.className) === false && $(tag).parent().hasClass(_this.className + '-wrapper')) {
            $(tag).unwrap();
        }
    };

    // adding attribute in tag
    EasyEditor.prototype.addAttribute = function(tag, node){
        if(node.style !== null) {
            $(tag).attr('style', node.style);
        }

        if(node.class !== null) {
            $(tag).addClass(node.class);
        }

        if(node.attribute !== null) {
            if($.isArray(node.attribute) === true) {
                if($.isArray(node.attribute[0]) !== true){
                    node.attribute[0] = [node.attribute[0], node.attribute[1]];
                }
                $.each(node.attribute,function(index,pair){
                    $(tag).attr(pair[0], pair[1]);
                });
            }
            else {
                $(tag).attr(node.attribute);
            }
        }

        return tag;
    };

    // insert a node into cursor point in editor
    EasyEditor.prototype.insertAtCaret = function(node){
        var _this = this;
        if(_this.isSelectionOutsideOfEditor() === true) {
            return false;
        }

        if(_this.getSelection()) {
            var range = _this.getSelection().getRangeAt(0);
            range.insertNode(node);
        }
        else {
            $(node).appendTo(_this.elem);
        }
    };

    // checking if selection outside of editor or not
    EasyEditor.prototype.isSelectionOutsideOfEditor = function(){
        return !this.elementContainsSelection(this.elem);
    };

    // node contains in containers or not
    EasyEditor.prototype.isOrContains = function(node, container) {
        while (node) {
            if (node === container) {
                return true;
            }
            node = node.parentNode;
        }
        return false;
    };

    // selected text is inside container
    EasyEditor.prototype.elementContainsSelection = function(el) {
        var _this = this;
        var sel;
        if (window.getSelection) {
            sel = window.getSelection();
            if (sel.rangeCount > 0) {
                for (var i = 0; i < sel.rangeCount; ++i) {
                    if (!_this.isOrContains(sel.getRangeAt(i).commonAncestorContainer, el)) {
                        return false;
                    }
                }
                return true;
            }
        } else if ( (sel = document.selection) && sel.type !== "Control") {
            return _this.isOrContains(sel.createRange().parentElement(), el);
        }
        return false;
    };

    // insert html chunk into editor's temp tag
    EasyEditor.prototype.insertHtml = function(html){
        var _this = this;
        $(_this.elem).find('temp').html(html);
    };

    // utility of editor
    EasyEditor.prototype.utils = function(){
        var _this = this;

        $('html').on('click', '.'+ _this.className +'-modal-close', function(event) {
            event.preventDefault();
            _this.closeModal('#' + $(this).closest('.'+ _this.className + '-modal').attr('id'));
        });
        
        // binding value in textarea if present
        if( $('.' + _this.randomString + '-bind').length > 0 ) {
            var bindData;
            $('html').on('click keyup', _this.elem, function() {
                var el = _this.elem;
                clearTimeout(bindData);
                bindData = setTimeout(function(){ $('.' + _this.randomString + '-bind').html( $(el).html() ); }, 250);
            });
        }

        $(document).click(function(event) {
            $('.' + _this.className).closest('.' + _this.className + '-wrapper').find('.' + _this.className + '-toolbar > ul > li > ul').hide();
        });
    };
    
    // Get value of current easy editor
    EasyEditor.prototype.getValue = function() {
        var _this = this;
        
        var html = $(_this.elem).html();
        var plainText = $(_this.elem).text();
        var characterCount = plainText.length;
        var wordCount = plainText.trim().split(/\s+/).length;
        
        return {
            html: html,
            plainText: plainText,
            characterCount: characterCount,
            wordCount: wordCount
        };
    };
    
    
    // Enable character limit
    EasyEditor.prototype.enableCharacterLimit = function() {
        var _this = this;
        
        var currentCharacterCount = _this.characterLimit - _this.getValue().characterCount;
        $(_this.elem).after('<div class="'+ _this.className +'-character-remaining '+ ((currentCharacterCount <= 0) ? 'is-invalid' : 'is-valid') +'">'+ (_this.characterLimitText ? _this.characterLimitText + ' ' + currentCharacterCount : currentCharacterCount) +'</div>');
        
        $('html').on('keyup', _this.elem, function(){
            var val = _this.getValue();
            var remainingCount = _this.characterLimit - val.characterCount;
            var $dom = $(_this.containerClass).find('[class*="-character-remaining"]');
            
            if (_this.characterLimitText) {
                $dom.text(_this.characterLimitText + ' ' + remainingCount);
            } else {
                $dom.text(remainingCount);
            }
            
            if (remainingCount <= 0) {
                $dom.removeClass('is-valid').addClass('is-invalid');
            } else {
                $dom.removeClass('is-invalid').addClass('is-valid');
            }
        });
        
        $('html').on('keypress', _this.elem, function(){
            var val = _this.getValue();
            
            if (_this.characterLimitPreventKeypress && _this.characterLimit <= val.characterCount) {
                return false;
            }
        });
    }
    

    // youtube video id from url
    EasyEditor.prototype.getYoutubeVideoIdFromUrl = function(url){
        if(url.length === 0) return false;
        var videoId = '';
        url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
        if(url[2] !== undefined) {
            videoId = url[2].split(/[^0-9a-z_\-]/i);
            videoId = videoId[0];
        }
        else {
            videoId = url;
        }
        return videoId;
    };

    // opening modal window
    EasyEditor.prototype.openModal = function(selector){
        var temp = document.createElement('temp');
        temp.textContent = '.';
        this.insertAtCaret(temp);

        $(selector).removeClass('is-hidden');
    };

    // closing modal window
    EasyEditor.prototype.closeModal = function(selector){
        var _this = this;

        $(selector).addClass('is-hidden').find('input').val('');
        $(selector).find('.' + _this.className + '-modal-content-body-loader').css('width', '0');
        var $temp = $(this.elem).find('temp');

        if($temp.html() === '.') {
            $temp.remove();
        }
        else {
            $temp.contents().unwrap();
        }

        $(this.elem).focus();
    };

    EasyEditor.prototype.bold = function(){
        var _this = this;
        var settings = {
            buttonIdentifier: 'bold',
            buttonHtml: 'B',
            clickHandler: function(){
                _this.wrapSelectionWithNodeName({ nodeName: 'strong', keepHtml: true });
            }
        };

        _this.injectButton(settings);
    };

    EasyEditor.prototype.italic = function(){
        var _this = this;
        var settings = {
            buttonIdentifier: 'italic',
            buttonHtml: 'I',
            clickHandler: function(){
                _this.wrapSelectionWithNodeName({ nodeName: 'em', keepHtml: true });
            }
        };

        _this.injectButton(settings);
    };

    EasyEditor.prototype.h2 = function(){
        var _this = this;
        var settings = {
            buttonIdentifier: 'header-2',
            buttonHtml: 'H2',
            clickHandler: function(){
                _this.wrapSelectionWithNodeName({ nodeName: 'h2', blockElement: true });
            }
        };

        _this.injectButton(settings);
    };

    EasyEditor.prototype.h3 = function(){
        var _this = this;
        var settings = {
            buttonIdentifier: 'header-3',
            buttonHtml: 'H3',
            clickHandler: function(){
                _this.wrapSelectionWithNodeName({ nodeName: 'h3', blockElement: true });
            }
        };

        _this.injectButton(settings);
    };

    EasyEditor.prototype.h4 = function(){
        var _this = this;
        var settings = {
            buttonIdentifier: 'header-4',
            buttonHtml: 'H4',
            clickHandler: function(){
                _this.wrapSelectionWithNodeName({ nodeName: 'h4', blockElement: true });
            }
        };

        _this.injectButton(settings);
    };

    EasyEditor.prototype.x = function(){
        var _this = this;
        var settings = {
            buttonIdentifier: 'remove-formatting',
            buttonHtml: 'x',
            clickHandler: function(){
                _this.removeFormatting({ inFullArea: false });
            }
        };

        _this.injectButton(settings);
    };

    EasyEditor.prototype.alignleft = function(){
        var _this = this;
        var settings = {
            buttonIdentifier: 'align-left',
            buttonHtml: 'Align left',
            clickHandler: function(){
                _this.wrapSelectionWithNodeName({ nodeName: 'p', style: 'text-align: left', class: 'text-left', keepHtml: true });
            }
        };

        _this.injectButton(settings);
    };

    EasyEditor.prototype.aligncenter = function(){
        var _this = this;
        var settings = {
            buttonIdentifier: 'align-center',
            buttonHtml: 'Align center',
            clickHandler: function(){
                _this.wrapSelectionWithNodeName({ nodeName: 'p', style: 'text-align: center', class: 'text-center', keepHtml: true });
            }
        };

        _this.injectButton(settings);
    };

    EasyEditor.prototype.alignright = function(){
        var _this = this;
        var settings = {
            buttonIdentifier: 'align-right',
            buttonHtml: 'Align right',
            clickHandler: function(){
                _this.wrapSelectionWithNodeName({ nodeName: 'p', style: 'text-align: right', class: 'text-right', keepHtml: true });
            }
        };

        _this.injectButton(settings);
    };

    EasyEditor.prototype.quote = function(){
        var _this = this;
        var settings = {
            buttonIdentifier: 'quote',
            buttonHtml: 'Quote',
            clickHandler: function(){
                _this.wrapSelectionWithNodeName({ nodeName: 'blockquote' });
            }
        };

        _this.injectButton(settings);
    };

    EasyEditor.prototype.code = function(){
        var _this = this;
        var settings = {
            buttonIdentifier: 'code',
            buttonHtml: 'Code',
            clickHandler: function(){
                _this.wrapSelectionWithNodeName({ nodeName: 'pre' });
            }
        };

        _this.injectButton(settings);
    };

    EasyEditor.prototype.link = function(){
        var _this = this;
        var settings = {
            buttonIdentifier: 'link',
            buttonHtml: 'Link',
            clickHandler: function(){
                _this.wrapSelectionWithNodeName({ nodeName: 'a', attribute: ['href', prompt('Insert link', '')] });
            }
        };

        _this.injectButton(settings);
    };

    EasyEditor.prototype.list = function(){
        var _this = this;
        var settings = {
            buttonIdentifier: 'list',
            buttonHtml: 'List',
            clickHandler: function(){
                _this.wrapSelectionWithList();
            }
        };

        _this.injectButton(settings);
    };

    EasyEditor.prototype.source = function(){
        var _this = this;
        var settings = {
            buttonIdentifier: 'source',
            buttonHtml: 'Source',
            clickHandler: function(thisButton){
                var $elemContainer = $(thisButton).closest('.' + _this.className + '-wrapper');
                var $elem = $elemContainer.find('.' + _this.className);
                var $tempTextarea;

                if($(thisButton).hasClass('is-view-source-mode')) {
                    $tempTextarea = $('body > textarea.' + _this.className + '-temp');
                    $elem.css('visibility', 'visible');
                    $tempTextarea.remove();
                    $(thisButton).removeClass('is-view-source-mode');
                }
                else {
                    $('body').append('<textarea class="' + _this.className + '-temp" style="position: absolute; margin: 0;"></textarea>');
                    $tempTextarea = $('body > textarea.' + _this.className + '-temp');

                    $tempTextarea.css({
                        'top' : $elem.offset().top,
                        'left' : $elem.offset().left,
                        'width' : $elem.outerWidth(),
                        'height' : $elem.outerHeight()
                    }).html( $elem.html() );

                    if( $elem.css('border') !== undefined ) {
                        $tempTextarea.css('border', $elem.css('border'));
                    }

                    $elem.css('visibility', 'hidden');
                    $(thisButton).addClass('is-view-source-mode');

                    $tempTextarea.on('keyup click change keypress', function() {
                        $elem.html( $(this).val() );
                    });
                }
            }
        };

        _this.injectButton(settings);
    };

    window.EasyEditor = EasyEditor;

    $.fn.easyEditor = function ( options ) {
        return this.each(function () {
            if (!$.data(this, 'plugin_easyEditor')) {
                $.data(this, 'plugin_easyEditor',
                new EasyEditor( this, options ));
            }
        });
    };

})(jQuery, document, window);
