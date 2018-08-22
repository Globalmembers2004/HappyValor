var SwipeListItem = (function() {
    function SwipeListItem(listItem, optionClass, threshold) {
        var self = this;
        
        this.li = listItem;
        this.$li = $(listItem);
        this.$itemContent = this.$li.find('.item');
        this.maxScroll = this.$li.find('.' + optionClass).width();
        this.threshold = threshold || this.maxScroll / 2;
        this.swipe = {};
        this.translateX = 0;
        
        this.$li.on('touchstart touchend touchmove', function(e) {
            var touchPos = self.getTouchPos(e),
                deltaX = self.swipe ? touchPos.x - self.swipe.xStart : 0,
                deltaY = self.swipe ? touchPos.y - self.swipe.yStart : 0,
                newTranslateX;
            
            switch (e.type) {
                case 'touchstart':
                    self.swipe = {
                        translateX: self.translateX,
                        isOpen: self.translateX < 0,
                        touchStarted: true,
                        locked: false,
                        xStart: touchPos.x,
                        yStart: touchPos.y
                    };
                    
                    self.enableAnimation(false);
                    
                    break;
                case 'touchmove':
                    if (!self.swipe.locked) {
                        setTimeout(function() {
                            self.swipe.horizontal = Math.abs(deltaX) > Math.abs(deltaY);
                            self.swipe.locked = true;
                        }, 25);
                    }
                    
                    if (self.swipe.touchStarted && self.swipe.horizontal) {
                        self.lockPageScroll(true);
                        newTranslateX = self.swipe.translateX + deltaX;
                        self.setTranslateX(newTranslateX < self.maxScroll ? newTranslateX : self.maxScroll);
                    }
                    break;
                case 'touchend':
                    if (self.swipe.horizontal) {
                        if (Math.abs(deltaX) > self.threshold) {
                            deltaX = (deltaX > 0) ? 0 : -self.maxScroll;
                        } else {
                            deltaX = self.swipe.isOpen ? -self.maxScroll : 0;
                        }

                        self.setTranslateX(deltaX, true);
                        self.lockPageScroll(false);
                    }
                    break;
            }
        });
    }
    
    SwipeListItem.prototype.enableAnimation = function(enable) {
        this.$itemContent.css({
            transition: enable ? 'transform 100ms' : 'none'
        });
    };
    
    SwipeListItem.prototype.setTranslateX = function(x, animate) {
        this.translateX = x;
        this.enableAnimation(animate);
        this.$itemContent.css({
            transform : 'translateX(' + x + 'px)'
        });
    };
    
    SwipeListItem.prototype.getTouchPos = function(e) {
        return {
            x: e.touches.length ? e.touches[0].clientX : e.changedTouches[0].clientX,
            y: e.touches.length ? e.touches[0].clientY : e.changedTouches[0].clientY
        }
    };    
    
    SwipeListItem.prototype.lockPageScroll = function(lock) {
        $(document.body).css({
            overflow: lock ? 'hidden' : ''
        });
    };
    
    return SwipeListItem;
}());