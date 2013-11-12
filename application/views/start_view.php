<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to your test!</title>
	
	<style type="text/css">
	
		body {
			background-size: 60px 60px;
			background-color: blue;
			background-image: linear-gradient(
				-45deg, 
				#888 25%, 
				rgba(255, 255, 255, 0.6) 25%, 
				rgba(255, 255, 255, 0.6) 50%, 
				#888 50%, 
				#888 75%, 
				rgba(255, 255, 255, 0.6) 75%, 
				rgba(255, 255, 255, 0.6));
		}
		
		form {
			font-family: sans-serif;
			font-weight: bold;
			
			box-shadow: 1em 1em 1em 0em rgba(0, 0, 0, 0.6);
			border-radius: 1em;
			
			position: fixed;
			top: 50%;
			left: 50%;
			width: 22em;
			height: 10em;
			margin-top: -10em;
			margin-left: -16em;
			text-align: center;
			border: thick #555 solid;
			
			background-color: white;
			
			padding: 5em;
		}
		
		
		
	</style>

</head>
<body>

<div id="main">

	<?php if ($error): ?>
		<div id="error">
			Sorry, your candidate code was not recognized.
			<br>
			Please try again or ask the test proctor or your recruiter for assistance.
		</div>
	<?php endif ?>

	<form action="welcome" method="post">
		<label for="code">Please enter your candidate code</label>
		<br><br>
		<input type="text" name="code" autocomplete="off">
		
		<input type="submit" value="Enter">
	</form>

</div>

</body>
</html>
