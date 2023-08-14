<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strix - Account</title>
    <link rel="stylesheet" href="./css/css_reset.css">
    <link rel="stylesheet" href="./css/predefine.css">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/account.css">
    <script src="./js/jquery.js"></script>
    <script src="./js/account.js"></script>
</head>
<body>
    <?php 
        session_start();

        $login = false;

        if (isset($_SESSION['username'])) {
            $login = true;
            $username = $_SESSION['username'];
        }

        else {
            header("location: ./login.php");
        }





        include_once("./app/dbInfo.php");

        $sqlStatement = "SELECT * FROM `user` WHERE userUsername = '$username'";

        if ($result = $mysqli -> query($sqlStatement)) {
            $numOfRows = $result -> num_rows;

            if ($numOfRows == 1) {
                $record = $result -> fetch_row();

                $userContactNo = $record[2];
                $userEmail = $record[3];
            }
        }

        $result -> free_result();
        $mysqli -> close();
    ?>


    <?php 
        include_once("./header.php");
    ?>

    
    <div id='main'>
        <div class="profileSection">
            <div class="header">
                <div class="subHeader">
                    <h1>Account</h1>
                    <span>Update your information here</span>
                </div>
            </div>
            <div id="updateProfileForm">
                <div class="inputDataSection">
                    <label>Username:</label>
                    <span class="userInfo"><?= $username ?></span>
                </div>
                <div class="inputDataSection">
                    <label>Contact Number:</label>
                    <span class="userInfo">+65 <?= $userContactNo ?></span>
                </div>
                <div class="inputDataSection">
                    <label>Email:</label>
                    <div class="editInput" id="emailEditSection">
                        <span class="userInfo" id="emailValue"><?= $userEmail ?></span>
                        <button id="editEmailBtn" title='Edit'>
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M13.94 5 19 10.06 9.062 20a2.25 2.25 0 0 1-.999.58l-5.116 1.395a.75.75 0 0 1-.92-.921l1.395-5.116a2.25 2.25 0 0 1 .58-.999L13.938 5Zm7.09-2.03a3.578 3.578 0 0 1 0 5.06l-.97.97L15 3.94l.97-.97a3.578 3.578 0 0 1 5.06 0Z" fill="#fff"/></svg>
                        </button>
                    </div>
                    <span class="errorMsg" id="userEmailError">Error Message</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>