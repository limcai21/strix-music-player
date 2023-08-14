<?php 
    session_start();

    include_once("./dbInfo.php");

    $songID = $_POST['songID'];

    $sqlStatement = "DELETE FROM `song` WHERE songID = '$songID'";

    if ($result = $mysqli -> query($sqlStatement)) {
        $affectRows = $mysqli -> affected_rows;
        
        if ($affectRows == 1) {
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

    $mysqli -> close();

    echo json_encode($returnJSON, JSON_PRETTY_PRINT);

?>