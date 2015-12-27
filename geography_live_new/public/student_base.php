<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>	
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in_student(); ?>



	
<?php include("../includes/layouts/header.php"); ?>

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
				<p><a href="quiz_front.php">Quizzes</a></p>
				<br />
				<p><a href="student_progress_student.php">High Scores and Badges</a></p>
				<br />
				<p><a href="student_account.php">Update Account Information</a></p>
			</div>
		</aside>

		<main>
		<article id="quizSpace">
				<h2>Student Base Page</h2>
				<br />
				<p>You are logged in as a student!</p>
				<br />
				<p>From here you can go to quizzes, check your high scores and badges, and update your account information.</p>	
		</article>
		</main>
		
<?php include("../includes/layouts/footer.php"); ?>
