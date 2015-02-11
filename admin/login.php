<?php

require_once 'utilities.php';

session_start();

//THIS IS NOT CHECKLOGIN, CAN'T USE checkLogin() here
if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
    header("Location: index.php");
    die();
}

# Check if password hash received corresponds to stored password
if (isset($_POST['hashed_password'])) {
    require_once "config.php";
    $stored_password = hash("sha512", $login_password);
    $received_password = $_POST['hashed_password'];
    if ($stored_password == $received_password)
    {
        $_SESSION['logged'] = true;
        ?>
        <h1>Logged in</h1>
        <?php
        goBack();
        die();
    }
}

# Else show the login form

?>

<head>
<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha512.js"></script>
<script>
function sendHash()
{
    var password = document.getElementById("password").value; 
    var hash = CryptoJS.SHA512(password);
    hashed_password = document.getElementById("hashed_password");
    hashed_password.value = hash;
    document.getElementById('login_form').submit();
}
</script>
</head>

<p>password: <input type="password" id="password"></p>

<form id="login_form" action="login.php" method="post">
<input type="hidden" value="" name="hashed_password" id="hashed_password">
<input type="button" value="login" onclick="sendHash()">
</form>
