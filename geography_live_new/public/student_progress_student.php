<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>	
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in_student(); ?>



	
<?php include("../includes/layouts/header_progress.php"); ?>

<?php
$query = "SELECT * FROM students WHERE site_id = '{$_SESSION['student_id']}' ";
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
			<p><a href="quiz_front.php">Quizzes</a></p>
			<br />
			<p><a href="student_base.php">Back to Student Base</a></p>
			<br />			
			<p><a href="student_account.php">Update Account Information</a></p>
		</div>
		</aside>
		
	<main>
		<article id="quizSpace">
				
				<h2>Your High Scores and Badges</h2>
<br>
				<table style ="width:80%">
					<tr>
						<th>World Geography High Score</th>
						<th>World Geography Badge</th>
					</tr>
					
					
<?php $row = mysqli_fetch_assoc($students);
	echo "<tr style=text-align:center>";
	echo "<td>{$row['world_geography_score']}</td>";
	echo "<td>{$row['world_geography_badge']}</td>";
	echo "</tr>";

?>

			</table>
<br>
				<table style ="width:80%">
					<tr>
						<th>Aztecs High Score</th>
						<th>Aztecs Badge</th>
					</tr>
	
<?php
	
	echo "<tr style=text-align:center>";
	echo "<td>{$row['cortes_trial_score']}</td>";
	echo "<td>{$row['cortes_trial_badge']}</td>";
	echo "</tr>";
?>
	</table>
<br>
<table style ="width:80%">
	<tr>
		<th>Cortes Trial Score</th>
		<th>Cortes Trial Badge</th>
	</tr>
<?php 
	echo "<tr style=text-align:center>";
	echo "<td>{$row['cortes_score']}</td>";
	echo "<td>{$row['cortes_badge']}</td>";
	echo "</tr>";
?>
				</table>	
				
				<br>
				<table style ="width:80%">
					<tr>
						<th>Imperialism in Africa Score</th>
						<th>Imperialism in Africa Badge</th>
					</tr>
				<?php 
					echo "<tr style=text-align:center>";
					echo "<td>{$row['africa_geography_score']}</td>";
					echo "<td>{$row['africa_geography_badge']}</td>";
					echo "</tr>";
				?>
								</table>	

					<br>
					<table style ="width:80%">
						<tr>
							<th>African Countries Score</th>
							<th>African Countries Badge</th>
						</tr>
						<?php 
							echo "<tr style=text-align:center>";
							echo "<td>{$row['africa_countries_score']}</td>";
							echo "<td>{$row['africa_countries_badge']}</td>";
							echo "</tr>";
						?>
				</table>	
				
				<br>
								<table style ="width:80%">
									<tr>
										<th>Government Essentials Score</th>
										<th>Government Essentials Badge</th>
									</tr>
					
					
				<?php $row = mysqli_fetch_assoc($students);
					echo "<tr style=text-align:center>";
					echo "<td>{$row['constitution_score']}</td>";
					echo "<td>{$row['constitution_badge']}</td>";
					echo "</tr>";

				?>

							</table>
							
					<br>
						<table style ="width:80%">
								<tr>
									<th>Essential Presidents Score</th>
									<th>Essential Presidents Badge</th>
								</tr>
					
					
					<?php $row = mysqli_fetch_assoc($students);
						echo "<tr style=text-align:center>";
						echo "<td>{$row['presidents_score']}</td>";
						echo "<td>{$row['presidents_badge']}</td>";
						echo "</tr>";

					?>

								</table>
					
				

				
		</article>
	</main>

<?php include("../includes/layouts/footer.php"); ?>
