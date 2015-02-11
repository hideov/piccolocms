<?php

require_once 'utilities.php';
checkLogin();

if (!isset($_GET['pg']) || $_GET['pg'] == "")
{
    echo '<h1>Nada para editar</h1>';
    goBack();
    exit();
}
if (!isset($_POST['title']) || !isset($_POST['content'])
    || $_POST['title'] == "" )
{
    echo "<h1>Title or content empty</h1>";
    goBack();
    exit();
}
if(strpos($_POST['title'], "=") !== false) {
    echo "<h1>Title can't contain = sign</h1>";
    goBack();
    exit();
}

# Load databases
require "../includes/Flintstone/vendor/autoload.php";
use Flintstone\Flintstone;

$options = array('dir' => '../database/');
$pages = Flintstone::load('pages', $options);

# Verify if page already exists
$keys = $pages->getKeys();
$is_newborn = !in_array($_GET['pg'], $keys);

if ($is_newborn) {
    # If it's a new page, inform the parent page
    $parentid = $_POST['supposed_parent'];
    if ($parentid == "" || !in_array($parentid, $keys))
    {
        $parentid = null;
        $hierarchy = 0;
    } else {
        $parent = $pages->get($parentid);
        $hierarchy = $parent['hierarchy'] + 1;
        //remember to update parents' status
        $parent['subpages'][] = $_GET['pg'];
        $pages->set($parentid, $parent);
    }
    $subpages = array();
} else {
    # Copy information about parent, subpages, hierarchy
    $page = $pages->get($_GET['pg']);
    $hierarchy = $page['hierarchy'];
    $parentid = $page['parent'];
    $subpages = $page['subpages'];
}

# Save the page
$pages->set($_GET['pg'],
                array('name' => $_GET['pg'],
                      'title' => $_POST['title'],
                      'content' => $_POST['content'],
                      'hierarchy' => $hierarchy,
                      'parent' => $parentid,
                      'subpages' => $subpages));
?>
<h1>Done editing <?php echo $_GET['pg']; ?></h1>
<?php goBack(); ?>
