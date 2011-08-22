(function($) {
	
	$.fn.submitter = function(options) {
		
		$(this).data('submitter', true);
		
	   	var defaults = {	
            page : '',
            format : 'json',
            wysiwyg_fields : new Array(),
            fields : new Array(),
            checkboxes : new Array(),
            CM_fields : new Array(),
            extrafields : new Object(),
            shadow_on_form : false,
            
            er_box : 'div.er_box',
            success_box : 'div.success_box',
            
            on_submit_start : function() {
                form.find(opts.er_box).hide();
            },
            
            on_submit_success : function(data) {
                form.parent().find(opts.success_box).html(data.msg).show(500).delay(1000).hide(500);
            },
            
            on_submit_error : function(data) {
                var er_box = form.find(opts.er_box).empty();
                for(var i in data.errors)
                    er_box.append($('<p class="exception_msg"></p>').html(data.errors[i]));
                er_box.show(500).delay(1000).hide(500);
            },
            
            success_condition : function() {return true;},
            
            do_collapse : false,
            collapse : function(item) {
                $(item).hide(1000, function() {$(this).remove();});
            },
            
    		callback : function() {}
    	},
        submit_in_process = false,
        form = this, 
		opts = $.extend(defaults, options),
        widget = form.parents('div.sidebar_widget:first, div.widget:first, div.area:first'),
        widget = widget.length != 0 ? widget : form,
        //widget = opts.shadow_on_form ? form : widget,
        loading_box,
                        
    	form_submitter = function() {
    	   
    		if(submit_in_process) return false;
           
            off = widget.offset(),
            loading_box = $('#load_holder').clone().css({
                'top' : off.top,
                'left': off.left,
                height: widget.outerHeight(),
                width : widget.outerWidth()
            }).find('.loading').css({
                'top' : widget.outerHeight() / 2 - 32,
                'left' : widget.outerWidth() / 2 - 32,
                'display' : 'block'
            }).end();
            
            submit_in_process = true;
            
            opts.on_submit_start();
             
            var obj = new Object(opts.fields.length + opts.wysiwyg_fields.length + opts.checkboxes.length);
            
            loading_box.appendTo('body');
            
            for(i in opts.fields)                                         //records all field to send post
                obj[opts.fields[i]] = form.find('[name="'+opts.fields[i]+'"]').val();             
    
            for(i in opts.w_fields)
                obj[opts.w_fields[i]] = form.find('#'+opts.w_fields[i]).data('wysiwyg').getContent();    
               
            for(i in opts.checkboxes)
                obj[opts.checkboxes[i]] = form.find('[name="'+opts.checkboxes[i]+'"]').attr('checked') ? 1 : 0;    
            
             for(i in opts.extrafields)
                obj[opts.extrafields[i]] = $('#'+opts.extrafields[i]).val();    
            
             for(i in opts.CM_fields) {            	
            	 obj[i] = opts.CM_fields[i].getValue();    
             }
             
             $.post(opts.page, obj, function(data) {
            
                loading_box.remove();  
                if(data.status == 'ok') {
                    if(opts.do_collapse) opts.collapse(form);
                    opts.on_submit_success(data);
                } else {                    
                    opts.on_submit_error(data);
                }
                
                submit_in_process = false;
                
                opts.callback(data);
                
            }, opts.format);
        };
        
        form.submit(function() {
		    
        	form_submitter();
			return false;
		});
		
		return this;
	};
	
})(jQuery);
