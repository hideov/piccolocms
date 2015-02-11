<?php

require_once 'utilities.php';
checkLogin();

if (!isset($_GET['pg']) || $_GET['pg'] == "") {
    echo '<h1>Nada para cancelar</h1>';
    goBack();
    exit();
}

if ($_GET['pg'] == "home") {
    echo '<h1>Never delete home</h1>';
    goBack();
    exit();
}

# Load databases
require "../includes/Flintstone/vendor/autoload.php";
use Flintstone\Flintstone;

$options = array('dir' => '../database/'); // Set options
$pages = Flintstone::load('pages', $options); // Load the databases

# Load the original page data
$page = $pages->get($_GET['pg']);

# Inform the parent of the page to remove it from its submenu
if (!is_null($page['parent'])) {
    $keys = $pages->getKeys();
    if (in_array($page['parent'], $keys)) {
        $parent = $pages->get($page['parent']);
        if( ($key = array_search($_GET['pg'], $parent['subpages'])) !== false)
            { unset($parent['subpages'][$key]); }
    }
}

# Delete the page
$pages->delete($_GET['pg']);
?>
<h1>Done deleting <?php echo $_GET['pg']; ?></h1>
<?php goBack(); ?>
