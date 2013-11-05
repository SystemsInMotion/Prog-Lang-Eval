
$(document).ready( function() {
	
	$('.decline input').change(function() {
		var el = $(this);
		
		var decline = el.is(":checked");
		
		var answers = el.closest('.question').find('.answers');
		answers.find('input').attr('disabled', decline);
		answers.toggleClass('declined', decline);
	});
	
});