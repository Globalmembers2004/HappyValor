var _body = document.body;

/*! Salt.js DOM Selector Lib. By @james2doyle */
window.$ = function(selector, context, undefined) {
  // an object containing the matching keys and native get commands
  var matches = {
    '#': 'getElementById',
    '.': 'getElementsByClassName',
    '@': 'getElementsByName',
    '=': 'getElementsByTagName',
    '*': 'querySelectorAll'
  }[selector[0]]; // you can treat a string as an array of characters
  // now pass the selector without the key/first character
  var el = (((context === undefined) ? document: context)[matches](selector.slice(1)));
  // if there is one element than return the 0 element
  return ((el.length < 2) ? el[0]: el);
};

(function(funcName, baseObj) {
    "use strict";
    // The public function name defaults to window.docReady
    // but you can modify the last line of this function to pass in a different object or method name
    // if you want to put them in a different namespace and those will be used instead of 
    // window.docReady(...)
    funcName = funcName || "docReady";
    baseObj = baseObj || window;
    var readyList = [];
    var readyFired = false;
    var readyEventHandlersInstalled = false;
    
    // call this when the document is ready
    // this function protects itself against being called more than once
    function ready() {
        if (!readyFired) {
            // this must be set to true before we start calling callbacks
            readyFired = true;
            for (var i = 0; i < readyList.length; i++) {
                // if a callback here happens to add new ready handlers,
                // the docReady() function will see that it already fired
                // and will schedule the callback to run right after
                // this event loop finishes so all handlers will still execute
                // in order and no new ones will be added to the readyList
                // while we are processing the list
                readyList[i].fn.call(window, readyList[i].ctx);
            }
            // allow any closures held by these functions to free
            readyList = [];
        }
    }
    
    function readyStateChange() {
        if ( document.readyState === "complete" ) {
            ready();
        }
    }
    
    // This is the one public interface
    // docReady(fn, context);
    // the context argument is optional - if present, it will be passed
    // as an argument to the callback
    baseObj[funcName] = function(callback, context) {
        // if ready has already fired, then just schedule the callback
        // to fire asynchronously, but right away
        if (readyFired) {
            setTimeout(function() {callback(context);}, 1);
            return;
        } else {
            // add the function and context to the list
            readyList.push({fn: callback, ctx: context});
        }
        // if document already ready to go, schedule the ready function to run
        // IE only safe when readyState is "complete", others safe when readyState is "interactive"
        if (document.readyState === "complete" || (!document.attachEvent && document.readyState === "interactive")) {
            setTimeout(ready, 1);
        } else if (!readyEventHandlersInstalled) {
            // otherwise if we don't have event handlers installed, install them
            if (document.addEventListener) {
                // first choice is DOMContentLoaded event
                document.addEventListener("DOMContentLoaded", ready, false);
                // backup is window load event
                window.addEventListener("load", ready, false);
            } else {
                // must be IE
                document.attachEvent("onreadystatechange", readyStateChange);
                window.attachEvent("onload", ready);
            }
            readyEventHandlersInstalled = true;
        }
    }
})("docReady", window);

(function (x) {
  var i;
  if (!x.matchesSelector) {
    for (i in x) {
      if (/^\S+MatchesSelector$/.test(i)) {
        x.matchesSelector = x[i];
        break;
      }
    }
  }
}(Element.prototype || Document.prototype));

var closest = function(elem, selector) {

   var matchesSelector = elem.matches || elem.webkitMatchesSelector || elem.mozMatchesSelector || elem.msMatchesSelector;

    while (elem) {
        if (matchesSelector.call(elem, selector)) {
            return elem;
        } else {
            elem = elem.parentElement;
        }
    }
    return false;
}

window.Document.prototype.on =
window.Element.prototype.on = function (eventType, selector, handler) {
    var _eventType = eventType.split(' ');
    for (var i = 0; i < _eventType.length; i++) {
        //_handler(this, _eventType[i], selector, handler);
        if (typeof handler === 'undefined') {
            handler = selector;
            this.addEventListener(_eventType[i], handler, false);
        }
        else {
            this.addEventListener(_eventType[i], function listener(event) {
                var t = event.target,
                  type = event.type,
                  x = [];
                if (event.detail && event.detail.selector === selector && event.detail.handler === handler) {
                  return this.removeEventListener(type, listener, true);
                }
                while (t) {
                  if (t.matchesSelector && t.matchesSelector(selector)) {
                    t.addEventListener(type, handler, false);
                    x.push(t);
                  }
                  t = t.parentNode;
                }
                setTimeout(function () {
                  var i = x.length - 1;
                  while (i >= 0) {
                    x[i].removeEventListener(type, handler, false);
                    i -= 1;
                  }
                }, 0);
            }, true);
        };
    };
    return this;
};

window.HTMLCollection.prototype.on = 
window.NodeList.prototype.on = function (eventType, selector, handler) {
    [].forEach.call(this, function(el) {
        el.on(eventType, selector, handler);
    });
    return this;
};

