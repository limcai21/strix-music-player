<?php 
    session_start();

    include_once("./dbInfo.php");

    $albumCoverURL = $_POST['albumCover'];
    $albumTitle = htmlspecialchars($_POST['albumTitle']);
    $albumArtist = htmlspecialchars($_POST['albumArtist']);
    $albumReleaseDate = $_POST['albumReleaseDate'];
    $albumGenre = $_POST['albumGenre'];

    $sqlStatement = 'INSERT INTO `album`(`albumTitle`, `albumCover`, `albumArtist`, `albumReleaseDate`, `albumGenreFK`) VALUES ("' . $albumTitle . '" , "' . $albumCoverURL . '" , "' . $albumArtist . '" , "' . $albumReleaseDate . '" , "' . $albumGenre . '")';

    if ($result = $mysqli -> query($sqlStatement)) {
        header("location: ../add_album.php?success=207839");
    }

    else {
        header("location: ../add_album.php?error=921341");
    }

    $result -> free_result();
    $mysqli -> close();
?>