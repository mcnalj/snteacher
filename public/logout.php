<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in_oneorother(); ?>
<?php
$_SESSION = array();
if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-42000, '/');
}
	session_destroy();
	redirect_to("goodbye.php");

/*$_SESSION["username"] = null;
redirect_to("../index.php");*/
?>

<?php
//this is a much more heavyhanded way of doing it and this code has not been tested.
/*
session_start(); //make sure the session is started. I think including the session does it.
$_SESSION = array();
if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-42000, '/');
}
session_destroy();
redirect_to("loginfromscratch.php");
*/
?>