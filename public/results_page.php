<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
confirm_logged_in_student();?>
<?php include("../includes/layouts/header.php"); ?>

<?php
if (!isset($_SESSION['version'])) {
	redirect_to ("../index.php");
}

if (isset($_SESSION['score'])) {
	$_SESSION['score'] = $_SESSION['score'];
	} else {
		$_SESSION['score'] = 0;
	}
	/*is it recording the score correctly or is it missing the last question?*/
	
		
if ($_SESSION['version'] == "2") {
	$quiz_name = "Hawaii";
	$version_name = "hawaii_score";
	$badge_version = "hawaii_badge";
} else if ($_SESSION['version'] == "3") {
	$quiz_name = "Portland";
	$version_name = "portland_score";
	$badge_version = "portland_badge";
} else if ($_SESSION['version'] == "4") {
	$quiz_name = "Summer 2015";
	$version_name = "summer2015_score";
	$badge_version = "summer2015_badge";
} else if ($_SESSION['version'] == "0") {
	$quiz_name = "Geography";
	$version_name = "geography_score";
	$badge_version = "geography_badge";
} else if ($_SESSION['version'] == "5") {
	$quiz_name = "World Geography";
	$version_name = "world_geography_score";
	$badge_version = "world_geography_badge";
} else if ($_SESSION['version'] == "6") {
	$quiz_name = "Aztecs";
	$version_name = "cortes_trial_score";
	$badge_version = "cortes_trial_badge";
} else if ($_SESSION['version'] == "7") {
	$quiz_name = "Spanish Arrival";
	$version_name = "cortes_score";
	$badge_version = "cortes_badge";
} else if ($_SESSION['version'] == "10") {
	$quiz_name = "Imperialism in Africa";
	$version_name = "africa_geography_score";
	$badge_version = "africa_geography_badge";
} else if ($_SESSION['version'] == "20") {
	$quiz_name = "African Countries";
	$version_name = "africa_countries_score";
	$badge_version = "africa_countries_badge";
} else if ($_SESSION['version'] == "30") {
	$quiz_name = "U.S. Government Essentials";
	$version_name = "constitution_score";
	$badge_version = "constitution_badge";
} else if ($_SESSION['version'] == "40") {
	$quiz_name = "Essential Presidents";
	$version_name = "presidents_score";
	$badge_version = "presidents_badge";


} else {
	echo "The quiz version was not set";
}
 
/*$query = "SELECT '{$version_name}' FROM students WHERE username = $_SESSION['username']";*/
/* This pulls the old high score from the database. */
$query = "SELECT $version_name FROM students WHERE username = '{$_SESSION['student_username']}' ";

$resultr = mysqli_query($connection, $query);
	if (!$resultr) {
		die("Database query failed.");
	}

