/*global define, module */
(function(window, document) {
    'use strict';

    /////////////////////
    // Default options //
    /////////////////////

    var noop = function() {};
    var DEFAULTS = {
    	typeview: 'gridview',
    	containerData: '.gridview-content',
    	//containerScroll: '*#pnlListado .mdl-layout__content',
    	actionbar: '#generic-actionbar',
        selectorItem: '.dato',
        selectedClass: '.selected',
    	// inputSearch: '#txtSearch',
    	// buttonSearch: '#btnSearch',
    	onSearch: noop,
    	onSelectItem: noop,
    	onSelectAll: noop,
    	onSelectClear: noop,
    	oneItemClick: noop,
        onInitSelecting: noop
    };

    var BACKSPACE = 8;
    var COMMA = 188;
    var TAB = 9;
    var ENTER = 13;

    function _scrollTop (el) {
      	return el.scrollTop ? el.scrollTop : el.pageYOffset
    }

    function _toggleElement (el, flag) {
    	if (typeof el !== 'null') {
	    	// if (flag)
	    	// 	el.removeClass('hide');
	    	// else
	    	// 	el.addClass('hide');
            el.toggleClass('hide');
    	};
    }

    var DataList = function(el, options) {
        this.container = el;
        if (typeof el === 'string')
            this.container = $(el);

        var _settings = $.extend({}, DEFAULTS, options);
        
        this.settings = _settings;
        this.actionbar = _settings.actionbar;
        
	    this.selectedClass = _settings.selectedClass;
        // this.inputSearch = $(_settings.inputSearch);
	    // this.buttonSearch = $(_settings.buttonSearch);
        
        this.startTime;
        this.endTime;
        this.longpress = false;
        this.isScroll = false;
        this.timeoutScroll = null;
        this.delayScroll = 200;
        this.current_page = 1;

     //    var _btnSelectAll = document.querySelector(_settings.buttonSelectAll);
     //    var _btnUnSelectAll = document.querySelector(_settings.buttonUnSelectAll);

	    // this.btnSelectAll = _btnSelectAll;
	    // this.btnUnSelectAll = _btnUnSelectAll;

        this._attachDataListEvents();
    };

    DataList.prototype.getContainer = function () {
        return this.container;
    };

    DataList.prototype._attachDataListEvents = function () {
        var _handlerGrid;
        var _this = this;

        var _container = _this.container;
        var _typeView = _this.settings.typeview;
        var _selectorItem = _this.settings.selectorItem;

        var _withDefaultEvents = typeof _this.settings.withDefaultEvents !== 'undefined' ? _this.settings.withDefaultEvents : true;

        if (_typeView == 'checklist') {
            _container.addClass('list-checkbox');
            _selectorItem += ' input[type="checkbox"]';
        };

        if (_withDefaultEvents) {
            var handlerDataList_CheckItems = function (event) {
                var parent = getParentsUntil(this, '#' + _container.id, _this.settings.selectorItem);

                $(parent[0]).toggleClass(_this.selectedClass.substr(1));

                var itemsChecked = _container.find(_this.selectedClass);

                if (typeof itemsChecked !== 'undefined') {
                    if (itemsChecked.length > 0){
                        if (itemsChecked.length == 1)
                            _this.showAppBar(true, 'edit');
                    }
                    else
                        _this.showAppBar(false, 'edit');
                }
                else
                    _this.showAppBar(false, 'edit');
            };

            var handlerDataList_Default = function (event) {
                event.preventDefault();
                
                var item = this;
                var _selectedClass = _this.selectedClass;

                if (_this.container.hasClass('custom'))
                    _this.settings.oneItemClick(event);
                else {
                    if (event.type == 'touchend'){
                        _this.endTime = new Date().getTime();
                        _this.longpress = (_this.endTime - _this.startTime < 300) ? false : true;
                    };

                    if (_this.isScroll === false){
                        if (_this.longpress){
                            _this.showAppBar(true, 'edit');
                            _this._setSelecting('true', 'some');
                            _this._selectElement(item, _selectedClass);
                            _this.settings.onInitSelecting(event);
                        }
                        else {
                            if (_this.container.attr('data-multiselect') == 'true')
                                _this._selectElement(item, _selectedClass);
                            else
                                _this.settings.oneItemClick(event);
                        };
                    };
                };
            };

            if (_typeView == 'checklist')
                _handlerGrid = handlerDataList_CheckItems;
            else
                _handlerGrid = handlerDataList_Default;
            
            this.container.on('click touchend', _selectorItem, _handlerGrid);
            
            if (_typeView == 'gridview') {
                this.container.on('mousedown touchstart', _selectorItem, function (event) {
                    _this.startTime = new Date().getTime();
                });

                this.container.on('mouseup', _selectorItem, function (event) {
                    _this.endTime = new Date().getTime();
                    _this.longpress = (_this.endTime - _this.startTime < 300) ? false : true;
                });
            };
        }
        else {
            this.container.on('click touchend', _selectorItem, function (event) {
                _this.settings.oneItemClick(event);
            });
        };

        // if (typeof _this.inputSearch !== 'undefined') {
        //     _this.inputSearch.on('keyup', function(event) {
        //         // if (event.keyCode == ENTER) {
        //             _this.current_page = 1;
        //             _this.settings.onSearch();
        //             // return false;
        //         // };
        //     });

        //     // _this.inputSearch.on('keypress', function(event) {
        //     //     if (event.keyCode == $.ui.keyCode.ENTER)
        //     //         return false;
        //     // });
        // };

        // if (typeof _this.buttonSearch !== 'undefined') {
        //     _this.buttonSearch.on('click', function(event) {
        //         event.preventDefault();
        //         _this.showAppBar(true, 'search');
        //     });
        // };
    };

    DataList.prototype.listenerScroll = function (attached, event) {
        var _this = this;
        _this.isScroll = true;

        clearTimeout(_this.timeoutScroll);
        _this.timeoutScroll = setTimeout(function(){
            _this.isScroll = false;
        }, _this.delayScroll);

        var _innerHeight = getStyle(attached, 'height');
        
        if (_scrollTop(attached) + Number(_innerHeight.replace('px', '')) >= attached.scrollHeight)
            _this.settings.onSearch();
    };

    DataList.prototype._setSelecting = function (valueMultiselect, valueSelected) {
	    this.container.attr('data-multiselect', valueMultiselect);
	    this.container.attr('data-selected', valueSelected);
	};

	DataList.prototype._selectElement = function (element, selectClass) {
        var $element = $(element);
	    var checkBox = element.querySelector('input[type="checkbox"]');

        var _selectClass = selectClass.substr(1);

	    if ($element.hasClass(_selectClass)){
	        $element.removeClass(_selectClass);
	        checkBox.checked = false;
	        
	        var selecteds = this.container.find(selectClass);

	        if (selecteds.length == 0){
	            if (!this.container.hasClass('custom')){
	                this.showAppBar(false, 'edit');
	                this._setSelecting('false', 'none');
                    this.settings.onSelectClear();
	            };
	            //_toggleElement(this.btnUnSelectAll, false);
	        }
	        else {
	            selecteds = this.container.find(selectClass);
	            // if (selecteds.length == 1){
	            //     _toggleElement(this.btnUnSelectAll, true);
	            // };
	        };
	    }
	    else {
	        $element.addClass(_selectClass);
	        checkBox.checked = true;
	        // _toggleElement(this.btnSelectAll, true);
	        // _toggleElement(this.btnUnSelectAll, true);
	    };
	};

    DataList.prototype._checkCheckList = function (container, flag) {
        var checkboxes = container.find('input[type="checkbox"]');
        [].forEach.call(checkboxes, function(el) {
            el.checked = flag;
        });
    };

    DataList.prototype.selectAll = function  (callback) {
        var toselect = this.container.find(this.settings.selectorItem);
        if (typeof toselect !== 'undefined') {
            this.showAppBar(true, 'edit');
            this._setSelecting('true', 'all');
            
            toselect.addClass(this.selectedClass.substr(1));
            this._checkCheckList(this.container, true);

            if (typeof callback !== 'undefined')
                callback();
        };
    }

	DataList.prototype.removeSelection = function (callback) {
	    var selecteds = this.container.find(this.selectedClass);
        if (typeof selecteds !== 'undefined') {
    	    selecteds.removeClass(this.selectedClass.substr(1));
    	    this._checkCheckList(this.container, false);

    	    this.showAppBar(false, 'visible');
    	    this._setSelecting('false', 'none');
            
            if (typeof callback !== 'undefined')
                callback();
        };
	};

    DataList.prototype.currentPage = function (page) {
    	if (typeof page !== 'undefined')
    		this.current_page = page;
    	else
    		return this.current_page;
    };

   	DataList.prototype.showAppBar = function (flag, mode) {
   		if (typeof this.actionbar === 'undefined')
   			return;
   		
   		var _container = this.container;
	    var _actionbar = this.actionbar;

	    if (typeof _actionbar === 'string')
            _actionbar = $(this.actionbar);

        if (_actionbar != null) {

            if (flag){
    	        _actionbar.removeClass('edit search').addClass('is-visible ' + mode);
    	        _container.addClass(mode);

    	        if (mode != 'search')
    	        //     this.inputSearch.focus();
    	        // else
    	            _container.addClass('prepare-multiselect');
    	    }
    	    else {
    	        _container.removeClass('prepare-multiselect ' + mode);
    	        _actionbar.removeClass('is-visible ' + mode);
    	    };
        }
        else {
            if (flag)
                _container.addClass('prepare-multiselect');
            else
                _container.removeClass('prepare-multiselect ' + mode);
        };
   	};
    
    /*global define, module */
    if (typeof define === 'function' && define.amd) {
        // AMD
        define([], function() {
            return DataList;
        });
    }
    else if (typeof exports === 'object') {
        // CommonJS
        module.exports = DataList;
    }
    else {
        // Vanilla browser global
        window.DataList = DataList;
    };
}(window, document));