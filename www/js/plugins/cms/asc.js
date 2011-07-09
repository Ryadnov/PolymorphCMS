(function (document, $, undefined) {

    var defaults = {
        version : '1.0',
        linkClass : 'add-widgets',
        dialog : null
    },

    opts = {};

	$.fn.asc = function (options) {

        opts = $.extend(defaults, options);
        return this.each(plugin);

        function plugin () {
            $(this).delegate('.'+opts.linkClass, 'click', function () {
                $t = $(this);
                opts.dialog = $('<div id="d">').dialog({
                    modal: true,
                    open: function () {
                        var $w = $(this);
                        $.get($t.attr('href'), {}, function(data) {
                            $w.html(data).find('form').ajaxForm({
                                //target:        '#output1',   // target element(s) to be updated with server response
                                beforeSubmit:  opts.beforeSubmit,  // pre-submit callback
                                success:       opts.success         // post-submit callback
                            });

                        });
                    },
                    height: 'auto',
                    width: 'auto',
                    title: $t.text()
                });
                return false;
            });
        }
	};
    
    var private = function () {

    };

})(document, jQuery);
