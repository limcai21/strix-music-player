<?php 
    session_start();
    include_once("../app/dbInfo.php");

    if (!isset($_POST['userEmail'])) {
        header("location: ../account.php");
    }

    $userEmail = $_POST['userEmail'];
    $userUsername = $_SESSION['username'];


    
    // check username and email must not exist
    $sqlStatement = "SELECT * FROM `user` WHERE userEmail = '$userEmail'";


    if ($result = $mysqli -> query($sqlStatement)) {
        $numOfRow = $result -> num_rows;
        
        if ($numOfRow > 0) {
            $returnJSON[] = array(
                "status" => "3",
            );
        }

        else {
            // UPDATE 
            $sqlStatement = "UPDATE `user` SET `userEmail`='$userEmail' WHERE userUsername = '$userUsername'";

            if ($result = $mysqli -> query($sqlStatement)) {
                $affectedRows = $mysqli -> affected_rows;
                if ($affectedRows == 1) {
                    $returnJSON[] = array(  
                        "status" => "1",
                    );
                }

                else {
                    $returnJSON[] = array(  
                        "status" => "2",
                    );
                }
            }

        }
    }

    else {
        $returnJSON[] = array(
            "status" => "2",
        );
    }


    echo json_encode($returnJSON, JSON_PRETTY_PRINT);
?>