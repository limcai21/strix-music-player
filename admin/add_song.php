<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strix - Add Song</title>
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

        if (isset($_GET['success']) && $_GET['success'] == '689017') {
            echo "<div class='successSection'>";
            echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2Zm3.22 6.97-4.47 4.47-1.97-1.97a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l5-5a.75.75 0 1 0-1.06-1.06Z" fill="#fff"/></svg>';
            echo "<span>Song added!</span>";
            echo "</div>";
        }
    ?>

    <div class="main" id="addSongDiv">
        <?php 
            if (!isset($_GET['id']) || $_GET['id'] == "") {
        ?>
        <div class="header">
            <h1>Select Album</h1>
            <button onclick="window.location = './add_album.php'">Create Album</button>
        </div>
        <select id="selectSong">
            <option disabled="" selected="">-- Select Album --</option>
            <?php 
                $sqlStatement = "SELECT * FROM `album`";

                if ($result = $mysqli -> query($sqlStatement)) {
                    $numOfRow = $result -> num_rows;

                    if ($numOfRow > 0) {
                        for ($i = 0; $i < $numOfRow; $i++) {
                            $record = $result -> fetch_row();

                            $albumID = $record[0];
                            $albumTitle = $record[1];
                            $albumArtist = $record[3];

                            echo "<option id = $albumID>$albumArtist - $albumTitle</option>";
                        }
                    }
                }
            ?>
        </select>        
        <?php
            }

            else {
                $albumID = $_GET['id'];
        ?>
        <div class="header">
            <h1>Add Song</h1>
        </div>

        <form action="./process/add_song.php" method="post" id="addSongForm">
            <div class="inputDataSection">
                <label>Album:</label>
                <?php 
                    $sqlStatement = "SELECT * FROM `album` WHERE albumID = '$albumID'";

                    if ($result = $mysqli -> query($sqlStatement)) {
                        $numOfRow = $result -> num_rows;
    
                        if ($numOfRow > 0) {
                            $record = $result -> fetch_row();
                            $albumTitle = $record[1];
                            $albumArtist = $record[3];

                            echo "<span class='albumTitle'>" . $albumArtist . " - " . $albumTitle . "</span>";
                        }
                    }
                ?>
            </div>
            <div class="inputDataSection">
                <label>Title:</label>
                <input type="text" name="songTitle" class="songTitle" required>
            </div>
            <div class="inputDataSection">
                <label>Track No:</label>
                <input type="number" name="songTrackNo" class="songTrackNo" required>
            </div>
            <div class="inputDataSection">
                <label>Artist:</label>
                <input type="text" name="songArtist" class="songArtist" required>
            </div>
            <div class="inputDataSection">
                <label>Audio Link:</label>
                <input type="url" name="songURL" class="songURL" required>
            </div>
            <div class="inputDataSection">
                <label>Duration:</label>
                <input type="text" name="songDuration" class="songDuration" readonly required placeholder="Duration is automatic generated base on song URL">
            </div>
            <div class="inputDataSection radioButtonInputDataSection">
                <label>Explicit:</label>
                <div class="explictRadioButtonSection">
                    <div class="radioButtonSection">
                        <input type="radio" name="songExplicit" class="songExplicit" id="yes" value="1" required>
                        <label for='yes'>Yes</label>
                    </div>
                    <div class="radioButtonSection">
                        <input type="radio" name="songExplicit" class="songExplicit" id="no" value="0" required>
                        <label for='no'>No</label>
                    </div>
                </div>
            </div>

            <input type="hidden" value="<?= $albumID ?>" name="albumID">
            <input type="submit" value="Add Song" id="addSongBtn">
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