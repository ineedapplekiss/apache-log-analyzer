<?php
require 'vendor/autoload.php';

$log = new Monolog\Logger('name');
$log->pushHandler(new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::WARNING));


$subject = new Shang\StreamSubject();

$hitTopOb = new Shang\HitTopOb();

$subject->attach($hitTopOb);
$subject->run();


