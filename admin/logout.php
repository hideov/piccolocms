<?php
require_once 'utilities.php';
session_start();

// remove all session variables
session_unset();

// destroy the session
session_destroy();
?>

<h1>Logout done</h1>
<?php goBack(); ?>