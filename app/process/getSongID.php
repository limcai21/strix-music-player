<?php 
    include_once("../dbInfo.php");

    if (isset($_GET['albumID'])) {
        if ($_GET['albumID'] == '') {
            header("location: ../index.php");
        }

        else {
            $albumID = $_GET['albumID'];
        }
    }

    else {
        header("location: ../index.php");
    }

    $sqlStatement = "SELECT * FROM `song` WHERE albumIDFK = '$albumID' ORDER BY `songTrackNo` ASC";

    $returnJSON = array();

    if ($result = $mysqli -> query($sqlStatement)) {
        $numOfRows = $result -> num_rows;

        for ($i = 0; $i <$numOfRows; $i++) {
            $record = $result -> fetch_row();
            $songID = $record[0];
            $songURL = $record[5];

            
            $returnJSON[] = array(
                "songID" => $songID,
            );
        }
    }

    $result -> free_result();
    $mysqli -> close();

    echo json_encode($returnJSON, JSON_PRETTY_PRINT);
?>