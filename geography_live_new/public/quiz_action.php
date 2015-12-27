<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
confirm_logged_in_oneorother();

/* This could come from quiz_front or ???? */

if ($_SESSION["context"] == "teacher") {
	$base_link = "teacher_base.php";
	$base_message = "Teacher Base";
} 
if ($_SESSION["context"] == "student") {
	$base_link = "student_base.php";
	$base_message = "Student Base";
} 


if (isset($_POST['quiz'])) {
	$version = $_POST['quiz'];
	$_SESSION['version'] = $version;
} else {
	if(isset($_SESSION['version'])) {
		$version = $_SESSION['version'];
	} else {
		// /*This should say $version = 0;*/
		$_SESSION['version'] = 5;
		$version = 5;
	}
}

/* determines which database to select from */

if ($version >=0 && $version <=4) {
	$database_title = "Geography";
	$image_source = "Geography";
	} else if ($version == 5){
		$database_title = "world_geography";
		$image_source = "images";
	} else if ($version == 6){
		$database_title = "cortes_trial";
		$image_source = "images";
	} else if ($version == 7){
		$database_title = "cortes";
		$image_source = "images";
	} else if ($version == 10){
		$database_title = "africa_geography";
		$image_source = "images";
	} else if ($version == 20){
		$database_title = "africa_countries";
		$image_source = "africa_images";
	} else if ($version == 30){
		$database_title = "constitution";
		$image_source = "constitution_images";
	} else if ($version == 40){
		$database_title = "essential_presidents";
		$image_source = "presidents_images";
	}
	

/* counts the number of questions in the quiz */
	
$query = "SELECT * FROM $database_title WHERE quiz_id=$version";
$result = mysqli_query($connection, $query);
	if (!$result) {
		die("Atomic Teacher is overwhelmed. The question bank is not responding. Please refresh your browser or click back and try again.");
	}
	$num_questions = mysqli_num_rows($result);


/* selects a random question */		
		
		$seek = rand(0, $num_questions);
		mysqli_data_seek($result, $seek);
		$question = mysqli_fetch_assoc($result);
		$qID = $question["QuestionID"];
		$imgID = $question["image_id"];
			 
		if (isset($_SESSION['already_answered'])) {
				$answeredquestions = $_SESSION['already_answered'];
		} else {
			$answeredquestions = array();
		}
			
		$_SESSION["already_answered"] = $answeredquestions;
			
/*Loop checks to make sure it is not repeating questions.*/
/*count is tricky. Trying not to count it if it hits the some question twice.*/
	$count = 0;
	while ((in_array($qID, $_SESSION['already_answered'])) && $count <= $num_questions) {
			$seek = rand(0, $num_questions);
			mysqli_data_seek($result, $seek);
			$question = mysqli_fetch_assoc($result);
			$qID = $question["QuestionID"];
			$imgID = $question["image_id"];
			if ($qID = $question["QuestionID"]) {
				$count = $count;
			} else {
				$count++;	
			}
		}
			
/*This adds the quesion to the array of questions that have already been asked.	*/
	array_push($_SESSION['already_answered'], $qID);
				
			
/*This marks the correct answers and shuffles the answer set. */
	if (isset($_SESSION['correct'])) {
	$previous_correct = $_SESSION['correct'];
	$length = strlen($previous_correct);
	if ($length > 50) {
		$previous_message = "incorrect";
	} else {
		$previous_message = $previous_correct;
	}
}

	$correct = $question["AnswerCorrect"];
	$_SESSION['correct'] = $correct;
		
	$answer_set = array($question["AnswerCorrect"], $question["Distractor1"], $question["Distractor2"], 	$question["Distractor3"], $question["Distractor4"]);
		
		shuffle ($answer_set);
			
			$checka = ($answer_set[0]);
			if ($checka === $correct) {
				$valuea = 1;
			} else {
				$valuea = 0;
			}
			
			$checkb = ($answer_set[1]);
			if ($checkb === $correct) {
				$valueb = 1;
			} else {
				$valueb = 0;
			}
			
			$checkc = ($answer_set[2]);
			if ($checkc === $correct) {
				$valuec = 1;
			} else {
				$valuec = 0;
			}
			
			$checkd = ($answer_set[3]);
			if ($checkd === $correct) {
				$valued = 1;
			} else {
				$valued = 0;
			}
			
			$checke = ($answer_set[4]);
			if ($checke === $correct) {
				$valuee = 1;
			} else {
				$valuee = 0;
			}
			
