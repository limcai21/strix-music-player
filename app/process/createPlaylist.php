<?php 
    session_start();

    include_once("../dbInfo.php");

    if (!isset($_SESSION['userID'])) {
        header("location: ../index.php");
    }

    // CHECK IF THIS PAGE IS ACCESS DIRECTLY FROM URL
    if (!isset($_SERVER['HTTP_REFERER'])) {
        header("location: ../index.php");
    }


    $username = $_SESSION['username'];
    $userID = $_SESSION['userID'];
    $returnJSON = array();

    $sqlStatement = "SELECT * FROM `playlist` WHERE playlistOwner = '$userID'";

    if ($result = $mysqli -> query($sqlStatement)) {
        $numOfRows = $result -> num_rows;
        $sqlStatement = "INSERT INTO `playlist`(`playlistName`, `playlistOwner`, `playlistPrivate`, `playlistCover`) VALUES ('My Playlist #$numOfRows', '$userID', '1', '')";

        if ($mysqli -> query($sqlStatement)) {
            $insertID = $mysqli -> insert_id;

            $sqlStatement = "UPDATE `playlist` SET `playlistName` = 'My Playlist #$insertID' WHERE playlistID = '$insertID'";
            if ($result = $mysqli -> query($sqlStatement)) {
                $returnJSON[] = array(
                    "playlistID" => $insertID,
                    "status" => true,
                );
            }

            else {
                $returnJSON[] = array(
                    "status" => false,
                );
            }
        }  
        
        else {
            $returnJSON[] = array(
                "status" => false,
            );
        }
    }

    else {
        $returnJSON[] = array(
            "status" => false,
        );
    }

    $mysqli -> close();

    echo json_encode($returnJSON, JSON_PRETTY_PRINT);
?>
