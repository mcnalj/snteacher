<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php

if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("username", "password");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("username" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    // Perform Create

    $username = mysql_prep($_POST["username"]);
    $hashed_password = password_encrypt($_POST["password"]);
	$teacher_name = mysql_prep($_POST["teacher_name"]);
	$teacher_email = mysql_prep($_POST["teacher_email"]);
	$school_name = mysql_prep($_POST["school_name"]);
				
    
    $query  = "INSERT INTO admins (";
    $query .= "  username, teacher_name, teacher_email, school_name, hashed_password";
    $query .= ") VALUES (";
    $query .= "  '{$username}', '{$teacher_name}', '{$teacher_email}', '{$school_name}', '{$hashed_password}'";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
      // Success
      $_SESSION["message"] = "Account created! Welcome to Atomic Teacher. Please login to get started.";
      redirect_to("loginfromscratch.php");
    } else {
      // Failure
      $_SESSION["message"] = "Admin creation failed.";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>
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
	
		<aside id ="playerStatus"></aside>
			
		<main>
		<article id="quizSpace">
			
			<p><?php echo message(); ?></p>
			<p><?php echo form_errors($errors); ?></p>
			
			<h2>Create A Teacher Account</h2>
			<form action="new_teacher.php" method="post">
				<fieldset>
				<p>Username:
					<input type="text" name="username" value="" />
				</p>
				<br />
				<p>Password:
					<input type="password" name="password" value="" />
				</p>
				<br />
				<p>Last Name:*
					<input type="text" name="teacher_name" value="" />
				</p>
				<br />
					<p>*This is how you are connected to your students. Any student that enters the same teacher last name will be available for you to monitor.</p>
				</p>
				<br />
				<p>School e-mail:
					<input type="text" name="teacher_email" value="" />
				</p>
				<br />
				<p>School Name:
					<input type="text" name="school_name" value="" />
				</p>
				<br />
					<input type="submit" name="submit" value="Create New Teacher" />
				</fieldset>
			</form>
			<br />
			<p>Oops, I already have a teacher account. Let me <a href="loginfromscratch.php">login</a>.</p>
			<br />
			<p>I'm a student, where do I <a href="new_student.php">sign-up</a> or <a href="login_student.php"</a>login?</p>
		</article>
	</main>
		
			
<?php include("../includes/layouts/footer.php"); ?>
