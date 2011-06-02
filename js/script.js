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

// what to call on doc ready 
(function($) {
    $(document).ready(function() {
        EP.someMethod();
    });
})(jQuery);
