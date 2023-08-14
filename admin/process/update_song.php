<?php 
    session_start();

    include_once("./dbInfo.php");

    $songID = $_POST['songID'];
    $songTitle = htmlspecialchars($_POST['songTitle']);
    $songTrackNo = $_POST['songTrackNo'];
    $songArtist = htmlspecialchars($_POST['songArtist']);
    $songURL = $_POST['songURL'];
    $songDuration = $_POST['songDuration'];
    $songExplicit = $_POST['songExplicit'];

    $sqlStatement = 'UPDATE `song` SET `songTitle`="' . $songTitle . '",`songTrackNo`="' . $songTrackNo . '",`songArtist`="' . $songArtist . '",`songURL`="' . $songURL . '",`songExplicit`="' . $songExplicit . '",`songDuration`="' . $songDuration . '" WHERE songID ="' . $songID . '"';

    if ($result = $mysqli -> query($sqlStatement)) {
        $affectRows = $mysqli -> affected_rows;
        
        if ($affectRows == 1) {
            header("location: ../edit_song.php?id=$songID&success=474737");
        }

        else {
            header("location: ../edit_song.php?id=$songID&error=520861");
        }
    }

    else {
        header("location: ../edit_song.php?id=$songID&error=921341");
    }

    $result -> free_result();
    $mysqli -> close();
?>