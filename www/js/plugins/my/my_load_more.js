(function($) {
	var defaults = {			
			cur_request : 1,		// 1 - beckause, 0 it is request for render page
			before_load : 1,
            load_count : 4,
			previews_box : '',
			thumbs_box : '#scrollable_widget div.items',
			tabs : {
				rebind : false,
				tabs : '',
				panes : ''
			},
			page : '',
			params : new Object,
			preload : true,
			callback : function() {}
			},
		previews_box,
		thumbs_box,
		tabs,
		panes,
		opts;
		

	$.fn.load_more = function(options) {
		
		opts = $.extend(defaults, options);
		
		thumbs_box = $(opts.thumbs_box);
		
		if(opts.previews_box) previews_box = $(opts.previews_box);		
		
		if(opts.tabs.rebind) {
			tabs = $(opts.tabs.tabs);		
			panes = $(opts.tabs.panes);
		}
		
		if(opts.preload) {
			load();
			opts.preload = false;
		}
		
		this.click(function() {
			opts.before_load--;
			
			if(opts.before_load != 0) return;
			opts.before_load = opts.load_count;
            
			load(); 
			return false;
		});
		
		return this;
	};
	
	function load() {
    			
        var load = $('<div class="earth_load"></div>');

			thumbs_box.append(load);						//load animation
				
		opts.params['cur_request'] = opts.cur_request;
		
        $.post(opts.page, opts.params, function(data) {
            if(data.status == 'ok') {
        
	           	opts.cur_request++;
	            
				load.remove();								//remove load animation
				
				if(previews_box) previews_box.append(data.previews);
				if(thumbs_box)   thumbs_box.append(data.thumbs);                
                if(opts.tabs.rebind) {
					tabs.data('tabs').destroy();
					opts.callback();
				}
            } else {
                
            }
        }, 'json');
    }
	
})(jQuery);
