<?php include("includes/includedFiles.php");

if(isset($_GET['term']) && !empty($_GET['term'])){
    $term = urldecode($_GET['term']);
}
else{
    $term = "";
}
?>
<div class="searchContainer">
    <h4>Search for an album,artist,song</h4>
    <input type="text" class="searchInput" value="<?php echo $term;?>" placeholder="Start typing..." onfocus="this.value=this.value">
</div>

<script>
$(function(){
    $(".searchInput").keyup(function(){
        clearTimeout(timer);
        timer = setTimeout(function(){
            var val = $(".searchInput").val();
            openPage("search.php?term="+val)
        },2000);
    })
});
</script>
<?php if($term == "") exit();?>
<div class="tracklistContainer borderBottom">
<h2>SONGS</h2>
    <ul class="tracklist">
        <?php
            $songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '%$term%' LIMIT 10");

            if(mysqli_num_rows($songsQuery) == 0){
                echo "<span class='noResults'>No founds ".$term."</span>";
            }
            $songIdArray = array();
            $i = 1;
            while($row = mysqli_fetch_array($songsQuery)){
                $songId  = $row['id'];

                if($i > 15) break;

                array_push($songIdArray,$songId);
                $albumSong = new Song($con,$songId);
                $albumArtist = $albumSong->getArtist();

                echo "
                    <li class='tracklistRow'>
                        <div class='trackCount'>
                            <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"".$albumSong->getId()."\",tempPlayList,true)'>
                            <span class='trackNumber'>{$i}</span>
                        </div>

                        <div class='trackInfo'>
                            <span class='trackName'>{$albumSong->getTitle()}</span>
                            <span class='artistName'>{$albumArtist->getName()}</span>
                        </div>

                        <div class='trackOptions'>
                            <input type='hidden' class='songId' value='".$albumSong->getId()."'>
                            <img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                        </div>

                        <div class='trackDuration'>
                            <span class='duration'>".$albumSong->getDuration()."</span>
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

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistsDropdown($con,$userLoggedIn->getUserName());?>
</nav>

<div class="artistsContainer borderBottom">
    <h2>ARTIST</h2>
    <?php
        $artistQuery = mysqli_query($con,"SELECT id FROM artists WHERE name LIKE '%$term%' LIMIT 10");
        
        if(mysqli_num_rows($artistQuery) == 0){
            echo "<span class='noResults'>No founds ".$term."</span>";
        }
        
        while($row = mysqli_fetch_array($artistQuery)){
            $artistFound = new Artist($con,$row["id"]);
            echo "<div class='searchResultRow'>
                    <div class='artistName'>
                        <span  role='link' tabindex='0' onclick='openPage(\"artist.php?id=".$artistFound->getId()."\")' >".$artistFound->getName()."</span>
                    </div>
                </div>";
        }

    ?>
</div>

<div class="gridViewContainer">
<h2>ALBUMS</h2>
    <?php
        $albumQuery = mysqli_query($con,"SELECT * FROM albums WHERE title LIKE '%$term%' LIMIT 10");
        while($row = mysqli_fetch_array($albumQuery)){

            if(mysqli_num_rows($albumQuery) == 0){
                echo "<span class='noResults'>No founds ".$term."</span>";
            }

            echo "
            <div class='gridViewItem'>
                <a  role='link' tabindex='0' onclick='openPage(\"album.php?id=".$row['id']."\")' >
                    <img src='".$row['artworkPath']."'>
                    <div class='gridViewInfo'>".$row['title']."</div>
                </a>
            </div>";
        }
    ?>
</div>