/*This is where the form is processed.
This first bit is about how to handle all possible answers. */
			if (!isset($_POST['answer'])) {
					$selection = "4";
				}
			else if (!isset($_POST["submit"])) {
				$selection = "3";
			} else {
				$selection = $_POST["answer"];	
			}
			
			if ($selection === "1") {
				$answer_message = "Correct!";
				$answer_class = "conversation_correct";
			} else if ($selection === "3") {
				$answer_message = "Here we go! Click an answer.";
				$answer_class = "conversation_unanswered";
			} else if ($selection === "4") {
			 	 $answer_message = "Select an answer . . . ";
				 $answer_class = "conversation_unanswered";
			} else {
				$answer_message = "Sorry, it was " . $previous_message;
				$answer_class = "conversation_incorrect";
			} 

/*this increments the score using a $_SESSION variable (from "unable to increment static value in PHP on Stack overflow") It used to come just before the images stuff.*/
			$score = isset($_SESSION['score']) ? $_SESSION['score'] : 0;
				if ($selection === "1")
					$score +=1;
				$_SESSION['score'] = $score;
				
/*This stops the quiz once they've answered all the questions */
			
	$quiz_count = isset($_SESSION['quiz_count']) ? $_SESSION['quiz_count'] : 0;
	$quiz_count++;
	$_SESSION['quiz_count'] = $quiz_count;
	
	$questions_answered = $quiz_count - 1;
			
			
	if (($quiz_count > $num_questions) && ($_SESSION["context"] == "student")) {
			redirect_to("results_page.php");
	} else if (($quiz_count > $num_questions) && ($_SESSION["context"] == "teacher")) {
			redirect_to("results_nonstudent.php");
	}
				
	
			?>
			
		<?php
			
/*This pulls the image filepath from the database. */ 
			$img = "images" . "/" . $question["image_id"];
			$query_img = "SELECT * FROM $image_source WHERE image_id=$imgID";
			$result_img = mysqli_query($connection, $query_img);
			if (!$result_img) {
				die("Atomic Teacher can not keep up with the request for images. Please refresh your browser or click back and try again.");
			}
			$img = mysqli_fetch_assoc($result_img);
			$image = $img["image_file"];

/*This is about the attribution of the image. .*/
						
			if(empty($img["title"])) {
				$title_img = "Image";
			} else {
				$title_img = $img["title"];
			}
			
			$author_img = $img["author"];
			
			
			if(empty($img["author_link"])) {
				$author_link_img = "";
			} else {
				$author_link_img = $img["author_link"];
			}

			if(empty($img["source_link"])) {
				$title_link_img = "";
			} else {
				$title_link_img = $img["source_link"];
			}

			if(empty($img["license_link"])) {
				$license_link_img = "";
			} else {
				$license_link_img = $img["license_link"];
			}
	

			$license_img = $img["license"];
			$html_code = $img["html_code"];
			
			if ($version == 20) {
				$image_open = "images" . "/" . "Africa" . "/" . $image;
			} else  if ($version == 30) {
				$image_open = "images" . "/" . "Constitution" . "/" . $image;
			} else  if ($version == 40) {
				$image_open = "images" . "/" . "Presidents" . "/" . $image;
			} else {
				$image_open = "images" . "/" . $image;
			}
			
			
		//	$image_open = "images" . "/" . "Africa" . "/" . $image;
			//to get back to normal, delete Africa
			
/* This is where it calculates and adjusts the size of the image. images can be up to 700 wide and 350 tall. Inspect and record in database. */
			
			$width = $img["width"];
			$height = $img["height"];
			
			if ($width == 0 || $height == 0) {
				$adjusted_width = 350;
				$adjusted_height = 350; 
				 }
			else if ($width/$height >= 1.9) {
				$width_adjust_factor = 600 / $width;
				$adjusted_width = $width * $width_adjust_factor;
				$adjusted_height = $height * $width_adjust_factor; 
			
				//this is new for the Africa countries (used to be 700)
			} else if ($height == 951) {
				$height_adjust_factor = 600 / $height;
				$adjusted_height = $height * $height_adjust_factor;
				$adjusted_width = $width * $height_adjust_factor;				
				//this is the end of the new Africa countries code
			
			
			} else {
				$height_adjust_factor = 350 / $height;
				$adjusted_height = $height * $height_adjust_factor;
				$adjusted_width = $width * $height_adjust_factor;
			}
			
		
			?>	
<?php 
	if ($version == 20) {
		include("../includes/layouts/action_header_big.php");
	} else {
		include("../includes/layouts/action_header.php"); 
	}
?>

	<body>
		
		<header>
			<div id = "banner">
				<p id ="currentQuiz">World Geography Quiz.</p>
				<img src="images/globeglass.png" alt="globe icon">
				<p id ="nameLogo">Atomic Teacher</p>		
			</div>

			<div id = "nav">
				<p id ="back"><a href="../index.php">Back to the Front Page</a></p>
				<p id ="link"><a href="<?php echo $base_link; ?>"><?php echo $base_message; ?></a></p>
				<p id ="logout"><a href="logout.php">Goodbye!</a></p>
			</div>
		</header>	
		
