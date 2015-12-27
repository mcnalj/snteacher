<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/layouts/index_header.php"); ?>

<?php 
	unset($_SESSION['quiz_count']); 
	unset($_SESSION['already_answered']);
	unset($_SESSION['score']);
?>
<body>
		
	<header>
		<div id = "banner">
			<img src="public/images/great_wall2.jpg" alt="Great Wall" style = "width:392;height:300;">
			<img src="public/images/blue_mosque.jpg" alt="Blue Mosque" style = "width:400;height:300;">
			<img src="public/images/scarlet_macaw.jpg" alt="Scarlet Macaw" style = "width:221;height:300;">
			<img src="public/images/pyramid.jpg" alt="Scarlet Macaw" style = "width:372;height:300;">
		</div>
		
		<div id = "nav"></div>
	</header>
	
		<aside id ="playerStatus"></aside>
			

	<main>
		<article id ="quizSpace">
			<div class = "column">
				<h1>Atomic Teacher</h1>
				<br />
				<br />
				<br />
				<br />
				<h2>Know your world. Expand your horizons.</h2>
				<br />
				<br />
				<br />
				<br />
				<h3><a href="public/login_student.php">Login</a> and learn. <a href="public/new_student.php">Create</a> a Student Account.</h3>
				<h3> Or try the <a href="public/quiz_action.php">World Geography Quiz</a>.</h3>	
			</div>
			<div class = "column">
			<p><img src="public/images/globeglass.png" alt="globe icon" style ="width:400;height:400;"></p> 
			</div>
			<br />
			<p><a href="public/loginfromscratch.php">Login</a> as a teacher or <a href="public/loginfromscratch.php">create a Teacher Acccount</a> to track your students' progress.</p>
			<br />
			<br />
			<br />
			<p><a href="public/logout.php">Goodbye!</a></p>
			<p><a href="public/student_base.php">Student Base</a></p>
			<p><a href="public/teacher_base.php">Teacher Base</a></p>
	    <!-- <form action="public/quiz_action.php" method="post">
			<fieldset>
				<button type="submit" name="quiz" value= 5 >Real Geography</button>  
			</fieldset>
		  </form> -->
		 </article>
	</main>
		
<?php include("includes/layouts/footer.php"); ?>
		
