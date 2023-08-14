<?php 
    session_start();

    include_once("./dbInfo.php");

    $albumID = $_POST['albumID'];

    $sqlStatement = "DELETE FROM `album` WHERE albumID = '$albumID'";

    if ($result = $mysqli -> query($sqlStatement)) {
        $affectRows = $mysqli -> affected_rows;
        
        if ($affectRows == 1) {
            // DELETE SONG NOW
            $sqlStatement = "DELETE FROM `song` WHERE albumIDFK = '$albumID'";
            if ($result = $mysqli -> query($sqlStatement)) {                
                $affectRows = $mysqli -> affected_rows;

                if ($affectRows > 0) {
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