<?php
namespace Systeme;
session_start();
require_once('systeme/config.php');
require_once('application/config.php');
require_once('systeme/routeur.php');
$url = '';
if (isset($_GET['url']))
	$url = $_GET['url'];
$routeur = new Routeur(new \App\Config(), $url);