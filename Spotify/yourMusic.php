<?php
    include("includes/includedFiles.php");
?>

<div class="playlistsContainer">
    <div class="gridViewContainer">
        <h2>PLAYLISTS</h2>

        <div class="buttonItems">
            <button class="button green" onclick="createPlaylist()">NEW PLAYLIST</button>
        </div>

        <?php
        $username = $userLoggedIn->getUserName();

        $playlistsQuery = mysqli_query($con,"SELECT * FROM playlists WHERE owner = '$username'");
        while($row = mysqli_fetch_array($playlistsQuery)){

            if(mysqli_num_rows($playlistsQuery) == 0){
                echo "<span class='noResults'>No founds playlists</span>";
            }
            $playlist = new Playlist($con, $row);
            echo "
            <div class='gridViewItem'>
                <div class='playlistImage'><img  src='assets/images/artwork/1.jpg'></div>
                <div class='gridViewInfo'>".$playlist->getName()."</div>
            </div>";
        }
        ?>

    </div>
</div>