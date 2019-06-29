<?php
    include("../config.php");

    if(isset($_POST['playlistId']) && !empty($_POST['playlistId']) && isset($_POST['songId']) && !empty($_POST['songId'])){
        $playlistId = $_POST['playlistId'];
        $songId   = $_POST['songId'];
        $query = mysqli_query($con, "DELETE FROM playlistSongs WHERE playlistId='$playlistId' AND songId='$songId'");
        
    }
    else {
        echo "Can not remove this song";
    }

?>