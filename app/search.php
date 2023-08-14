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
        $queryValue = "";

        if (isset($_GET['query'])) {
            if ($_GET['query'] != "") {
                $queryValue = $_GET['query'];
            }
        }

        include_once("./dbInfo.php");
    ?>

    
    <div class="pageContent">
        <?php include_once("./sidebar.php") ?>

        <div id='main' class="searchMainDiv">
            <div class="welcomeUser">
                <h1>Search</h1>
                <input type="search" placeholder="Search for songs, albums & playlists" id="searchbar" value="<?= $queryValue ?>">
            </div>

            <div class="searchResultSection">
                <div class="songResult result">
                    <h3>Song</h3>
                    <div class="songResultList resultList">
                        <!-- OUTPUT -->
                    </div>
                </div>

                <div class="albumResult result">
                    <h3>Album</h3>
                    <div class="albumResultList resultList">
                        <!-- OUTPUT -->
                    </div>
                </div>
                
                <div class="playlistResult result">
                    <h3>Playlist</h3>
                    <div class="playlistResultList resultList">
                        <!-- OUTPUT -->
                    </div>
                </div>
            </div>
        </div>
    </div>


    


    <?php
        include_once("./player.php");
    ?>
</body>

</html>