<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strix - Sign Up</title>
    <link rel="stylesheet" href="./css/css_reset.css">
    <link rel="stylesheet" href="./css/predefine.css">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/signUp.css">
    <script src="./js/jquery.js"></script>
</head>
<body>
    <?php 
        session_start();

        $login = false;
    ?>


    <?php 
        if (isset($_GET['error']) && $_GET['error'] == '921341') {
            echo "<div class='errorSection'>";
            echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2c5.523 0 10 4.478 10 10s-4.477 10-10 10S2 17.522 2 12 6.477 2 12 2Zm.002 13.004a.999.999 0 1 0 0 1.997.999.999 0 0 0 0-1.997ZM12 7a1 1 0 0 0-.993.884L11 8l.002 5.001.007.117a1 1 0 0 0 1.986 0l.007-.117L13 8l-.007-.117A1 1 0 0 0 12 7Z" fill="#fff"/></svg>';
            echo "<span>Something went wrong</span>";
            echo "</div>";
        }

        if (isset($_GET['error']) && $_GET['error'] == '429516') {
            echo "<div class='errorSection'>";
            echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2c5.523 0 10 4.478 10 10s-4.477 10-10 10S2 17.522 2 12 6.477 2 12 2Zm.002 13.004a.999.999 0 1 0 0 1.997.999.999 0 0 0 0-1.997ZM12 7a1 1 0 0 0-.993.884L11 8l.002 5.001.007.117a1 1 0 0 0 1.986 0l.007-.117L13 8l-.007-.117A1 1 0 0 0 12 7Z" fill="#fff"/></svg>';
            echo "<span>Fail to create account</span>";
            echo "</div>";
        }

        if (isset($_GET['error']) && $_GET['error'] == '137197') {
            echo "<div class='errorSection'>";
            echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2Zm3.53 6.47-.084-.073a.75.75 0 0 0-.882-.007l-.094.08L12 10.939l-2.47-2.47-.084-.072a.75.75 0 0 0-.882-.007l-.094.08-.073.084a.75.75 0 0 0-.007.882l.08.094L10.939 12l-2.47 2.47-.072.084a.75.75 0 0 0-.007.882l.08.094.084.073a.75.75 0 0 0 .882.007l.094-.08L12 13.061l2.47 2.47.084.072a.75.75 0 0 0 .882.007l.094-.08.073-.084a.75.75 0 0 0 .007-.882l-.08-.094L13.061 12l2.47-2.47.072-.084a.75.75 0 0 0 .007-.882l-.08-.094-.084-.073.084.073Z" fill="#fff"/></svg>';
            echo "<span>Username or Email has been taken</span>";
            echo "</div>";
        }
    ?>

    <div id="signupMain">
        <div class="signUpSection">
            <div class="left">
                <div class="content">
                    <button id="backBtn" onclick="window.location = './index.php'">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M10.295 19.716a1 1 0 0 0 1.404-1.425l-5.37-5.29h13.67a1 1 0 1 0 0-2H6.336L11.7 5.714a1 1 0 0 0-1.404-1.424l-6.924 6.822a1.25 1.25 0 0 0 0 1.78l6.924 6.823Z" fill="#fff"/></svg>
                        <span>Home</span>
                    </button>

                    <div class="header">
                        <div class="subHeader">
                            <h1>Sign Up</h1>
                            <span>Have an account? <a href='./login.php'>Login</a></span>
                        </div>
                    </div>

                    <form action="./process/register_user.php" method="post" id="signUpForm">
                        <div class="inputDataSection">
                            <label for="userUsername">Username:</label>
                            <input type="text" name="userUsername" id="userUsername">
                            <span class="errorMsg" id="userUsernameError"></span>
                        </div>
                        <div class="inputDataSection">
                            <label for="userContactNo">Contact Number:</label>
                            <input type="text" name="userContactNo" id="userContactNo" maxlength="8">
                            <span class="errorMsg" id="userContactNoError"></span>
                        </div>
                        <div class="inputDataSection">
                            <label for="userEmail">Email:</label>
                            <input type="text" name="userEmail" id="userEmail">
                            <span class="errorMsg" id="userEmailError"></span>
                        </div>
                        <div class="passwordSection">
                            <div class="inputDataSection">
                                <label for="userPassword">Password:</label>
                                <input type="password" name="userPassword" id="userPassword">
                                <span class="errorMsg" id="userPasswordError"></span>
                            </div>
                            <div class="inputDataSection">
                                <label for="userPasswordRetype">Retpye Password:</label>
                                <input type="password" name="userPasswordRetype" id="userPasswordRetype">
                                <span class="errorMsg" id="userPasswordRetypeError"></span>
                            </div>
                        </div>
                        <div class="otherDataSection">
                            <input type="submit" id="signUpSubmitBtn" value="Create Account">
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
                        <img class="sidePic" src="./img/mello.svg"/>
                        <h2>Let's get the party started!</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./js/signUp.js"></script>
</body>
</html>