<!--This is the green column on the left for score and badges.-->	
					
	<aside id="playerStatus">
			
		<div id="score">
			<h2>PROGRESS</h2>
			<p><span class = "color"><?php echo $score; ?></span> correct</p>
			<p><span class = "color"><?php echo $questions_answered; ?></span> answered out of <?php echo $num_questions; ?></p>
			<!--<p id="name"><span class="quiz">Quiz Name</span> Personal Best:</p>
			<p id = "personalBest"><span class = "color">10 PHP</span> correct</p> -->
		<!--	<p id = "badgeReq">score 14 out of <?php echo $num_questions; ?> to earn a badge</p> -->
		</div>
			
	<?php

/* This loads up information about a students badges and high scores. */
	
	$query_badge_after_record = "SELECT hawaii_badge, portland_badge, summer2015_badge, geography_badge, cortes_trial_badge, cortes_badge, world_geography_badge, africa_geography_badge, africa_countries_badge, constitution_badge, presidents_badge FROM students WHERE username = '{$_SESSION['student_username']}' ";
	

	$result_badges_after_record = mysqli_query($connection, $query_badge_after_record);
		if (!$result_badges_after_record) {
			die("Database query failed.");
		}

	$badges_earned_now = mysqli_fetch_assoc($result_badges_after_record);


	$hawaii_badge = $badges_earned_now['hawaii_badge'];
	if($hawaii_badge) {
		$hawaii_message = "YES";
	} else {
		$hawaii_message = "NO";
	}


	$portland_badge = $badges_earned_now['portland_badge'];
	if($portland_badge) {
		$portland_message = "YES";
	} else {
		$portland_message = "NO";
	}

	$summer2015_badge = $badges_earned_now['summer2015_badge'];
	if($summer2015_badge) {
		$summer2015_message = "YES";
	} else {
		$summer2015_message = "NO";
	}

	$geography_badge = $badges_earned_now['geography_badge'];
	if($geography_badge) {
		$geography_message = "YES";
	} else {
		$geography_message = "NO";
	}
	
	$cortes_trial_badge = $badges_earned_now['cortes_trial_badge'];
	if($cortes_trial_badge) {
		$cortes_trial_message = "YES";
	} else {
		$cortes_trial_message = "NO";
	}

	$cortes_badge = $badges_earned_now['cortes_badge'];
	if($cortes_badge) {
		$cortes_message = "YES";
	} else {
		$cortes_message = "NO";
	}
	
	$world_geography_badge = $badges_earned_now['world_geography_badge'];
	if($world_geography_badge) {
		$world_geography_message = "YES";
	} else {
		$world_geography_message = "NO";
	}

	$africa_geography_badge = $badges_earned_now['africa_geography_badge'];
	if($africa_geography_badge) {
		$africa_geography_message = "YES";
	} else {
		$africa_geography_message = "NO";
	}
	
	$africa_countries_badge = $badges_earned_now['africa_countries_badge'];
	if($africa_countries_badge) {
		$africa_countries_message = "YES";
	} else {
		$africa_countries_message = "NO";
	}

	$constitution_badge = $badges_earned_now['constitution_badge'];
	if($constitution_badge) {
		$constitution_message = "YES";
	} else {
		$constitution_message = "NO";
	}

	$presidents_badge = $badges_earned_now['presidents_badge'];
	if($presidents_badge) {
		$presidents_message = "YES";
	} else {
		$presidents_message = "NO";
	}

		
	?>
		<div id="badges">
			<h2>BADGES EARNED</h2>
			<table>
			<tr><td>World Geography Badge:</td><td><?php echo $world_geography_message; ?></td></tr>
			<tr><td>Aztecs:</td><td><?php echo $cortes_trial_message; ?></td></tr>
			<tr><td>Spanish Arrival:</td><td><?php echo $cortes_message; ?></td></tr>
			<tr><td>Imperialism in Africa:</td><td><?php echo $africa_geography_message; ?></td></tr>
			<tr><td>African Countries:</td><td><?php echo $africa_countries_message; ?></td></tr>
			<tr><td>U.S. Government Essentials:</td><td><?php echo $constitution_message; ?></td></tr>
			<tr><td>Essential Presidents:</td><td><?php echo $presidents_message; ?></td></tr>

			</table>
		</div>
	</aside>


	<main>
		
	<article id ="quizSpace">

		<section id ="picture">


<!-- this chooses whether to get the image from the html code or the image file in the images folder and displays the image. -->
			<?php
			/* if(!empty($img["html_code"])) { 
				echo $html_code; }
				else { */
				?>

				<img src="<?php echo($image_open); ?>" alt="<?php echo "{$img['alt']}"; ?>" style="width:<?php echo($adjusted_width); ?>;height:<?php echo($adjusted_height); ?>;">
		<!--	don't forget the closing bracket here if I reanimate the html-->

