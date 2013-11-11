<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to your test!</title>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="../assets/css/test.css">
	<script type="text/javascript" src="../assets/js/script.js"></script>
	

</head>
<body>

<div id="main">

	
	Total Score: <?=$test->getTotalScore()?>
	<br>
	Questions Answered: <?=$test->getTotalAnswered()?> / <?=$test->getTotalQuestions()?> 
	<br>
	<br>
	
	<fieldset id="levels" data-levels="<?=$test->getLevelCount()?>">
		<legend>Score by Level</legend>
		
		<?php foreach($test->getLevels() as $number => $level): ?>
			<div class="level">
				<?=$number?>: <?=$level->getScore()?> (<?=$level->getTotalQuestions()?>)
				<div class="level_result" data-questions="<?=$level->getTotalQuestions()?>">
					
					<?php foreach($level->getScoreDistribution() as $score => $count): ?>
						<div class="level_score" data-score="<?=$score?>" data-count="<?=$count?>">
							<?=$score?>: <?=$count?>
						</div>
					<?php endforeach ?>
					
				</div>
			</div>
		<?php endforeach ?>
		
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
