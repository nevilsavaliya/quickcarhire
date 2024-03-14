<?php
require_once 'vendor/autoload.php';
$google_client = new Google_Client();
$google_client->setClientId('457578089846-kbltactg648ou7n4o06462uh3v9tp3r1.apps.googleusercontent.com');
$google_client->setClientSecret('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');
$google_client->setRedirectUri('http://quickcarhire.live/check.php');
$google_client->addScope('email');
$google_client->addScope('profile');
?>