<!-- This decides how to display the image attribution depending on what links are available in the database -->

			
<?php if(!empty($img["source_link"]) && !empty($img["author_link"]) && !empty($img["license_link"])) { ?>			
				<p class="caption"><a href ="<?php echo $title_link_img; ?>" target="_blank"><?php echo $title_img; ?></a> by <a href ="<?php echo $author_link_img; ?>" target="_blank"><?php echo $author_img; ?></a> is licensed under <a href ="<?php echo $license_link_img; ?>" target="_blank"><?php echo $license_img; ?></a>.</p> <?php } 
		else if (empty($img["source_link"]) && !empty($img["author_link"]) && !empty($img["license_link"])) { ?>
				<p class="caption"><?php echo $title_img; ?> by <a href ="<?php echo $author_link_img; ?>" target="_blank"><?php echo $author_img; ?></a> is licensed under <a href ="<?php echo $license_link_img; ?>" target="_blank"><?php echo $license_img; ?></a>.</p>
		<?php }
		else if (!empty($img["source_link"]) && empty($img["author_link"]) && !empty($img["license_link"])) { ?>
			<p class="caption"><a href ="<?php echo $title_link_img; ?>" target="_blank"><?php echo $title_img; ?></a> by <?php echo $author_img; ?> is licensed under <a href ="<?php echo $license_link_img; ?>" target="_blank"><?php echo $license_img; ?></a>.</p>
		<?php }
		else if (!empty($img["source_link"]) && !empty($img["author_link"]) && empty($img["license_link"])) { ?>
			<p class="caption"><a href ="<?php echo $title_link_img; ?>" target="_blank"><?php echo $title_img; ?></a> by <a href ="<?php echo $author_link_img; ?>" target="_blank"><?php echo $author_img; ?></a> is licensed under <?php echo $license_img; ?>.</p>
			<?php }

			else if (empty($img["source_link"]) && empty($img["author_link"]) && !empty($img["license_link"])) { ?>
					<p class="caption"><?php echo $title_img; ?> by <?php echo $author_img; ?> is licensed under <a href ="<?php echo $license_link_img; ?>" target="_blank"><?php echo $license_img; ?></a>.</p>
			<?php }
			else if (empty($img["source_link"]) && !empty($img["author_link"]) && empty($img["license_link"])) { ?>
				<p class="caption"><?php echo $title_img; ?> by <a href ="<?php echo $author_link_img; ?>" target="_blank"><?php echo $author_img; ?></a> is licensed under <?php echo $license_img; ?>.</p>
			<?php }
			else if (!empty($img["source_link"]) && empty($img["author_link"]) && empty($img["license_link"])) { ?>
				<p class="caption"><a href ="<?php echo $title_link_img; ?>" target="_blank"><?php echo $title_img; ?></a> by <?php echo $author_img; ?> is licensed under <?php echo $license_img; ?>.</p>
				<?php } 
			else if (empty($img["source_link"]) && empty($img["author_link"]) && empty($img["license_link"])) { ?>
					<p class="caption"><?php echo $title_img; ?> by <?php echo $author_img; ?> is licensed under <?php echo $license_img; ?>.</p>	
				<?php } ?>
		</section>

							
<!-- This prints the qustion and answer choices. -->
		<section id ="question">
						
			<p><?php printf($question["Question"]); ?></p>
		</section>

		<form action="quiz_action.php" method="post">
			<fieldset>
				<input type="radio" name="answer" value="<?php echo $valuea; ?>"><?php printf($checka); ?>
				<br />
				<br />
				<input type="radio" name="answer" value="<?php echo $valueb; ?>"><?php printf($checkb); ?>
				<br />
				<br />
				<input type="radio" name="answer" value="<?php echo $valuec; ?>"><?php printf($checkc); ?>
				<br />
				<br />
				<input type="radio" name="answer" value="<?php echo $valued; ?>"><?php printf($checkd); ?>
				<br />
				<br />
				<input type="radio" name="answer" value="<?php echo $valuee; ?>"><?php printf($checke); ?>
				<br />
				<br />

				<input type="submit" name="submit" value="Submit" id="submit" />
			</fieldset>
		</form>		
	</article>			
				
	<aside id = "<?php echo $answer_class; ?>">
				
<!--This is the conversation in response to the user's answer.-->					
		<p id="grade"><?php echo $answer_message; ?></p>
		<!--<p id="convo">That's right. Show 'em what you got.</p> -->
	</aside>
		<br />
</main>
						

<?php include("../includes/layouts/footer.php"); ?>		
