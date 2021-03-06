<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to your test!</title>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="../assets/css/test.css">
	<script type="text/javascript" src="../assets/js/test.js"></script>
	

</head>
<body>
	
<div id="overlay"></div>

<div id="intro">

	<div class="button">
	
	</div>
	
	<div class="contents">
	
		<fieldset id="key">
			<legend>Scoring</legend>
			
			<table>
				<tr>
					<td class="question_type">
						<strong>Single</strong> Answer Questions<br>
						("<em>Select one answer.</em>")
					</td>
					<td class="answers">
						<span class="correct">Correct</span><br>
						<span class="incorrect">Incorrect</span><br>
					</td>
					<td class="score">
						 <span class="correct">+ 1</span><br>
						 <span class="incorrect">- &frac12;</span>
					</td>
				</tr>
					<td class="question_type">
						<strong>Multiple</strong> Answer Questions<br>
						("<em>Select all correct answers.</em>")
					</td>
					<td class="answers">
						<span class="correct">All Correct</span><br>
						Some Correct</span><br>
						<span class="incorrect"><strong><em>Any</em></strong> Incorrect</span>
					</td>
					<td class="score">
						 <span class="correct">+ 1<br>
						 + &frac12;<br>
						 <span class="incorrect">- &frac12;</span>
					</td>
				<tr>
				</tr>
				<tr>
					<td colspan="3">
						<em>No question will score more than <span class="correct"><strong>+ 1</strong></span> or less than <span class="incorrect"><strong>- &frac12;</span>
					</td> 	
				</tr>
			</table>
		</fieldset>
		
		<?php if ($review): ?>
			<fieldset class="review">
				<legend>Question Difficulty Levels</legend>
			 	Who will answer this question correctly:
				<ol>
					<li><strong>Basic:</strong> Any programmer</li>
					<li><strong>Essential:</strong> Any Java programmer</li>
					<li><strong>Competent:</strong> A Java programmer with college-level experience</li>
					<li><strong>Experienced:</strong> A Java programmer with some professional experience</li>
					<li><strong>Excellent:</strong> A senior Java programmer</li>
					<li><strong>Obscure:</strong> Someone who memorized the Java API?</li>
				</o>
			</fieldset>			
		<?php endif ?>	
	
	</div>

</div>

<div id="main">
	
	<div id="name">
		<?=$test_name?>
	</div>
	
	<form id="exam" action="submit" method="post">
	
		<ol id="questions">
			<?php $qnum = 1?>
		
			<?php foreach ($questions as $qid => $question): ?>
		    	<li class="question" data-number="<?=$qnum?>">
		    		<?php if ($review): ?>
		    			<div class="review">
		    				Original Question #: <?=$qid?><br>
		    				Question Difficulty Level: <?=$question->getLevel()?>
		    			</div>
		    		<?php endif ?>
		    		
		    		<div class="text">
		    			<?=$question->getText()?>
		    		</div>
		    			    		
		    		<ol class="answers">
		    		
		    			<span class="instruction">
		    				<?= ($question->hasMultipleAnswers())?
		    					"Select all correct answers." :
		    					"Select one answer."
		    				?>
		    			</span>
		    			
		    			<?php foreach ($question->getAnswers($shuffle) as $aid => $answer): ?>
		    				<li class="answer">
		    				
		    					<section class="input">
			    					<input
			    						<?= $question->hasMultipleAnswers()?
						    				'type="checkbox"' : 'type="radio"' 
						    			?> 
						    			id="<?=$answer->getUid()?>" name="<?=$qid?>[]" value="<?=$aid?>"
						    			<?php if ($review && $answer->isCorrect()): ?>
						    				checked="checked"
						    			<?php endif ?>
						    		>
						    	</section>
				    			
				    			<section class="label">
		    						<label for="<?=$answer->getUid()?>"><?=$answer->getText()?></label>
		    					</section>
		    					
		    					<div style="clear:both"></div>
		    				</li>
		    			<?php endforeach ?>
		    			
		    			<?php $qnum++; ?>
		    		</ol>
		    		
		    		<div class="decline">
		    			<input type="checkbox" id="<?=$qid?>_decline" name="<?=$qid?>" value="decline">
		    			<label for="<?=$qid?>_decline">Decline to answer this question</label>
		    		</div>
		    	</li>
			<?php endforeach ?>
			
		</ol>
		
		<input type="submit">
		
	</form>

</div>

<footer>
	<?=$version?>
</footer>

</body>
</html>
