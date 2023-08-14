<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "theme-color" content = "#000000">
    <title>Strix - Web Player</title>
    <link rel="stylesheet" href="./css/css_reset.css">
    <link rel="stylesheet" href="./../css/predefine.css">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/player.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/album.css">
    <link rel="stylesheet" href="./css/playlist.css">
    <link rel="stylesheet" href="./css/search.css">
    <link rel="stylesheet" href="./css/library.css">
    <script src="./js/jquery.js"></script>
    <script src="./js/playerFunctions.js"></script>
    <script src="./js/global.js"></script>
    <script src="./js/index.js"></script>
    <script src="./js/album.js"></script>
    <script src="./js/playlist.js"></script>
    <script src="./js/search.js"></script>
    <script src="./js/library.js"></script>
</head>

<body>
    <?php 
        session_start();
        date_default_timezone_set("Asia/Singapore");  

        

        if (!isset($_SESSION['username'])) {
            header("location: ../login.php");
        }



        $username = $_SESSION['username'];
        $userID = $_SESSION['userID'];

        include_once("./dbInfo.php");
    ?>

    
    <div class="pageContent">
        <?php include_once("./sidebar.php") ?>

        <div id='main'>
            <div class="welcomeUser">
                <?php 
                    $h = date('G');

                    if ($h >= 5 && $h <= 11) {
                        echo "<h1>Good Morning</h1>";
                    }

                    else if ($h >= 12 && $h <= 15) {
                        echo "<h1>Good Afternoon</h1>";
                    }

                    else {
                        echo "<h1>Good Evening</h1>";
                    }
                ?>
            </div>


            <div class="playlistAndAlbumSection">

                <!-- YOUR PLAYLIST -->
                <div class="displaySection">
                    <div class="songListDiv"> 

                        <!-- FAVOURITE PLAYLIST -->
                        <?php 
                            $sqlStatement = "SELECT playlistID, playlistCover, playlistName FROM `playlist` WHERE playlistName = 'Favourites' AND playlistOwner = '$userID'";
        
                            if ($result = $mysqli -> query($sqlStatement)) {
                                $record = $result -> fetch_row();
                                $playlistID = $record[0];
                                $playlistCover = base64_encode($record[1]);
                                $playlistName = $record[2];
        
                                if ($playlistCover == '') {
                                    $playlistCover = "https://raw.githubusercontent.com/limcai21/project-music/main/img/favouriteCover.png";
                                }
        
                                else {
                                    $playlistCover = "data:image/png;base64,$playlistCover";
                                }                            
                        ?>
                        
                        <div class='playlistCard' playlistid=<?= $playlistID ?>>
                            <div class='content'>
                                <div class='coverArt'>
                                    <img src='<?= $playlistCover ?>' alt='<?= $playlistName ?> Playlist Cover' onerror="this.src='../img/favouriteCover.png'"/>
                                </div>
                                <div class='information'>
                                    <div class='songTitleAndArtist'>
                                        <label class='playlistTitle'><?= $playlistName ?></label>
                                    </div>

                                    <?php 
                                        // Check Number of Song inside 
                                        $sqlStatement = "SELECT * FROM `playlist_songs` WHERE playlistIDFK = '$playlistID'";
                                        if ($result = $mysqli -> query($sqlStatement)) {
                                            $numOfRows = $result -> num_rows;

                                            if ($numOfRows > 0) {
                                    ?>
                                    <div class='actionBtn'>
                                        <button class='playlistPlayBtn' playlistid=<?= $playlistID ?>>
                                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.274c0-1.707 1.826-2.792 3.325-1.977l12.362 6.726c1.566.853 1.566 3.101 0 3.953L8.325 20.702C6.826 21.518 5 20.432 5 18.726V5.274Z" fill="#fff"/></svg>
                                        </button>
                                    </div>
                                    <?php 
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>


                        <?php 
                            }

                            // OTHER PLAYLIST
                            $sqlStatement = "SELECT playlistID, playlistCover, playlistName FROM `playlist` WHERE NOT playlistName = 'Favourites' AND playlistOwner = '$userID'  ORDER BY playlistID DESC LIMIT 3";
        
                            if ($result = $mysqli -> query($sqlStatement)) {
                                $numOfRows = $result -> num_rows;

                                if ($numOfRows > 0) {
                                    for ($i = 0; $i < $numOfRows; $i++) {
                                        $record = $result -> fetch_row();
                                        $playlistID = $record[0];
                                        $playlistCover = $record[1];
                                        $playlistName = $record[2];
                
                                        if ($playlistCover == '') {
                                            $playlistCover = "https://raw.githubusercontent.com/limcai21/project-music/main/img/newPlaylistCover.png";
                                        }
                
                                        else {
                                            $playlistCover = "data:image/png;base64,$playlistCover";
                                        }
                                
                        ?>

                        <!-- PLAYLIST TEMPALTE -->
                        <div class='playlistCard' playlistid='<?= $playlistID ?>'>
                            <div class='content'>
                                <div class='coverArt'>
                                    <img src='<?= $playlistCover ?>' alt='<?= $playlistName ?> Playlist Cover' onerror='this.src=`../img/newPlaylistCover.png`'/>
                                </div>
                                <div class='information'>
                                    <div class='songTitleAndArtist'>
                                        <label class='playlistTitle'><?= $playlistName ?></label>
                                    </div>
                                    <?php 
                                        // Check Number of Song inside 
                                        $sqlStatement = "SELECT * FROM `playlist_songs` WHERE playlistIDFK = '$playlistID'";
                                        if ($result2 = $mysqli -> query($sqlStatement)) {
                                            $numOfRows2 = $result2 -> num_rows;

                                            if ($numOfRows2 > 0) {
                                    ?>
                                    <div class='actionBtn'>
                                        <button class='playlistPlayBtn' playlistid='<?= $playlistID ?>'>
                                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.274c0-1.707 1.826-2.792 3.325-1.977l12.362 6.726c1.566.853 1.566 3.101 0 3.953L8.325 20.702C6.826 21.518 5 20.432 5 18.726V5.274Z" fill="#fff"/></svg>
                                        </button>
                                    </div>

                                    <?php 
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <?php 
                                    }
                                }
                            }
                        ?>

                        <!-- MORE PLAYLIST -->
                        <?php 
                            if ($numOfRows > 0) {
                                echo "<div id='viewMorePlaylist'>";
                                echo "<label class='playlistTitle'>View All</label>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                </div>  

                <!-- COMING SOON -->
                <?php 
                    $checker = false;
                    $sqlStatement = "SELECT * FROM `album`";
                    if ($result = $mysqli -> query($sqlStatement)) {
                        $numOfRows = $result->num_rows;
                        if ($numOfRows > 0) {
                            echo "<div class='displaySection comingSoonSection'>";
                            echo "<div class='header'>";
                            echo "<h3>Coming Soon</h3>";
                            echo "</div>";
                            echo "<div class='songListDiv'>";

                            for ($i = 0; $i < $numOfRows; $i++) {
                                $record = $result->fetch_row();
                                $albumID = $record[0];
                                $albumTitle = $record[1];
                                $albumCover = $record[2];
                                $albumArtist = $record[3];
                                $albumReleaseDate = $record[4];
                                $albumGenreFK = $record[5];

                                // CHECK IF GOT SONG OR NOT
                                $sqlStatement2 = "SELECT * FROM `song` WHERE albumIDFK = '$albumID'";
                                if ($result2 = $mysqli -> query($sqlStatement2)) {
                                    $numOfRows2 = $result2 -> num_rows;
                                    if ($numOfRows2 == 0) {
                                        echo "<div class='songCard' albumid='$albumID'>";
                                        echo "<div class='content'>";
                                        echo "<div class='coverArt'>";
                                        echo "<img src='$albumCover' alt='$albumTitle Album Cover' onerror='this.src=`../img/albumCover.png`'>";
                                        echo "</div>";
                                        echo "<div class='information'>";
                                        echo "<div class='songTitleAndArtist'>";
                                        echo "<label class='albumTitle'>$albumTitle</label>";
                                        echo "<span class='albumArtist'>$albumArtist</span>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        
                                        $checker = true;
                                    }
                                }
                            }

                            echo "</div>";
                            echo "</div>";

                            if ($checker != true) {
                                echo "<script>$('.comingSoonSection').css('display', 'none')</script>"; 
                            }
                        }
                    }

                    else {
                        echo "<span class='errorIndex'>Something went wrong</span>";
                    }
                ?>           

                <!-- BASE ON YOUR PLAYLIST GENRE -->
                <?php 
                    $sqlStatement = "SELECT genre.genreID, genre.genreTitle, COUNT(`genreID`) AS `value_occurrence` FROM `playlist` JOIN playlist_songs ON playlist.playlistID = playlist_songs.playlistIDFK JOIN song ON playlist_songs.songID = song.songID JOIN album ON song.albumIDFK = album.albumID JOIN genre ON album.albumGenreFK = genre.genreID WHERE playlist.playlistOwner = '$userID' GROUP BY `genreID` ORDER BY `value_occurrence` DESC LIMIT 1;";
                    if ($result = $mysqli -> query($sqlStatement)) {
                        $numOfRows = $result->num_rows;
                        if ($numOfRows > 0) {
                            $record = $result -> fetch_row();
                            $genreID = $record[0];
                            $genreTitle = $record[1];
                                    
                            echo "<div class='displaySection'>";
                            echo "<div class='header'>";
                            echo "<h3>More On: $genreTitle</h3>";
                            echo "</div>";
                            echo "<div class='songListDiv'>";
                        
                            $sqlStatement = "SELECT * FROM `album` WHERE albumGenreFK = '$genreID' LIMIT 8";
                            if ($result = $mysqli -> query($sqlStatement)) {
                                $numOfRows = $result -> num_rows;
                                if ($numOfRows > 0) {
                                    for ($y = 0; $y < $numOfRows; $y++) {
                                        $record = $result -> fetch_row();
                                        $albumID = $record[0];
                                        $albumTitle = $record[1];
                                        $albumCover = $record[2];
                                        $albumArtist = $record[3];

                                        echo "<div class='songCard' albumid='$albumID'>";
                                        echo "<div class='content'>";
                                        echo "<div class='coverArt'>";
                                        echo "<img src='$albumCover' alt='$albumTitle Album Cover' onerror='this.src=`../img/albumCover.png`'>";
                                        echo "</div>";
                                        echo "<div class='information'>";
                                        echo "<div class='songTitleAndArtist'>";
                                        echo "<label class='albumTitle'>$albumTitle</label>";
                                        echo "<span class='albumArtist'>$albumArtist</span>";
                                        echo "</div>";
                                        echo "<div class='actionBtn'>";
                                        echo "<button class='albumPlayBtn' albumid='$albumID'>";
                                        echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.274c0-1.707 1.826-2.792 3.325-1.977l12.362 6.726c1.566.853 1.566 3.101 0 3.953L8.325 20.702C6.826 21.518 5 20.432 5 18.726V5.274Z" fill="#fff"/></svg>';
                                        echo "</button>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                    }
                                }
                            }

                            echo "</div>";
                            echo "</div>";
                        }
                    }
                    
                ?>

                <!-- NEW RELEASE -->
                <div class="displaySection">
                    <div class="header">
                        <h3>New Release</h3>
                    </div>
                    <div class="songListDiv"> 
                        <?php
                            $sqlStatement = "SELECT * FROM `album` ORDER BY albumReleaseDate DESC LIMIT 8";

                            if ($result = $mysqli->query($sqlStatement)) {
                                $numOfRows = $result->num_rows;

                                if ($numOfRows > 0) {
                                    for ($i = 0; $i < $numOfRows; $i++) {
                                        $record = $result->fetch_row();

                                        $albumID = $record[0];
                                        $albumTitle = $record[1];
                                        $albumCover = $record[2];
                                        $albumArtist = $record[3];
                                        $albumReleaseDate = $record[4];
                                        $albumGenreFK = $record[5];

                                        // CHECK IF GOT SONG OR NOT
                                        $sqlStatement2 = "SELECT * FROM `song` WHERE albumIDFK = '$albumID'";
                                        if ($result2 = $mysqli -> query($sqlStatement2)) {
                                            $numOfRows2 = $result2 -> num_rows;
                                            if ($numOfRows2 > 0) {
                                                echo "<div class='songCard' albumid='$albumID'>";
                                                echo "<div class='content'>";
                                                echo "<div class='coverArt'>";
                                                echo "<img src='$albumCover' alt='$albumTitle Album Cover' onerror='this.src=`../img/albumCover.png`'>";
                                                echo "</div>";
                                                echo "<div class='information'>";
                                                echo "<div class='songTitleAndArtist'>";
                                                echo "<label class='albumTitle'>$albumTitle</label>";
                                                echo "<span class='albumArtist'>$albumArtist</span>";
                                                echo "</div>";
                                                echo "<div class='actionBtn'>";
                                                echo "<button class='albumPlayBtn' albumid='$albumID'>";
                                                echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.274c0-1.707 1.826-2.792 3.325-1.977l12.362 6.726c1.566.853 1.566 3.101 0 3.953L8.325 20.702C6.826 21.518 5 20.432 5 18.726V5.274Z" fill="#fff"/></svg>';
                                                echo "</button>";
                                                echo "</div>";
                                                echo "</div>";
                                                echo "</div>";
                                                echo "</div>";
                                            }
                                        }
                                    }
                                }

                                else {
                                    echo "<span class='errorIndex'>Something went wrong</span>";
                                }
                            }

                            else {
                                echo "<span class='errorIndex'>Something went wrong</span>";
                            }
                        ?>
                    </div>
                </div>

                <!-- BAD BOY ALBUM -->
                <div class="displaySection">
                    <div class="header">
                        <h3>Curse it Out</h3>
                    </div>
                    <div class="songListDiv"> 
                        <?php
                            $sqlStatement = "SELECT DISTINCT album.albumID, album.albumTitle, album.albumCover, album.albumArtist FROM `song` RIGHT JOIN `album` ON album.albumID = song.albumIDFK WHERE songExplicit = '1' ORDER BY `albumGenreFK` ASC LIMIT 8";

                            if ($result = $mysqli->query($sqlStatement)) {
                                $numOfRows = $result->num_rows;

                                if ($numOfRows > 0) {
                                    for ($i = 0; $i < $numOfRows; $i++) {
                                        $record = $result->fetch_row();

                                        $albumID = $record[0];
                                        $albumTitle = $record[1];
                                        $albumCover = $record[2];
                                        $albumArtist = $record[3];

                                        echo "<div class='songCard' albumid='$albumID'>";
                                        echo "<div class='content'>";
                                        echo "<div class='coverArt'>";
                                        echo "<img src='$albumCover' alt='$albumTitle Album Cover' onerror='this.src=`../img/albumCover.png`'>";
                                        echo "</div>";
                                        echo "<div class='information'>";
                                        echo "<div class='songTitleAndArtist'>";
                                        echo "<label class='albumTitle'>$albumTitle</label>";
                                        echo "<span class='albumArtist'>$albumArtist</span>";
                                        echo "</div>";
                                        echo "<div class='actionBtn'>";
                                        echo "<button class='albumPlayBtn' albumid='$albumID'>";
                                        echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.274c0-1.707 1.826-2.792 3.325-1.977l12.362 6.726c1.566.853 1.566 3.101 0 3.953L8.325 20.702C6.826 21.518 5 20.432 5 18.726V5.274Z" fill="#fff"/></svg>';
                                        echo "</button>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                    }
                                }

                                else {
                                    echo "<span class='errorIndex'>The grass is always greener on the other side</span>";
                                }
                            }

                            else {
                                echo "<span class='errorIndex'>Something went wrong</span>";
                            }
                        ?>
                    </div>
                </div>

                <!-- RECENTLY ADDED -->
                <div class="displaySection">
                    <div class="header">
                        <h3>Recently Added</h3>
                    </div>
                    <div class="songListDiv"> 
                        <?php
                            $sqlStatement = "SELECT * FROM `album` ORDER BY albumID DESC LIMIT 8";

                            if ($result = $mysqli -> query($sqlStatement)) {
                                $numOfRows = $result->num_rows;

                                if ($numOfRows > 0) {
                                    for ($i = 0; $i < $numOfRows; $i++) {
                                        $record = $result->fetch_row();

                                        $albumID = $record[0];
                                        $albumTitle = $record[1];
                                        $albumCover = $record[2];
                                        $albumArtist = $record[3];
                                        $albumReleaseDate = $record[4];
                                        $albumGenreFK = $record[5];

                                        // CHECK IF GOT SONG OR NOT
                                        $sqlStatement2 = "SELECT * FROM `song` WHERE albumIDFK = '$albumID'";
                                        if ($result2 = $mysqli -> query($sqlStatement2)) {
                                            $numOfRows2 = $result2 -> num_rows;
                                            if ($numOfRows2 > 0) {
                                                echo "<div class='songCard' albumid='$albumID'>";
                                                echo "<div class='content'>";
                                                echo "<div class='coverArt'>";
                                                echo "<img src='$albumCover' alt='$albumTitle Album Cover' onerror='this.src=`../img/albumCover.png`'>";
                                                echo "</div>";
                                                echo "<div class='information'>";
                                                echo "<div class='songTitleAndArtist'>";
                                                echo "<label class='albumTitle'>$albumTitle</label>";
                                                echo "<span class='albumArtist'>$albumArtist</span>";
                                                echo "</div>";
                                                echo "<div class='actionBtn'>";
                                                echo "<button class='albumPlayBtn' albumid='$albumID'>";
                                                echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.274c0-1.707 1.826-2.792 3.325-1.977l12.362 6.726c1.566.853 1.566 3.101 0 3.953L8.325 20.702C6.826 21.518 5 20.432 5 18.726V5.274Z" fill="#fff"/></svg>';
                                                echo "</button>";
                                                echo "</div>";
                                                echo "</div>";
                                                echo "</div>";
                                                echo "</div>";
                                            }
                                        }
                                    }
                                }

                                else {
                                    echo "<span class='errorIndex'>Something went wrong</span>";
                                }
                            }

                            else {
                                echo "<span class='errorIndex'>Something went wrong</span>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    


    <?php
        $result -> free_result();
        $mysqli -> close();
        
        include_once("./player.php");
    ?>
</body>

</html>