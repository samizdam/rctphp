<?php
require_once __DIR__ .'/../vendor/autoload.php';

require_once 'Application.php';

$app = new Application('purePHP');
echo $app->execute()->getBody();