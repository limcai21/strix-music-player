<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strix - Edit Song</title>
    <link rel="stylesheet" href="./css/css_reset.css">
    <link rel="stylesheet" href="./../css/predefine.css">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/edit.css">
    <script src="./js/jquery.js"></script>
    <script src="./js/global.js"></script>
    <script src="./js/edit.js"></script>
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

        if (isset($_GET['error']) && $_GET['error'] == '520861') {
            echo "<div class='errorSection'>";
            echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2c5.523 0 10 4.478 10 10s-4.477 10-10 10S2 17.522 2 12 6.477 2 12 2Zm.002 13.004a.999.999 0 1 0 0 1.997.999.999 0 0 0 0-1.997ZM12 7a1 1 0 0 0-.993.884L11 8l.002 5.001.007.117a1 1 0 0 0 1.986 0l.007-.117L13 8l-.007-.117A1 1 0 0 0 12 7Z" fill="#fff"/></svg>';
            echo "<span>There is no change in data</span>";
            echo "</div>";
        }

        if (isset($_GET['success']) && $_GET['success'] == '474737') {
            echo "<div class='successSection'>";
            echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2Zm3.22 6.97-4.47 4.47-1.97-1.97a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l5-5a.75.75 0 1 0-1.06-1.06Z" fill="#fff"/></svg>';
            echo "<span>Song Updated!</span>";
            echo "</div>";
        }
    ?>


    <div class="main" id="editMainDiv">
        <?php 
            if (!isset($_GET['id'])) {
        ?>
            <div class="header">
                <h1 id="title">Edit Song</h1>
            </div>
            
            <select id="selectSong">
                <?php 
                    if (isset($_GET['album'])) {
                        $albumID = $_GET['album'];
                        $sqlStatement = "SELECT * FROM `song` RIGHT JOIN album ON album.albumID = song.albumIDFK WHERE albumIDFK = '$albumID' ORDER BY songTrackNo ASC";

                        if ($result = $mysqli -> query($sqlStatement)) {
                            $numOfRows = $result -> num_rows;
                            if ($numOfRows > 0) {
                                echo "<option disabled selected>-- Select Song --</option>";
                                for ($i = 0; $i < $numOfRows; $i++) {
                                    $record = $result -> fetch_row();
                                    $songID = $record[0];
                                    $songTitle = $record[2];
                                    $songTrackNo = $record[3];
                                    $albumTitle = $record[9];
                                    $albumArtist = $record[11];

                                    echo "<option id = $songID>Track $songTrackNo - $songTitle</option>";
                                }
                            }

                            else {
                                echo "<script>window.location = './edit_song.php'</script>";
                            }
                        }

                        echo "<script>document.getElementById('title').innerHTML = 'Edit Song<span>Album: $albumArtist - $albumTitle</span>'</script>";
                    }

                    else {
                        $sqlStatement = "SELECT * FROM `album`";

                        if ($result = $mysqli -> query($sqlStatement)) {
                            $numOfRows = $result -> num_rows;

                            if ($numOfRows > 0) {
                                echo "<option disabled selected>-- Select Song --</option>";
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

                                                echo "<option id = $songID>$songArtist - $songTitle</option>";
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
            }

            else {
                $songID = $_GET['id'];
                $sqlStatement = "SELECT * FROM `song` RIGHT JOIN album ON album.albumID = song.albumIDFK WHERE songID = '$songID'";

                if ($result = $mysqli -> query($sqlStatement)) {
                    $numOfRows = $result -> num_rows;

                    if ($numOfRows > 0) {
                        $record = $result -> fetch_row();
                        $songID = $record[0];
                        $albumIDFK = $record[1];
                        $songTitle = $record[2];
                        $songTrackNo = $record[3];
                        $songArtist = $record[4];
                        $songURL = $record[5];
                        $songExplicit = $record[6];
                        $songDuration = $record[7];
                        $selected1 = '';
                        $selected = '';
                        $albumTitle = $record[9];
                        $albumArtist = $record[11];

                        if ($songExplicit == "1") {
                            $selected1 = 'checked';
                        } 

                        else {
                            $selected = 'checked';
                        }
                    }

                    else {
                        echo "<script>window.location = './edit_song.php'</script>";
                    }
                }
        ?>
            <div class="header">
                <h1>Edit Song</h1>
                <button onclick="window.location='./edit_album.php?id=<?= $albumIDFK ?>'">Edit Album</button>
            </div>

            <form action="./process/update_song.php" method="post" id="editSongForm">
                <?php 
                    echo "<div class='inputDataSection'>";
                    echo "<label>Album:</label>";
                    echo "<span class='albumTitle'>" . $albumArtist . " - " . $albumTitle . "</span>";
                    echo "</div>";
                ?>
                <div class="inputDataSection">
                    <label>Title:</label>
                    <input type="text" name="songTitle" class="songTitle" value="<?= $songTitle ?>" required>
                </div>
                <div class="inputDataSection">
                    <label>Track No:</label>
                    <input type="number" name="songTrackNo" class="songTrackNo" value="<?= $songTrackNo ?>" required>
                </div>
                <div class="inputDataSection">
                    <label>Artist:</label>
                    <input type="text" name="songArtist" class="songArtist" value="<?= $songArtist ?>" required>
                </div>
                <div class="inputDataSection">
                    <label>Audio Link:</label>
                    <input type="url" name="songURL" class="songURL" value="<?= $songURL ?>" required>
                </div>
                <div class="inputDataSection">
                    <label>Duration:</label>
                    <input type="text" name="songDuration" class="songDuration" value="<?= $songDuration ?>" required placeholder="Duration is automatic generated base on song URL">
                </div>
                <div class="inputDataSection radioButtonInputDataSection">
                    <label>Explicit:</label>
                    <div class="explictRadioButtonSection">
                        <div class="radioButtonSection">
                            <input type="radio" name="songExplicit" class="songExplicit" value="1" id="yes" <?= $selected1 ?> required>
                            <label for='yes'>Yes</label>
                        </div>
                        <div class="radioButtonSection">
                            <input type="radio" name="songExplicit" class="songExplicit" value="0" id="no" <?= $selected ?> required>
                            <label for='no'>No</label>
                        </div>
                    </div>
                </div>

                <input type="hidden" value="<?= $songID ?>" name="songID">
                <input type="submit" value="Update Song" id="updateSongBtn">
            </form>

        <?php
            }
        ?>
    </div>



    <?php 
        $result -> free_result();
        $mysqli -> close();
        
        include_once("../footer.php"); 
    ?>
</body>
</html>