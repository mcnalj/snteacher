<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<!DOCTYPE html PUBLIC>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Summer Geography</title>
			<link href="stylesheets/stylesheet.css" media="all" rel="stylesheet" type="text/css" />
	</head>


<?php //include("../includes/layouts/header.php"); ?>
<body>
	
	<div id="header"></div>



	<div id="body">
		<p class="text">
			<?php echo "Answer Message"; ?>
		</p>
		
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

		<img src="images/brazil.png" alt="Map of Brazil" style="width:<?php echo($adjusted_width); ?>;height:<?php echo($adjusted_height); ?>;">
			<p class="caption">Title by McNalj licensed by Creative Commons Share Alike 3.0 Unported</p>

		<p class="text">Which country is depicted here?</p>

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
				<input type="submit" name="submit" value="Submit" />
			</fieldset>
		</form>
			<br />
		</div>



		<div id="left">
			<p><a href="../index.php">Back to the Front Page</a></p>
			<div id="score">
				<p>PROGRESS</p>
				<p>0 out of 6 questions answered correctly</p>
			</div>
	
			<div id="badges">
				<p>BADGES EARNED</p>
				<p>Hawaii Badge: YES</p>
				<p>World Geography Badge: YES</p>
				<p>Portland Badge: YES</p>	
				<p>United States Badge: YES</p>	
				<p>Leaders Badge: YES</p>
			</div>
		</div>



		<div id="footer">
			<p>Copyright McNalj 2015</p>
		</div>

</body>		