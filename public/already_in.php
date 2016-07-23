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
				<p id ="back"><a href="student_base.php">Student Base</a></p>				
				<p id ="logout"><a href="logout.php">Goodbye!</a></p>
			</div>
		</header>	
		
		<aside id="playerStatus">
			<div id="score">
				<p><a href="quiz_front.php">Quizzes</a></p>
				<br />
				<p><a href="student_base.php">Student Base</a></p>
			</div>	
		</aside>
			
	<main>
		<article id = "quizSpace">
				<p>You are already logged in as a student!</p>
				<br />
				<p>Go to the <a href="quiz_front.php">Quiz Page</a> to continue learning.</p>
																
		</article>
	</main>

<?php include("../includes/layouts/footer.php"); ?>
