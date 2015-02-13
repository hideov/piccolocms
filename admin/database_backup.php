<?php

require_once 'utilities.php';
checkLogin();

require 'config.php';

$time = date("Y-m-d_H-i-s",time());

# Prepare backup file
$tempfile = tempnam("database_backup_$time", "zip");
$zip = new ZipArchive();
$zip->open($tempfile, ZipArchive::OVERWRITE);

# Stuff the content
foreach(glob($install_dir.'/database/'.'/*') as $file)
    { $zip->addFile($file, end(explode('/', $file))); }

# Close file and send it to the user
$zip->close();

header('Content-Type: application/zip');
header('Content-Length: ' . filesize($file));
header('Content-Disposition: attachment; filename="database_backup_'.$time.'.zip"');

readfile($tempfile);

# Cancel the temporary file
unlink($tempfile);

?>