<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php include("../includes/layouts/header.php"); ?>

<body>
		
	<header>
		<div id = "banner">
			<img src="images/globeglass.png" alt="globe icon">
			<p id ="nameLogo">Atomic Teacher</p>		
		</div>

		<div id = "nav">
			<p id ="back"><a href="../index.php">Atomic Teacher Home</a></p>
		</div>
	</header>

	
	<aside id="playerStatus"></aside>
	
	<main>
		<article id="quizSpace">
			<h1>Thank you for learning with Atomic Teacher!</h1>
			<br />
			<p>Atomic Teacher is here for you whenever you want to get back to learning.</p>
			<br />
			<br />
			<br />
			<p>Oops! I wasn't finished. Please take me back to <a href="login_student.php">Login as a Student</a>.</p>
			<br />
			<p>Forgot my keys. Please take me back to <a href="loginfromscratch.php">Login as a Teacher</a>.</p>				
		<br />
			
		</article>
	</main>
			
<?php include("../includes/layouts/footer.php"); ?>
		
