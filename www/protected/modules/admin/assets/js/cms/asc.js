(function (document, $, undefined) {

	$.fn.asc = function (options) {

        var defaults = {
            version : '1.0',
            dialog : null,
            doCloseDialog : true,
            insertResponse : true,
            responseContainerId : null,
            isStatic : false,
            success : function(responseText, statusText, xhr, $form)  {
                if (opts.insertResponse) {
                    $('#'+opts.responseContainerId).prepend(responseText);
                }
            },
            beforeSubmit: null
        },

        opts = $.extend(defaults, options);

        return this.each(plugin);

        function plugin () {
            $(this).click(function () {
                var $t = $(this),
                    url = $t.attr('href'),
                    data = new Object();

                data = {
                    modal: true,
                    height: 'auto',
                    width: 'auto',
                    title: $t.text() ? $t.text() : $t.attr('title')
                };

                data.buttons = opts.buttons;

                data.open = opts.isStatic ? null : function () {
                    var $w = $(this);
                    $.get(url, {}, function(data) {
                        $w.html(data).find('form').ajaxForm({
                            //target:        '#output1',   // target element(s) to be updated with server response
                            beforeSubmit:  opts.beforeSubmit,  // pre-submit callback
                            success:       function(responseText, statusText, xhr, $form)  {
                                //close UI-Dialog
                                if (opts.doCloseDialog)
                                    $form.parent().dialog('close');

                                //external event
                                opts.success(responseText, statusText, xhr, $form);
                            }
                        });
                    });
                };

                opts.dialog = $('<div>').dialog(data);
                return false;
            });
        }
	};
    
    var private = function () {

    };

})(document, jQuery);
