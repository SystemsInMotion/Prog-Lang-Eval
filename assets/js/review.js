
$(document).ready(function() {
	
	var graphParams = {
			data: scoreTableData,
			legend: true, 
			legends: ['Incorrect', 'Partial', 'Correct', 'Declined']
	};
	
	$('#levels').jqBarGraph(graphParams); 
	
});