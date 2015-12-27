<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<!DOCTYPE html PUBLIC>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Summer Geography</title>
			<link href="stylesheets/stylesheet1.css" media="all" rel="stylesheet" type="text/css" />
	</head>


<?php //include("../includes/layouts/header.php"); ?>
<body>

	<header>
		<div id = "banner">
			<p id ="currentQuiz">World Geography Quiz</p>
			<img src="images/globeglass.png" alt="globe icon">
			<p id ="nameLogo">Atomic Teacher</p>		
		</div>

		<div id = "nav">
			<p id ="back"><a href="../index.php">Back to the Front Page</a></p>
			<p id ="logout"><a href="logout.php">Goodbye!</a></p>
		</div>
	</header>	
	

	<aside id="playerStatus">
			<!--<h1>SCOREBOARD</h1>-->
		<div id="score">
			<h2>PROGRESS</h2>
			<p><span class = "color">6</span> correct</p>
			<p><span class = "color">18</span> answered out of 20</p>
			<p id="name"><span class="quiz">Quiz Name</span> Personal Best:</p>
			<p id = "personalBest"><span class = "color">10</span> correct</p>
			<p id = "badgeReq">score 18 out of 20 to earn a badge</p>
		</div>

		<div id="badges">
			<h2>BADGES EARNED</h2>
			<table>
			<tr><td>Hawaii Badge:</td><td>YES</td></tr>
			<tr><td>World Geography Badge:</td><td>YES</td></tr>
			<tr><td>Portland Badge:</td><td>YES</td></tr>	
			<tr><td>United States Badge:</td><td>YES</td></tr>	
			<tr><td>Leaders Badge:</td><td>YES</td></tr>
			</table>
		</div>
	</aside>
	
	<main>

	<article id="quizSpace">
			
		<?php
		$width = 512;
		$height = 512;
		
		if ($width == 0 || $height == 0) {
			$adjusted_width = 350;
			$adjusted_height = 350; 
			 }
		else if ($width/$height >= 2) {
			$width_adjust_factor = 700 / $width;
			$adjusted_width = $width * $width_adjust_factor;
			$adjusted_height = $height * $width_adjust_factor; 
		} else {
			$height_adjust_factor = 350 / $height;
			$adjusted_height = $height * $height_adjust_factor;
			$adjusted_width = $width * $height_adjust_factor;
		}
		?>

		<section id="picture">
			<!--<h4>Image</h4>-->
			<img src="images/brazil.png" alt="Map of Brazil" style="width:<?php echo($adjusted_width); ?>;height:<?php echo($adjusted_height); ?>;">
			<p>Title by McNalj licensed by Creative Commons Share Alike 3.0 Unported</p>
		</section>

		<section id="question">
			<!--<h4>Question</h4>-->
			<p>Which country is depicted here?</p>
		</section>


		<form action="quiz_action.php" method-"post">
			<fieldset>
				<input type="radio" name="answer" value="1">Php echo printf
				<br />
				<br />
				<input type="radio" name="answer" value="1">Brazil
				<br />
				<br />
				<input type="radio" name="answer" value="1">Argentina
				<br />
				<br />
				<input type="radio" name="answer" value="1">Uruguay
				<br />
				<br />
				<input type="radio" name="answer" value="1">Peru
				<br />
				<br />
				<input type="submit" name="submit" value="Submit" id="submit" />
			</fieldset>
		</form>
		
		</article>

		<aside id="conversation">
			<!--<h4>Student's Name</h4>-->
				<p id="grade">Correct!</p>
				<p id="convo">That's right. Show 'em what you got . . .</p>
		</aside>
		
				
			<br />
	</main>

		<footer>
			<p>Copyright McNalj 2015</p>
		</footer>
</body>
</html>		