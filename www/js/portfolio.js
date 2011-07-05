/**
 * 
 */
$(document).ready(function() {
	
	//hotkeys
	$(document).bind('keydown', 'Ctrl+left', function() {
		$('#portfolioPager .previous a').click();
	}).bind('keydown', 'Ctrl+right', function() {
		$('#portfolioPager .next a').click();
	});
	
	var body = 	$('#portfolio-body');
	hideButton();
	
	body
		//highlight
		.delegate('#portfolio > li', 'mouseover', function() {
			$('#portfolio-picz').find('.'+$(this).attr('class')+'>a').addClass('active');
		})
		.delegate('#portfolio > li', 'mouseout', function () {
			$('#portfolio-picz').find('.'+$(this).attr('class')+'>a').removeClass('active');
		})
		.delegate('#portfolio-picz > li', 'mouseover', function() {
			$('#portfolio').find('.'+$(this).attr('class')).addClass('active');
		})
		.delegate('#portfolio-picz > li', 'mouseout', function () {
			$('#portfolio').find('.'+$(this).attr('class')).removeClass('active');
		})
		//filter
		.delegate('#filter', 'change', function() {
			$.get(
				$('#filter-wrapper > form').attr('action'), 
				{
					filter:$(this).val()
				},
				function (data) {
					body.html($(data).find('#portfolio-body').html());
					hideButton();
				}
			);
		})
		.delegate('#filterDetails', 'change', function() {
			$.get(
				$('#filter-wrapper > form').attr('action'), 
				{
					filter : $('#filter').val(),
					filterDetails : $(this).val()
				}, 
				function(data) {
					body.html($(data).find('#portfolio-body').html());
					hideButton();
				}
			);
		});
	
	//hide filter form submitButton
	function hideButton()
	{
		$("#filter-wrapper input").hide();
	}
});