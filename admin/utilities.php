<?php

require 'config.php';

function forceSSL()
{
    global $base_url;
    //echo "forceSSL ";
    if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on')
    {
        header("Location: https://".$base_url."/admin/login.php");
        exit(); //HERE IS WHY http://thedailywtf.com/articles/WellIntentioned-Destruction
    }
}

# Forces usage of ssl and verifies the admin is logged in
function checkLogin ()
{
    global $force_https;
    if ($force_https === true)
        forceSSL();

    session_start();
    if (!isset($_SESSION['logged']) && $_SESSION['logged'] !== true)
    {
        header("Location: login.php");
        die();
    }
}

# Shows links to admin and homepage indexes
function goBack()
{
    echo '<a href="index.php">Admin</a><br/>'."\n";
    echo '<a href="../index.php">Homepage</a>'."\n";
}
?>