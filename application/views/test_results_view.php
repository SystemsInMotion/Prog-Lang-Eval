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
	
	<?php foreach($test->getQuestions() as $question): ?>
		
		<?=$question->getId()?>: <?=$question->getScore()?>
		<br>
		
	<?php endforeach ?>

</div>

</body>
</html>
