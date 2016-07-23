<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>	
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php /*
	$query = "SELECT * FROM Geography";
	$result = mysqli_query($connection, $query);
	if (!$result) {
		die("Database query failed.");
	}*/
/*Do we need this above*/?>
<?php

$_SESSION["message"] = "Add question information below . . .";
if (isset($_POST['submit'])) {
  // Process the form
  
  if ($_POST["quiz_name"] == "World Geography") {
	  $quiz_id = 5;
  } else {
	  $quiz_id = 6;
  }
  
  if ($_POST["question_bank"] == "World Geography") {
	  $question_bank = "world_geography";
  } else {
	  $question_bank = "geography";
}
  
  /*this is copied from new_teacher, make it relevant to new_question*/
  $question_title = mysql_prep($_POST["question_title"]);
  $quiz_name = $_POST["quiz_name"];
  $question = mysql_prep($_POST["Question"]);
  $no_sort = $_POST["no_sort"];
  $image_exist = $_POST["image_exist"];
  $answer_correct = mysql_prep($_POST["AnswerCorrect"]);	
  $distractor_one = mysql_prep($_POST["Distractor1"]);
  $distractor_two = mysql_prep($_POST["Distractor2"]);
  $distractor_three = mysql_prep($_POST["Distractor3"]);
  $distractor_four = mysql_prep($_POST["Distractor4"]);  
  				  
   	/*$query  = "INSERT INTO $question_bank (";
    $query .= " QuestionTitle ";
    $query .= ") VALUES (";
    $query .= " '{$question_title}'";
    $query .= ")";*/


	$query  = "INSERT INTO $question_bank (";
    $query .= " quiz_id, QuestionTitle, quiz_name, Question, no_sort, AnswerCorrect, Distractor1, Distractor2, Distractor3, Distractor4";
    $query .= ") VALUES (";
    $query .= " {$quiz_id}, '{$question_title}', '{$quiz_name}', '{$question}', '{$no_sort}', '{$answer_correct}', '{$distractor_one}', '{$distractor_two}', '{$distractor_three}', '{$distractor_four}' ";
    $query .= ")";


    $result = mysqli_query($connection, $query);

    if ($result) {
      // Success
      $_SESSION["message"] = "Question successfully added!";
	  
	$findID_query = "SELECT * FROM $question_bank WHERE quiz_id=$quiz_id AND QuestionTitle='{$question_title}'";
	
  	$result_ID = mysqli_query($connection, $findID_query);
  			if (!$result_ID) {
  					die("Database query failed at Find ID" . mysql_errno($result_ID));
  				} 
				
  $id_lookup = mysqli_fetch_assoc($result_ID);
  $question_id = $id_lookup["QuestionID"];

  echo $question_id;

  $_SESSION["QuestionID"] = $question_id;
  $_SESSION["quiz_name"] = $quiz_name;
 
  	if ($image_exist == 1) {
  	  redirect_to("insert_image.php");
    } else {
    	  $_SESSION["message"] = "Question successfully added! Add another?";
	  		}
} else {
      // Failure
	  die("Sorry, Atomic Teacher is a bit confused. Please try again later." . mysqli_error($connection));
      $_SESSION["message"] = "Sorry, Atomic Teacher is a bit confused. Please try again later.";
    }
}
	?>
	
	<?php include("../includes/layouts/teacher_header.php"); ?>

	<body>


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
					<p><a href="teacher_base.php">Back to Teacher Base</a></p>
				</div>
		
			</aside>


		<main>
			<article id="quizSpace">
					<h2>New Question</h2>
					<br />
					<p><?php echo $_SESSION["message"]; ?></p>
					<br />
					<form action="new_question.php" method="post">
						<fieldset>
						<div>
						<p>Where do you want to add this question?<p>
							<p>
							<select name="question_bank">
								<option value = "World Geography">World Geography</option>
								<option value = 6>Some crazy ass quiz Croft is making</option>
								<option value = 7>New Quiz</option>
							</select>
						</p>
					</div>
					<br />
						<p>Question Title:
							<input type="text" name="question_title" value="" />
						</p>
						<br />
						<div>
						<p>Quiz Name:</p>
						<p>
							<select name=quiz_name>
								<option value="World Geography">World Geography</option>
								<option value="constitution">The Constitution</option>
								<option value="miscellaneous">none</option>
							</select>
						</p>
						</div>
						<br />
						<p>Question:</p>
							<textarea name="Question" rows=6 cols=60></textarea>
							<br />
							<br />
							<input type="hidden" name="image_exist" value=0 />
							<input type="checkbox" name="image_exist" value=1 /> This question includes an image.
						<br />
							<input type="hidden" name="no_sort" value=0 />
							<input type="checkbox" name="no_sort" value=1 /> Do not scramble the order of the answers.
						<br />
						<br />
						<p>Correct Answer:</p>
							<textarea name="AnswerCorrect" rows=3 cols=40></textarea>
						<br />
						<br />
						<p>Distractor 1:</p>
							<textarea name="Distractor1" rows=3 cols=40></textarea>
						<br />
						<p>Distractor 2:</p>
							<textarea name="Distractor2" rows=3 cols=40></textarea>
						<br />
						<p>Distractor 3:</p>
							<textarea name="Distractor3" rows=3 cols=40></textarea>
						<br />
						<p>Distractor 4:  (Tab out of this field before you hit "Submit")</p>
							<textarea name="Distractor4" rows=3 cols=40></textarea>
						<br />
						<br />
						<input type="submit" name="submit" value="Submit" />
					</fieldset>
					</form>		
				</article>
			</main>
					

	<?php include("../includes/layouts/footer.php"); ?>

 

