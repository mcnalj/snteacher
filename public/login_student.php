<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
prevent_double_student_login();

$student_username = "";




if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("student_username", "student_password");
  validate_presences($required_fields);
  
$student_username = mysql_prep($_POST["student_username"]);
$student_password = mysql_prep($_POST["student_password"]);
 
  if (empty($errors)) {
    // Attempt login
	

	$found_student = attempt_student_login($student_username, $student_password);
	
	if ($found_student) {
		// Success. Mark user as logged in
		$_SESSION["student_id"] = $found_student["site_id"];
		$_SESSION["student_username"] = $found_student["username"];
		$_SESSION["context"] = "student";
		redirect_to ("student_base.php");	
	} else {
		// Failure
		 $_SESSION["message"] = "Username/password not found.";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>


<?php include("../includes/layouts/header.php"); ?>
<!--<head>
	<title>Summer Geography</title>
		<link href="stylesheets/stylesheet.css" media="all" rel="stylesheet" type="text/css" />
</head> -->

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
	
		<aside id ="playerStatus"></aside>
	
	<main>
		
		<article id="quizSpace">
			<h2>Student Login</h2>
			<?php echo message(); ?>	
			<?php echo form_errors($errors); ?>
			<br />
			
			<p>Login as a Student</p>
			<br />
			<form action="login_student.php" method="post">
				<fieldset>
				<p>Username:
					<input type="text" name="student_username" value="<?php echo htmlentities($student_username); ?>" />
				</p>
				<br />
				<p>Password:
					<input type="password" name="student_password" value="" />
				</p>
				<br />
					<input type="submit" name="submit" value="Submit" />
				</fieldset>
			</form>
			<br />
			<br />
			
			<p>Haven't signed up yet? <a href="new_student.php">Sign-up here!</a></p>
			<br />
			<p>If you are a teacher, <a href="loginfromscratch.php">login </a> or create a <a href="loginfromscratch.php">new account</a>.</p>
		</article>
		
			
	</main>
					
<?php include("../includes/layouts/footer.php"); ?>
