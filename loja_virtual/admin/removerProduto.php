<?php

require('../autoloader.php');

$usuarios = new Usuarios();
$produtos = new Produtos();
$status = $usuarios->verificaStatus();
$db = new Database;

if($status != 2) {
	die('Voce nao possui acesso a esta area');
}

if(empty($_GET['id'])) {
	die('<meta http-equiv="refresh" content="0;url=index.php">');
} else {
	$produtos->removerProduto($_GET['id']);
	die('<meta http-equiv="refresh" content="0;url=index.php">');
}