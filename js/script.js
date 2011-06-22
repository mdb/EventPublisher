if (typeof EP === 'undefined' || !EP)  {
    // EventPublisher global namespace object
    var EP = {};
}

// timepicker
(function($) {

    EP.Timepicker = function(options) {

        // configuration options, which can be overridden via 'options' argument
        var settings = {

                form: $('form#post'),
                startPicker: $('#start_date_meta input.ep-timepicker'),
                endPicker: $('#end_date_meta input.ep-timepicker'), 
                startDropdown: $('#start_date_meta ol.ep-timepicker'),
                endDropdown: $('#end_date_meta ol.ep-timepicker')
            },

            // object to house private helper methods
            helpers = {

                getPosLeft: function(elem) {
                    return Math.floor($(elem).position().left);
                },

                setPosTop: function(dropdown) {
                    var dropdownHeight = $(dropdown).outerHeight(),
                        viewportBottom = $(window).height() - $(window).scrollTop();

                    if (dropdownHeight > viewportBottom) {
                        $(dropdown).css('top', '0');
                    }
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

            // object to house public methods returned by EP.timepicker
            pubMethods = {

                init: function () {

                    var tp = this;

                    tp.toggleDropdown(settings.startPicker, settings.startDropdown);
                    tp.toggleDropdown(settings.endPicker, settings.endDropdown);
                    tp.save();
                    
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

                    $(trigger).blur(function() {
                        setTimeout(function () {
                            tp.hideDropdown(dropdown);
                        }, 0);
                    });

                    tp.populateInput(trigger, dropdown);
                },

                hideDropdown: function (dropdown) {
                    $(dropdown).removeClass('visible');
                },

                setDropdownPos: function (trigger, dropdown) {
                    $(dropdown).css('left', helpers.getPosLeft(trigger));
                    //$(dropdown).css('top', helpers.getPosTop(trigger));
                    //helpers.setPosTop(dropdown);
                },

                populateInput: function (trigger, dropdown) {
                    var tp = this;

                    $(dropdown).find('li').click(function() {
                        $(trigger).attr('value', $(this).text());
                        tp.hideDropdown(dropdown);
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
                                helpers.formError(trigger, 'Invalid value for hours: ' + hours);
                                return false;
                            }

                            if (helpers.checkMinsSecs(mins) === false) {
                                helpers.formError(trigger, 'Invalid value for minutes: ' + mins);
                                return false;
                            }

                            if (helpers.checkMinsSecs(secs) === false) {
                                helpers.formError(trigger, 'Invaid value for seconds: ' + secs);
                                return false;
                            }

                        } else {

                            helpers.formError(trigger, 'Invalid time format: ' + inputText);
                            return false;
                        }
                    }

                    $(trigger).removeClass('error');
                    return true;
                },

                save: function () {
                    var form = settings.form,
                        tp = this;

                    $(form).submit(function () {

                        if (tp.validateInput(settings.startPicker) === false || tp.validateInput(settings.endPicker) === false) {

                            $('input#publish').removeClass('button-primary-disabled'); // Remove the 'focused' style for the Publish button
                            $('img#ajax-loading').hide(); // re-hide the 'loading' graphic to left of Publish button
                            alert('Please enter a valid time format.');
                            return false;

                        } else {

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
        var timepicker = new EP.Timepicker();
        timepicker.init();
    });
})(jQuery);
