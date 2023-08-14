<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strix - Admin Portal</title>
    <link rel="stylesheet" href="./css/css_reset.css">
    <link rel="stylesheet" href="./../css/predefine.css">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/index.css">
    <script src="./js/jquery.js"></script>
    <script src="./js/global.js"></script>
    <script src="./js/index.js"></script>
</head>
<body>
    <?php 
        include_once("./header.php"); 
        include_once("./process/dbInfo.php");    
    ?>

    <div class="main" id="viewMainDiv">
        <?php 
            if (!isset($_GET['id']) || $_GET['id'] == "") {
                $selectedLatest = "";
                $selectedOldest = "";
                $selectedAscending = "";
                $selectedDescending = "";
                
                if (!isset($_GET['filter']) || $_GET['filter'] == "") {
                    $filter = "albumID DESC";
                }

                else {
                    $filterName = $_GET['filter'];
                    
                    if ($filterName == "latest") {
                        $filter = "albumID DESC";
                        $selectedLatest = 'selected';
                    }

                    else if ($filterName == "oldest") {
                        $filter = "albumID ASC";
                        $selectedOldest = 'selected';
                    }

                    else if ($filterName == "ascending") {
                        $filter = "albumTitle ASC";
                        $selectedAscending = 'selected';
                    }

                    else if ($filterName == "descending") {
                        $filter = "albumTitle DESC";
                        $selectedDescending = 'selected';
                    }

                    else {
                        $filter = "albumID DESC";
                    }
                    
                }
        ?>
            <div class="header">
                <h1>Overview</h1> 
                <div class="filterDiv">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m6.288 4.293-3.995 4-.084.095a1 1 0 0 0 .084 1.32l.095.083a1 1 0 0 0 1.32-.084L6 7.41V19l.007.117a1 1 0 0 0 .993.884l.117-.007A1 1 0 0 0 8 19V7.417l2.293 2.29.095.084a1 1 0 0 0 1.319-1.499l-4.006-4-.094-.083a1 1 0 0 0-1.32.084ZM17 4.003l-.117.007a1 1 0 0 0-.883.993v11.58l-2.293-2.29-.095-.084a1 1 0 0 0-1.319 1.498l4.004 4 .094.084a1 1 0 0 0 1.32-.084l3.996-4 .084-.095a1 1 0 0 0-.084-1.32l-.095-.083a1 1 0 0 0-1.32.084L18 16.587V5.003l-.007-.116A1 1 0 0 0 17 4.003Z" fill="#000"></path></svg>
                    <select name="filter" id="filter">
                        <optgroup label="Release Date">
                            <option value="latest" <?= $selectedLatest ?>>Latest</option>
                            <option value="oldest" <?= $selectedOldest ?>>Oldest</option>
                        </optgroup>
                        <optgroup label="Alphabet">
                            <option value="ascending" <?= $selectedAscending ?>>Ascending</option>
                            <option value="descending" <?= $selectedDescending ?>>Descending</option>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="outputAlbum">
                <?php 
                    $sqlStatement = "SELECT * FROM `album` RIGHT JOIN genre ON genre.genreID = album.albumGenreFK WHERE genre.genreID = album.albumGenreFK ORDER BY $filter";

                    if ($result = $mysqli -> query($sqlStatement)) {
                        $numOfRow = $result -> num_rows;

                        if ($numOfRow > 0) {
                            for ($i = 0; $i < $numOfRow; $i++) {
                                $record = $result -> fetch_row();
                                $albumID = $record[0];
                                $albumTitle = $record[1];
                                $albumCover = $record[2];
                                $albumArtist = $record[3];
                                $albumReleaseDate = date('n M Y', (strtotime($record[4])));
                                $albumGenre = $record[7];

                                $sqlStatement2 = "SELECT * FROM `song` WHERE albumIDFK = '$albumID'";
                                if ($result2 = $mysqli -> query($sqlStatement2)) {
                                    $numOfRow2 = $result2 -> num_rows;

                                    $track = 'song';
                                    if($numOfRow2 > 1) {
                                        $track = 'songs';
                                    }

                                    echo "<div class='albumData' id=$albumID>";
                                    echo "<div class='left'>";
                                    echo "<img src='$albumCover'/>";
                                    echo "</div>";
                                    echo "<div class='right'>";
                                    echo "<div class='albumTitleAndArtist'>";
                                    echo "<label class='albumTitle'>$albumTitle</label>";
                                    echo "<span class='albumArtist'>$albumArtist</span>";
                                    echo "</div>";
                                    echo "<div class='otherData'>";
                                    echo "<span class='smallText'>$albumGenre</span>";
                                    echo "<span class='smallText'>&bull;</span>";
                                    echo "<span class='smallText'>$albumReleaseDate</span>";
                                    echo "<span class='smallText'>&bull;</span>";
                                    echo "<span class='smallText'>$numOfRow2 $track</span>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            }
                        }
                    }
                ?>
            </div>
        <?php 
            }

            else {
                $albumID = $_GET['id'];
                $sqlStatement = "SELECT album.albumTitle, album.albumCover, album.albumArtist, album.albumReleaseDate, genre.genreTitle FROM `album` RIGHT JOIN genre ON genre.genreID = album.albumGenreFK WHERE albumID = '$albumID'";

                if ($result = $mysqli -> query($sqlStatement)) {
                    $numOfRows = $result -> num_rows;

                    if ($numOfRows == 1) {
                        $record = $result -> fetch_row();

                        $albumTitle = $record[0];
                        $albumCover = $record[1];
                        $albumArtist = $record[2];
                        $albumReleaseDate = date('j M Y', (strtotime($record[3])));
                        $albumGenre = $record[4];   
                        
                        echo "<div class='albumHeader' style='background-image: url($albumCover)'>";
                        echo "<div class='backgroundBlur'>";
                        echo "<div class='content'>";
                        echo "<div class='left'>";
                        echo "<img src='$albumCover'/>"; 
                        echo "</div>";
                        echo "<div class='right'>";
                        echo "<div class='albumTitleAndArtist'>";
                        echo "<h1>$albumTitle</h1>";
                        echo "<span class='albumArtist'>$albumArtist</span>";
                        echo "</div>";
                        echo "<div class='otherData'>";
                        echo "<span class='smallText'>$albumGenre</span>";
                        echo "<span class='smallText'>&bull;</span>";
                        echo "<span class='smallText'>$albumReleaseDate</span>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='toolbar'>";
                        echo "<button class='editBtn' accent='navIconAndText' onclick='window.location = `./edit_album.php?id=$albumID`' title='Edit Album'>";
                        echo "<svg width='24' height='24' fill='none' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M13.94 5 19 10.06 9.062 20a2.25 2.25 0 0 1-.999.58l-5.116 1.395a.75.75 0 0 1-.92-.921l1.395-5.116a2.25 2.25 0 0 1 .58-.999L13.938 5Zm7.09-2.03a3.578 3.578 0 0 1 0 5.06l-.97.97L15 3.94l.97-.97a3.578 3.578 0 0 1 5.06 0Z' fill='#fff'/></svg>";
                        echo "<span>Edit Album</span>";
                        echo "</button>";
                        echo "<button class='deleteBtn' accent='navIconAndText' onclick='window.location = `./delete_album.php?id=$albumID`' title='Delete Album'>";
                        echo "<svg width='24' height='24' fill='none' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M21.5 6a1 1 0 0 1-.883.993L20.5 7h-.845l-1.231 12.52A2.75 2.75 0 0 1 15.687 22H8.313a2.75 2.75 0 0 1-2.737-2.48L4.345 7H3.5a1 1 0 0 1 0-2h5a3.5 3.5 0 1 1 7 0h5a1 1 0 0 1 1 1Zm-7.25 3.25a.75.75 0 0 0-.743.648L13.5 10v7l.007.102a.75.75 0 0 0 1.486 0L15 17v-7l-.007-.102a.75.75 0 0 0-.743-.648Zm-4.5 0a.75.75 0 0 0-.743.648L9 10v7l.007.102a.75.75 0 0 0 1.486 0L10.5 17v-7l-.007-.102a.75.75 0 0 0-.743-.648ZM12 3.5A1.5 1.5 0 0 0 10.5 5h3A1.5 1.5 0 0 0 12 3.5Z' fill='#fff'/></svg>";
                        echo "<span>Delete Album</span>";
                        echo "</button>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
    


                        // GET SONG TITLE AND MORE
                        $sqlStatement = "SELECT * FROM `song` WHERE albumIDFK = '$albumID' ORDER BY songTrackNo ASC";
                        if ($result = $mysqli -> query($sqlStatement)) {
                            $numOfRows = $result -> num_rows;
                            $explictSVG = '<svg class="explicitIcon" width="24" height="24" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg" class="glyph" aria-hidden="true"><path d="M1.59 8.991h5.82c1.043 0 1.582-.538 1.582-1.566v-5.85C8.992.547 8.453.008 7.41.008H1.59C.552.008.008.542.008 1.575v5.85c0 1.028.544 1.566 1.582 1.566zm1.812-2.273c-.332 0-.505-.211-.505-.553V2.753c0-.341.173-.553.505-.553h2.264c.245 0 .408.14.408.385 0 .235-.163.384-.408.384H3.854v1.106h1.71c.226 0 .38.125.38.355 0 .221-.154.346-.38.346h-1.71V5.95h1.812c.245 0 .408.14.408.385 0 .235-.163.384-.408.384H3.402z"></path></svg>';

                            if ($numOfRows > 0) {
                                echo "<div class='songSection'>";

                                for ($i = 0; $i < $numOfRows; $i++) {
                                    $record = $result -> fetch_row();
                                    $songID = $record[0];
                                    $albumID = $record[1];
                                    $songTitle = $record[2];
                                    $songTrackNo = $record[3];
                                    $songArtist = $record[4];
                                    $songURL = $record[5];
                                    $songExplicit = $record[6] == 1 ? $explictSVG : '';
                                    $songDuration = $record[7];

                                    if (trim($songArtist) == $albumArtist) {
                                        $songArtist = "";
                                    }

                                    else {
                                        $songArtist = "<span class='songArtist'>$songArtist</span>";
                                    }
                                    
                                    echo "<div class='indivualSongList'>";
                                    echo "<div class='left'>";
                                    echo "<label class='trackNo'>$songTrackNo</label>";
                                    echo "<div class='titleAndDuration'>";
                                    echo "<label class='songTitle'>$songTitle $songExplicit $songArtist</label>";
                                    echo "<label class='songDuration'>$songDuration</label>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "<div class='right'>";
                                    echo "<button class='editBtn' onclick='window.location = `./edit_song.php?id=$songID`' title='Edit'>";
                                    echo "<svg width='24' height='24' fill='none' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M13.94 5 19 10.06 9.062 20a2.25 2.25 0 0 1-.999.58l-5.116 1.395a.75.75 0 0 1-.92-.921l1.395-5.116a2.25 2.25 0 0 1 .58-.999L13.938 5Zm7.09-2.03a3.578 3.578 0 0 1 0 5.06l-.97.97L15 3.94l.97-.97a3.578 3.578 0 0 1 5.06 0Z' fill='#fff'/></svg>";
                                    echo "</button>";
                                    echo "<button class='deleteBtn' onclick='window.location = `./delete_song.php?id=$songID`' title='Delete'>";
                                    echo "<svg width='24' height='24' fill='none' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M21.5 6a1 1 0 0 1-.883.993L20.5 7h-.845l-1.231 12.52A2.75 2.75 0 0 1 15.687 22H8.313a2.75 2.75 0 0 1-2.737-2.48L4.345 7H3.5a1 1 0 0 1 0-2h5a3.5 3.5 0 1 1 7 0h5a1 1 0 0 1 1 1Zm-7.25 3.25a.75.75 0 0 0-.743.648L13.5 10v7l.007.102a.75.75 0 0 0 1.486 0L15 17v-7l-.007-.102a.75.75 0 0 0-.743-.648Zm-4.5 0a.75.75 0 0 0-.743.648L9 10v7l.007.102a.75.75 0 0 0 1.486 0L10.5 17v-7l-.007-.102a.75.75 0 0 0-.743-.648ZM12 3.5A1.5 1.5 0 0 0 10.5 5h3A1.5 1.5 0 0 0 12 3.5Z' fill='#fff'/></svg>";
                                    echo "</button>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                                echo "</div>";
                            }

                            else {
                                echo "No song yet";
                            }
                        }
                    }
                }
            }
        ?>
    </div>

    <?php 
        $result -> free_result();
        $mysqli -> close();
            
        include_once("../footer.php") 
    ?>
</body>
</html>