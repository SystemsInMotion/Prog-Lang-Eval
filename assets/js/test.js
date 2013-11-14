
$(document).ready( function() {
	
	$('.decline input').change(function() {
		var el = $(this);
		
		var decline = el.is(":checked");
		
		var answers = el.closest('.question').find('.answers');
		answers.find('input').attr('disabled', decline);
		answers.toggleClass('declined', decline);
	});
	
	
	$('form').submit(function() {
		var skipped = [];
		
		$('.question').each(function() {
			checked = $(this).find('input:checked');
			if (checked.length < 1) {
				skipped.push($(this).data('number'))
			}
		});
		
		if (skipped.length < 1) {
			return true;
		}
		
		alert("Please either answer or decline every question.\n You skipped "+skipped+"\n\nIf you have questions, please check the instructions or ask the proctor.");
		
		return false;
	});

	$('#intro').click(toggleIntro);
	
});

function toggleIntro() {
	if ($('#intro').hasClass('min')) {
		showIntro();
	}
	else {
		hideIntro();
	}
}

function showIntro() {
	$('#intro').removeClass('min').removeAttr('style');
	$('#intro').find('*').removeAttr('style');
	$('#overlay').show();
}

function hideIntro() {
	var complete = function() {
		$('#intro').addClass('min');
	};
	
	var attr = {width: '10em', height: '1em', left: 0, 'margin-left': 0, 'margin-top': '-1em', padding: '0.5em'};
	
	$('#intro .contents').animate({'font-size': 0});
	$('#intro').animate(attr, complete);
	$('#overlay').fadeOut();
	
}