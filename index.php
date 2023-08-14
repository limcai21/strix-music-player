<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strix</title>
    <link rel="stylesheet" href="./css/css_reset.css">
    <link rel="stylesheet" href="./css/predefine.css">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/index.css">
    <script src="./js/jquery.js"></script>
    <script src="./js/index.js"></script>
</head>
<body>
    <?php 
        session_start();
        date_default_timezone_set('Asia/Singapore');

        $login = false;

        if (isset($_SESSION['username'])) {
            $login = true;
        }
    ?>


    <?php 
        include_once("./header.php");
    ?>




    <div id='main'>
        <div class="left">
            <div class="heading">
                <?php 
                    if ($login) {
                        echo "<h1>More Waiting</h1>";
                        echo "<h1>For You</h1>";
                    }

                    else {
                        echo "<h1>All the Songs</h1>";
                        echo "<h1>Right Here</h1>";
                    }
                ?>
                <h1>At Strix</h1>
                <?php
                    if ($login) {
                        echo "<span class='marginTop5'>&#x1F970;&#x1F60D;&#x1F618;</span>";
                    }

                    else {
                        echo "<span class='marginTop5'>And it's free! No ads!</span>";
                    }
                ?>
            </div>
            <?php 
                if ($login) {
                    echo "<button onclick='window.location = `./app/`' accent='btnTextOnly'>Listen</button>";
                }

                else {
                    echo "<button onclick='window.location = `./signup.php`' accent='btnTextOnly'>Try Now</button>";
                }
            ?>
        </div>

        <div class="right">
            <div class="albumShowcase">
                <?php 
                    include_once("./app/dbInfo.php");

                    $sqlStatement = "SELECT * FROM `album` ORDER BY RAND() ASC LIMIT 5";

                    if ($result = $mysqli->query($sqlStatement)) {
                        $numOfRows = $result->num_rows;

                        for ($i = 0; $i < $numOfRows; $i++) {
                            $record = $result->fetch_row();

                            $albumID = $record[0];
                            $albumTitle = $record[1];
                            $albumCover = $record[2];
                            $albumArtist = $record[3];
                            $albumReleaseDate = $record[4];
                            $albumGenreFK = $record[5];

                            echo "<div class='albumCover' id=$albumID>";
                            echo "<img src='$albumCover' alt='$albumTitle Album Cover'>";
                            echo "<div class='albumTitleDiv'>";
                            echo "<span class='albumTitle'>$albumTitle</span>";
                            echo "<span class='albumArtist'>$albumArtist</span>";
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                ?>
            </div>
        </div>
    </div>





    <?php 
        $result -> free_result();
        $mysqli -> close();

        include_once("./footer.php") 
    ?>
</body>
</html>