<?php
	define("DB_SERVER", "localhost");
	define("DB_USER", "mcnalj");
	define("DB_PASS", "tec0L0te");
	define("DB_NAME", "JakeTest3");

	$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	if(mysqli_connect_errno()) {
		die("Database connection failed: " .
			mysqli_connect_error() .
			" (" . mysqli_connect_errno() . ")"
		);
	}
?>