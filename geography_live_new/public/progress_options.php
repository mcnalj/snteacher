<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>	
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>



	
<?php include("../includes/layouts/teacher_progress_header.php"); ?>

<?php
$query = "SELECT * FROM students WHERE teacher_name = '{$_SESSION['teacher_last_name']}' AND teacher_name IS NOT NULL ORDER BY ssblock, last_name";
$students = mysqli_query($connection, $query);
confirm_query($students);

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
			<p><a href="teacher_base.php">Back to Teacher Base</a></p>
			<br />
			<p><a href="new_question.php">Create/Edit Questions</a></p>
			<br />
			<p><a href="teacher_account.php">Update Account Information</a></p>
			</div>
		</aside>

		<main>
			
		<article id="quizSpace">

				<h2>Progress Check Options</h2>
				<br>
				<p>Hi, <?php echo $_SESSION['teacher_last_name']?> in the box below click which quizzes for which you want progress updates.</p>
				<br>
				<form action="student_progress_test.php" method="post">
					<input type="checkbox" name="progressCheck[]" value= 5 > World Geography<br>
					<input type="checkbox" name="progressCheck[]" value= 6 > Cortes Trial<br>
					<input type="checkbox" name="progressCheck[]" value= 7 > Spanish Arrival<br>
					<input type="checkbox" name="progressCheck[]" value= 10 > Imperialism in Africa<br>
					<input type="checkbox" name="progressCheck[]" value= 20 > African Countries<br>
					<input type="checkbox" name="progressCheck[]" value= 30 > Government Essentials<br>
					<input type="checkbox" name="progressCheck[]" value= 40 > Essential Presidents<br>	
					<input type="submit" value="Submit">		
				</form>
						
				<table style ="width:100%">
					<tr>
						<th>Student ID</th>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Essential Presidents</th>
						<th>Essential Presidents Badge</th>
						<th>U.S. Government Essentials</th>
						<th>U.S. Government Essentials Badge</th>
						<th>World Geography Score</th>
						<th>World Geography Badge</th>
						<th>Aztecs Score</th>
						<th>Aztecs Badge</th>
						<th>Cortes Score</th>
						<th>Cortes Badge</th>
						<th>Imperialism in Africa Score</th>
						<th>Imperialism in Africa Badge</th>
						<th>African Countries</th>
						<th>African Countries Badge</th>

						
						
					</tr>
<?php while ($row = mysqli_fetch_assoc($students)) {
	echo "<tr style=text-align:center>";
	echo "<td>{$row['school_id']}</td>";
	echo "<td>{$row['first_name']}</td>";
	echo "<td>{$row['last_name']}</td>";
	echo "<td>{$row['presidents_score']}</td>";
	echo "<td>{$row['presidents_badge']}</td>";
	echo "<td>{$row['constitution_score']}</td>";
	echo "<td>{$row['constitution_badge']}</td>";
	echo "<td>{$row['world_geography_score']}</td>";
	echo "<td>{$row['world_geography_badge']}</td>";
	echo "<td>{$row['cortes_trial_score']}</td>";
	echo "<td>{$row['cortes_trial_badge']}</td>";
	echo "<td>{$row['cortes_score']}</td>";
	echo "<td>{$row['cortes_badge']}</td>";
	echo "<td>{$row['africa_geography_score']}</td>";
	echo "<td>{$row['africa_geography_badge']}</td>";
	echo "<td>{$row['africa_countries_score']}</td>";
	echo "<td>{$row['africa_countries_badge']}</td>";
	
	
	echo "</tr>";
}
?>
				</table>	
		</article>
		</main>		
		
<?php include("../includes/layouts/footer.php"); ?>
