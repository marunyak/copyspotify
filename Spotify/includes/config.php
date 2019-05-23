<?php
	@ob_start();
	@session_start();
	$timezone = date_default_timezone_set("Europe/Kiev");
	$con = mysqli_connect("localhost","root","1234cisco!!!","slotify");
	if (!$con) {
      die("Connection failed: " . mysqli_connect_error());
	}
?>