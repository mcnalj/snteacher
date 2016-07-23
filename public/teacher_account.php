<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>	
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>



	
<?php include("../includes/layouts/teacher_header.php"); ?>

<?php

if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
 $required_fields = array("username");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("username" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    // Perform Create

    $username = mysql_prep($_POST["username"]);
	$teacher_name = mysql_prep($_POST["teacher_name"]);
	$teacher_email = mysql_prep($_POST["teacher_email"]);
	$school_name = mysql_prep($_POST["school_name"]);
	    
    $query_update  = "UPDATE admins SET ";
    $query_update .= "username = '{$username}', ";
	$query_update .= "teacher_name = '{$teacher_name}', ";
	$query_update .= "teacher_email = '{$teacher_email}', ";
	$query_update .= "school_name = '{$school_name}' ";
	$query_update .= "WHERE admin_id = {$_SESSION['admin_id']} ";
    $result_update = mysqli_query($connection, $query_update);
}
    if ($result_update && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "Teacher account updated.";
	  $_SESSION["teacher_last_name"] = $_POST["teacher_name"];
	  /*do I need mysql_prep or anything on $_POSt["chosen_name"]? */
	   redirect_to("teacher_base.php");
    } else if ($result_update && mysqli_affected_rows($connection) != 1) {
      // Success
      $_SESSION["message"] = "You did not make any changes to your account.";
	  $_SESSION["teacher_last_name"] = $_POST["teacher_name"];
	  /*do I need mysql_prep or anything on $_POSt["chosen_name"]? */
	   redirect_to("teacher_base.php");
   } else {
      // Failure
	  die("This function is temporarily unavailable. Click the back arrow on your browser re-connect with Atomic Teacher. Your account was not updated." . mysqli_error($connection));
      $_SESSION["message"] = "Teacher account update failed.";
    }
  }
?>

<?php



$query = "SELECT username, teacher_name, teacher_email, school_name FROM admins WHERE admin_id = {$_SESSION['admin_id']} ";
$teacher_set = mysqli_query($connection, $query);
if(!$teacher_set) {
	die("Database query failed.");
}
$teacher = mysqli_fetch_assoc($teacher_set); 
	
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

		<aside id=playerStatus>
			<div id="score">
				<p><a href="teacher_base.php">Back to Teacher Base</a></p>
				<br />
				<p><a href="student_progress.php">Check My Students' Progress</a></p>
			</div>
		</aside>
		
		<main>
			
		<article id="quizSpace">
			<h2>Edit Teacher Account Information</h2>
			<br />
			<form action="teacher_account.php" method="post">
				<fieldset>
				<p>Username:
					<input type="text" name="username" value="<?php echo $teacher["username"]; ?>" />
				</p>
				<br />
				<p>Teacher Last Name:
					<input type="text" name="teacher_name" value="<?php echo $teacher["teacher_name"]; ?>" />
				</p>
				<br />
				<p>School e-mail:
					<input type="text" name="teacher_email" value="<?php echo $teacher["teacher_email"]; ?>" />
				</p>
				<br />
				<p>School Name:
					<input type="text" name="school_name" value="<?php echo $teacher["school_name"]; ?>" />
				</p>
				<br />
					<input type="submit" name="submit" value="Update Information" />
				</fieldset>	
			</form>
		</article>
		</main>
												
		
		
<?php include("../includes/layouts/footer.php"); ?>
