<?php 
    include_once("../app/dbInfo.php");


    if (!isset($_POST['userUsername'])) {
       header("location: ../signup.php");
    }


    $userUsername = $_POST['userUsername'];
    $userContactNo = $_POST['userContactNo'];
    $userEmail = $_POST['userEmail'];
    $userPassword = md5($_POST['userPassword']);
    


    
    // check username and email must not exist
    $sqlStatement = "SELECT * FROM `user` WHERE userUsername = '$userUsername' OR userEmail = '$userEmail'";


    if ($result = $mysqli -> query($sqlStatement)) {
        $numOfRow = $result -> num_rows;
        
        if ($numOfRow > 0) {
            // go back to sign up say this email or username has been taken
            header("location: ../signup.php?error=137197");
        }

        else {
            // INSERT INTO USER
            $sqlStatement = "INSERT INTO `user`(`userUsername`, `userContactNo`, `userEmail`, `userPassword`, `adminOrUser`) VALUES ('$userUsername', '$userContactNo', '$userEmail','$userPassword', 0)";

            if ($mysqli -> query($sqlStatement)) {
                // CREATE A FAVOURITE PLAYLIST FOR USER
                $userID = $mysqli -> insert_id;
                $defaultCover = "";
                $sqlStatement = "INSERT INTO `playlist` (`playlistName`, `playlistOwner`, `playlistPrivate`, `playlistCover`) VALUES ('Favourites','$userID', 1, '')";

                if ($mysqli -> query($sqlStatement)) {
                    header("location: ../login.php?success=868220");
                }
                
                else {
                    header(".location: ./signup.php?error=429516");
                }
            }

            else {
                header(".location: ./signup.php?error=429516");
            }
        }
    }

    else {
        header("location: ../signup.php?error=921341");
    }
?>