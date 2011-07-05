(function (document, $, undefined) {

    var defaults = {
        version : '1.0',
        windowId : ''
    },

    opts = {};

	$.fn.ascWindow = function (options) {

        opts = $.extend(defaults, options);
        return this.each(plugin);

        function plugin () {
            var $t = $(this), parent, url;
            
			$t.delegate('#'+opts.windowId+'-link', 'click', function() {
				url = $(this).attr('href');
				parent = $(this).parent();
				$('#'+opts.windowId).dialog('open');
				return false;
			});

			$('#'+opts.windowId).find('form').submit(function() {
				$('#'+opts.windowId).dialog('close');
                var fields = {};
                
                $('#'+opts.windowId).find('input[type="text"], input[type="hidden"]').each(function () {
                    var $t = $(this);
                    fields[$t.attr('name')] = $t.val();
                });
				
				$.get(url, fields, function(data) {
					$(data).insertBefore(parent);
				});
				return false;
			});
        }
	};

    var private = function () {
        
    };
    
})(document, jQuery);