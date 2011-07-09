(function (document, $, undefined) {

    var defaults = {
        version : '1.0',
        linkClass : '',
        targetId : '',
        onStart : function() {},
        onComplete : function() {},
        onResponse : function() {}
    };

	$.fn.openLi = function (options) {

        return this.each(plugin);

        function plugin () {
            var opts = $.extend(defaults, options),
                $t = $(this);
            $t.delegate('.'+opts.linkClass, 'click', function() {
                opts.onStart($t);
				$.get($(this).attr('href'), {}, function(data) {
                    opts.onResponse(data);
                    $('#'+opts.targetId).html(data);
                    opts.onComplete(data);
				});
				return false;
			});
        }
	};

    var private = function () {

    };

})(document, jQuery);
