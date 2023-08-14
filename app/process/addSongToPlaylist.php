<?php 
    include_once("../dbInfo.php");

    if (isset($_POST['songID'])) {
        $songID = $_POST['songID'];
        $playlistID = $_POST['playlistID'];
    }

    else {
        header("location: ../index.php");
    }


    
    $returnJSON = array();
    $sqlStatement = "INSERT INTO `playlist_songs`(`playlistIDFK`, `songID`, `favOrNot`) VALUES ('$playlistID','$songID', 0)";

    if ($result = $mysqli -> query($sqlStatement)) {
        $returnJSON[] = array(
            "status" => true,
        );
    }

    else {
        $returnJSON[] = array(
            "status" => false,
            "title" => "Something went wrong try again later",
        );
    }

    $mysqli -> close();

    echo json_encode($returnJSON, JSON_PRETTY_PRINT);
?>