window.Document.prototype.off =
window.Element.prototype.off = function (eventType, handler) {
    if (this.removeEventListener) {
        this.removeEventListener(eventType, handler);
    } else if (this.detachEvent) {
        this.detachEvent("on" + eventType, handler);
    }
};

window.Document.prototype.trigger =
window.Element.prototype.trigger = function (eventType, selector, handler) {
    var event = document.createEvent('CustomEvent');
    event.initCustomEvent(eventType, false, false, {selector: selector, handler: handler});
    this.dispatchEvent(event);
};

window.Element.prototype.find = function(selector) {
    return $(selector, this);
};

window.HTMLCollection.prototype.first =
window.NodeList.prototype.first = function() {
    // if this is more than one item return the first
    return (this.length < 2) ? this : this[0];
};

window.HTMLCollection.prototype.last =
window.NodeList.prototype.last = function() {
    // if there are many items, return the last
    return (this.length > 1) ? this[this.length - 1] : this;
};

window.Element.prototype.remove = function () {
    this.parentNode.removeChild(this);
};

window.HTMLCollection.prototype.remove = 
window.NodeList.prototype.remove = function(){
    [].forEach.call(this, function(el) {
        el.remove();
    });
};

window.Element.prototype.addClass = function(css) {
    this.className += " " + css;
    return this;
};

window.HTMLCollection.prototype.addClass = 
window.NodeList.prototype.addClass = function(css){
    [].forEach.call(this, function(el) {
        el.addClass(css);
    });
    return this;
};

window.Element.prototype.hasClass = function(css) {
    if (this.classList)
        return this.classList.contains(css);
    else
        return !!this.className.match(new RegExp('(\\s|^)' + css + '(\\s|$)'));
};

window.HTMLCollection.prototype.hasClass = 
window.NodeList.prototype.hasClass = function(css) {
    [].forEach.call(this, function(el) {
        if (el.hasClass(css));
            return true;
    });
    return false;
};

