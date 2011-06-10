if (typeof EP === 'undefined' || !EP)  {
    // EventPublisher global namespace object
    var EP = {};
}

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
    };

    return obj;

})(jQuery);

// what to call on doc ready 
(function($) {
    $(document).ready(function() {
        $('input.ep-datepicker').datepicker();
        EP.timepicker.init();
    });
})(jQuery);
