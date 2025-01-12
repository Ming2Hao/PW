<?php
	session_start();
	$conn = mysqli_connect('localhost', 'root', '', 'T7_221116962');
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	function alert($message)
	{
		echo "<script>alert($message)</script>";
	}
?>