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
		
		newPlayList = <?php echo $jsonArray;?>;
		audioElement = new Audio();
		setTrack(newPlayList[0],newPlayList,false);
		updateVolumeProgressBar(audioElement.audio);

		$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove",function(e){
			e.preventDefault();
		});

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
			mouseDown = false;
		});
	});

	function timeFromOffset(mouse,progressBar){
			var percentage = mouse.offsetX / $(progressBar).width() * 100;
			var seconds = audioElement.audio.duration * (percentage / 100); 
			audioElement.setTime(seconds);
	}

	function prevSong(){
		if(audioElement.audio.currentTime >= 3  || currentIndex == 0){
			audioElement.setTime(0);
		}
		else {
			currentIndex--;
			setTrack(currentPlayList[currentIndex],currentPlayList,true);
		}
	}

	function nextSong(){

		if(repeat){
			audioElement.setTime(0);
			playSong();
			return;
		}

		if(currentIndex == currentPlayList.length - 1){
			currentIndex = 0;
		}
		else{
			currentIndex++;
		}

		var trackToPlay = shuffle?shufflePlayList[currentIndex]:currentPlayList[currentIndex];
		setTrack(trackToPlay,currentPlayList,true);
	}

	function setTrack(trackId,newPlayList,play){

		if(newPlayList != currentPlayList){
			currentPlayList = newPlayList;
			shufflePlayList = currentPlayList.slice();
			shuffleArray(shufflePlayList);
		}

		if(shuffle) currentIndex = shufflePlayList.indexOf(trackId);
		else 		currentIndex = currentPlayList.indexOf(trackId);
		pauseSong();

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

	function setRepeat(){
		repeat = !repeat;
		var imageName = repeat ? "repeat-active.png": "repeat.png";
		$(".controlButton.repeat img").attr("src","assets/images/icons/"+imageName);
	}

	function setMute(){
		audioElement.audio.muted = !audioElement.audio.muted ;
		var imageName = audioElement.audio.muted  ? "volume-mute.png": "volume.png";
		$(".controlButton.volume img").attr("src","assets/images/icons/"+imageName);
	}

	function setShuffle(){
		shuffle = !shuffle;
		var imageName = shuffle ? "shuffle-active.png": "shuffle.png";
		$(".controlButton.shuffle img").attr("src","assets/images/icons/"+imageName);

		if(shuffle){
			//Find track when shuffle = true
			shuffleArray(shufflePlayList);
			currentIndex = shufflePlayList.indexOf(audioElement.currentlyPlaying.id);
		}
		else{
			currentIndex = currentPlayList.indexOf(audioElement.currentlyPlaying.id);
		}
	}

	function shuffleArray(array) {
  	  var currentIndex = array.length, temporaryValue, randomIndex;
  	  while (0 !== currentIndex) {
    	randomIndex = Math.floor(Math.random() * currentIndex);
   		currentIndex -= 1;
		temporaryValue = array[currentIndex]; 
		array[currentIndex] = array[randomIndex]; 
		array[randomIndex] = temporaryValue; 
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
							<img src="assets/images/icons/shuffle.png" alt="Shuffle" onclick="setShuffle()">
						</button>

						<button class="controlButton previous" title="Previous Song">
							<img src="assets/images/icons/previous.png" alt="Previous" onclick="prevSong()">
						</button>

						<button class="controlButton play" title="Play button" >
							<img src="assets/images/icons/play.png" alt="Play" onclick="playSong()">
						</button>

						<button class="controlButton pause" title="Pause button" style="display: none;">
							<img src="assets/images/icons/pause.png" alt="Pause" onclick="pauseSong()">
						</button>

						<button class="controlButton next" title="Next Song">
							<img src="assets/images/icons/next.png" alt="Next" onclick="nextSong()">
						</button>

						<button class="controlButton repeat" title="Repeat Song">
							<img src="assets/images/icons/repeat.png" alt="Repeat" onclick="setRepeat()">
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
						<img src="assets/images/icons/volume.png" alt="Volume" onclick="setMute()">
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