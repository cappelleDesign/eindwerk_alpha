<h1>MASTER SERVICE TESTING</h1>
<?php
$fileHandler = new FileHandler();
$root = Globals::getRoot('img', 'app', FALSE);
Globals::cleanDump($root);
//$fileHandler->addFolder($root, 'test');
$fileHandler->removeFile($root . 'test');