<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
confirm_logged_in();

include("../includes/layouts/header.php");
if (!isset($_SESSION['version'])) {
	redirect_to ("../index.php");
}

if (isset($_SESSION['score'])) {
	$_SESSION['score'] = $_SESSION['score'];
	} else {
		$_SESSION['score'] = 0;
	}
	/*is it recording the score correctly or is it missing the last question?*/
	
	$recent_score = $_SESSION['score'];	

	$results_message = "You answered " . $recent_score . " questions correctly."; 
	
	


	unset($_SESSION['quiz_count']); 
	unset($_SESSION['already_answered']);
	unset($_SESSION['score']);
?>
	<body>
		
		<header>
			<div id = "banner">
				<img src="images/globeglass.png" alt="globe icon">
				<p id ="nameLogo">Atomic Teacher</p>		
			</div>

			<div id = "nav">
				<p id ="back"><a href="../index.php">Atomic Teacher Home</a></p>
				<p id ="back"><a href="/teacher_base.php">Teacher Base</a></p>				
				<p id ="logout"><a href="logout.php">Goodbye!</a></p>
			</div>
		</header>	

		<aside id="playerStatus">
			
			<div id="score">
				<h2>PROGRESS</h2>
				<p id ="name"><?php echo $results_message; ?></p>
					<br />
			</div>
		</aside>
		
		<main>

		<article id="quizSpace">
			<h2>Congratulations! You finished the quiz.</h2>
				<br />
				<p>Login or register as a student to keep track of your progress and record your high scores.</p>
				<br />
				<br />
			<p>Try the same quiz again or choose another quiz.</p>
			<br />
	
	   
	    <form action="quiz_action.php" method="post">
			<fieldset>
	      <!--  <button type="submit" name="quiz" value= 2 >Hawaii</button>
			<button type="submit" name="quiz" value= 3 >Portland</button> 
			<button type="submit" name="quiz" value= 4 >Summer 2015</button> 
			<button type="submit" name="quiz" value= 0 >Geography</button>  -->
			<button type="submit" name="quiz" value= 5 >World Geography</button>  
			</fieldset>
	      </form>
		  	<br />
			<br />
		 <p><a href>Sign up</a> for a student account. Or if you are already signed up <a href="student_login.php">login</a> as a student.</p>

		</article>
		</main>
<?php include("../includes/layouts/footer.php"); ?>
		
