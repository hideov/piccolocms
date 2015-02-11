<?php

require_once 'utilities.php';
checkLogin();

if (!isset($_GET['pg']) || $_GET['pg'] == "") {
    echo '<h1>Nada para editar</h1>';
    goBack();
    exit();
}

# Load the databases
require "../includes/Flintstone/vendor/autoload.php";
use Flintstone\Flintstone;

$options = array('dir' => '../database/');
$pages = Flintstone::load('pages', $options);

# Load the page information
$page = $pages->get($_GET['pg']);
?>
<head>
<script src="../includes/ckeditor/ckeditor.js"></script>
</head>

<h1>Editing <?php echo $_GET['pg']; ?>
<span style="float: right"><a href="index.php">back</a></span></h1>

<form action="save.php?pg=<?php echo $_GET['pg']; ?>" method="post">
<p>Title: <input type="text" name="title" value="<?php echo $page['title']; ?>"></p>
<p>Content:<br/><textarea id="content" name="content"><?php echo $page['content']; ?></textarea></p>
<input type="hidden" name="supposed_parent" value="<?php echo $_GET['parent']; ?>">
<input type="submit" value="save page">
<script>
// Replace the <textarea id="content"> with a CKEditor
// instance, using default configuration.
CKEDITOR.replace( 'content' );
</script>
<div>

<!-- iframe window -->
<iframe style="margin-top:10px;height:200px;width:400px;" src="image_upload.php" name="image_upload"></iframe></div>
</form>
