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
		
		$(".playbackBar .progressBar").mousedown(function(){
			mouseDown = true;
		});

		$(".playbackBar .progressBar").mousemove(function(e){
			if(mouseDown){
				timeFromOffset(e,this);
			}
		});

		$(".playbackBar .progressBar").mouseup(function(e){
			timeFromOffset(e,this);
			mouseDown = false;
		});


		$(".volumeBar .progressBar").mousedown(function(){
			mouseDown = true;
		});

		$(".volumeBar .progressBar").mousemove(function(e){
			if(mouseDown){
				var percentage = e.offsetX / $(this).width();

				if(percentage >= 0 && percentage <= 1){
					audioElement.audio.volume = percentage;
				}
			}
		});

		$(".volumeBar .progressBar").mouseup(function(e){
			var percentage = e.offsetX / $(this).width();
				
				if(percentage >= 0 && percentage <= 1){
					audioElement.audio.volume = percentage;
				}
			}
		});


	});

	function timeFromOffset(mouse,progressBar){
		var percentage = mouse.offsetX / $(progressBar).width() * 100;
		var seconds = audioElement.audio.duration * (percentage / 100); 
		audioElement.setTime(seconds);
	}

	function setTrack(trackId,currentPlayList,play){
		$.ajax({
			type:"POST",
			url:"includes/handlers/getSong_json.php",
			data:{songId:trackId},
			success:function(data){
				var track = JSON.parse(data);			
				$(".trackName span").text(track.title);

				$.ajax({
					type:"POST",
					url:"includes/handlers/getArtist_json.php",
					data:{artistId:track.artist},
					success:function(data){
						var artist = JSON.parse(data);
						$(".artistName span").text(artist.name);
					}
				});

				$.ajax({
					type:"POST",
					url:"includes/handlers/getAlbum_json.php",
					data:{albumId:track.album},
					success:function(data){
						var album = JSON.parse(data);
						$(".albumArtwork").attr('src',album.artworkPath);
					}
				});

				audioElement.setTrack(track);
				audioElement.play();
			}
		});


	}

	function playSong(){

		if(audioElement.audio.currentTime  == 0){
			$.ajax({
				type:"POST",
				url:"includes/handlers/updatePlays.php",
				data:{songId:audioElement.currentlyPlaying.id},
				success:function(data){

				}
			});
		}	

		$(".controlButton.play").hide();
		$(".controlButton.pause").show();
		audioElement.play();
	}

	function pauseSong(){
		$(".controlButton.play").show();
		$(".controlButton.pause").hide();
		audioElement.pause();
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

						<button class="controlButton play" title="Play button" style="display: none;">
							<img src="assets/images/icons/play.png" alt="Play" onclick="playSong()">
						</button>

						<button class="controlButton pause" title="Pause button" >
							<img src="assets/images/icons/pause.png" alt="Pause" onclick="pauseSong()">
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