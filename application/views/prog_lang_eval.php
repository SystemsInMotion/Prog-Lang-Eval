<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to your test!</title>
	
	<link rel="stylesheet" type="text/css" href="../assets/css/test.css">

</head>
<body>

<div id="main">
	<h1>Test!</h1>

	<div id="intro">
	
		<?=$test->intro?>
	
	</div>
	
	<ol id="questions">
	
		<?php foreach ($test->questions->question as $question): ?>
	    	<li class="question">
	    		<div class="text">
	    			<?=$question->text->asXML()?>
	    		</div>
	    		
	    		<ol class="answers">
	    			<?php foreach ($question->answers->answer as $answer): ?>
	    				<li class="answer">
	    					<?=$answer->asXML()?>
	    				</li>
	    			<?php endforeach ?>
	    		</ol>
	    	</li>
		<?php endforeach ?>
		
	</ol>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>
