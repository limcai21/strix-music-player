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

        if (!isset($_GET['id']) || $_GET['id'] == '') {
            header("location: ./index.php");
        }

        if (!isset($_SESSION['username'])) {
            header("location: ../login.php");
        }

        $albumID = $_GET['id'];
        $explictSVG = '';

        include_once("./dbInfo.php");
    ?>

    <div class="pageContent">
        <?php include_once("./sidebar.php") ?>

        <div id='main'>
            <!-- ALBUM DETAIL -->
            <?php 
                $sqlStatement = "SELECT album.albumTitle, album.albumCover, album.albumArtist, album.albumReleaseDate, genre.genreTitle FROM `album` RIGHT JOIN genre ON genre.genreID = album.albumGenreFK WHERE albumID = '$albumID'";

                if ($result = $mysqli -> query($sqlStatement)) {
                    $numOfRows = $result -> num_rows;

                    if ($numOfRows == 1) {
                        $record = $result -> fetch_row();

                        $albumTitle = $record[0];
                        $albumCover = $record[1];
                        $albumArtist = $record[2];
                        $albumReleaseDate = date('Y', (strtotime($record[3])));
                        $albumGenre = $record[4];                                


                        // CHECK FOR EXPLICIT
                        $sqlStatement = "SELECT * FROM `song` WHERE albumIDFK = '$albumID' AND songExplicit = '1'";

                        if ($result = $mysqli -> query($sqlStatement)) {
                            $numOfRows = $result -> num_rows;

                            if ($numOfRows > 0) {
                                $explictSVG = '<svg class="explicitIcon" width="24" height="24" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg" class="glyph" aria-hidden="true"><path d="M1.59 8.991h5.82c1.043 0 1.582-.538 1.582-1.566v-5.85C8.992.547 8.453.008 7.41.008H1.59C.552.008.008.542.008 1.575v5.85c0 1.028.544 1.566 1.582 1.566zm1.812-2.273c-.332 0-.505-.211-.505-.553V2.753c0-.341.173-.553.505-.553h2.264c.245 0 .408.14.408.385 0 .235-.163.384-.408.384H3.854v1.106h1.71c.226 0 .38.125.38.355 0 .221-.154.346-.38.346h-1.71V5.95h1.812c.245 0 .408.14.408.385 0 .235-.163.384-.408.384H3.402z"></path></svg>';
                            }
                        ?>
                        

                        <div class="albumContent">
                            <div class="header" style="background-image: url('<?= $albumCover ?>'), url('../img/albumCover.png')">
                                <div class="headerContent backgroundBlur">
                                    <div class="left">
                                        <img src="<?= $albumCover ?>" alt='<?= $albumTitle ?> Album Cover' onerror='this.src=`../img/albumCover.png`'>
                                    </div>
                                    <div class="right">
                                        <div class="top">
                                            <span class="type smallText">Type</span>
                                            <div class="titleAndArtist">
                                                <h1><?= $albumTitle ?></h1>
                                                <h5><?= $albumArtist ?></h5>
                                            </div>
                                        </div>

                                        <div class="bottom">
                                            <span class="smallText"><?= $albumGenre ?></span>
                                            <span class="smallText">&bull;</span>
                                            <span class="smallText"><?= $albumReleaseDate ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>  

                            <div class="quickActions">
                                <button class='albumPlayBtn' accent='navIconAndText' albumid=<?= $albumID ?>>
                                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.274c0-1.707 1.826-2.792 3.325-1.977l12.362 6.726c1.566.853 1.566 3.101 0 3.953L8.325 20.702C6.826 21.518 5 20.432 5 18.726V5.274Z" fill="#fff"/></svg>
                                    <span>Play</span>
                                </button>
                            </div>  


                            <!-- TRACK DETAILS -->
                            <div class="songListSection">
                                <?php
                                }

                                // GET SONG TITLE AND MORE
                                $sqlStatement = "SELECT * FROM `song` WHERE albumIDFK = '$albumID' ORDER BY songTrackNo ASC";

                                if ($result = $mysqli -> query($sqlStatement)) {
                                    $numOfRows = $result -> num_rows;

                                    if ($numOfRows > 0) {
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

                                            // CHECK WHETHER SONG IS USER FAV SONG
                                            $sqlStatement = "SELECT * FROM `playlist` RIGHT JOIN playlist_songs ON playlist_songs.playlistIDFK = playlist.playlistID WHERE playlistName = 'Favourites' AND playlistOwner = '$userID' AND songID = '$songID'"; 
                                            $heartFillSVG = '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12.82 5.58-.82.822-.824-.824a5.375 5.375 0 1 0-7.601 7.602l7.895 7.895a.75.75 0 0 0 1.06 0l7.902-7.897a5.376 5.376 0 0 0-.001-7.599 5.38 5.38 0 0 0-7.611 0Z" fill="#fff"/></svg>';
                                            $heartNotFillSVG = '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12.82 5.58-.82.822-.824-.824a5.375 5.375 0 1 0-7.601 7.602l7.895 7.895a.75.75 0 0 0 1.06 0l7.902-7.897a5.376 5.376 0 0 0-.001-7.599 5.38 5.38 0 0 0-7.611 0Zm6.548 6.54L12 19.485 4.635 12.12a3.875 3.875 0 1 1 5.48-5.48l1.358 1.357a.75.75 0 0 0 1.073-.012L13.88 6.64a3.88 3.88 0 0 1 5.487 5.48Z" fill="#fff"/></svg>';
                                            $favouriteOrNot = 0;
                                            $selectedSVG = $heartNotFillSVG;

                                            if ($result2 = $mysqli -> query($sqlStatement)) {
                                                $numOfRows2 = $result2 -> num_rows;

                                                if ($numOfRows2 == 1) {
                                                    $favouriteOrNot = 1;
                                                    $selectedSVG = $heartFillSVG;
                                                }

                                                else {
                                                    $selectedSVG = $heartNotFillSVG;
                                                }

                                                if (trim($songArtist) == $albumArtist) {
                                                    $songArtist = "";
                                                }

                                                else {
                                                    $songArtist = "<span class='songArtist'>$songArtist</span>";
                                                }
                                            }
                                ?>

                                <div class="indivualSongList">
                                    <div class="left">
                                        <label class="trackNo"><?= $songTrackNo ?></label>
                                        <button class="playIndividualSong" songid=<?= $songID ?>>
                                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.274c0-1.707 1.826-2.792 3.325-1.977l12.362 6.726c1.566.853 1.566 3.101 0 3.953L8.325 20.702C6.826 21.518 5 20.432 5 18.726V5.274Z" fill="#fff"/></svg>
                                        </button>
                                        <div class="titleAndDuration">
                                            <label class="songTitle"><?= $songTitle, $songExplicit ?>
                                                <?= $songArtist ?>
                                            </label>
                                            <label class='songDuration'><?= $songDuration ?></label>
                                        </div>
                                    </div>

                                    <div class="right">
                                        <button class="favouriteBtn" songid=<?= $songID ?> albumid = <?= $albumID ?> favourite=<?= $favouriteOrNot ?>>
                                            <?= $selectedSVG ?>     
                                        </button>
                                        <button class="moreBtn">
                                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M8 12a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM14 12a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM18 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" fill="#fff"/></svg>
                                        </button>
                                    </div>
                                </div>
                            
                            <?php
                                    
                                    }

                                    if ($numOfRows > 0 && $numOfRows < 4) {
                                        echo "<script>$('.type').html('Single')</script>";
                                    }

                                    else if ($numOfRows > 4 && $numOfRows < 7) {
                                        echo "<script>$('.type').html('EP')</script>";
                                    }

                                    else {
                                        echo "<script>$('.type').html('Album')</script>";
                                    }
                                }

                                else {
                                    echo "You're here early. Why not come back another time?";
                                    echo "<script>$('.albumPlayBtn').css('display', 'none'); $('.type').html('')</script>";
                                }
                            }
                        }

                        else {
                            echo "<script>window.location = './index.php'</script>";
                        }
                    }

                    else {
                        echo "something went wrong";
                    }
                ?>
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