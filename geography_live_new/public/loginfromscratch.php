<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
prevent_double_teacher_login();
$username = "";


if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("username", "password");
  validate_presences($required_fields);
  
$username = mysql_prep($_POST["username"]);
$password = mysql_prep($_POST["password"]);
 
  if (empty($errors)) {
    // Attempt login
	

	$found_admin = attempt_login($username, $password);
	
	if ($found_admin) {
		// Success. Mark user as logged in
		$_SESSION["admin_id"] = $found_admin["admin_id"];
		$_SESSION["username"] = $found_admin["username"];
		$_SESSION["teacher_last_name"] = $found_admin["teacher_name"];
		$_SESSION["context"] = "teacher";
		redirect_to ("teacher_base.php");	
	} else {
		// Failure
		 $_SESSION["message"] = "Username/password not found.";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>

<!--<?php $layout_context = "admin"; ?> -->
<?php 

include("../includes/layouts/teacher_header.php"); ?>

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
			
			<h2>Teacher Login</h2>
			<br>
			<?php echo message(); ?>	
			<?php echo form_errors($errors); ?>
			<p>Login as a Teacher</p>
			<br />
			<form action="loginfromscratch.php" method="post">
				<fieldset>
				<p>Username:
					<input type="text" name="username" value="<?php echo htmlentities($username); ?>" />
				</p>
				<br />
				<p>Password:
					<input type="password" name="password" value="" />
				</p>
				<br />
					<input type="submit" name="submit" value="Submit" />
				</fieldset>
			</form>
			<br />
			<p> Haven't signed up yet? <a href="loginfromscratch.php">Create a teacher account </a>and track your students' progress.</p>
			<br />
			<p>Whoa! Umm . . . I think I'm in the wrong place. Where's the <a href="login_student.php">student page</a></p>
			
		</article>
	</main>	
				
					
<?php include("../includes/layouts/footer.php"); ?>
