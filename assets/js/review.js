
$(document).ready(function() {
	
	$('.level').each(function() { 
		$(this).height($(this).data('questions')+"em");
	});
	
	$('.level_result').each(function() { 
		$(this).height($(this).data('questions')+"em");
	});

	$('.level_score').each(function() { 
		$(this).height($(this).data('count')+"em");
	 });
	
	
});