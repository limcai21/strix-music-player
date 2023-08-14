<!DOCTYPE html>
<html lang="en" id="loginHTML">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strix - Login</title>
    <link rel="stylesheet" href="./css/css_reset.css">
    <link rel="stylesheet" href="./css/predefine.css">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <?php 
        session_start();

        if (isset($_SESSION['username']) || isset($_SESSION['adminOrUser'])) {
            if ($_SESSION['adminOrUser'] == '0') {
                header("location: ./app/");
            }

            else {
                header("location: ./admin/");
            }
        }
    ?>





    <?php 
        if (isset($_GET['error']) && $_GET['error'] == '921341') {
            echo "<div class='errorSection'>";
            echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2c5.523 0 10 4.478 10 10s-4.477 10-10 10S2 17.522 2 12 6.477 2 12 2Zm.002 13.004a.999.999 0 1 0 0 1.997.999.999 0 0 0 0-1.997ZM12 7a1 1 0 0 0-.993.884L11 8l.002 5.001.007.117a1 1 0 0 0 1.986 0l.007-.117L13 8l-.007-.117A1 1 0 0 0 12 7Z" fill="#fff"/></svg>';
            echo "<span>Something went wrong</span>";
            echo "</div>";
        }

        if (isset($_GET['error']) && $_GET['error'] == '887619') {
            echo "<div class='errorSection'>";
            echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2c5.523 0 10 4.478 10 10s-4.477 10-10 10S2 17.522 2 12 6.477 2 12 2Zm0 13.5a1 1 0 1 0 0 2 1 1 0 0 0 0-2Zm0-8.75A2.75 2.75 0 0 0 9.25 9.5a.75.75 0 0 0 1.493.102l.007-.102a1.25 1.25 0 1 1 2.5 0c0 .539-.135.805-.645 1.332l-.135.138c-.878.878-1.22 1.447-1.22 2.53a.75.75 0 0 0 1.5 0c0-.539.135-.805.645-1.332l.135-.138c.878-.878 1.22-1.447 1.22-2.53A2.75 2.75 0 0 0 12 6.75Z" fill="#fff"/></svg>';
            echo "<span>Invalid Username or Password</span>";
            echo "</div>";
        }

        if (isset($_GET['success']) && $_GET['success'] == '868220') {
            echo "<div class='successSection'>";
            echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2Zm3.22 6.97-4.47 4.47-1.97-1.97a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l5-5a.75.75 0 1 0-1.06-1.06Z" fill="#fff"/></svg>';
            echo "<span>Sign up complete! You may now login</span>";
            echo "</div>";
        }
    ?>



    <div id="loginMain">
        <div class="loginSection">
            <div class="left">
                <div class="content">
                    <button id="backBtn" onclick="window.location = './index.php'">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M10.295 19.716a1 1 0 0 0 1.404-1.425l-5.37-5.29h13.67a1 1 0 1 0 0-2H6.336L11.7 5.714a1 1 0 0 0-1.404-1.424l-6.924 6.822a1.25 1.25 0 0 0 0 1.78l6.924 6.823Z" fill="#fff"/></svg>
                        <span>Home</span>
                    </button>

                    <div class="header">
                        <div class="subHeader">
                            <h1>Login</h1>
                            <span>No account? Sign up <a href='./signup.php'>here</a></span>
                        </div>
                    </div>

                    <form id="loginForm" action="./process/login_user.php" method="POST">
                        <div class="inputDataSection">
                            <label for="userUsername">Username:</label>
                            <input type="text" name="userUsername" id="userUsername" required oninvalid="this.setCustomValidity('Please enter your username')" oninput="this.setCustomValidity('')">
                        </div>
                        <div class="inputDataSection">
                            <label for="userPassword">Password</label>
                            <input type="password" name="userPassword" id="userPassword" required oninvalid="this.setCustomValidity('Please enter your password')" oninput="this.setCustomValidity('')">
                        </div>
                        <div class="otherDataSection">
                            <input type="submit" id="loginSubmitBtn" value="Login">
                        </div>
                    </form>
                </div>
            </div>
            <div class="right">
                <div class="content">
                    <div class="header">
                        <svg viewBox="0 0 350 115.27715536768454" id="siteLogo"><defs id="SvgjsDefs1040"></defs><g id="SvgjsG1041" featurekey="Ua4uQk-0" transform="matrix(8.016492496202558,0,0,8.016492496202558,-4.008246248101279,-46.976647098064205)" fill="#fff"><path d="M5.96 12.879999999999999 c-0.28 -0.72 -0.7 -0.96 -1.16 -0.96 c-0.42 0 -0.84 0.24 -0.84 0.64 c0 0.38 0.24 0.6 0.7 0.76 l1.32 0.46 c1.48 0.54 2.98 1.08 2.98 3.16 c0 2.1 -2.1 3.3 -4.26 3.3 c-1.94 0 -3.76 -1.14 -4.2 -2.96 l2.48 -0.78 c0.26 0.58 0.72 1.24 1.72 1.24 c0.68 0 1.12 -0.44 1.12 -0.84 c0 -0.2 -0.16 -0.46 -0.66 -0.66 l-1.22 -0.44 c-2.08 -0.76 -3.06 -1.82 -3.06 -3.3 c0 -1.94 1.8 -3.08 3.78 -3.08 c2.02 0 3.36 1.1 3.96 2.76 z M15.64 17.36 c0.56 0 0.96 -0.08 1.4 -0.2 l0 2.62 c-0.44 0.2 -1.16 0.34 -2.22 0.34 c-1.74 0 -3.2 -0.58 -3.2 -3.78 l0 -4.14 l-1.46 0 l0 -2.6 l1.46 0 l0 -2.44 l3.16 0 l0 2.44 l2.22 0 l0 2.6 l-2.22 0 l0 4.14 c0 0.46 0.12 1.02 0.86 1.02 z M25.400000000000002 9.44 c0.28 0 0.56 0 0.82 0.06 l0 3.02 c-0.24 -0.06 -0.52 -0.06 -0.72 -0.06 c-1.92 0 -3.46 1.38 -3.62 3.3 l0 4.24 l-3.16 0 l0 -10.4 l3.16 0 l0 2.54 c0.48 -1.56 1.68 -2.7 3.52 -2.7 z M31.000000000000004 5.859999999999999 l0 2.66 l-3.16 0 l0 -2.66 l3.16 0 z M31.000000000000004 9.6 l0 10.4 l-3.16 0 l0 -10.4 l3.16 0 z M40.540000000000006 20 l-2.16 -3.04 l-2.14 3.04 l-3.62 0 l3.94 -5.34 l-3.54 -5.06 l3.58 0 l1.78 2.78 l1.8 -2.78 l3.58 0 l-3.56 5.06 l3.96 5.34 l-3.62 0 z"></path></g></svg>
                    </div>
                    <div class="illustrations">
                        <img class="sidePic" src="./img/happy_music.svg"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>