<?php 
    session_start();

    include_once("../app/dbInfo.php");

    $userUsername = $_POST['userUsername'];
    $userPassword = md5($_POST['userPassword']);



    $sqlStatement = "SELECT * FROM `user` WHERE userUsername = '$userUsername' AND userPassword = '$userPassword'";
    
    if ($result = $mysqli -> query($sqlStatement)) {
        $numOfRow = $result -> num_rows;
        
        if ($numOfRow > 0) {
            $record = $result -> fetch_row();
            $userID = $record[0];
            $username = $record[1];
            $adminOrUser = $record[5];
            $_SESSION['username'] = $username;
            $_SESSION['adminOrUser'] = $adminOrUser;
            $_SESSION['userID'] = $userID;

            if ($adminOrUser == 0) {
                // USER
                header("location: ../app/library.php");
            }

            else {
                // ADMIN
                header("location: ../admin/");
            }
        }

        else {
            // INVALID PASSWORD OR USERNAME
            header("location: ../login.php?error=887619");
        }
    }

    else {
        header("location: ../login.php?error=921341");
    }
?>