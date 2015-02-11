<?php

require "includes/Flintstone/vendor/autoload.php";
use Flintstone\Flintstone;

# Declare directory where databases are
$options = array('dir' => 'database/');

# Load the databases
$site = Flintstone::load('site', $options);
$pages = Flintstone::load('pages', $options);

# Load website generic content (header, motto, footer)
$header = $site->get('header'); //returns array('title' => '' ,  'motto' => ''));
$footer = $site->get('footer');

# Load menu data
$keys = $pages->getKeys();

$menu = array();
foreach ($keys as $pageid) {
    $page = $pages->get($pageid);
    if ($page['hierarchy'] == 0)
        { $menu[] = array('name' => $pageid, 'title' => $page['title']); }
}

$pg = (isset($_GET['pg']) && in_array($_GET['pg'], $keys) ) ?
      $_GET['pg'] :
      'home';

# Load page content and other data
$page = $pages->get($pg);

# Find offspring data for submenu
$submenu = array();
foreach ($page['subpages'] as $childid) {
    $child = $pages->get($childid);
    $submenu[] = array('name' => $childid, 'title' => $child['title']);
}

# Find genealogy data used for tracking current position
$genealogy[] = array('name' => $page['name'], 'title' => $page['title']);
$guy = $page['parent'];
while (!is_null($guy)) {
    $guy_details = $pages->get($guy);
    $genealogy[] = array('name' => $guy_details['name'],
                         'title' => $guy_details['title']);
    $guy = $guy_details['parent'];
}
$genealogy = array_reverse($genealogy);

# Load templating engine
require_once 'includes/twig/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
$template = $twig->loadTemplate('layout76/index.html');
echo $template->render(array('header' => $header,
                             'footer' => $footer,
                             'navigation' => $menu,
                             'page' => $page,
                             'offspring' => $submenu,
                             'genealogy' => $genealogy));
?>
