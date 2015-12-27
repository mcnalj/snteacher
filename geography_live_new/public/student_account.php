<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>	
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in_student(); ?>
<?php include("../includes/layouts/header.php"); ?>

<?php

if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
 $required_fields = array("username");
  validate_presences($required_fields);
    
  if (empty($errors)) {
    // Perform Create
	$chosen_name = mysql_prep($_POST["chosen_name"]);
    $username = mysql_prep($_POST["username"]);
	$teacher_name = mysql_prep($_POST["teacher_name"]);
	$first_name = mysql_prep($_POST["first_name"]);
	$last_name = mysql_prep($_POST["last_name"]);
	$school_name = mysql_prep($_POST["school_name"]);
	$school_id = mysql_prep($_POST["school_id"]);
	$teacher_email = mysql_prep($_POST["teacher_email"]);
	    
    $query_update  = "UPDATE students SET ";
    $query_update .= "chosen_name = '{$chosen_name}', ";
	$query_update .= "username = '{$username}', ";
	$query_update .= "teacher_name = '{$teacher_name}', ";
	$query_update .= "first_name = '{$first_name}', ";
	$query_update .= "last_name = '{$last_name}', ";
	$query_update .= "school_name = '{$school_name}', ";
	$query_update .= "school_id = '{$school_id}', ";
	$query_update .= "teacher_email = '{$teacher_email}' ";
	$query_update .= "WHERE site_id = {$_SESSION['student_id']} ";
    $result_update = mysqli_query($connection, $query_update);
}
    if ($result_update && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "Student account updated.";
	  /*$_SESSION["student_username"] = mysql_prep($_POST["username"]);*/
	  /*do I need mysql_prep or anything on $_POSt["chosen_name"]? */
	  
      redirect_to("student_base.php");
    } else if ($result_update && mysqli_affected_rows($connection) != 1) {
      // Success
      $_SESSION["message"] = "Student account updated.";
	  /*$_SESSION["student_username"] = mysql_prep($_POST["username"]);*/
	  /*do I need mysql_prep or anything on $_POSt["chosen_name"]? */
	  
      redirect_to("student_base.php");
  } else {
      // Failure

	  die("This function is temporarily unavailable. Your account was not updated. Please try again later." . mysqli_error($connection));
      $_SESSION["message"] = "Student account update failed.";
    }
  }
?>

<?php



$query = "SELECT chosen_name, username, teacher_name, first_name, last_name, school_name, school_id, teacher_email FROM students WHERE site_id = {$_SESSION['student_id']} ";
$student_set = mysqli_query($connection, $query);
if(!$student_set) {
	die("Database query failed at the bottom.");
}
$student = mysqli_fetch_assoc($student_set); 
	
?>

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

		<aside id="playerStatus">
		
			<div id="score">
				<p><a href="quiz_front.php">Quizzes</a></p>
				<br />
				<p><a href="student_base.php">Back to Student Base</a></p>
				<br />
				<p><a href="student_progress_student.php">High Scores and Badges</a></p>
			</div>
		</aside>


		<main>
			<article id ="quizSpace">
			<h2>Edit Student Account Information</h2>
			<br />
			<form action="student_account.php" method="post">
				<fieldset>
		<p>Name:
			<input type="text" name="chosen_name" value="<?php echo $student["chosen_name"]; ?>" />
		</p>
		<br />
		<p>Username (no longer than 8 characters):
			<input type="text" name="username" value="<?php echo $student["username"]; ?>" />
		</p>
		<br />
		<br />
		<p>The bottom of this form is essential if you want your teacher to see your progress.</p>
		<p>What is your Teacher's last name?
			<input type="text" name="teacher_name" value="<?php echo $student["teacher_name"]; ?>" />
		</p>
		<br />
		<p>What is your First Name?
			<input type="text" name="first_name" value="<?php echo $student["first_name"]; ?>" />
		</p>
		<br />
		<p>What is your Last Name?
			<input type="text" name="last_name" value="<?php echo $student["last_name"]; ?>" />
		</p>
		<br />
		<p>What is the name of your school?
			<input type="text" name="school_name" value="<?php echo $student["school_name"]; ?>" />
		</p>
		<br />
		<p>What is your student ID Number? 
			<input type="text" name="school_id" value="<?php echo $student["school_id"]; ?>" />
		</p>
		<br />
		<p>What is your teacher's e-mail address?
			<input type="text" name="teacher_email" value="<?php echo $student["teacher_email"]; ?>" />
		</p>
		<br />
			<input type="submit" name="submit" value="Update Information" />
		</fieldset>
		</form>
	</article>
</main>
		

<?php include("../includes/layouts/footer.php"); ?>
