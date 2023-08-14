<?php 
    session_start();
    include_once("../dbInfo.php");

    if (isset($_POST['playlistID'])) {
        if ($_POST['playlistID'] == '') {
            header("location: ../index.php");
        }

        else {
            $playlistID = $_POST['playlistID'];
            $userID = $_SESSION['userID'];
        }
    }

    else {
        header("location: ../index.php");
    }


    $sqlStatement = "DELETE FROM `playlist` WHERE playlistID = '$playlistID' AND playlistOwner = '$userID'";
    $returnJSON = array();

    if ($mysqli -> query($sqlStatement)) {
        $sqlStatement = "SELECT * FROM `playlist_songs` WHERE playlistIDFK = '$playlistID'";

        if ($result = $mysqli -> query($sqlStatement)) {
            $numOfRows = $result -> num_rows;

            if ($numOfRows > 0) {
                for ($i = 0; $i < $numOfRows; $i++) {
                    $sqlStatement = "DELETE FROM `playlist_songs` WHERE playlistIDFK = '$playlistID'";
                    
                    if ($mysqli -> query($sqlStatement)) {
                        $returnJSON[] = array(
                            "status" => true,
                        );
                    }

                    else {
                        $returnJSON[] = array(
                            "status" => false,
                        );
                    }
                }
            }

            else {
                $returnJSON[] = array(
                    "status" => true,
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

    $result -> free_result();
    $mysqli -> close();
    
    echo json_encode($returnJSON, JSON_PRETTY_PRINT);
?>
