(function (document, $, undefined) {

    var defaults = {
        version : '1.0',
        linkClass : 'add-widgets',
        dialog : null,
        doClose : true,
        insertResponse : true,
        responseContainerId : null,
        success : function(responseText, statusText, xhr, $form)  {
            if (opts.doClose)
                $form.parent().dialog('close');
            
            if (opts.insertResponse) {
                $('#'+opts.responseContainerId).prepend(responseText);
            }
        },
        beforeSubmit: null
    },

    opts = {};

	$.fn.asc = function (options) {

        opts = $.extend(defaults, options);
        return this.each(plugin);

        function plugin () {
            $(this).delegate('.'+opts.linkClass, 'click', function () {
                var $t = $(this),
                    url = $t.attr('href'),
                    data = new Object();

                data = {
                    modal: true,
                    height: 'auto',
                    width: 'auto',
                    title: $t.text() ? $t.text() : $t.attr('title')
                };
                
                if (opts.isConfirm) {
                    data.buttons = opts.buttons;
                } else {
                    data.open = function () {
                        var $w = $(this);
                        $.get(url, {}, function(data) {
                            $w.html(data).find('form').ajaxForm({
                                //target:        '#output1',   // target element(s) to be updated with server response
                                beforeSubmit:  opts.beforeSubmit,  // pre-submit callback
                                success:       opts.success         // post-submit callback
                            });
                        });
                    };
                }

                opts.dialog = $('<div>').dialog(data);
                return false;
            });
        }
	};
    
    var private = function () {

    };

})(document, jQuery);
