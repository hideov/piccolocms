<?php

require_once 'utilities.php';
checkLogin();

# Load the database
require "../includes/Flintstone/vendor/autoload.php";
use Flintstone\Flintstone;

$options = array('dir' => '../database/'); // Set options
$pages = Flintstone::load('pages', $options); // Load the databases
$site = Flintstone::load('site', $options); // Load the databases

# Load site information
$keys = $pages->getKeys();
$header = $site->get("header");
$footer = $site->get("footer");
?>

<head>
<style>
table {
    border-collapse: collapse;
}
td, th {
    text-align: center;
    border: 1px solid grey;
    padding: 2px;
    padding-left: 5px;
    padding-right: 5px;
}
div {
    border: 1px dashed black;
    padding-left: 20px;
    padding-right: 20px;
    margin: 5px;
}
</style>
</head>

<h1>Administration
    <span style="float:right">
    <input type="button" value="logout" onclick="window.location.href='logout.php'">
    </span></h1>

<div>
<h3>Create a page</h3>
<form action="edit.php" method="get">
<p>parent: <select name="parent" size="0">
<option value="" label="----">----</option>
<?php
foreach ($keys as $pageid)
    { echo '<option value="'.$pageid.'" label="'.$pageid.'">'.$pageid.'</option>'."\n"; }
?>
</select>
</p>
<p>name: <input type="text" name="pg"></p>
<input type="submit" value="create new page">
</form>
</div>

<div>
<h3>Manage and edit existing pages</h3>
<span style="color:red;font-weight: bold">
Remember: cancelling a parent page leaving orphans is a BAD idea.</span>
<form action="swap.php" method="get">
<table>
<tr>
    <th>edit page</th>
    <th>page name</th>
    <th>hierarchy</th>
    <th>parent</th>
    <th>delete page</th>
    <th>A</th>
    <th>B</th>
</tr>
<?php
foreach ($keys as $pageid) {
    $page = $pages->get($pageid);
    echo "<tr>\n";
    echo "<td>".'<a href="edit.php?pg='.$pageid.'">';
    echo $page['title']."</a></td>\n";
    echo "<td>".$page['name']."</td>\n";
    echo "<td>".$page['hierarchy']."</td>\n";
    echo "<td>".$page['parent']."</td>\n";
    echo '<td><a href="delete.php?pg='.$pageid.'">DELETE</a></td>'."\n";
    echo '<td><input type="radio" name="key1" value="'.$pageid.'"></td>'."\n";
    echo '<td><input type="radio" name="key2" value="'.$pageid.'"></td>'."\n";
    echo "</tr>\n";
}
?>
<tr>
    <td></td>	<td></td>	<td></td>	<td></td>	<td></td>
    <td colspan="2"><input type="submit" value="Swap A and B"></td>
</tr>
</table>
</form>
</div>

<div>
<h3>Website configuration</h3>
<span style="color:red;font-weight: bold">
Remember: html tags inside title, motto and footer will show screwed up, but work</span>
<form action="sitesettings.php" method="post">
<p>title <input type="text" name="site_title" value="<?php echo $header['title']; ?>"></p>
<p>motto <input type="text" name="site_motto" value="<?php echo $header['motto']; ?>"></p>
<p>footer <input type="text" name="site_footer" value="<?php echo $footer; ?>"></p>
<input type="submit" value="save website settings">
</form>
<input style="margin-bottom:10px" type="button" value="download database backup" 
    onclick="window.location.href='database_backup.php'">
</div>
<div>
<h3>Free software used (need to add versions)</h3>
<ul>
<li>ckeditor 4.4.7 (Mozilla Public License) </li>
<li>twig 1.18.0 (BSD license)</li>
<li>Flinstone 1.8 (modded adding method swap, see FlintstoneDB.php) (MIT License)</li>
<li>class.upload.php v0.33dev (http://www.verot.net/download/class.upload.php/class.upload_0.33dev.txt) (GPL v2)</li>
<li>CryptoJS 3.1 (New BSD License)</li>
</ul>
</div>