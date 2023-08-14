<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strix - Delete Album</title>
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

        if (isset($_GET['success']) && $_GET['success'] == '493262') {
            echo "<div class='successSection'>";
            echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2Zm3.22 6.97-4.47 4.47-1.97-1.97a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l5-5a.75.75 0 1 0-1.06-1.06Z" fill="#fff"/></svg>';
            echo "<span>Deleted Successfully!</span>";
            echo "</div>";
        }
    ?>

    

    <div class="main" id="deleteMainDiv">

        <div class="header">
            <h1>Delete Album</h1>
            <?php 
                if (isset($_GET['id'])) {
                    $albumID = $_GET['id'];
                    echo "<div class='actionBtn'>";
                    echo "<button onclick='window.location=`./delete_song.php?album=$albumID`'>Delete Song</button>";
                    echo "</div>";
                }
            ?>
        </div>

        <div class="deleteAndSelectSection">
            <select id="selectAlbum">
                <option disabled selected>-- Select Album --</option>
                <?php 
                    $sqlStatement = "SELECT * FROM `album`";

                    if ($result = $mysqli -> query($sqlStatement)) {
                        $numOfRows = $result -> num_rows;

                        if ($numOfRows > 0) {
                            for ($i = 0; $i < $numOfRows; $i++) {
                                $selected = '';
                                $record = $result -> fetch_row();
                                $albumID = $record[0];
                                $albumTitle = $record[1];
                                $albumArtist = $record[3];

                                if ($albumID == $_GET['id']) {
                                    $selected = 'selected';
                                }

                                echo "<option id=$albumID $selected>$albumArtist - $albumTitle</option>";
                            }
                        }
                    }
                ?>
            </select>
            <?php 
                if (isset($_GET['id'])) {
                    $albumID = $_GET['id'];
                    $sqlStatement = "SELECT * FROM album WHERE albumID = '$albumID'";

                    if ($result = $mysqli -> query($sqlStatement)) {
                        if ($result -> num_rows > 0) {
                            echo "<div class='actionBtn'>";
                            echo "<button id='deleteAlbumBtn'>Delete</button>";
                            echo "</div>";
                        }

                        else {
                            echo "<script>window.location = './delete_album.php'</script>";
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