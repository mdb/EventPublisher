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

    function formError(string) {
        $(trigger).addClass('error');
        alert(string);
    }

    function checkHours(ampm, hours) {

        // if there is an am/pm specified
        if (ampm) {

            if (hours < 1 || hours > 12) { 
                return false; 
            }

        // if there is no am/pm specified
        } else { 
            if (hours > 23) { 
                return false; 
            }
        }
    }

    function checkMinsSecs(minsOrSecs) {
        if (minsOrSecs > 59) {
            return false; 
        }
    }

    obj = {

        init: function () {
            this.toggleDropdown();
            this.populateInput();
            this.save('form#post');
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
                $(this).parent().prev(trigger).attr('value', $(this).text());
                EP.timepicker.hideDropdown();
            });
        },

        validateInput: function () {
            var validTime = /^(\d{1,2}):(\d{2})(:(\d{2}))?(\s?(AM|am|PM|pm))?$/;
                inputText = $(trigger).attr('value'),
                matchArray = inputText.match(validTime);
                
            if (inputText !== '') {

                if (matchArray) {

                    var hours = matchArray[1],
                        mins = matchArray[2],
                        secs = matchArray[4],
                        ampm = matchArray[6];

                    if (checkHours(ampm, hours) === false) {
                        formError('Invalid value for hours: ' + hours);
                        return false;
                    }

                    if (checkMinsSecs(mins) === false) {
                        formError('Invalid value for minutes: ' + mins);
                        return false;
                    }

                    if (checkMinsSecs(secs) === false) {
                        formError('Invaid value for seconds: ' + secs);
                        return false;
                    }

                } else {

                    formError('Invalid time format: ' + inputText);
                    return false;
                }
            }

            alert('All input fields have been validated!');
            return true;
        },

        save: function (formSelector) { //TODO: why this no work?
            var form = $(formSelector);
            $(form).submit(function () {
                if (EP.timepicker.validateInput() === false) {
                    $('input#publish').removeClass('button-primary-disabled'); // Remove the 'focused' style for the Publish button
                    $('img#ajax-loading').hide(); // re-hide the 'loading' graphic to left of Publish button
                    return false;
                } else if (EP.timepicker.validateInput() === true) {
                    return true;
                }
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
