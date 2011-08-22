(function($) {
	var defaults = {			
        	cur_request : 1,		// 1 - beckause, 0 it is request for render page
            your_site: 'freenews.kz/ru/news',
            google_news: false,
            local: false,
            video: false,
            bing_news: false,
            yahoo_news: false,
            web_search: false,
            lang: 'ru',
            
            local_logo: 'http://dev.freenews.kz/images/FN_label.png',
            local_label: 'Новости от FreeNews.kz',
            google_logo: 'http://google.com/favicon.ico',
            google_label: 'Новости от Google.com'
	},
	opts,
    is_visible = false,
    range,
    selection,
    highlightDiv,
    click_catcher = get_click_catcher();

	$.fn.FN_search_init = function(options) {
		
        opts = $.extend(defaults, options);
        
        $('body').append(click_catcher);

		$('body').bind('textselect mouseup', function(e){
            if(is_visible) return false;
            var info = get_selection_info();
            
            //if empty selection do nothing
            if(info.text.length == 1) {
                var code = info.text.charCodeAt(0);
                if((info.text == undefined) || 
                    (info.text == '') ||  
                    (code == 10) || // \n
                    (code == 13) || // \r
                    ((code >= 32) && (code <= 47)) || 
                    ((code >= 58) && (code <= 64)) || 
                    ((code >= 91) && (code <= 96)) || 
                    ((code >= 123) && (code <= 207)))  return false;
            }
            if(info.text.length == 0) return false;
            
            is_visible = true;
                
            var frame = get_frame(e, info),
                load_bar = get_load_bar(e);
            
            frame.append(get_view()).drag();
            
            //if(opts.google_news) search('google_news', info.text, 'ru', frame);
            //if(opts.local)       search('local', info.text, 'ru', frame);
            //if(opts.video)     search('video', info.text, 'ru', frame);
        
            click_catcher.show();
        
            $('#FN_search_holder')
                .append(frame)
                .append(load_bar)
                .find(".FN_tabs").tabs("div.FN_back > div");
                
            load_bar.css('display', 'block');            
            
            $('#FN_load_front').animate({width: '128'}, 2500, function() {
                load_bar.css('display', 'none');
                frame.css('display', 'block');
            });
        });
        $('#FN_search_holder').delegate('a.FN_close', 'click', hide_all);
    };
    
    function fancy_bind(item) {
        $(item).fancybox({
    		'height'			: '100%',
            'width'             : '100%',
            'titlePosition'		: 'inside',
            'overlayOpacity'	: 0.2,
            'overlayColor'		: '#699',
            'autoScale'			: false,        
    		'transitionIn'		: 'elastic',
    		'transitionOut'		: 'elastic',
            'type'				: 'iframe'
        });
    }    
    
    function hide_all() {
        $('#FN_search_holder').empty();
        $('#FN_selected_text').replaceWith(function () {
            return $(this).text();                                  
        });
        
        if (window.getSelection) { 
            window.getSelection().removeAllRanges(); 
        } else if (document.selection && document.selection.clear) {
            document.selection.clear();
        }
        click_catcher.hide();
        is_visible = false;
        return false;
    }
    
    var local_formatting_functions = {
        title_formatting : function (str) {
            var res = str.split('|');
            var res1 = res[0].split('mobile.');
            return res1[0];
        }, 
        url_formatting : function (str) {
            str = unescape(str);
            var pos = str.indexOf('mobile.');
            return pos > 0 ? str.substr(0, pos) + str.substr(pos + 7, str.length) : str;                 
        }
    },
    
    google_news_formatting_functions = {
        title_formatting : function (str) {
            return str;
        }, 
        url_formatting : function (str) {
            return unescape(str);                 
        }
    },
    
    video_formatting_functions = {
        img_formatting : function (str) {
            return str;
        },
        title_formatting : function (str) {
            return str;
        }, 
        url_formatting : function (str) {
            return unescape(str);                 
        }
    };
    
    function parse_data(data, type, frame) {
        
        if(type == 'google_news') {
            var target = frame.find('#FN_google_results');
            $('#news_search_result_tmpl').tmpl(
                data, 
                google_news_formatting_functions
            ).appendTo(target.prepend(
                '<div class="FN_label">'+
					'<img class="FN_google_logo" src="'+opts.google_logo+'" width="16" height="16" />'+
					'<div class="FN_resource_title">'+opts.google_label+'</div>'+
				'</div>'
            ));
            fancy_bind(target.find('a.FN_title'));
        } else if(type == 'local') {
            var target = frame.find('#FN_local_results');
            $('#news_search_result_tmpl').tmpl(
                data,
                local_formatting_functions
            ).appendTo(target.prepend(
                '<div class="FN_label">'+
					'<img class="FN_local_logo" src="'+opts.local_logo+'" width="16" height="16" />'+
					'<div class="FN_resource_title">'+opts.local_label+'</div>'+
				'</div>'
            ));
        } else if(type == 'video') {
            var target = frame.find('#FN_video_results');
            $('#video_search_result_tmpl').tmpl(
                data,
                local_formatting_functions
            ).appendTo(target);
            
        }
    }
    
    function search(type, query, lang, frame) {

        var _google_search;
        if(type == 'web') {
            _google_search = new google.search.WebSearch();
        } else if(type == 'local') {
            _google_search = new google.search.WebSearch();
            query += ' site:' + opts.your_site;
        } else if (type == 'google_news'){
            _google_search = new google.search.NewsSearch();
        } else if(type == 'video'){
            _google_search = new google.search.VideoSearch();
        }
                
        /*$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?tags=cat&tagmode=any&format=json&jsoncallback=?",
        function(data){
          $.each(data.items, function(i,item){
            $("<img/>").attr("src", item.media.m).appendTo("#images");
            if ( i == 3 ) return false;
          });
        });*/

        //_google_search.setResultSetSize(google.search.Search.LARGE_RESULTSET);
        _google_search.setResultSetSize(4);
        _google_search.setSearchCompleteCallback(
            this, 
    		function(){
    	
        		if (_google_search.results && _google_search.results.length > 0) {
    				parse_data(_google_search.results, type, frame);
    			}
    		}, 
            null
        );
    	
    	_google_search.execute(query); 
    }
    
    function get_load_bar(e) {
        var coords = getCursorPosition(e),
            fix = 'position: absolute; top: 0; left: 0; border: none;';
            
        return $('<div>', {
                "id":"FN_load_back",
                "class": "shadow"
            }).css({
                top : coords.y,
                left: coords.x,
                position: 'absolute',
                border : 'none',
                "z-index" : '100',
                height: 18,
                width: 128,
                display: 'none',
                backgroundColor: '#0671c1'
            }).corner()
            .append($('<div style="'+fix+'color: #FFF; font-weight: bold; height: 18px; width: 128px;"></div>'))
            .append($('<div id="FN_load_front" style="'+fix+'height: 18px; width: 0px; background-image: url(/images/search_load_bg.png); ">'))
            .append($('<div style="'+fix+'margin: 2px 0 0 0; color: #FFF; font-weight: bold; height: 16px; width: 128px; text-align: center;">Поиск Новостей</div>'))
            ;
    }
    
    function get_frame(e, info) {
        var coords = getCursorPosition(e);
        
        return $('<div>', {
                "id":"FN_search_frame",
                "class": "shadow",                   
                //ie border fix
                'border':"0",
                "noresize":"noresize"
            }).css({
                top : coords.y,
                left: coords.x,
                display: 'none'     
            }).corner();
    }
    
    function get_click_catcher() {
        return $('<div>', {
                "id":"FN_click_catcher",                   
                //ie border fix
                'border':"0",
                "noresize":"noresize"
            }).click(hide_all);
    }
    
    function getCursorPosition(e) {
		e = e || window.event;
		var cursor = {x:0, y:0};
		if (e.pageX || e.pageY) {
			cursor.x = e.pageX;
			cursor.y = e.pageY;
		} else {
			cursor.x = e.clientX + 
				(document.documentElement.scrollLeft || 
				document.body.scrollLeft) - 
				document.documentElement.clientLeft;
			cursor.y = e.clientY + 
				(document.documentElement.scrollTop || 
				document.body.scrollTop) - 
				document.documentElement.clientTop;
		}
		return cursor;
	}
    
    function get_selection_info() {
        if (document.selection) {
            selection = document.selection.createRange();
            return {
                text : selection.text,
                html : selection.htmlText,
                x : selection.offsetLeft, 
                y : selection.offsetTop
            };
        } else if (window.getSelection) {
            selection = window.getSelection();
        } else if (document.getSelection) {
            selection = document.getSelection();
        }
        
        var dummy = document.createElement("span"),
            text = '';
        
        if(!selection.getRangeAt || selection.rangeCount == 0) return {text : ''};        //if browser is bad
        
        try { range = expand_range(range, selection); } catch(e) { return {text : ''}; }    //expand range
        text = range.toString();                                                          //get text from range
        try { highlight_range(range); } catch(e) { return {text : ''}; }                    //highlight range
        
        range.collapse(false);                              //fix
        range.insertNode(dummy);                            
  
        var rect = dummy.getBoundingClientRect();
        dummy.parentNode.removeChild(dummy);
  
        return {
            text : text,
//                html : toHTML(range.cloneContents()),
            x : rect.left, 
            y : rect.top
        };
    }
    function highlight_range(range) {
        highlightDiv = document.createElement('span');
        highlightDiv.style.backgroundColor = '#DDD';
        highlightDiv.id = 'FN_selected_text';
        
        // Обернем наш Range в спан
        range.surroundContents( highlightDiv );
    }
    function expand_range(range, selection) {
        var result_range = range,
            all_text = result_range['startContainer']['wholeText'],
            start = result_range['startOffset'],
            end = result_range['endOffset'];
        
        if(all_text == undefined) return result_range;
        
        var i = 0,
            ch = all_text[start - i];
        while((ch+"" != " ") && (i < start)) {
            i++;
            ch = all_text[start - i];
        }
    
        var j = 0,
            ch = all_text[end + j]; 
        while((ch != " ") && (end + j < all_text.length)){
            j++;
            ch = all_text[end + j];
        }
        
        result_range.setStart(selection['anchorNode'], start - i+1);
        result_range.setEnd(selection['focusNode'], end + j);
        return result_range;
    }
    
	function get_view() {
	   return $('#main_search_result_tmpl').tmpl();
	}
    
    function htmlEncode(html) {
        return $('<div/>').text(html).html();
    }
    
    function htmlDecode(text) {
        return $('<div/>').html(text).text();
    }
    
})(jQuery);
