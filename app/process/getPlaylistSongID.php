<?php 
    include_once("../dbInfo.php");

    if (isset($_GET['playlistID'])) {
        if ($_GET['playlistID'] == '') {
            header("location: ../index.php");
        }

        else {
            $playlistID = $_GET['playlistID'];
        }
    }

    else {
        header("location: ../index.php");
    }

    $sqlStatement = "SELECT * FROM `playlist_songs` WHERE playlistIDFK = '$playlistID' ORDER BY `playlistSongID` ASC";

    $returnJSON = array();

    if ($result = $mysqli -> query($sqlStatement)) {
        $numOfRows = $result -> num_rows;

        for ($i = 0; $i <$numOfRows; $i++) {
            $record = $result -> fetch_row();
            $songID = $record[2];

            
            $returnJSON[] = array(
                "songID" => $songID,
            );
        }
    }  
    
    else {
        $returnJSON[] = array(
            "status" => false,
        );
    }

    echo json_encode($returnJSON, JSON_PRETTY_PRINT);

    $result -> free_result();
    $mysqli -> close();
?>