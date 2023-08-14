<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    include_once("./dbInfo.php");

    $username = $_SESSION['username'];
    $userID = $_SESSION['userID'];
?>

<nav id="sideNavBar">
    <div class="content">
        <div class="top">
            <svg viewBox="0 0 350 115.27715536768454" id="siteLogo"><defs id="SvgjsDefs1040"></defs><g id="SvgjsG1041" featurekey="Ua4uQk-0" transform="matrix(8.016492496202558,0,0,8.016492496202558,-4.008246248101279,-46.976647098064205)" fill="#fff"><path d="M5.96 12.879999999999999 c-0.28 -0.72 -0.7 -0.96 -1.16 -0.96 c-0.42 0 -0.84 0.24 -0.84 0.64 c0 0.38 0.24 0.6 0.7 0.76 l1.32 0.46 c1.48 0.54 2.98 1.08 2.98 3.16 c0 2.1 -2.1 3.3 -4.26 3.3 c-1.94 0 -3.76 -1.14 -4.2 -2.96 l2.48 -0.78 c0.26 0.58 0.72 1.24 1.72 1.24 c0.68 0 1.12 -0.44 1.12 -0.84 c0 -0.2 -0.16 -0.46 -0.66 -0.66 l-1.22 -0.44 c-2.08 -0.76 -3.06 -1.82 -3.06 -3.3 c0 -1.94 1.8 -3.08 3.78 -3.08 c2.02 0 3.36 1.1 3.96 2.76 z M15.64 17.36 c0.56 0 0.96 -0.08 1.4 -0.2 l0 2.62 c-0.44 0.2 -1.16 0.34 -2.22 0.34 c-1.74 0 -3.2 -0.58 -3.2 -3.78 l0 -4.14 l-1.46 0 l0 -2.6 l1.46 0 l0 -2.44 l3.16 0 l0 2.44 l2.22 0 l0 2.6 l-2.22 0 l0 4.14 c0 0.46 0.12 1.02 0.86 1.02 z M25.400000000000002 9.44 c0.28 0 0.56 0 0.82 0.06 l0 3.02 c-0.24 -0.06 -0.52 -0.06 -0.72 -0.06 c-1.92 0 -3.46 1.38 -3.62 3.3 l0 4.24 l-3.16 0 l0 -10.4 l3.16 0 l0 2.54 c0.48 -1.56 1.68 -2.7 3.52 -2.7 z M31.000000000000004 5.859999999999999 l0 2.66 l-3.16 0 l0 -2.66 l3.16 0 z M31.000000000000004 9.6 l0 10.4 l-3.16 0 l0 -10.4 l3.16 0 z M40.540000000000006 20 l-2.16 -3.04 l-2.14 3.04 l-3.62 0 l3.94 -5.34 l-3.54 -5.06 l3.58 0 l1.78 2.78 l1.8 -2.78 l3.58 0 l-3.56 5.06 l3.96 5.34 l-3.62 0 z"></path></g></svg>
            <button accent='navIconAndText' class="logoutBtn" onclick="window.location = '../logout.php'" title="Logout">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 4.354v6.651l7.442-.001L17.72 9.28a.75.75 0 0 1-.073-.976l.073-.084a.75.75 0 0 1 .976-.073l.084.073 2.997 2.997a.75.75 0 0 1 .073.976l-.073.084-2.996 3.004a.75.75 0 0 1-1.134-.975l.072-.085 1.713-1.717-7.431.001L12 19.25a.75.75 0 0 1-.88.739l-8.5-1.502A.75.75 0 0 1 2 17.75V5.75a.75.75 0 0 1 .628-.74l8.5-1.396a.75.75 0 0 1 .872.74ZM8.502 11.5a1.002 1.002 0 1 0 0 2.004 1.002 1.002 0 0 0 0-2.004Z" fill="#fff"/><path d="M13 18.501h.765l.102-.006a.75.75 0 0 0 .648-.745l-.007-4.25H13v5.001ZM13.002 10 13 8.725V5h.745a.75.75 0 0 1 .743.647l.007.102.007 4.251h-1.5Z" fill="#fff"/></svg>                    
            </button>
        </div>

        <div class="middle">
            <label for='navDrop' id="navDropLabel">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M3 17h18a1 1 0 0 1 .117 1.993L21 19H3a1 1 0 0 1-.117-1.993L3 17h18H3Zm0-6 18-.002a1 1 0 0 1 .117 1.993l-.117.007L3 13a1 1 0 0 1-.117-1.993L3 11l18-.002L3 11Zm0-6h18a1 1 0 0 1 .117 1.993L21 7H3a1 1 0 0 1-.117-1.993L3 5h18H3Z" fill="#fff"/></svg>
            </label>
            <input type="checkbox" id="navDrop">
            <div class="navigationButton">
                <button accent='navIconAndText' id="homeBtn" title="Home">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M10.55 2.533a2.25 2.25 0 0 1 2.9 0l6.75 5.695c.508.427.8 1.056.8 1.72v9.802a1.75 1.75 0 0 1-1.75 1.75h-3a1.75 1.75 0 0 1-1.75-1.75v-5a.75.75 0 0 0-.75-.75h-3.5a.75.75 0 0 0-.75.75v5a1.75 1.75 0 0 1-1.75 1.75h-3A1.75 1.75 0 0 1 3 19.75V9.947c0-.663.292-1.292.8-1.72l6.75-5.694Z" fill="#fff"/></svg>
                    <span>Home</span>
                </button>

                <button accent='navIconAndText' id="searchBtn" title="Search">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M10 2.5a7.5 7.5 0 0 1 5.964 12.048l4.743 4.745a1 1 0 0 1-1.32 1.497l-.094-.083-4.745-4.743A7.5 7.5 0 1 1 10 2.5Zm0 2a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11Z" fill="#fff"/></svg>
                    <span>Search</span>
                </button>

                <button accent='navIconAndText' id="libraryBtn" title="Library">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 3A1.5 1.5 0 0 1 7 4.5v15A1.5 1.5 0 0 1 5.5 21h-2A1.5 1.5 0 0 1 2 19.5v-15A1.5 1.5 0 0 1 3.5 3h2Zm6 0A1.5 1.5 0 0 1 13 4.5v15a1.5 1.5 0 0 1-1.5 1.5h-2A1.5 1.5 0 0 1 8 19.5v-15A1.5 1.5 0 0 1 9.5 3h2Zm7.281 3.124 3.214 12.519a1.5 1.5 0 0 1-1.08 1.826l-1.876.48a1.5 1.5 0 0 1-1.826-1.08L13.999 7.354a1.5 1.5 0 0 1 1.08-1.826l1.876-.483a1.502 1.502 0 0 1 1.826 1.08Z" fill="#fff"/></svg>
                    <span>Library</span>
                </button>
                <button accent='navIconAndText' id="accountBtn" title="Account">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.754 14a2.249 2.249 0 0 1 2.25 2.249v.918a2.75 2.75 0 0 1-.513 1.599C17.945 20.929 15.42 22 12 22c-3.422 0-5.945-1.072-7.487-3.237a2.75 2.75 0 0 1-.51-1.595v-.92a2.249 2.249 0 0 1 2.249-2.25h11.501ZM12 2.004a5 5 0 1 1 0 10 5 5 0 0 1 0-10Z" fill="#fff"/></svg>                        
                    <span>Account</span>
                </button>
                <?php 
                    if ($_SESSION['adminOrUser'] == '1') {
                ?>
                 <button accent='navIconAndText' id="adminPortalBtn" title="Admin Portal">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M11.499 9.5 11.5 21H6.25a3.25 3.25 0 0 1-3.245-3.065L3 17.752V9.499h8.499Zm1.5 5.999H21.5v2.253a3.25 3.25 0 0 1-3.25 3.25L13 21l-.001-5.502Zm5.252-13a3.25 3.25 0 0 1 3.245 3.065l.005.184-.001 8.251h-8.501L13 2.498h5.251ZM11.5 2.497 11.499 8H3V5.748a3.25 3.25 0 0 1 3.25-3.25h5.25Z" fill="#fff"/></svg>
                    <span>Admin Portal</span>
                </button>
                <?php
                    }
                ?>
                <button accent='navIconAndText' class="logoutBtn" onclick="window.location = '../logout.php'" title="Logout">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 4.354v6.651l7.442-.001L17.72 9.28a.75.75 0 0 1-.073-.976l.073-.084a.75.75 0 0 1 .976-.073l.084.073 2.997 2.997a.75.75 0 0 1 .073.976l-.073.084-2.996 3.004a.75.75 0 0 1-1.134-.975l.072-.085 1.713-1.717-7.431.001L12 19.25a.75.75 0 0 1-.88.739l-8.5-1.502A.75.75 0 0 1 2 17.75V5.75a.75.75 0 0 1 .628-.74l8.5-1.396a.75.75 0 0 1 .872.74ZM8.502 11.5a1.002 1.002 0 1 0 0 2.004 1.002 1.002 0 0 0 0-2.004Z" fill="#fff"/><path d="M13 18.501h.765l.102-.006a.75.75 0 0 0 .648-.745l-.007-4.25H13v5.001ZM13.002 10 13 8.725V5h.745a.75.75 0 0 1 .743.647l.007.102.007 4.251h-1.5Z" fill="#fff"/></svg>                    
                    <span>Logout</span>
                </button>
            </div>
        </div>


        <div class="seperatorH"></div>

        <div class="bottom">
            <div class="userPlaylist">
                <div class="createPlaylist" userid = <?= $userID ?>>
                    <div class="left">
                        <img src="../img/addCover.png">
                    </div>
                    <div class="right">
                        <span>Create Playlist</span>
                    </div>
                </div>

                <?php 
                    $sqlStatement = "SELECT playlistID, playlistCover, playlistName FROM `playlist` WHERE playlistName = 'Favourites' AND playlistOwner = '$userID'";

                    if ($result = $mysqli -> query($sqlStatement)) {
                        $record = $result -> fetch_row();
                        $playlistID = $record[0];
                        $playlistCover = base64_encode($record[1]);
                        $playlistName = $record[2];

                        if ($playlistCover == '') {
                            $imageOutput = "https://raw.githubusercontent.com/limcai21/project-music/main/img/favouriteCover.png";
                        }

                        else {
                            $imageOutput = "data:image/png;base64,$playlistCover";
                        }
                    }
                ?>

                <div id="likeSongPlaylist" playlistid=<?= $playlistID ?>>
                    <div class="left">
                        <img src=<?= $imageOutput ?> alt='<?= $playlistName ?> Playlist Cover' onerror='this.src=`../img/favouriteCover.png`'>
                    </div>
                    <div class="right">
                        <span><?= $playlistName ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
