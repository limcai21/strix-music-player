<?php 
    session_start();

    include_once("../dbInfo.php");

    if (!isset($_POST['playlistID'])) {
        header("location: ../index.php");
    } 
    
    else {
        $username = $_SESSION['username'];
        $playlistCover = $_POST['playlistCover'];
        $playlistID = $_POST['playlistID'];
    }

    $returnJSON = array();
    $sqlStatement = "UPDATE `playlist` SET `playlistCover`='$playlistCover' WHERE playlistID = '$playlistID'";

    if ($mysqli -> query($sqlStatement)) {
        $returnJSON[] = array(
            "status" => true,
        );
    }

    else {
        $returnJSON[] = array(
            "status" => false,
            "error" => $mysqli -> error
        );
    }


    echo json_encode($returnJSON, JSON_PRETTY_PRINT);

    $mysqli -> close();
?>