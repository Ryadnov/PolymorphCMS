(function (document, $, undefined) {

    var defaults = {
        version : '1.0'
    },

    opts = {};

	$.fn.myPlugin = function () {

        function init(options) {
            opts = $.extend(defaults, options)
            return this.each(plugin);
        };

        function plugin () {
            var $t = $(this);
            // code goes here
        }
	};

/*
	// и, если нужен метод, не привязанный к dom-элементам:
	$.myPlugin = function () {
		
	};
*/
    var private = function () {
        
    };
    
})(document, jQuery);