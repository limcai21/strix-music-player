<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strix - Delete Song</title>
    <link rel="stylesheet" href="./css/css_reset.css">
    <link rel="stylesheet" href="./../css/predefine.css">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/delete.css">
    <script src="./js/jquery.js"></script>
    <script src="./js/global.js"></script>
    <script src="./js/delete.js"></script>
</head>
<body>
    <?php
        include_once("./process/dbInfo.php");
        include_once("./header.php");

        if (isset($_GET['error']) && $_GET['error'] == '921341') {
            echo "<div class='errorSection'>";
            echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2c5.523 0 10 4.478 10 10s-4.477 10-10 10S2 17.522 2 12 6.477 2 12 2Zm.002 13.004a.999.999 0 1 0 0 1.997.999.999 0 0 0 0-1.997ZM12 7a1 1 0 0 0-.993.884L11 8l.002 5.001.007.117a1 1 0 0 0 1.986 0l.007-.117L13 8l-.007-.117A1 1 0 0 0 12 7Z" fill="#fff"/></svg>';
            echo "<span>Something went wrong</span>";
            echo "</div>";
        }

        if (isset($_GET['success']) && $_GET['success'] == '761171') {
            echo "<div class='successSection'>";
            echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2Zm3.22 6.97-4.47 4.47-1.97-1.97a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l5-5a.75.75 0 1 0-1.06-1.06Z" fill="#fff"/></svg>';
            echo "<span>Song Deleted!</span>";
            echo "</div>";
        }
    ?>


    <div class="main" id="deleteMainDiv">
        <div class="header">
            <h1 id="title">Delete Song</h1>
        </div>

        <div class="deleteAndSelectSection">
            <select id="selectSong">
                <option disabled selected>-- Select Song --</option>
                <?php 
                    if (isset($_GET['album'])) {
                        $albumID = $_GET['album'];
                        $sqlStatement = "SELECT * FROM `song` RIGHT JOIN album ON album.albumID = song.albumIDFK WHERE albumIDFK = '$albumID' ORDER BY songTrackNo ASC";

                        if ($result = $mysqli -> query($sqlStatement)) {
                            $numOfRows = $result -> num_rows;
    
                            if ($numOfRows > 0) {
                                for ($i = 0; $i < $numOfRows; $i++) {
                                    $record = $result -> fetch_row();
                                    $songID = $record[0];
                                    $songTitle = $record[2];
                                    $songTrackNo = $record[3];
                                    $songArtist = $record[4];
                                    $songURL = $record[5];
                                    $songExplicit = $record[6];
                                    $songDuration = $record[7];
                                    $albumTitle = $record[9];
                                    $albumArtist = $record[11];

                                    echo "<script>document.getElementById('title').innerHTML = 'Delete Song<span>Album: $albumArtist - $albumTitle</span>'</script>";
    
                                    if (isset($_GET['album'])) {
                                        if (isset($_GET['id'])) {
                                            if ($songID == $_GET['id']) {
                                                echo "<option id = $songID selected>Track $songTrackNo - $songTitle</option>";
                                            }
        
                                            else {
                                                echo "<option id = $songID>Track $songTrackNo - $songTitle</option>";
                                            }
                                        }

                                        else {
                                            echo "<option id = $songID>Track $songTrackNo - $songTitle</option>";
                                        }
                                    }
                                }
                            }

                            else {
                                echo "<script>window.location = './delete_song.php'</script>";
                            }
                        }
                    }

                    else {
                        $sqlStatement = "SELECT * FROM `album`";

                        if ($result = $mysqli -> query($sqlStatement)) {
                            $numOfRows = $result -> num_rows;

                            if ($numOfRows > 0) {
                                for ($i = 0; $i < $numOfRows; $i++) {
                                    $record = $result -> fetch_row();
                                    $albumID = $record[0];
                                    $albumTitle = $record[1];
                                    $albumArtist = $record[3];
                                    
                                    $sqlStatement2 = "SELECT * FROM `song` WHERE albumIDFK = '$albumID' ORDER BY songTrackNo ASC";
                                    if ($result2 = $mysqli -> query($sqlStatement2)) {
                                        $numOfRows2 = $result2 -> num_rows;
                                        if ($numOfRows2 > 0) {
                                            echo '<optgroup label="' . $albumArtist . ' - ' . $albumTitle . '" id="' . $albumID . '">"';
                                            for ($y = 0; $y < $numOfRows2; $y++) {
                                                $record2 = $result2 -> fetch_row();
                                                $songID = $record2[0];
                                                $songTitle = $record2[2];
                                                $songTrackNo = $record2[3];
                                                $songArtist = $record2[4];

                                                if (isset($_GET['id']) && $_GET['id'] != "") {
                                                    if ($songID == $_GET['id']) {
                                                        echo "<option id = $songID selected>$songArtist - $songTitle</option>";
                                                        echo "<script>document.getElementById('title').innerHTML = 'Delete Song<span>Album: $albumArtist - $albumTitle</span>'</script>";
                                                    }
            
                                                    else {
                                                        echo "<option id = $songID>$songArtist - $songTitle</option>";
                                                    }
                                                }
                                                
                                                else {
                                                    echo "<option id = $songID>$songArtist - $songTitle</option>";
                                                }
                                            }

                                            echo "</optgroup>";
                                        }
                                    }

                                    else {
                                        echo "<option disabled selected>No song in this album</option>";
                                    }
                                }
                            }
                        }
                    }
                ?>
            </select>
            <?php 
                if (isset($_GET['id'])) {
                    $songID = $_GET['id'];
                    $sqlStatement = "SELECT * FROM song WHERE songID = '$songID'";

                    if ($result = $mysqli -> query($sqlStatement)) {
                        if ($result -> num_rows > 0) {
                            echo "<div class='actionBtn'>";
                            echo "<button id='deleteSongBtn'>Delete</button>";
                            echo "</div>";
                        }

                        else {
                            echo "<script>window.location = './delete_song.php'</script>";
                        }
                    }
                }
            ?>
        </div>
    </div>



    <?php 
        $result -> free_result();
        $mysqli -> close();
        
        include_once("../footer.php"); 
    ?>
</body>
</html>