window.Element.prototype.removeClass = function(css) {
    this.className = this.className.replace(new RegExp('(^|\\b)' + css.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
    // alert(css);
    return this;
    // _return = typeof _return !== 'undefined' ? _return : true;
    // if (_return)
    //     return this;
};

window.HTMLCollection.prototype.removeClass = 
window.NodeList.prototype.removeClass = function(css){
    var arr = Array.from(this);
    var countdata = arr.length;
    var i = 0;

    for (i = 0; i < countdata; i++) {
        var _item = arr[i];
        _item.className = _item.className.replace(new RegExp('(^|\\b)' + css.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
    };

    return this;
};

window.Element.prototype.toggleClass = function (css) {
    if (this.classList)
        this.classList.toggle(css);
    else {
        var classes = this.className.split(' ');
        var existingIndex = classes.indexOf(css);

        if (existingIndex >= 0)
            classes.splice(existingIndex, 1);
        else
            classes.push(css);

        this.className = classes.join(' ');
    };
};

window.HTMLCollection.prototype.toggleClass = 
window.NodeList.prototype.toggleClass = function(css){
    var arr = Array.from(this);
    var countdata = arr.length;
    var i = 0;

    for (i = 0; i < countdata; i++) {
        var _item = arr[i];
        _item.toggleClass(css);
    };
    
    return this;
};

window.Element.prototype.text = function (_text) {
    if (typeof _text === 'undefined')
        return window.attachEvent && !window.addEventListener ? this.innerText : this.textContent;
    else {
        if (window.attachEvent && !window.addEventListener) // <= IE8
            this.innerText = _text;
        else
            this.textContent = _text;
        return this;
    };
};

window.Element.prototype.val = function (_value) {
    if (typeof _value === 'undefined'){
        if (this.type == 'select-multiple') {
            var arr = [];
            var l = this.options.length; 
            var i = 0;

            while(i < l){
                if (this.options[i].selected)
                    arr.push(this.options[i].value);
                ++i;
            };

            return arr;
        }
        else
            return this.value;
    }
    else {
        if (this.hasClass('mdl-textfield__input')) {
            this.parentNode.MaterialTextfield.change(_value);
        }
        else
            this.value = _value;
        return this;
    };
};

window.Element.prototype.changeMaterialSelect = function (_value) {
    //this.parentNode.MaterialSelectfield.change(_value);
    var listBox = this.parentNode.find('.mdl-selectfield__list-option-box');
    var optionText = listBox.find('*li[data-option-value="' + _value + '"]').text();
   
    this.parentNode.find('.mdl-selectfield__box-value').text(optionText);
    this.value = _value;
};

var isArray = Array.isArray || function(arr) {
    return Object.prototype.toString.call(arr) == '[object Array]';
}
var inArray = function(elem, array, i){
    return [].indexOf.call(array, elem, i)
}

String.prototype.repeat = function (num) {
    return new Array(num + 1).join(this);
}

String.prototype.hasWhiteSpace = function() {
    return /\s/g.test(this);
}

// Date.prototype.fromString = function(str, ddmmyyyy) {
//     var m = str.match(/(\d+)(-|\/)(\d+)(?:-|\/)(?:(\d+)\s+(\d+):(\d+)(?::(\d+))?(?:\.(\d+))?)?/);
//     if(m[2] == "/"){
//         if(ddmmyyyy === false)
//             return new Date(+m[4], +m[1] - 1, +m[3], m[5] ? +m[5] : 0, m[6] ? +m[6] : 0, m[7] ? +m[7] : 0, m[8] ? +m[8] * 100 : 0);
//         return new Date(+m[4], +m[3] - 1, +m[1], m[5] ? +m[5] : 0, m[6] ? +m[6] : 0, m[7] ? +m[7] : 0, m[8] ? +m[8] * 100 : 0);
//     }
//     return new Date(+m[1], +m[3] - 1, +m[4], m[5] ? +m[5] : 0, m[6] ? +m[6] : 0, m[7] ? +m[7] : 0, m[8] ? +m[8] * 100 : 0);
// };

function getVisible (selector) {
    var items = document.querySelectorAll(selector);
    var count_items = items.length;
    var i = 0;

    if (count_items > 0){
        while (i < count_items){
            var panel = items[i];
            if (getStyle(panel, 'display') !== 'none')
                return panel;
            ++i;
        };

        return false;
    }
    else {
        return false;
    };
}

// function siblings (el) {
// 	Array.prototype.filter.call(el.parentNode.children, function(child){
//         return child !== el;
//     });
// }

function addLeadingZero(num) {
    return ((num < 10) ? "0" + num : "" + num);
}

function Interval(fn, time) {
    var timer = false;
    this.start = function () {
        if (!this.isRunning())
            timer = setInterval(fn, time);
    };
    this.stop = function () {
        clearInterval(timer);
        timer = false;
    };
    this.isRunning = function () {
        return timer !== false;
    };
}
 
function getStyle(oElm, css3Prop){
    var strValue = '';
    
    if (window.getComputedStyle){
        strValue = getComputedStyle(oElm).getPropertyValue(css3Prop);
    }
    else if (oElm.currentStyle){
        try {
            strValue = oElm.currentStyle[css3Prop];
        }
        catch (e) {
            console.log(e);
        }
    };

    return strValue;
}

window.Element.prototype.serializeArray = function() {
    var _elements = this.nodeName == "FORM" ? this.elements : this.getElementsByTagName("*");
    var field, l, s = [];
    var len = _elements.length;
    for (i=0; i<len; i++) {
        field = _elements[i];
        if (field.name && !field.disabled && field.type != 'file' && field.type != 'reset' && field.type != 'submit' && field.type != 'button') {
            if (field.type == 'select-multiple') {
                l = _elements[i].options.length; 
                for (j=0; j<l; j++) {
                    if(field.options[j].selected)
                        s[s.length] = { name: field.name, value: field.options[j].value };
                }
            } else if ((field.type != 'checkbox' && field.type != 'radio') || field.checked) {
                s[s.length] = { name: field.name, value: field.value };
            };
        };
    };
    return s;
};

var getParentsUntil = function (elem, parent, selector) {

    var parents = [];
    if ( parent ) {
        var parentType = parent.charAt(0);
    }
    if ( selector ) {
        var selectorType = selector.charAt(0);
    }

    // Get matches
    for ( ; elem && elem !== document; elem = elem.parentNode ) {

        // Check if parent has been reached
        if ( parent ) {
            // If parent is a class
            if ( parentType === '.' ) {

                if ( elem.hasClass( parent.substr(1) ) ) {
                    break;
                }
            }

            // If parent is an ID
            if ( parentType === '#' ) {
                if ( elem.id === parent.substr(1) ) {
                    break;
                }
            }

            // If parent is a data attribute
            if ( parentType === '[' ) {
                if ( elem.hasAttribute( parent.substr(1, parent.length - 1) ) ) {
                    break;
                }
            }

            // If parent is a tag
            if ( elem.tagName.toLowerCase() === parent ) {
                break;
            }

        }

        if ( selector ) {

            // If selector is a class
            if ( selectorType === '.' ) {
                if ( elem.hasClass( selector.substr(1) ) ) {
                    parents.push( elem );
                }
            }

            // If selector is an ID
            if ( selectorType === '#' ) {
                if ( elem.id === selector.substr(1) ) {
                    parents.push( elem );
                }
            }

            // If selector is a data attribute
            if ( selectorType === '[' ) {
                if ( elem.hasAttribute( selector.substr(1, selector.length - 1) ) ) {
                    parents.push( elem );
                }
            }

            // If selector is a tag
            if ( elem.tagName.toLowerCase() === selector ) {
                parents.push( elem );
            }

        } else {
            parents.push( elem );
        }

    }

    // Return parents if any exist
    if ( parents.length === 0 ) {

        return null;
    } else {
        return parents;
    }

};