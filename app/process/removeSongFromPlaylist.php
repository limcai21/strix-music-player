<?php 
    include_once("../dbInfo.php");

    if (!isset($_POST['playlistSongID'])) {
        header("location: ../index.php");
    } 
    
    else {
        $playlistSongID = $_POST['playlistSongID'];
        $playlistID = $_POST['playlistID'];
    }


    $sqlStatement = "DELETE FROM `playlist_songs` WHERE playlistIDFK = '$playlistID' AND playlistSongID = '$playlistSongID' ";

    $returnJSON = array();

    if ($result = $mysqli -> query($sqlStatement)) {
        $returnJSON[] = array(
            "status" => true,
        );
    }

    else {
        $returnJSON[] = array(
            "title" => "Something went wrong, try again later",
            "status" => false,
        );
    }
        
    $mysqli -> close();

    echo json_encode($returnJSON, JSON_PRETTY_PRINT);
?>