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

$safe_username = mysql_prep($_POST["username"]); 
 
$query_username = "SELECT * FROM students WHERE username = '{$safe_username}' ";
$username_set = mysqli_query($connection, $query_username);
confirm_query($username_set);
if($existing_admin = mysqli_fetch_assoc($username_set)) {
	$errors[$safe_username] = "Sorry, username aready exists. Please pick a new username.";
	}
	
/* if (mysql_num_rows($query_username) !== 0) {
	$errors[$username] = "Sorry, username aready exists. Please pick a new username.";
} */
  
  
  if (empty($errors)) {
    // Perform Create
	
	$chosen_name = mysql_prep($_POST["chosen_name"]);

    $hashed_password = password_encrypt($_POST["password"]);
	$first_name = mysql_prep($POST["first_name"]);
	$last_name = mysql_prep($POST["last_name"]);
	$teacher_name = mysql_prep($_POST["teacher_name"]);
	$school_name = mysql_prep($_POST["school_name"]);
	$school_id = mysql_prep($_POST["school_id"]);
	$teacher_email = mysql_prep($_POST["teacher_email"]);
	
	    
    $query  = "INSERT INTO students (";
    $query .= "  chosen_name, username, hashed_password, first_name, last_name, teacher_name, school_name, School_id, teacher_email";
    $query .= ") VALUES (";
    $query .= "  '{$chosen_name}', '{$safe_username}', '{$hashed_password}', '{$first_name}', '{$last_name}', '{$teacher_name}', '{$school_name}', '{$school_id}', '{$teacher_email}' ";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
      // Success
      $_SESSION["message"] = "Student account created.";
	  $_SESSION["student_username"] = $_POST["username"];
	  
      redirect_to("login_student.php");
    } else {
      // Failure
      $_SESSION["message"] = "Student account creation failed.";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

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
	
	<aside id="playerStatus"></aside>

	<main>
		
	<article id="quizSpace">
			<p><?php echo message(); ?></p>
			<p><?php echo form_errors($errors); ?></p>
			
			<h2>Sign up as a New Student to record your scores and keep track of your progress.</h2>
			<br />
			<form action="new_student.php" method="post">
				<fieldset>
				<p>What name do you want Atomic Teacher to call you?
					<input type="text" name="chosen_name" value="" />
				</p>
				<br />
				<p>Username (no longer than 8 characters):
					<input type="text" name="username" value="" />
				</p>
				<br />
				<p>Password:
					<input type="password" name="password" value="" />
				</p>
				<br />
				<br />
				<p>Help Atomic Teacher communicate with your teacher to get credit for what you know! This bottom part is essential if you want your teacher to see your progress.</p>
				<br />
				<p>What's your Teacher's last name?
					<input type="text" name="teacher_name" value="" />
				</p>
				<br />
				<p>What's your First Name?
					<input type="text" name="first_name" value="" />
				</p>
				<br />				
				<p>What's your Last Name?
					<input type="text" name="last_name" value="" />
				</p>
				<br />				
				<p>What's the name of your school?
					<input type="text" name="school_name" value="" />
				</p>
				<br />				
				<p>What's your student ID Number? (This will help connect your progress to your teacher. Only enter it if your teacher asked you to.)
					<input type="text" name="school_id" value="" />
				</p>
				<br />				
				<p>Give Atomic Teacher your teacher's e-mail address and we'll tell your teacher to give you credit for your progress. (Of course, that doesn't mean your teacher will give you credit, but it never hurts to ask.)
					<input type="text" name="teacher_email" value="" />
				</p>
				<br />
					<input type="submit" name="submit" value="Create Student Account" />
				</fieldset>
			</form>
				<br />
				<p>I think I already have an account. Where do I <a href="login_student.php">login</a>?</p>
				<br />
		</article>
		</main>
		
					
<?php include("../includes/layouts/footer.php"); ?>
