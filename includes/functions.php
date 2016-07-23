<?php

function redirect_to($new_location) {
	header("Location: " . $new_location);
	exit;
}

function mysql_prep($string) {
	global $connection;
	
	$escaped_string = mysqli_real_escape_string($connection, $string);
	return $escaped_string;
}

function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div class=\"error\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}
	

function password_encrypt($password) {
	$hash_format = "$2y$10$"; //Tells PHP to use Blowfish with a "cost" of 10
	// Blowfish salts should be 22 characters or more
	$salt_length = 22;
	$salt = generate_salt($salt_length);
	$format_and_salt = $hash_format . $salt;
	$hash = crypt($password, $format_and_salt);
		return $hash;
}

function generate_salt($length) {
	  // Not 100% unique, not 100% random, but good enough for a salt
	  // MD5 returns 32 characters
	  $unique_random_string = md5(uniqid(mt_rand(), true));
	  
		// Valid characters for a salt are [a-zA-Z0-9./]
	  $base64_string = base64_encode($unique_random_string);
	  
		// But not '+' which is valid in base64 encoding
	  $modified_base64_string = str_replace('+', '.', $base64_string);
	  
		// Truncate string to the correct length
	  $salt = substr($modified_base64_string, 0, $length);
	  
		return $salt;
	}
	
function password_check($password, $existing_hash) {
			// existing hash contains format and salt at start
		  $hash = crypt($password, $existing_hash);
		  if ($hash === $existing_hash) {
		    return true;
		  } else {
		    return false;
		  }
		}


		
		function find_admin_by_username($username) {
			global $connection;
	
			$safe_username = mysqli_real_escape_string($connection, $username);
	
			$query = "SELECT * ";
			$query .= "FROM admins ";
			$query .= "WHERE username = '{$safe_username}' ";
			$query .= "LIMIT 1";
			$admin_set = mysqli_query($connection, $query);
			confirm_query($admin_set);
			if($admin = mysqli_fetch_assoc($admin_set)) { /* what is $admin????? */
				return $admin;
			} else {
				return null;
			}
		}

		function find_student_by_username($student_username) {
			global $connection;
	
			$safe_student_username = mysqli_real_escape_string($connection, $student_username);
	
			$query = "SELECT * ";
			$query .= "FROM students ";
			$query .= "WHERE username = '{$safe_student_username}' ";
			$query .= "LIMIT 1";
			$student_set = mysqli_query($connection, $query);
			confirm_query($student_set);
			if($student = mysqli_fetch_assoc($student_set)) {
				return $student;
			} else {
				return null;
			}
		}

function attempt_login($username, $password) {
	$admin = find_admin_by_username($username);
	if ($admin) {
		//found admin, now check password
		if (password_check($password, $admin["hashed_password"])) {
			// password matches
			return $admin;
		} else {
			// password does not match
			return false;
		}
	} else {
		// admin not found
		return false;
	}
}

function attempt_student_login($student_username, $student_password) {
	$student = find_student_by_username($student_username);
	if ($student) {
		//found admin, now check password
		if (password_check($student_password, $student["hashed_password"])) {
			// password matches
			return $student;
		} else {
			// password does not match
			return false;
		}
	} else {
		// admin not found
		return false;
	}
}


function logged_in() {
	return isset($_SESSION["admin_id"]);
}

function logged_in_student() {
	return isset($_SESSION["student_username"]);
}

function confirm_logged_in() {
	if (!logged_in()) {
		redirect_to ("loginfromscratch.php");
	}
}


function confirm_logged_in_student() {
	if (!logged_in_student()) {
		redirect_to ("login_student.php");
	}
}

function prevent_double_student_login() {
	if (logged_in_student()) {
		redirect_to("already_in.php");
	}
}

function prevent_double_teacher_login() {
	if (logged_in()) {
		redirect_to("already_in_teacher.php");
	}
}

function confirm_logged_in_oneorother() {
	if (!logged_in_student() && !logged_in())
		redirect_to("login_student.php");
}

function confirm_query($result_set) {
	if (!$result_set) {
		die("Database query failed.");
	}
}

function find_default_page_for_subject($subject_id) {
	$page_set = find_pages_for_subject($subject_id);
	if($first_page = sysqli_fetch_assoc($page_set)) {
		return $first_page;
	} else {
		return null;
	}
}

function find_subject_by_id($subject_id, $public=true) {
	global $connection;

	$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);

	$query = "SELECT * ";
	$query .= "FROM subjects ";
	$query .= "WHERE id = {$safe_subject_id} ";
	if ($public) {
		$query .= "AND visible = 1 ";
	}
	$query .= "LIMIT 1";
	$subject_set = mysqli_query($connection, $query);
	confirm_query($subject_set);
	if($subject = mysqli_fetch_assoc($subject_set)) {
		return $subject;
	} else {
		return null;
	}
}



/*function find_selected_page($public=false) {
	global $current_subject;
	global $current_page;

	if (issset($_GET["subject"])) {
		$current_subject = find_subject_by_id($_GET["subject"], $public);
		if ($current_subject && $public) {
			$current_page = 

function find_default_page_for_subject($current_subject["id"]);
		} else {
			$current_page = null;
		}
	} else if (issset($_GET["page"])) {
		$current_subject = null;
		$current_page = find_page_by_id($_GET["page"], $public);
	} else {
		$current_subject = null;
		$current_page = null;
	}
}
*/
				
?>