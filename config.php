<?php
require_once 'vendor/autoload.php';
$google_client = new Google_Client();
$google_client->setClientId('457578089846-gomi9ia6h27k24ie2fet2fd4m5f24p7l.apps.googleusercontent.com');
$google_client->setClientSecret('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');
$google_client->setRedirectUri('http://localhost/quickcarhire/check.php');
$google_client->addScope('email');
$google_client->addScope('profile');
?>
