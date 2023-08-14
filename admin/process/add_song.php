<?php 
    session_start();

    include_once("./dbInfo.php");

    $songTitle = htmlspecialchars($_POST['songTitle']);
    $songTrackNo = $_POST['songTrackNo'];
    $songArtist = htmlspecialchars($_POST['songArtist']);
    $songURL = $_POST['songURL'];
    $songDuration = $_POST['songDuration'];
    $songExplicit = $_POST['songExplicit'];
    $albumID = $_POST['albumID'];

    $sqlStatement = 'INSERT INTO `song`(`albumIDFK`, `songTitle`, `songTrackNo`, `songArtist`, `songURL`, `songExplicit`, `songDuration`) VALUES ("' . $albumID . '", "' . $songTitle . '", "' . $songTrackNo . '", "' . $songArtist . '", "' . $songURL . '", "' . $songExplicit . '", "' . $songDuration . '")';

    if ($result = $mysqli -> query($sqlStatement)) {
        header("location: ../add_song.php?id=$albumID&success=689017");
    }

    else {
        header("location: ../add_song.php?id=$albumID&error=921341");
    }

    $result -> free_result();
    $mysqli -> close();
?>