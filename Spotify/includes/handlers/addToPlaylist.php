<?php
    include("../config.php");

    if(isset($_POST['playlistId']) && !empty($_POST['playlistId']) && isset($_POST['songId']) && !empty($_POST['songId'])){
        $playlistId = $_POST['playlistId'];
        $songId   = $_POST['songId'];
        $query = mysqli_query($con, "SELECT MAX(playlistOrder) + 1 as playlistOrder FROM playlistSongs WHERE playlistId='$playlistId'");
        $row = mysqli_fetch_array($query);
        $order = $row['playlistOrder'];

        $q =  mysqli_query($con,"INSERT INTO playlistSongs SET songId = '$songId',playlistId = '$playlistId', playlistOrder = '$order'");
    }
    else {
        echo "Can not add to this Playlist";
    }

?>