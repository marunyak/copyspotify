<?php
    include("../config.php");

    if(isset($_POST['playlistId']) && !empty($_POST['playlistId'])){
        $id = $_POST['playlistId'];
        $Playlistquery = mysqli_query($con, "DELETE FROM playlists WHERE id = '$id'");
        $Songquery     = mysqli_query($con, "DELETE FROM playlistSongs WHERE playlistId = '$id'");
    }
    else {
        echo "Can not delete playlist";
    }
?>