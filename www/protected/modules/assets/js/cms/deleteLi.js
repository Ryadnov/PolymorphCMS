(function (document, $, undefined) {

    var defaults = {
        version : '1.0',
        linkClass : ''
    },

    opts = {};

	$.fn.deleteLi = function (options) {

        opts = $.extend(defaults, options);
        return this.each(plugin);

        function plugin () {
            var $t = $(this);
            $t.delegate('.'+opts.linkClass, 'click', function() {
				var link = $(this);
				$.get(link.attr('href'), {}, function(data) {
					link.parent().remove();
				});
				return false;
			});
        }
	};

    var private = function () {
        
    };
    
})(document, jQuery);