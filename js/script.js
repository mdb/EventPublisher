if (typeof EP === 'undefined' || !EP)  {
    // EventPublisher global namespace object
    var EP = {};
}

// timepicker
(function($) {

    EP.timepicker = function(options) {

        var settings = {

                startPicker: $('#start_date_meta input.ep-timepicker'),
                endPicker: $('#end_date_meta input.ep-timepicker'), 
                startDropdown: $('#start_date_meta ol.ep-timepicker'),
                endDropdown: $('#end_date_meta ol.ep-timepicker')
            },

            helpers = {

                getPosLeft: function(elem) {
                    return Math.floor($(elem).position().left);
                },

                formError: function(trigger, string) {
                    $(trigger).addClass('error');
                    alert(string);
                },

                checkHours: function(ampm, hours) {

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
                },

                checkMinsSecs: function(minsOrSecs) {
                    if (minsOrSecs > 59) {
                        return false; 
                    }
                }

            },

            pubMethods = {

                init: function () {

                    var tp = this;

                    tp.toggleDropdown(settings.startPicker, settings.startDropdown);
                    tp.toggleDropdown(settings.endPicker, settings.endDropdown);
                    tp.populateInput(settings.startPicker, settings.startDropdown);
                    tp.populateInput(settings.endPicker, settings.endDropdown);
                    //this.save('form#post');
                    
                    $(settings.startPicker).change(function() {
                        tp.validateInput(settings.startPicker);
                    });
                    $(settings.endPicker).change(function() {
                        tp.validateInput(settings.endPicker);
                    });
                },

                toggleDropdown: function (trigger, dropdown) {

                    var tp = this;

                    $(trigger).focus(function() {
                        $(dropdown).addClass('visible');
                        tp.setDropdownPos(trigger, dropdown);
                    });
                },

                hideDropdown: function (dropdown) {
                    $(dropdown).removeClass('visible');
                },

                setDropdownPos: function (trigger, dropdown) {
                    $(dropdown).css('left', helpers.getPosLeft(trigger));
                },

                populateInput: function (trigger, dropdown) {
                    $(dropdown).find('li').click(function() {
                        $(this).parent().prev(trigger).attr('value', $(this).text());
                        EP.timepicker.hideDropdown(dropdown);
                    });
                },

                validateInput: function (trigger) {
                    var validTime = /^(\d{1,2}):(\d{2})(:(\d{2}))?(\s?(AM|am|PM|pm))?$/,
                        inputText = $(trigger).attr('value'),
                        matchArray = inputText.match(validTime);
                        
                    if (inputText !== '') {

                        if (matchArray) {

                            var hours = matchArray[1],
                                mins = matchArray[2],
                                secs = matchArray[4],
                                ampm = matchArray[6];

                            if (helpers.checkHours(ampm, hours) === false) {
                                formError(trigger, 'Invalid value for hours: ' + hours);
                                return false;
                            }

                            if (checkMinsSecs(mins) === false) {
                                formError(trigger, 'Invalid value for minutes: ' + mins);
                                return false;
                            }

                            if (checkMinsSecs(secs) === false) {
                                formError(trigger, 'Invaid value for seconds: ' + secs);
                                return false;
                            }

                        } else {

                            formError(trigger, 'Invalid time format: ' + inputText);
                            return false;
                        }
                    }

                    $(trigger).removeClass('error');
                    return true;
                },

                save: function (formSelector) {
                    var form = $(formSelector);
                    $(formSelector).submit(function () {
                        if (EP.timepicker.validateInput() === false) {
                            $('input#publish').removeClass('button-primary-disabled'); // Remove the 'focused' style for the Publish button
                            $('img#ajax-loading').hide(); // re-hide the 'loading' graphic to left of Publish button
                            alert('Please enter a valid time format.');
                            return false;
                        } else if (EP.timepicker.validateInput() === true) {
                            return true;
                        }
                    });
                }
            };

        if (options) {
            $.extent(settings, options);
        }

        return pubMethods;
    };

}(jQuery));

// what to call on doc ready 
(function($) {
    $(document).ready(function() {
        $('input.ep-datepicker').datepicker();
        var timepicker = new EP.timepicker();
        timepicker.init();
    });
})(jQuery);
