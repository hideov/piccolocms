<?php

require_once 'utilities.php';
checkLogin();


# This file depends on a modified FlinstoneDB.php (one method added)
# We swap the order of two pages inside the database

if (!isset($_GET['key1']) || $_GET['key1'] == "")
{
    echo '<h1>Nada para editar</h1>';
    goBack();
    exit();
}
if (!isset($_GET['key2']) || $_GET['key2'] == "")
{
    echo '<h1>Nada para editar</h1>';
    goBack();
    exit();
}

# Load database
require "../includes/Flintstone/vendor/autoload.php";
use Flintstone\Flintstone;

$options = array('dir' => '../database/'); // Set options
$pages = Flintstone::load('pages', $options); // Load the databases

$page1 = $pages->get($_GET['key1']);
$page2 = $pages->get($_GET['key2']);
$parentid1 = $page1['parent'];
$parentid2 = $page2['parent'];
if (!is_null($parentid1) && $parentid1 == $parentid2)
{
    $parent = $pages->get($parentid1);
    $subpages = $parent['subpages'];
    $subkey1 = array_search($_GET['key1'], $subpages);
    $subkey2 = array_search($_GET['key2'], $subpages);
    $temp = $subpages[$subkey1];
    $subpages[$subkey1] = $subpages[$subkey2];
    $subpages[$subkey2] = $temp;
    $parent['subpages'] = $subpages;
    $pages->set($parentid1, $parent);
}

$pages->swap($_GET['key1'], $_GET['key2']);

?>
<h1>Done swapping <?php echo $_GET['key1'].' and '.$_GET['key2']; ?></h1>
<? goBack(); ?>








