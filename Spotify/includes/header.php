<?php
	include("includes/config.php");
	include("includes/classes/Artist.php");  
	include("includes/classes/Album.php"); 
	include("includes/classes/Song.php");
	//session_destroy();

	if(isset($_SESSION['userLoggedIn'])){
		$userLoggedIn = $_SESSION['userLoggedIn'];
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
	<script src="assets/js/script.js"></script>
</head>
<body>
<script>
	var audioElement = new Audio();
	audioElement.setTrack('assets/music/thank_u_next.mp3');
	var playPromise = audioElement.audio.play();

	// if (playPromise !== undefined) {
	// 	playPromise.then(_ => {
	// 	// Automatic playback started!
	// 	// Show playing UI.
	// 	audioElement.audio.play();
	// 	})
	// 	.catch(error => {
	// 	// Auto-play was prevented
	// 	// Show paused UI.
	// 	audioElement.audio.pause();
	// 	});
	// }

</script>
<div id="mainContainer">
	<div id="topContainer">
		<?php include "includes/navBarContainer.php";?>

		<div id="mainViewContainer">
			<div id="mainContent">