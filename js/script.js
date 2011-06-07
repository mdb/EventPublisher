if (typeof EP === 'undefined' || !EP)  {
    // EventPublisher global namespace object
    var EP = {};
}

EP = (function($) {
    obj = {
        someMethod: function () {
            console.log('This works.');
        }
    }
    return obj;
})(jQuery);

// timepicker
EP.timepicker = (function($) {

    var trigger = 'input.ep-timepicker',
        dropdown = 'ol.ep-timepicker';

    // helpers
    function getPosLeft(elem) {
        return Math.floor($(elem).position().left);
    }

    obj = {

        init: function () {
            this.toggleDropdown();
            this.populateInput();
        },

        toggleDropdown: function () {

            $(trigger).focus(function() {
                $(this).next($(dropdown)).addClass('visible');
                EP.timepicker.setDropdownPos();
            });

            /*
            $(trigger).blur(function() {
                $(this).next($(dropdown)).removeClass('visible');
            });
            */

        },

        hideDropdown: function () {
            $(dropdown).removeClass('visible');
        },

        setDropdownPos: function () {
            $(dropdown).css('left', getPosLeft(trigger));
        },

        populateInput: function () {
            $(dropdown).find('li').click(function() {
                console.log(this);
                $(trigger).attr('value', $(this).text());
                EP.timepicker.hideDropdown();
            });
        }
    }

    return obj;

})(jQuery);

// what to call on doc ready 
(function($) {
    $(document).ready(function() {
        EP.someMethod();
        $('input.date').datepicker();   
        EP.timepicker.init();
    });
})(jQuery);
