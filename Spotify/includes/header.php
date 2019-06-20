<?php
	include("includes/config.php");
	include("includes/classes/Artist.php");  
	include("includes/classes/Album.php"); 
	include("includes/classes/Song.php");

	if(isset($_SESSION['userLoggedIn'])){
		$userLoggedIn = $_SESSION['userLoggedIn'];
		echo "<script>userLoggedIn = '$userLoggedIn';</script>";
	}
	else{
		header("Location: register.php");
	}


 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Spotify!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="assets/js/script.js"></script>
</head>
<body>
<!-- <script>
	 audioElement = new Audio();
	// audioElement.setTrack('assets/music/thank_u_next.mp3');
	// var playPromise = audioElement.audio.play();
</script> -->
<div id="mainContainer">
	<div id="topContainer">
		<?php include "includes/navBarContainer.php";?>

		<div id="mainViewContainer">
			<div id="mainContent">