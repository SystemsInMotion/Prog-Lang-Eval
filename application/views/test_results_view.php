<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to your test!</title>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="../assets/js/jqBarGraph.1.1.js"></script>
	
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
	
	<fieldset id="levels" data-levels="<?=$test->getLevelCount()?>">
		<legend>Score by Level</legend>

		
	</fieldset>
	
	<div id="questions">
		<?php foreach($test->getQuestions() as $question): ?>
			<?=$question->getId()?>: 
			<?=$question->isDeclined()? "declined" : $question->getScore()?>
		<br>
			
		<?php endforeach ?>
	</div>

</div>

</body>
</html>
