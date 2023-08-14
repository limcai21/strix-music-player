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


        include_once("./dbInfo.php");
    ?>

    <div class="pageContent">
        <?php include_once("./sidebar.php") ?>


        <div id='main'>
            <?php 
                include_once("./dbInfo.php");

                $username = $_SESSION['username'];
                $userID = $_SESSION['userID'];
                $playlistID = $_GET['id'];
                $explictSVG = '<svg class="explicitIcon" width="24" height="24" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M1.59 8.991h5.82c1.043 0 1.582-.538 1.582-1.566v-5.85C8.992.547 8.453.008 7.41.008H1.59C.552.008.008.542.008 1.575v5.85c0 1.028.544 1.566 1.582 1.566zm1.812-2.273c-.332 0-.505-.211-.505-.553V2.753c0-.341.173-.553.505-.553h2.264c.245 0 .408.14.408.385 0 .235-.163.384-.408.384H3.854v1.106h1.71c.226 0 .38.125.38.355 0 .221-.154.346-.38.346h-1.71V5.95h1.812c.245 0 .408.14.408.385 0 .235-.163.384-.408.384H3.402z"></path></svg>';
                $lockSVG = '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2a4 4 0 0 1 4 4v2h2.5A1.5 1.5 0 0 1 20 9.5v11a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 4 20.5v-11A1.5 1.5 0 0 1 5.5 8H8V6a4 4 0 0 1 4-4Zm0 11.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3ZM12 4a2 2 0 0 0-2 2v2h4V6a2 2 0 0 0-2-2Z" fill="#fff"/></svg>';
                $unlockSVG = '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.001a4 4 0 0 1 3.771 2.666 1 1 0 0 1-1.84.774l-.045-.107a2 2 0 0 0-3.88.517L10.002 6v1.999h7.749a2.25 2.25 0 0 1 2.245 2.097l.005.154v9.496a2.25 2.25 0 0 1-2.096 2.245l-.154.005H6.25A2.25 2.25 0 0 1 4.005 19.9L4 19.746V10.25a2.25 2.25 0 0 1 2.096-2.245L6.25 8l1.751-.001v-2A3.999 3.999 0 0 1 12 2.002Zm0 11.498a1.499 1.499 0 1 0 0 2.998 1.499 1.499 0 0 0 0-2.998Z" fill="#fff"/></svg>';
                $notFavouritePlaylist = '';

                $sqlStatement = "SELECT playlist.playlistID, playlist.playlistName, playlist.playlistOwner, playlist.playlistPrivate, playlist.playlistCover, user.userUsername, playlist.playlistOwner FROM `playlist` RIGHT JOIN user ON user.userID = playlist.playlistOwner WHERE playlistID = '$playlistID'";

                if ($result = $mysqli -> query($sqlStatement)) {
                    $numOfRow = $result -> num_rows;
                    
                    if ($numOfRow > 0) {
                        $record = $result -> fetch_row();
                        $playlistID = $record[0];
                        $playlistName = $record[1];
                        $playlistOwner = $record[2];
                        $playlistPrivate = $record[3];
                        $playlistCover = $record[4];
                        $playlistOwnerUsername = $record[5];
                        $playlistOwnerID = $record[6];

                        // CHECK IF PLAYLIST IS PRIVATE OR NOT
                        if ($playlistPrivate == '1') {
                            if ($playlistOwner != $userID) {
                                echo "<script>window.location = './index.php'</script>";
                            }
                        }


                        // CHECK FOR PLAYLIST COVER
                        if ($playlistName == 'Favourites') {
                            $playlistCover = "https://raw.githubusercontent.com/limcai21/project-music/main/img/favouriteCover.png";
                            $backgroundCover = "../img/favouriteCover.png";
                            $erroPlaylistCover = "../img/favouriteCover.png";
                        }

                        else {
                            if ($playlistCover != "") {
                                $playlistCover = "data:image/png;base64,$playlistCover";
                                $backgroundCover = "../img/newPlaylistCover.png";
                                $erroPlaylistCover = "../img/newPlaylistCover.png";
                            }

                            else {
                                $playlistCover = "https://raw.githubusercontent.com/limcai21/project-music/main/img/newPlaylistCover.png";
                                $backgroundCover = "../img/newPlaylistCover.png";
                                $erroPlaylistCover = "../img/newPlaylistCover.png";
                            }
                        }


                        // CHECK IF PLAYLIST PRIVATE OR NOT, ASSIGN SVG 
                        if ($playlistPrivate == '1') {
                            $playlistPrivateText = "Private";
                            $outputSVG = $lockSVG;
                        }

                        else {
                            $playlistPrivateText = "Public";
                            $outputSVG = $unlockSVG;
                        }

                        
                        if ($playlistName != "Favourites") {
                            $notFavouritePlaylist = 'notFavouritePlaylist';
                        }
            ?>

            <div class="playlistContent">
                <!-- HEADER -->
                <div class="header" style="background-image: url('<?= $playlistCover ?>'), url('<?= $backgroundCover ?>')">
                    <div class="headerContent backgroundBlur <?= $notFavouritePlaylist ?>">
                        <div class="left" id="playlistCoverArt">
                            <img id="playlistCoverArtImg" src="<?= $playlistCover ?>" alt='<?= $playlistName ?> Playlist Cover' onerror='this.src=`<?= $erroPlaylistCover ?>`'>
                        </div>
                        <div class="right">
                            <div class="top">
                                <span class="type smallText">Playlist</span>
                                <h1 id="playlistTitle"><?= $playlistName ?></h1>
                                <span class="errorMsg" id="newPlaylistTitleError">
                            </div>

                            <div class="bottom">
                                <span class="playlistOwner smallText" currentuser='<?= $username ?>'><?= $playlistOwnerUsername ?></span>
                                <span class="smallText">&bull;</span>
                                <span class="amountOfSongs smallText"></span>
                            </div>
                        </div>
                    </div>
                </div>  

                <!-- QUICK ACTIONS -->
                <div class="quickActions">
                    <button class='playlistPlayBtn' accent='navIconAndText' playlistid=<?= $playlistID ?>>
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.274c0-1.707 1.826-2.792 3.325-1.977l12.362 6.726c1.566.853 1.566 3.101 0 3.953L8.325 20.702C6.826 21.518 5 20.432 5 18.726V5.274Z" fill="#fff"/></svg>
                        <span>Play</span>
                    </button>

                    <?php 
                        if ($playlistOwnerUsername == $username) {
                            if ($playlistName != "Favourites") {
                    ?>


                    <button id='playlistEditName' accent='navIconAndText' playlistid=<?= $playlistID ?>>
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M13.94 5 19 10.06 9.062 20a2.25 2.25 0 0 1-.999.58l-5.116 1.395a.75.75 0 0 1-.92-.921l1.395-5.116a2.25 2.25 0 0 1 .58-.999L13.938 5Zm7.09-2.03a3.578 3.578 0 0 1 0 5.06l-.97.97L15 3.94l.97-.97a3.578 3.578 0 0 1 5.06 0Z" fill="#fff"/></svg>
                        <span>Edit</span>
                    </button>
                    <button id='playlistLock' accent='navIconAndText' playlistid=<?= $playlistID ?> playliststatus=<?= $playlistPrivate ?>>
                        <?= $outputSVG ?>    
                        <span><?= $playlistPrivateText ?></span>
                    </button>
                    <button id='playlistDelete' accent='navIconAndText' playlistid=<?= $playlistID ?>>
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21.5 6a1 1 0 0 1-.883.993L20.5 7h-.845l-1.231 12.52A2.75 2.75 0 0 1 15.687 22H8.313a2.75 2.75 0 0 1-2.737-2.48L4.345 7H3.5a1 1 0 0 1 0-2h5a3.5 3.5 0 1 1 7 0h5a1 1 0 0 1 1 1Zm-7.25 3.25a.75.75 0 0 0-.743.648L13.5 10v7l.007.102a.75.75 0 0 0 1.486 0L15 17v-7l-.007-.102a.75.75 0 0 0-.743-.648Zm-4.5 0a.75.75 0 0 0-.743.648L9 10v7l.007.102a.75.75 0 0 0 1.486 0L10.5 17v-7l-.007-.102a.75.75 0 0 0-.743-.648ZM12 3.5A1.5 1.5 0 0 0 10.5 5h3A1.5 1.5 0 0 0 12 3.5Z" fill="#fff"/></svg>                        
                        <span>Delete</span>
                    </button>

                    <?php 
                            }
                        }
                    ?>
                </div>  

                <!-- TRACK LIST SECTION -->
                <div class="songListSection">   
                    <?php 
                        $sqlStatement = "SELECT playlist_songs.songID, song.songTitle, song.songArtist, song.songExplicit, song.songDuration, playlist_songs.playlistSongID FROM `playlist_songs` RIGHT JOIN song ON playlist_songs.songID = song.songID WHERE playlistIDFK = '$playlistID' ORDER BY playlist_songs.playlistSongID ASC";

                        if ($result = $mysqli -> query($sqlStatement)) {
                            $numOfRow = $result -> num_rows;

                            if ($numOfRow > 0) {
                                for ($i = 0; $i < $numOfRow; $i++) {
                                    $record = $result -> fetch_row();

                                    $songID = $record[0];
                                    $songTitle = $record[1];
                                    $songArtist = $record[2];
                                    $songExplicit = $record[3] == 1 ? $explictSVG : '';
                                    $songDuration = $record[4];
                                    $playlistSongID = $record[5];

                                    // CHECK WHETHER SONG IS USER FAV SONG
                                    $sqlStatement2 = "SELECT * FROM `playlist` RIGHT JOIN playlist_songs ON playlist_songs.playlistIDFK = playlist.playlistID WHERE playlistName = 'Favourites' AND playlistOwner = '$userID' AND songID = '$songID' AND favOrNot = 1"; 
                                    $heartFillSVG = '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12.82 5.58-.82.822-.824-.824a5.375 5.375 0 1 0-7.601 7.602l7.895 7.895a.75.75 0 0 0 1.06 0l7.902-7.897a5.376 5.376 0 0 0-.001-7.599 5.38 5.38 0 0 0-7.611 0Z" fill="#fff"/></svg>';
                                    $heartNotFillSVG = '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12.82 5.58-.82.822-.824-.824a5.375 5.375 0 1 0-7.601 7.602l7.895 7.895a.75.75 0 0 0 1.06 0l7.902-7.897a5.376 5.376 0 0 0-.001-7.599 5.38 5.38 0 0 0-7.611 0Zm6.548 6.54L12 19.485 4.635 12.12a3.875 3.875 0 1 1 5.48-5.48l1.358 1.357a.75.75 0 0 0 1.073-.012L13.88 6.64a3.88 3.88 0 0 1 5.487 5.48Z" fill="#fff"/></svg>';
                                    $favouriteOrNot = 0;
                                    $selectedSVG = $heartNotFillSVG;

                                    if ($result2 = $mysqli -> query($sqlStatement2)) {
                                        $numOfRows2 = $result2 -> num_rows;

                                        if ($numOfRows2 == 1) {
                                            $favouriteOrNot = 1;
                                            $selectedSVG = $heartFillSVG;
                                        }

                                        else {
                                            $selectedSVG = $heartNotFillSVG;
                                        }
                                }   
                    ?>
                    
                    <div class="indivualSongList" playlistsongid = <?= $playlistSongID ?>>
                        <div class="left">
                            <label class="trackNo"><?= $i + 1 ?></label>
                            <button class="playIndividualSong" songid=<?= $songID ?>>
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.274c0-1.707 1.826-2.792 3.325-1.977l12.362 6.726c1.566.853 1.566 3.101 0 3.953L8.325 20.702C6.826 21.518 5 20.432 5 18.726V5.274Z" fill="#fff"/></svg>
                            </button>
                            <div class="titleAndDuration">
                                <label class="songTitle"><?= $songTitle, $songExplicit ?></label>
                                <label><?= $songDuration ?></label>
                            </div>
                        </div>

                        <div class="right">
                            <button class="favouriteBtn" songid=<?= $songID ?> favourite=<?= $favouriteOrNot ?>>
                                <?= $selectedSVG ?>     
                            </button>
                            <button class="moreBtn" playlistowner = <?= $playlistOwnerID ?> userid = <?= $userID ?>>
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M8 12a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM14 12a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM18 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" fill="#fff"/></svg>
                            </button>
                        </div>
                    </div>

            <?php 
                                }
                            }

                            else {
                                if ($playlistOwnerUsername == $username) {
                                    echo "<div class='noSongInPlaylist'>";
                                    echo "<span>No song here yet. Find some and add in!</span>";
                                    echo "</div>";
                                    echo "<button id='playlistToSearch'>Find</button>";
                                    echo "<script>$('.playlistPlayBtn').css('display', 'none')</script>";
                                }

                                else {
                                    echo "<div class='noSongInPlaylist'>";
                                    echo "<span>No song in playlist yet</span>";
                                    echo "</div>";
                                    echo "<script>$('.quickActions').css('display', 'none')</script>";
                                    echo "<script>$('.playlistContent .header .headerContent').css('padding-bottom', '60px')</script>";
                                }
                            }

                            echo "<script>$('.amountOfSongs').html('$numOfRow songs')</script>";
                        }
                    }

                    else {
                        echo "<script>window.location = './index.php'</script>";
                    }
                }
            ?>
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