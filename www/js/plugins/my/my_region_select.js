(function($) {
       	
	$.fn.region_select = function(options) {
	   
    	var city_select = $(options.city_select),
            region_select = this;
   
        function get_cities() {
                 
            var region_id = $(this).val();
            
            $.post(
                '/works/get_cities_in_region',
                {
                    region_id : region_id
                },
                function(data) {
                    if(data.status == "ok") {
                        show_city_select(data.cities);
                    } else {
                        region_select.val(0);
                    }                    
                }, 
                'json'
            );
        }
            
        function show_city_select(cities) {
            city_select.empty().append(cities).show(300);
        }
   
        region_select.change(get_cities);
        
		return this;
	};
	
})(jQuery);
