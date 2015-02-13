<?php

require_once 'utilities.php';
checkLogin();

# Load database
require "../includes/Flintstone/vendor/autoload.php";
use Flintstone\Flintstone;

$options = array('dir' => '../database/'); // Set options
$site = Flintstone::load('site', $options); // Load the databases

# Save generic title/motto/footer opsions
$site->set('header', array('title' => $_POST['site_title'],
                           'motto' => $_POST['site_motto']));
$site->set('footer', $_POST['site_footer']);
?>
<h1>Done editing the site settings</h1>
<? goBack(); ?>