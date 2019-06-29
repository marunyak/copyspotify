<?php 

include("includes/includedFiles.php");

if(isset($_GET['id']) && !empty($_GET['id'])){
    $playlistId = $_GET['id'];
}
else {
    header("Location: index.php");
}

$playlist = new Playlist($con,$playlistId);
$owner    = new User($con,$playlist->getOwner()); 
?>

<div class="entityInfo">
    <div class="leftSection">
        <div class="playlistImage">
            <img src="assets/images/artwork/1.jpg" alt="">
        </div>
    </div>

    <div class="rightSection">
        <h2><?php echo $playlist->getName();?></h2>
        <p>By <?php echo $playlist->getOwner();?></p>
        <p><?php echo $playlist->getNumberOfSongs();?> songs</p>
        <button class="button" onclick="deletePlaylist('<?php echo $playlistId;?>')">DELETE PLAYLIST</button>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
        <?php
            $songIdArray = $playlist->getSongsIds();
            $i = 1;
            foreach($songIdArray as $songId){
                $playlistSong = new Song($con,$songId);
                $albumArtist = $playlistSong->getArtist();

                echo "
                    <li class='tracklistRow'>
                        <div class='trackCount'>
                            <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"".$playlistSong->getId()."\",tempPlayList,true)'>
                            <span class='trackNumber'>{$i}</span>
                        </div>

                        <div class='trackInfo'>
                            <span class='trackName'>{$playlistSong->getTitle()}</span>
                            <span class='artistName'>{$albumArtist->getName()}</span>
                        </div>

                        <div class='trackOptions'>
                            <img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                        </div>

                        <div class='trackDuration'>
                            <span class='duration'>".$playlistSong->getDuration()."</span>
                        </div>
                    </li>
                ";
                $i++;
            }
        ?>

        <script>
            var tempPlayList = <?php echo json_encode($songIdArray);?>;
        </script>
    </ul>
</div>
