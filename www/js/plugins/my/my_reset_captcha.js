(function($) {
       	
	$.fn.reset_captcha = function() {
	    
        this.click(function() {
            var k = $(this).siblings('img.captcha');
                
            k.animate({'opacity' : '0.01'}, 500);
            $.post(
                '/pages/get_new_captcha',
                {},
                function(data) {
                    if(data.status == 'ok') {
                        k.attr('src', data.img).animate({'opacity' : '1'}, 200);  
                    } 
                },
                'json'
            ); 
            return false;
        });         
        
		return this;
	};
	
})(jQuery);
