<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strix - Edit</title>
    <link rel="stylesheet" href="./css/css_reset.css">
    <link rel="stylesheet" href="./../css/predefine.css">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/edit.css">
    <script src="./js/jquery.js"></script>
    <script src="./js/global.js"></script>
    <script src="./js/edit.js"></script>
</head>
<body>
    <?php include_once("./header.php"); ?>

    <div class="main" id="editMainDiv">
        <div class="header">
            <h1>What do you want to Edit?</h1> 
        </div>

        <div class="actionBtn choiceBtn">
            <button onclick="window.location = './edit_album.php'">
                <span>Album</span>
            </button>
            <button onclick="window.location = './edit_song.php'">
                <span>Song</span>
            </button>
        </div>
    </div>

    <?php include_once("../footer.php") ?>

</body>
</html>