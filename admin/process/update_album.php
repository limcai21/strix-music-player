<?php 
    session_start();

    include_once("./dbInfo.php");

    $albumID = $_POST['albumID'];
    $albumCoverURL = $_POST['albumCover'];
    $albumTitle = htmlspecialchars($_POST['albumTitle']);
    $albumArtist = htmlspecialchars($_POST['albumArtist']);
    $albumReleaseDate = $_POST['albumReleaseDate'];
    $albumGenre = $_POST['albumGenre'];

    $sqlStatement = 'UPDATE `album` SET `albumTitle`="' . $albumTitle . '", `albumCover`= "' . $albumCoverURL . '", `albumArtist`="' . $albumArtist . '", `albumReleaseDate`="' . $albumReleaseDate . '", `albumGenreFK`="' . $albumGenre . '" WHERE albumID = "' . $albumID . '"';

    if ($result = $mysqli -> query($sqlStatement)) {
        $affectRows = $mysqli -> affected_rows;
        
        if ($affectRows == 1) {
            header("location: ../edit_album.php?id=$albumID&success=668640");
        }

        else {
            header("location: ../edit_album.php?id=$albumID&error=520861");
        }
    }

    else {
        header("location: ../edit_album.php?id=$albumID&error=921341");
    }

    $result -> free_result();
    $mysqli -> close();
?>