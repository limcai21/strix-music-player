<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strix - Add Album</title>
    <link rel="stylesheet" href="./css/css_reset.css">
    <link rel="stylesheet" href="./../css/predefine.css">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/add.css">
    <script src="./js/jquery.js"></script>
    <script src="./js/global.js"></script>
    <script src="./js/add.js"></script>
</head>
<body>
    <?php 
        session_start();
        include_once("./header.php");
    ?>

    <?php 
        date_default_timezone_set('Asia/Singapore');
        include_once("./process/dbInfo.php");

        if (isset($_GET['error']) && $_GET['error'] == '921341') {
            echo "<div class='errorSection'>";
            echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2c5.523 0 10 4.478 10 10s-4.477 10-10 10S2 17.522 2 12 6.477 2 12 2Zm.002 13.004a.999.999 0 1 0 0 1.997.999.999 0 0 0 0-1.997ZM12 7a1 1 0 0 0-.993.884L11 8l.002 5.001.007.117a1 1 0 0 0 1.986 0l.007-.117L13 8l-.007-.117A1 1 0 0 0 12 7Z" fill="#fff"/></svg>';
            echo "<span>Something went wrong</span>";
            echo "</div>";
        }

        if (isset($_GET['success']) && $_GET['success'] == '207839') {
            echo "<div class='successSection'>";
            echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2Zm3.22 6.97-4.47 4.47-1.97-1.97a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l5-5a.75.75 0 1 0-1.06-1.06Z" fill="#fff"/></svg>';
            echo "<span>Album added!</span>";
            echo "</div>";
        }
    ?>

    <div class="main" id="addAlbumMainDiv">
        <div class="left">
            <div class="header">
                <h1>New Album</h1>
                <button onclick="window.location='./add_song.php'">Add Song</button>
            </div>

            <form action="./process/add_album.php" method="post" id="addAlbumForm">
                <div class="inputDataSection">
                    <label for="albumCover">Album Art URL:</label>
                    <input type="text" name="albumCover" id="albumCover" required value="https://thechive.com/wp-content/uploads/2019/12/person-hilariously-photoshops-animals-onto-random-things-xx-photos-25.jpg">
                </div>
                <div class="inputDataSection">
                    <label for="albumTitle">Title:</label>
                    <input type="text" name="albumTitle" id="albumTitle" required value="Album Title">
                </div>
                <div class="inputDataSection">
                    <label for="albumTitle">Artist:</label>
                    <input type="text" name="albumArtist" id="albumArtist" required value="Album Artist">
                </div>
                <div class="inputDataSection">
                    <label for="albumReleaseDate">Release Date:</label>
                    <input type="date" name="albumReleaseDate" id="albumReleaseDate" value="<?php echo date('Y-m-d') ?>" required>
                </div>
                <div class="inputDataSection">
                    <label for="albumGenre">Genre:</label>
                    <select name="albumGenre" id="albumGenre" required>
                        <option selected disabled value=''>Select an Option</option>
                        <?php 
                            $sqlStatement = "SELECT * FROM `genre` ORDER BY genreTitle ASC";

                            if ($result = $mysqli -> query($sqlStatement)) {
                                $numOfRows = $result -> num_rows;

                                for ($i = 0; $i < $numOfRows; $i++) {
                                    $record = $result -> fetch_row();

                                    $genreID = $record[0];
                                    $genreTitle = $record[1];

                                    echo "<option value='$genreID' selected>$genreTitle</option>";
                                }
                            }

                            else {
                                $error = $mysqli -> error;
                                echo "<span class='errorQuery'>$error</span>";
                            }
                        ?>
                    </select>
                </div>

                <input type="submit" value="Create Album" id="createAlbumBtn">
                
            </form>
        </div>

        <div class="right">
            <div class="albumCoverDisplay">
                Album Art Preview
            </div>
        </div>
    </div>



    <?php 
        $result -> free_result();
        $mysqli -> close();
        
        include_once("../footer.php"); 
    ?>
</body>
</html>