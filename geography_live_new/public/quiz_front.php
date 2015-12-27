<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php 
confirm_logged_in_oneorother();

/* The session context is set as "teacher" by loginfromscratch.php or "student" by login_student.php. If it's teacher, it jumps straight to the html form. */
include("../includes/layouts/header.php"); 
if ($_SESSION["context"] == "teacher") {
	goto a;
} 

if (isset($_SESSION['score'])) {
	$_SESSION['score'] = $_SESSION['score'];
	} else {
		$_SESSION['score'] = 0;
	}

/*	echo "Current Score = " . $_SESSION['score'];
	echo $_SESSION['student_username'];*/
	
	if(isset($_SESSION['version'])) {
	$version_message = "Quiz version = " . $_SESSION['version'];
} else {
	$_SESSION['version'] = 5;
}
	
if ($_SESSION['version'] == "2") {
	$version_name = "hawaii_score";
	$badge_version = "hawaii_badge";
} else if ($_SESSION['version'] == "3") {
	$version_name = "portland_score";
	$badge_version = "portland_badge";
} else if ($_SESSION['version'] == "4") {
	$version_name = "summer2015_score";
	$badge_version = "summer2015_badge";
} else if ($_SESSION['version'] == "0") {
	$version_name = "geography_score";
	$badge_version = "geography_badge";
} else if ($_SESSION['version'] == "5") {
	$version_name = "world_geography_score";
	$badge_version = "world_geograpy_badge";
} else if ($_SESSION['version'] == "6") {
	$version_name = "cortes_trial_score";
	$badge_version = "cortes_trial_badge";
} else if ($_SESSION['version'] == "7") {
	$version_name = "cortes_score";
	$badge_version = "cortes_badge";
} else if ($_SESSION['version'] == "10") {
	$version_name = "africa_geography_score";
	$badge_version = "africa_geography_badge";
} else if ($_SESSION['version'] == "20") {
	$version_name = "africa_countries_score";
	$badge_version = "africa_countries_badge";
} else if ($_SESSION['version'] == "30") {
	$version_name = "constitution_score";
	$badge_version = "constitution_badge";
} else if ($_SESSION['version'] == "40") {
	$version_name = "presidents_score";
	$badge_version = "presidents_badge";	
} else {
	echo "The quiz version was not set";
}
 
/*$query = "SELECT '{$version_name}' FROM students WHERE username = $_SESSION['username']";*/
/* This pulls the old high score from the database. */
$query = "SELECT $version_name FROM students WHERE username = 		'{$_SESSION["student_username"]}' ";

$resultr = mysqli_query($connection, $query);
	if (!$resultr) {
		die("Database query failed.");
	}

$old_score = mysqli_fetch_assoc($resultr);
$store_score = $old_score[$version_name];

	$new_high_score = $_SESSION['score'];
	$current_username = $_SESSION['student_username'];
	
	function record_high_score($new_high_score) {
		global $connection;
		global $version_name;
		global $current_username;

		$query_record = "UPDATE students SET $version_name={$new_high_score} WHERE username='{$current_username}'";
		$recorded_score = mysqli_query($connection, $query_record);
		confirm_query($recorded_score);
		if($recorded_score) {
			echo "Score updated.";
	} else {
		die("Database query failed.");
	}
}
	
if ($new_high_score > $store_score) {
	$last_quiz_message = "Congratulations! You earned your personal best on the " . $version_name . " quiz!";
	$last_quiz_report = "You answered " . $new_high_score . " questions correctly.";
	record_high_score($new_high_score, $current_username);
} else {
	$last_quiz_message = "You answered " . $new_high_score . " questions correctly.";
	$last_quiz_report = "Your best score on this quiz is " . $store_score . " correct answers.";
	}

	
