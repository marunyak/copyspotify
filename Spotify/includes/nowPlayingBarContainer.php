<?php
	$songQuery = mysqli_query($con,"SELECT id FROM songs  ORDER BY RAND() LIMIT 10");
	$resultArray = [];
	while($row = mysqli_fetch_array($songQuery)){
		array_push($resultArray,$row['id']);
	}
	$jsonArray = json_encode($resultArray);
?>

<script>
	$(document).ready(function(){
		currentPlayList = <?php echo $jsonArray;?>;
		audioElement = new Audio();
		setTrack(currentPlayList[0],currentPlayList,false);
		
	});

	function setTrack(trackId,currentPlayList,play){
		audioElement.setTrack("assets/music/face2reality.mp3");
		//var isPlaying = audioElement.audio.currentTime > 0 && !audioElement.audio.paused && !audioElement.audio.ended;

		if (play) {
			audioElement.play();
		}

	}
</script>	

<div id="nowPlayingBarContainer">
		<div id="nowPlayingBar">
			<div id="nowPlayingLeft">
				<div class="content">
					<span class="albumLink">
						<img src="https://muzonov.net/uploads/posts/2018-04/medium/1523086657_zolxt3427-s.jpg" class="albumArtwork">
					</span>
					<div class="trackInfo">
							<div class="trackName">
								<span>Hard 2 face reality</span>
							</div>

							<div class="artistName">
								<span>Poo Bear(feat Justin Bieber)</span>
							</div>
					</div>
				</div>
			</div>

			<div id="nowPlayingCenter">
				<div class="content playerControls">
						<div class="buttons">
							<button class="controlButton shuffle" title="Shuffle button">
								<img src="assets/images/icons/shuffle.png" alt="Shuffle">
							</button>

							<button class="controlButton previous" title="Previous button">
								<img src="assets/images/icons/previous.png" alt="Previous">
							</button>

							<button class="controlButton play" title="Play button">
								<img src="assets/images/icons/play.png" alt="Play">
							</button>

							<button class="controlButton pause" title="Pause button" style="display: none;">
								<img src="assets/images/icons/pause.png" alt="Pause">
							</button>


							<button class="controlButton next" title="Next button">
								<img src="assets/images/icons/next.png" alt="Next">
							</button>

							<button class="controlButton repeat" title="Repeat button">
								<img src="assets/images/icons/repeat.png" alt="Repeat">
							</button>
						</div>

						<div class="playbackBar">
							<span class="progressTime current">0.00</span>
							<div class="progressBar">
								<div class="progressBarBg">
									<div class="progress"></div>
								</div>
							</div>
							<span class="progressTime remaining">0.00</span>
						</div>
				</div>
			</div>

			<div id="nowPlayingRight">
					<div class="volumeBar">
						<button class="controlButton volume" title="Volume button">
							<img src="assets/images/icons/volume.png" alt="Volume">
						</button>
						<div class="progressBar">
							<div class="progressBarBg">
								<div class="progress"></div>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>