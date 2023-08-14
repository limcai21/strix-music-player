<?php 
    session_start();

    include_once("../dbInfo.php");

    if (!isset($_POST['playlistTitle'])) {
        header("location: ../index.php");
    } 
    
    else {
        $username = $_SESSION['username'];
        $playlistTitle = $_POST['playlistTitle'];
        $playlistID = $_POST['playlistID'];
    }

    $returnJSON = array();

    // CHECK IF USER GOT THIS SAME NAME IN PLAYLIST
    $sqlStatement = "SELECT * FROM `playlist` WHERE `playlistName`='$playlistTitle'";

    if ($result = $mysqli -> query($sqlStatement)) {
        $numOfRows = $result -> num_rows;

        if ($numOfRows == 0) {
            $sqlStatement = "UPDATE `playlist` SET `playlistName`='$playlistTitle' WHERE playlistID = '$playlistID'";

            if ($mysqli -> query($sqlStatement)) {
                $returnJSON[] = array(
                    "status" => '1',
                );
            }

            else {
                $returnJSON[] = array(
                    "status" => '2',
                    "error" => "Something went wrong, try again later"
                );
            }
        }

        else {
            $returnJSON[] = array(
                "status" => '3',
                "error" => "Playlist name already used"
            );
        }
    }

    else {
        $returnJSON[] = array(
            "status" => '2',
            "error" => "Something went wrong, try again later"
        );
    }


    $result -> free_result();
    $mysqli -> close();

    echo json_encode($returnJSON, JSON_PRETTY_PRINT);
?>