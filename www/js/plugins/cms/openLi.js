(function (document, $, undefined) {

    var defaults = {
        version : '1.0',
        linkClass : '',
        targetId : ''
    },

    opts = {};

	$.fn.openLi = function (options) {

        opts = $.extend(defaults, options);
        return this.each(plugin);

        function plugin () {
            var $t = $(this);
            $t.delegate('.'+opts.linkClass, 'click', function() {
				$.get($(this).attr('href'), {}, function(data) {
					$('#'+opts.targetId).html(data);
				});
				return false;
			});
        }
	};

    var private = function () {

    };

})(document, jQuery);
