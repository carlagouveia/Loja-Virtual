<?php

require('../autoloader.php');

$usuarios = new Usuarios();
$status = $usuarios->verificaStatus();
$db = new Database;

if($status != 2) {
	die('Voc� n�o possui acesso a esta �rea');
}

if(empty($_GET['id'])) {
	die('<meta http-equiv="refresh" content="0;url=index.php">');
} else {
	$usuarios->removerUsuario($_GET['id']);
	die('<meta http-equiv="refresh" content="0;url=index.php">');
}