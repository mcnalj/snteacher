<?php
// quiz_front.php
//line 61-63

} else if ($_SESSION['version'] == "50") {
	$version_name = "civil_war_score";
	$badge_version = "civil_war_badge";	
	//line 131
	$civil_war_message = "";
	// line 137 - add to query string
	
	//line 223
	$civil_war_badge = $badges_earned_now['civil_war_badge'];
	if($civil_war_badge) {
		$civil_war_message = "YES";
	} else {
		$civil_war_message = "NO";
	}
	
	//line 283
	<tr><td>Civil War: </td><td><?php echo $civil_war_message; ?></td><tr>	
	
<?php

	//line 316
	<button type="submit" name="quiz" value= 50 >Civil War</button>
		
		
	//progress_options.php
	//line 59
	<input type="checkbox" name="progressCheck[]" value= 50 > Civil War<br>
							
	//line 68-69
	<th>Civil War</th>
	<th>Civil War Badge</th>
		
	//line 93-94
	echo "<td>{$row['civil_war_score']}</td>";
	echo "<td>{$row['civil_war_badge']}</td>";
	
							
?>