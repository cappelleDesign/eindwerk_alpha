<?php
$masterControllerTest = new MasterController();

$loggedIn = $masterControllerTest->getCurrentUser();
echo $loggedIn ? $loggedIn . ' is logged in' : 'no user logged in';
