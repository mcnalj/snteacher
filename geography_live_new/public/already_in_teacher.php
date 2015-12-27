<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>	
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>



	
<?php include("../includes/layouts/teacher_header.php"); ?>

<body>
		
	<header>
		<div id = "banner">
			<img src="images/globeglass.png" alt="globe icon">
			<p id ="nameLogo">Atomic Teacher</p>		
		</div>

		<div id = "nav">
			<p id ="back"><a href="../index.php">Atomic Teacher Home</a></p>
			<p id ="logout"><a href="logout.php">Goodbye!</a></p>
		</div>
	</header>
	
		<aside id ="playerStatus">
			<div id="score">
				<p><a href="teacher_base.php">Back to Teacher Base</a></p>
			</div>
		</aside>
	
	<main>
		
		<article id="quizSpace">
			<p>You are already logged in as a teacher!</p>
			<br />
			<p>Go to the <a href="teacher_base.php">Teacher Base Page</a> to check on your students' progress, create new questions, or manage your account</p>
			<br />
			<p>Go to the <a href="quiz_front.php"> Quiz Page</a> if you would like to try a quiz.</p>
			<br />
			<p>Or <a href="logout.php">Logout</a> if you would like to switch to student mode or create an account as a student.</p>									
		</article>
	</main>
		
		
<?php include("../includes/layouts/footer.php"); ?>
