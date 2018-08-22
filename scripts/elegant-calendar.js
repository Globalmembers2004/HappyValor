/*global define, module */
(function(window, document) {
    'use strict';

    // var noop = function() {};

    var today = new Date();

    // function _extend() {
    //     var master = arguments[0];
    //     for (var i = 1, l = arguments.length; i < l; i++) {
    //         var object = arguments[i];
    //         for (var key in object) {
    //             if (object.hasOwnProperty(key)) {
    //                 master[key] = object[key];
    //             }
    //         }
    //     }

    //     return master;
    // }

    // function addLeadingZero(num) {
    //     return ((num < 10) ? "0" + num : "" + num);
    // }

    function convertTodayToString () {
        var _year = today.getFullYear();
        var _month = today.getMonth();
        var _day = today.getDate();

        var _initDate = [addLeadingZero(_day), addLeadingZero(_month + 1), _year].join('/');

        return _initDate;
    }
    //

    var DEFAULTS = {
        monthTag: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        initDate: convertTodayToString(),
        onInit: $.noop(),
        onDayClick: $.noop(),
        onMonthChange: $.noop()
    };

    var Calendar = function(el, options) {
        this.container = $(el);
        
        if (typeof el === 'string')
            this.container = $(el);

        this.days = this.container.find('td');
        
        this.settings = $.extend({}, DEFAULTS, options);
        
        var stringDate = this.settings.initDate.match(/\d+/g);
       
        var _setDate = new Date(stringDate[2], stringDate[1]-1, stringDate[0]);
        
        this._setDay(_setDate);
        this._init();
    };
    
    Calendar.prototype._init = function() {
        this._getCookie('selected_day');
        this._drawDays();

        var _this = this,
            reset = this.container.find('.reset'),
            pre = this.container.find('.pre-button'),
            next = this.container.find('.next-button');
            
        pre.on('click', function(event){
            event.preventDefault();
            _this.preMonth();
        });

        next.on('click', function(event){
            event.preventDefault();
            _this.nextMonth();
        });

        reset.on('click', function(event){
            event.preventDefault();
            _this.resetDate();
        });

        this.container.on('click', 'td:not(.disabled) > button', function(event) {
            event.preventDefault();
            _this._clickDay(this);
        });

        this.settings.onInit(_this);
    };

    Calendar.prototype._setDay = function (_setDate) {
        this.selectedDay = _setDate;
        this.setDate = _setDate;
        this.day = _setDate.getDate();
        this.year = _setDate.getFullYear();
        this.month = _setDate.getMonth();
    }
    
    Calendar.prototype._drawHeader = function(e) {
        var headDay = this.container.find('.head-day'),
            headMonth = this.container.find('.head-month');

        e ? headDay.html(e) : headDay.html(this.day);
        headMonth.html(this.settings.monthTag[this.month].substr(0, 3) + " - " + this.year);
    };
    
    Calendar.prototype._drawDays = function() {
        var startDay = new Date(this.year, this.month, 1).getDay(),
            nDays = new Date(this.year, this.month + 1, 0).getDate(),
            n = startDay;

        for (var k = 0; k < 42; k++) {
            var _innerDay = this.days[k].childNodes[0];
            _innerDay.classList.remove('open');
            _innerDay.innerHTML = '';

            this.days[k].classList.remove('disabled', 'selected', 'today');
        };

        for (var i = 1; i <= nDays; i++) {
            var mDays = this.days[n].childNodes[0];
            
            mDays.innerHTML = i;
            mDays.classList.add('day');
            mDays.setAttribute('data-day', i);
            mDays.setAttribute('data-month', this.month + 1);
            mDays.setAttribute('data-year', this.year);
            
            if ((i === today.getDate()) && (this.month === today.getMonth()) && (this.year === today.getFullYear())) {
                this._drawHeader(this.day);
                this.days[n].classList.add('today');
            };

            n++;
        };
        
        for (var j = 0; j < 42; j++) {
            if (this.days[j].childNodes[0].innerHTML === ""){
                this.days[j].classList.add('disabled');
            };
            // else if (j === this.day + startDay - 1){
                // if ( ( (this.month === this.setDate.getMonth()) && (this.year === this.setDate.getFullYear()) ) || ( (this.month === today.getMonth()) && (year===today.getFullYear()) ) ){
                    
                // };
            //};

            if (this.selectedDay){
                if ( (j === this.selectedDay.getDate() + startDay - 1) && (this.month === this.selectedDay.getMonth()) && (this.year === this.selectedDay.getFullYear()) ){
                    this.days[j].classList.add('selected');
                    this._drawHeader(this.selectedDay.getDate());
                };
            };
        };
    };
    
    Calendar.prototype._clickDay = function(o) {
        this.container.find('.selected').removeClass('selected')
        o.parentNode.classList.add('selected');
        
        var _selectedDay = new Date(this.year, this.month, o.innerHTML);
        this._setDay(_selectedDay);
        this._drawHeader(o.innerHTML);
        this._setCookie('selected_day', 1);
        this.settings.onDayClick(o);
    };

    Calendar.prototype.getCurrentDate = function (format) {
        format = typeof format !== 'undefined' ? format : '/';
        
        var dd = addLeadingZero(this.day),
            mm = this.month,
            yyyy = this.year;

        return (format == 'large') ? dd + ' de ' + this.settings.monthTag[mm] + ' del año ' + yyyy : (format === '-' ? [yyyy, addLeadingZero(mm + 1), dd] : [dd, addLeadingZero(mm + 1), yyyy]).join(format);
    };
    
    Calendar.prototype.preMonth = function() {
        if (this.month < 1){ 
            this.month = 11;
            this.year = this.year - 1; 
        }
        else
            this.month = this.month - 1;

        this._drawHeader(1);
        this._drawDays();
        this.settings.onMonthChange(this);
    };
    
    Calendar.prototype.nextMonth = function() {
        if (this.month >= 11){
            this.month = 0;
            this.year = this.year + 1; 
        }
        else
            this.month = this.month + 1;
        
        this._drawHeader(1);
        this._drawDays();
        this.settings.onMonthChange(this);
    };
    
     Calendar.prototype.resetDate = function() {
        this.selectedDay = false;
        this.month = today.getMonth();
        this.year = today.getFullYear();
        this.day = today.getDate();
        this._drawDays();
     };
    
    Calendar.prototype._setCookie = function(name, expiredays){
        if (expiredays) {
            var date = new Date();
            date.setTime(date.getTime() + (expiredays*24*60*60*1000));
            var expires = "; expires=" +date.toGMTString();
        }
        else {
            var expires = "";
        };
        document.cookie = name + "=" + this.selectedDay + expires + "; path=/";
    };
    
    Calendar.prototype._getCookie = function(name) {
        if(document.cookie.length){
            var arrCookie  = document.cookie.split(';'),
                nameEQ = name + "=";
            
            for (var i = 0, cLen = arrCookie.length; i < cLen; i++) {
                var c = arrCookie[i];
                while (c.charAt(0)==' ') {
                    c = c.substring(1,c.length);
                };

                if (c.indexOf(nameEQ) === 0) {
                    var _selectedDay =  new Date(c.substring(nameEQ.length, c.length));
                    this._setDay(_selectedDay);
                };
            }
        }
    };

    /*global define, module */
    if (typeof define === 'function' && define.amd) {
        // AMD
        define([], function() {
            return Calendar;
        });
    }
    else if (typeof exports === 'object') {
        // CommonJS
        module.exports = Calendar;
    }
    else {
        // Vanilla browser global
        window.Calendar = Calendar;
    };
}(window, document));