a:

	unset($_SESSION['quiz_count']); 
	unset($_SESSION['already_answered']);
	unset($_SESSION['score']);

	if ($_SESSION["context"] == "student") {
		$menu_message = "Student Base";
		$menu_link = "student_base.php";
	} else if ($_SESSION["context"] == "teacher") {
		$menu_message = "Teacher Base";
		$menu_link = "teacher_base.php";
		$hawaii_message = "";
		$portland_message = "";
		$summer2015_message = "";
		$geography_message = "";
		$world_geography_message = "";
		$cortes_trial_message = "";
		$cortes_message = "";
		$africa_geography_message = "";
		$africa_countries_message = "";
		$constitution_message = "";
		$presidents_message = "";							
		goto b;
	}
	
	

	$query_badges = "SELECT hawaii_badge, portland_badge, summer2015_badge, geography_badge, world_geography_badge, cortes_trial_badge, cortes_badge, africa_geography_badge, africa_countries_badge, constitution_badge, presidents_badge FROM students WHERE username = '{$_SESSION['student_username']}' ";

	$result_badges_after_record = mysqli_query($connection, $query_badges);
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

	
	
	b:
?>
		
	<body>
		
		<header>
			<div id = "banner">
				<img src="images/globeglass.png" alt="globe icon">
				<p id ="nameLogo">Atomic Teacher</p>		
			</div>

			<div id = "nav">
				<p id ="back"><a href="../index.php">Atomic Teacher Home</a></p>
				<p id ="link"><a href="<?php echo $menu_link; ?>"><?php echo $menu_message; ?></a></p>
				<p id ="logout2"><a href="logout.php">Goodbye!</a></p>
			</div>
		</header>	
		
		<aside id ="playerStatus">
			
			<div id="score">
				<h2>PROGRESS</h2>
			<!--	<p><?php $last_quiz_message; ?></p>
				<p><?php $last_quiz_report; ?></p> -->
				<p id="name"><span class="quiz">Your previous personal best on this quiz was</span></p>
				<p id = "personalBest"><span class = "color"><?php 
					if (isset($store_score)) {
					echo $store_score; 
				} else {
					echo "?????";
				}
					?></span> correct.</p>
			<!--	<p id = "badgeReq">score 14 out of 15 to earn a badge</p> -->
			</div>
			

				
			<div id ="badges">			
				<h2>BADGES EARNED</h2>
				<table>
			<!--	<tr><td>Hawaii Badge: </td><td><?php echo $hawaii_message; ?></td></tr>
				<tr><td>Portland Badge: </td><td><?php echo $portland_message; ?></td></tr>
				<tr><td>Summer 2015 Badge: </td><td><?php echo $summer2015_message; ?></td></tr>
				<tr><td>Geography Badge: </td><td><?php echo $geography_message; ?></td></tr> -->
				<tr><td>World Geography: </td><td><?php echo $world_geography_message; ?></td><tr>
				<tr><td>Aztecs: </td><td><?php echo $cortes_trial_message; ?></td><tr>
				<tr><td>Spanish Arrival: </td><td><?php echo $cortes_message; ?></td><tr>
				<tr><td>Imperialism in Africa: </td><td><?php echo $africa_geography_message; ?></td><tr>
				<tr><td>African Countries: </td><td><?php echo $africa_countries_message; ?></td><tr>
				<tr><td>U.S. Government Essentials: </td><td><?php echo $constitution_message; ?></td><tr>
				<tr><td>Essential Presidents: </td><td><?php echo $presidents_message; ?></td><tr>
				</table>
			</div>
		</aside>
				
		<main>
			
		<article id = "quizSpace">
			
			<h2>Atomic Teacher: Gateway to Knowledge</h2>
		</br>
			<p>Choose your quiz.</p>
		</br>
			<p>Get 18 out of 20 on Government Essentials before December 22 (Tuesday of next week) to get a 4.0 on that standard. </p>
			<br/>
			<p>Get 18 out of 23 on Essential Presidents to meet, 20 to get a 3.5 and 23 to get a 4.0 by December 22. </p>
		</br>
		</br>
	    	<h2>Quizzes</h2>
		</br>
	    	<form action="quiz_action.php" method="post">
				<fieldset>
	        	 <!--<button type="submit" name="quiz" value= 2 >Hawaii</button>
				<button type="submit" name="quiz" value= 3 >Portland</button> 
				<button type="submit" name="quiz" value= 4 >Summer 2015</button> 
				<button type="submit" name="quiz" value= 0 > Old World Geography</button> -->
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
		