$old_score = mysqli_fetch_assoc($resultr);
$store_score = $old_score[$version_name];


	$recent_score = $_SESSION['score'];
	
	if (isset($_SESSION['student_username'])) {
		$current_username = $_SESSION['student_username'];	
	}
	
	$results_message = "didn't work";
	$score_message = "not reading";
	/* This controlling if seems to go to the end of the php*/
	
	if (isset($current_username)) {
		
		function record_high_score($recent_score, $current_username) {
				global $connection;
				global $version_name;

				$query_record = "UPDATE students SET $version_name={$recent_score} WHERE username='{$current_username}'";
				$recorded_score = mysqli_query($connection, $query_record);
				confirm_query($recorded_score);
				if(!$recorded_score) {
				die("Database query failed.");
			}
		}

		/* compares your recent score to the stored score. If new score is higher, it records it. */
		
		if ($recent_score > $store_score) {
			$results_message = "Congratulations! You earned your personal best on the " . $quiz_name . " quiz!"; 
			$score_message = "You answered " . $recent_score . " questions correctly.";
			record_high_score($recent_score, $current_username);
		} else {
			$results_message = "You answered " . $recent_score . " questions correctly.";
			$score_message = "Your best score on the " . $quiz_name . " Quiz is " . $store_score . " correct answers.";
		}
	
	
		/*$query_record = "UPDATE students SET $version_name={$_SESSION['score']} WHERE username='{$_SESSION['student_username']}'";*/ 


	
		/*	$query_record = "UPDATE students SET hawaii_score=1 WHERE username='mcnalj'"; */
	


		/*Here's where I try to set up a badge system */
		/* I need this query to find out if they have already earned the badge */

		$query_badge = "SELECT $badge_version FROM students WHERE username = '{$_SESSION['student_username']}' ";

		$result_badges = mysqli_query($connection, $query_badge);
			if (!$result_badges) {
				die("Database query failed.");
			}

		$badges_earned = mysqli_fetch_assoc($result_badges);

		function record_badge_earned($badge_version) {
					global $connection;
					global $current_username;

					$query_badge_record = "UPDATE students SET $badge_version=true WHERE username='{$current_username}'";
					$recorded_badge = mysqli_query($connection, $query_badge_record);
					confirm_query($recorded_badge);
					if(!$recorded_badge) {
					die("Database query failed.");
				}
			}
			if ($_SESSION['version'] == "40") { 
				$required_score = 18;
			} else if ($_SESSION['version'] == "30") {
			$required_score = 18;
			} else {
			$required_score = 13;
		}
		if ($recent_score >= $required_score && $badges_earned[$badge_version] == 0) {
			$badge_congrats = "Congratulations, you earned the " . $quiz_name . " Badge!";
			record_badge_earned($badge_version);
		} else if ($recent_score >= $required_score && $badges_earned[$badge_version] ==1) { 
			$badge_congrats = "You have mastered the " . $quiz_name . " Quiz. You already earned the " . $quiz_name . " Badge.";
		} else if ($recent_score < $required_score && $badges_earned[$badge_version] ==1) { 
			$badge_congrats = "You already earned the " . $quiz_name . " Badge. Try it again to sharpen your skills or move on to a new quiz.";
		} else if ($recent_score < $required_score && $badges_earned[$badge_version] ==0) { 
			$badge_congrats = "Try again to earn the " . $quiz_name . " Badge. Answer " . $required_score . " questions correctly to earn the " . $quiz_name . " Badge.";
		}

		/* This second query into the badges is necessary to update the badge list incase they earned a new badge */

		$query_badge_after_record = "SELECT hawaii_badge, portland_badge, summer2015_badge, geography_badge, world_geography_badge, cortes_trial_badge, cortes_badge, africa_geography_badge, africa_countries_badge, constitution_badge, presidents_badge FROM students WHERE username = '{$_SESSION['student_username']}' ";

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

		$world_geography_badge = $badges_earned_now['world_geography_badge'];
		if($world_geography_badge) {
			$world_geography_message = "YES";
		} else {
			$world_geography_message = "NO";
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
		
	} else {
		$results_message = "You answered " . $recent_score . " questions correctly.";
		$score_message = "Login or register to keep track of your high scores.";
		$badge_congrats = "Login or register to record your progress and earn badges.";
		$hawaii_message = "???";
		$portland_message = "???";
		$summer2015_message = "???";
		$geography_message = "???";
		$world_geography_message = "???";
		$cortes_trial_message = "???";
		$cortes_message = "???";
		$africa_geography_message = "???";
		$africa_countries_message = "???";
		$constitution_message = "???";
		$presidents_message = "???";
	}
	




	
	
	

	
	
	/*
	this is just here for a model
	
$query = "INSERT INTO Geography (";
$query .= " QuestionTitle, Question, AnswerCorrect, Distractor1, Distractor2, Distractor3";
$query .= ") VALUES (";
$query .= " '{$questiontitle}', '{$question}', '{$answercorrect}', '{$distractor1}', '{$distractor2}', '{$distractor3}'";
$query .= ")";

$resultq = mysqli_query($connection, $query);
if ($resultq) {
	echo "Success!";
} else {
	die("Database query failed." . mysqli_error($connection));
}
*/


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
				<p id ="back"><a href="student_base.php">Student Base</a></p>				
				<p id ="logout"><a href="logout.php">Goodbye!</a></p>
			</div>
		</header>	
		
		<aside id="playerStatus">
			
			<div id="score">
				<h2>PROGRESS</h2>
				<p id ="name"><?php echo $results_message; ?></p>
				<p id ="name"><?php echo $score_message; ?></p>				
			</div>
			
			<div id="badges">
				<h2>BADGES EARNED</h2>
				<table>
				<!--<tr><td>Hawaii Badge:</td><td><?php echo $hawaii_message; ?></td></tr>-->
				<tr><td>World Geography:</td><td><?php echo $geography_message; ?></td></tr>
				<!--<tr><td>Portland Badge:</td><td><?php echo $portland_message; ?></td></tr>	
				<tr><td>United States Badge:</td><td>YES</td></tr>	
				<tr><td>Summer 2015:</td><td><?php echo $summer2015_message; ?></td></tr> -->
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
			
		<article id="quizSpace">
			
			<h2>Congratulations you finished the quiz!</h2>
				<br />
				<p><?php echo $badge_congrats ?></p>
<!--

			<p>Hawaii Badge: <?php echo $hawaii_message; ?></p>
			<p>Portland Badge: <?php echo $portland_message; ?></p>
			<p>Summer 2015 Badge: <?php echo $summer2015_message; ?></p>
			<p>Geography Badge: <?php echo $geography_message; ?></p>
			<p>World Geography Badge: <?php echo $world_geography_message; ?></p>
-->
		</br>
			<h2>Continue learning!</h2>
			<br />
			<p>Try the <?php echo $quiz_name; ?> Quiz again or choose another quiz.</p>
						
		</br>
		<br />
		
		
	    <h2>Quizzes</h2>
		 	<br />
	    <form action="quiz_action.php" method="post">
			<fieldset>
	      <!--  <button type="submit" name="quiz" value= 2 >Hawaii</button>
			<button type="submit" name="quiz" value= 3 >Portland</button> 
			<button type="submit" name="quiz" value= 4 >Summer 2015</button> 
			<button type="submit" name="quiz" value= 0 >Geography</button>  -->
			<button type="submit" name="quiz" value= 5 >World Geography</button>
			<button type="submit" name="quiz" value= 6 >Aztecs</button>
			<button type="submit" name="quiz" value= 7 >Spanish Arrival</button>
			<button type="submit" name="quiz" value= 10 >Imperialism in Africa</button>
			<button type="submit" name="quiz" value= 20 >African Countries</button>
			<button type="submit" name="quiz" value= 30 >U.S. Government Essentials</button>
			<button type="submit" name="quiz" value= 40 >Essential Presidents</button>  
		</fieldset>
	      </form>
	</article>
</main>
		
		
<?php include("../includes/layouts/footer.php"); ?>
		
