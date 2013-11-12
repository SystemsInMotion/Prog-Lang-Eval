<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to your test!</title>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="../assets/js/jqBarGraph.1.1_a.js"></script>
	
	<link rel="stylesheet" type="text/css" href="../assets/css/review.css">
	<script type="text/javascript" src="../assets/js/review.js"></script>
	
	

</head>
<body>

<div id="main">

	
	Total Score: <?=$test->getTotalScore()?>
	<br>
	Questions Answered: <?=$test->getTotalAnswered()?> / <?=$test->getTotalQuestions()?> (<?=$test->getTotalDeclined()?> declined)
	<br>
	<br>
	
	<script type="text/javascript">
		var scoreTableData = <?=$graph_data?>;
		
	</script>
	
	<fieldset id="levels">
		<legend>Score by Level</legend>

		
	</fieldset>
	
	<fieldset id="questions">
		<legend>Results by Question</legend>
		
		<table>
			<tr>
				<th colspan="3">Question</th>
				<th colspan="3">{User}'s Results</th>
			</tr>
			<tr>
				<th>Number</th>
				<th>Difficulty Level</th>
				<th>Expected Answers</th>
			
				<th>Score</th>
				<th>Correct Answers</th>
				<th>Incorrect Answers</th>
			</tr>
		<?php foreach($test->getQuestions() as $question): ?>
			<tr>
				<td><?=strtoupper($question->getId())?></td>
				<td><?=$question->getLevel()?></td>
				<td><?=$question->getExpectedCorrect()?></td>
				
				<?php if($question->isDeclined()): ?>
					<td colspan="3">Declined</td>
				<?php else: ?>
					<td><?=$question->getScore()?></td>
					<td><?=$question->getCorrect()?></td>
					<td><?=$question->getIncorrect()?></td>
				<?php endif ?>
								
			</tr>
		<?php endforeach ?>
	</div>

</div>

</body>
</html>
