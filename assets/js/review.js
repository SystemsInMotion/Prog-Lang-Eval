
$(document).ready(function() {
	
	var graphParams = {
			data: scoreTableData, 
			colors: ['red', 'white', 'green'], 
			legend: true, 
			legends: ['Incorrect', 'Declined', 'Partial', 'Correct']
	};
	
	$('#levels').jqBarGraph(graphParams); 
	
});