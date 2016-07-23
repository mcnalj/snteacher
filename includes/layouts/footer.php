	<footer>Copyright <?php echo date("Y"); ?>, SNTeacher</footer>
	
	</body>
</html>

<?php
	if (isset($connection)) {
		mysqli_close($connection);
	}
?>