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

        $sqlStatement = "SELECT * FROM `playlist` WHERE playlistOwner = '$userID'";

        if ($result = $mysqli -> query($sqlStatement)) {
            $numOfRows = $result -> num_rows;

            if ($numOfRows == 1) {
                $record = $result -> fetch_row();
                $playlistID = $record[0];
            }
        }
    ?>

    
    <div class="pageContent">
        <?php include_once("./sidebar.php") ?>

        <div id='main'>
            <div class="welcomeUser" id="libraryWelcomeUser">
                <h1>Library</h1>
                <button class="createPlaylist" id="libraryCreatePlaylist" userid = <?= $userID ?> title="Create new playlist">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M11.883 3.007 12 3a1 1 0 0 1 .993.883L13 4v7h7a1 1 0 0 1 .993.883L21 12a1 1 0 0 1-.883.993L20 13h-7v7a1 1 0 0 1-.883.993L12 21a1 1 0 0 1-.993-.883L11 20v-7H4a1 1 0 0 1-.993-.883L3 12a1 1 0 0 1 .883-.993L4 11h7V4a1 1 0 0 1 .883-.993L12 3l-.117.007Z" fill="#fff"/></svg>
                </button>
            </div>
            
            <div class="allPlaylistSection">
                <div id="libraryFavouriteSection" playlistid=<?= $playlistID ?>>
                    <div class="content backgroundBlur">
                        <div class="left">
                            <h2>Favourites</h2>
                            <span>Find all your favourites here</span>
                        </div>
                        <div class="right">
                            <img src='https://raw.githubusercontent.com/limcai21/project-music/main/img/favouriteCover.png' alt='Favourite Playlist Cover' onerror='this.src=`../img/favouriteCover.png`'>
                        </div>
                    </div>
                </div>

                <?php 
                    $sqlStatement = "SELECT * FROM `playlist` RIGHT JOIN user ON user.userID = playlist.playlistOwner WHERE NOT playlist.playlistName = 'Favourites' AND playlist.playlistOwner = '$userID' ORDER BY playlistID DESC";
                    if ($result = $mysqli -> query($sqlStatement)) {
                        $numOfRows = $result -> num_rows;
            
                        if ($numOfRows > 0) {
                ?>

                <div class="otherPlaylistSection">
                    <?php 
                            for ($i = 0; $i < $numOfRows; $i++) {
                                $record = $result -> fetch_row();
                                $playlistID = $record[0];
                                $playlistName = $record[1];
                                $playlistCover = $record[4];
                                $playlistOwner = $record[6];

                                if ($playlistCover == '') {
                                    $playlistCover = "https://raw.githubusercontent.com/limcai21/project-music/main/img/newPlaylistCover.png";
                                }
        
                                else {
                                    $playlistCover = "data:image/png;base64,$playlistCover";
                                }
                    ?>
                    <div class="individualPlaylistSearch individualSearch" playlistid=<?= $playlistID ?> bis_skin_checked="1">
                        <div class="left" bis_skin_checked="1">
                            <img src="<?= $playlistCover ?>" alt='<?= $playlistName ?> Playlist Cover' onerror='this.src=`../img/newPlaylistCover.png`'>
                        </div>
                        <div class="right" bis_skin_checked="1">
                            <div class="titleAndArtist" bis_skin_checked="1">
                                <label class="title"><?= $playlistName ?></label>
                                <span class="artist"><?= $playlistOwner ?></span>
                            </div>
                            <?php 
                                // Check Number of Song inside 
                                $sqlStatement = "SELECT * FROM `playlist_songs` WHERE playlistIDFK = '$playlistID'";
                                if ($result2 = $mysqli -> query($sqlStatement)) {
                                    $numOfRows2 = $result2 -> num_rows;

                                    if ($numOfRows2 > 0) {
                            ?>
                            <div class="actionBtn" bis_skin_checked="1">
                                <button class="playlistPlayBtn" playlistid="<?= $playlistID ?>">
                                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.274c0-1.707 1.826-2.792 3.325-1.977l12.362 6.726c1.566.853 1.566 3.101 0 3.953L8.325 20.702C6.826 21.518 5 20.432 5 18.726V5.274Z" fill="#fff"></path></svg>
                                </button>
                            </div>
                            <?php 
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <?php 
                            }
                        }

                        else {
                            echo "<span>Looks like you don't have a playlist yet. Click the '<b style='font-weight: 700; font-size: 24px;'>+</b>' at the top right to create</span>";
                        }
                    ?>
                </div>

                <?php 
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