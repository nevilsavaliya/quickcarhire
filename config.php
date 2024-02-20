<?php
require_once 'vendor/autoload.php';
$google_client = new Google_Client();
$google_client->setClientId('670885709604-8idtbvtpioqfeq3m9s274dh8t8u77h90.apps.googleusercontent.com');
$google_client->setClientSecret('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');
$google_client->setRedirectUri('http://localhost/quickcarhire/check.php');
$google_client->addScope('email');
$google_client->addScope('profile');
?>