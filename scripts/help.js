String.prototype.repeat = function (num) {
    return new Array(num + 1).join(this);
}

String.prototype.hasWhiteSpace = function() {
    return /\s/g.test(this);
}

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