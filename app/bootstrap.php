<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

$configurator->setDebugMode('146.102.123.42'); // enable for your remote IP
$configurator->enableTracy(__DIR__ . '/../log');
$configurator->setDebugMode(TRUE);

$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');


$container = $configurator->createContainer();


$ini_array = parse_ini_file("../www/config.ini");
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";



if(isset($ini_array['dbname'])){
	return $container;
}

if(preg_match( '/install\/$/', $actual_link) > 0 OR preg_match( '/install$/', $actual_link) > 0){
	return $container;
}
header('Location: '.$actual_link.'install/');
exit();
return $container;
