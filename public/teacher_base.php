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
			<p><a href="quiz_front.php">Try Quizzes</a></p>
			<br />	
			<p><a href="new_question.php">Create/Edit Questions</a></p>
			<br />
			<p><a href="student_progress.php">Check My Students' Progress</a></p>
			<br />
			<p><a href="teacher_account.php">Update Account Information</a></p>

			</div>
		</aside>


		<main>
				
		<article id="quizSpace">
				<h2>Teacher Base Page</h2>
				<br />
				<p>You are logged in as a teacher.</p>
				<br />
				<p>This is the teacher's home base for managing the database. From here you can try quizzes, create and edit question banks, check on the progress of your students and update your account information.</p>
		</article>
		
		</main>

<?php include("../includes/layouts/footer.php"); ?>
