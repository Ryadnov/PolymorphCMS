(function($) {
	var defaults = {			
			vote_page : '/news/vote',
            answer_page: '/news/add_comment',
            news_id : null,
            is_logged : false,
		    form : null,
            fields : null
        },
        old_id,
        submit_in_process = false,
        opts;
		
	$.fn.comments = function(options) {
		
        opts = $.extend(defaults, options);
        
        opts.fields = opts.form.find('input, textarea, checkbox');
        
        var li = this.find('li');
        
        li.each(function() {
                 
            var comment = $(this),                             //init
                vote_buttons = comment.find('a.vote_plus:first, a.vote_minus:first'),
                plus = comment.find('a.vote_plus:first'),
                minus = comment.find('a.vote_minus:first'),
                reiting = comment.find('span.reiting:first'),
    		    answer = comment.find('a.answer:first'),
                last_el = comment.find('div.description:first'),
                id = comment.attr('class').substr(8);
    
            plus.click(function() {
    			send_vote('+', id, reiting, vote_buttons); 
    			return false;
    		});
            
            minus.click(function() {
                send_vote('-', id, reiting, vote_buttons);
                return false;
            });
    		
            answer.click(function() {
                
                if(old_id == id && opts.form.css('display') == 'block') {
                    opts.form.hide(300);
                    return false;
                } else {   
                    old_id = id;
                }
                
                if(opts.form.css('display') == 'block') {
                    opts.form.hide(300, function() {
                        last_el.after(opts.form);
                        opts.form.show(300);
                    });
                } else {
                    last_el.after(opts.form);
                    opts.form.show(300);    
                }
                
                return false;
            });
        });
        
		return this;
	};
	
    $.fn.comment_form_submitter = function() {
        
        this.submit(function() {
            
            if(!opts.form.data('validator').checkValidity()) return false;
            if(submit_in_process) return false;
            
            submit_in_process = true;
            
            var form = $(this),
                comment = form.parent().parent(),
                id = comment.attr('class').substr(8),
                off = form.offset(),
                loading_box = $('#load_holder').clone().css({
                    'top' : off.top,
                    'left': off.left,
                    height: form.outerHeight(),
                    width : form.outerWidth(),
                    'padding' : form.css('padding')
                }).find('.loading').css({
                    'top' : form.outerHeight() / 2 - 32,
                    'left' : form.outerWidth() / 2 - 32,
                    'display' : 'block'
                }).end();

            send_answer(comment, id, loading_box);
            
            return false;
        });
        
    };
    //comment functions
    function send_answer(comment, id, loading_box) {
        
        loading_box.appendTo('body');
        
        $.post(
            opts.answer_page,
            {
                news_id : opts.news_id,
                parent_id : id,
                text : opts.form.find('textarea[name="text"]').val(),
                name : opts.form.find('input[name="name"]').val(),
                captcha_text : opts.form.find('input[name="captcha_text"]').val(),
                captcha_img : opts.form.find('input[name="captcha_img"]').val()
                //website : opts.form.find('input[name="website"]').val(),
                //email : opts.form.find('input[name="email"]').val()
            },
            function(data) {
                if(data.status == "ok") {
                    if(opts.form.css('display') == 'block') {
                        opts.form.hide(300);
                    } 
                    submit_in_process = false;
                    insert_new_comment(comment, data.comment);
                } else if(data.status == 'error') {
                    
                    opts.form.find('div.er_box').html(data.errors[0]);            
                }
                
                loading_box.remove();
                submit_in_process = false;
            },
            'json'
        );
    }
    
    function insert_new_comment(comment, new_comment) {
        var ul = comment.find('ul:first');
        if(ul.length > 0) {
            ul.append(new_comment).hide().show(300);
        } else {
            $('<ul></ul>').append(new_comment).appendTo(comment).hide().show(300);
        }
    }
    
    //vote functions
	function send_vote(action, id, reiting, buttons) {
        buttons.remove();
        
        $.post(
            opts.vote_page, 
            {
                comment_id: id,
                action : action
            }, 
            function(data) {
                if(data.status == 'ok') {
                    set_reiting(reiting, data.reiting);
                } 
            }, 
            'json'
        );
    }
    
    function set_reiting(reiting, new_reiting) {
        
        var numb = parseInt(new_reiting);
            
        new_reiting = numb > 0 ? '+' + numb : numb;
        reiting.text(new_reiting);
        
        if(numb == 0 || numb == 1) {
           reiting.removeClass('red').removeClass('green');
           numb == 0 ? reiting.addClass('red') : reiting.addClass('green');
        }
    }
    
	
})(jQuery);
