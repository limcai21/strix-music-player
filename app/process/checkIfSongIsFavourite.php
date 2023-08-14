<?php 
    session_start();

    include_once("../dbInfo.php");

    if (isset($_GET['songID'])) {
        if ($_GET['songID'] == '') {
            header("location: ../index.php");
        }

        else {
            $songID = $_GET['songID'];
            $userID = $_SESSION['userID'];
        }
    }

    else {
        header("location: ../index.php");
    }


    $heartFillSVG = '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12.82 5.58-.82.822-.824-.824a5.375 5.375 0 1 0-7.601 7.602l7.895 7.895a.75.75 0 0 0 1.06 0l7.902-7.897a5.376 5.376 0 0 0-.001-7.599 5.38 5.38 0 0 0-7.611 0Z" fill="#fff"/></svg>';
    $heartOutlineSVG = '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12.82 5.58-.82.822-.824-.824a5.375 5.375 0 1 0-7.601 7.602l7.895 7.895a.75.75 0 0 0 1.06 0l7.902-7.897a5.376 5.376 0 0 0-.001-7.599 5.38 5.38 0 0 0-7.611 0Zm6.548 6.54L12 19.485 4.635 12.12a3.875 3.875 0 1 1 5.48-5.48l1.358 1.357a.75.75 0 0 0 1.073-.012L13.88 6.64a3.88 3.88 0 0 1 5.487 5.48Z" fill="#fff"/></svg>';


    $sqlStatement = "SELECT * FROM `playlist` WHERE playlistOwner = '$userID' AND playlistName = 'Favourites'";

    if ($result = $mysqli -> query($sqlStatement)) {
        $numOfRows = $result -> num_rows;
        $record = $result -> fetch_row();
        $playlistID = $record[0];


        if ($numOfRows == 1) {
            $sqlStatement = "SELECT * FROM `playlist_songs` WHERE playlistIDFK = '$playlistID' AND songID = '$songID'";

            if ($result = $mysqli -> query($sqlStatement)) {
                $numOfRows = $result -> num_rows;


                // ALR FAV 
                if ($numOfRows == 1) {
                    $returnJSON[] = array(
                        "status1" => true,
                        "svg1" => $heartFillSVG
                    );
                }

                // NOT FAVOUTITE YET 
                else {
                    $returnJSON[] = array(
                        "status1" => false,
                        "svg1" => $heartOutlineSVG
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
