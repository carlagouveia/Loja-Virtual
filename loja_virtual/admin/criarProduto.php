<?php

require('../autoloader.php');

$usuarios = new Usuarios();
$produtos = new Produtos();
$status = $usuarios->verificaStatus();
$db = new Database;

if($status != 2) {
	die('Voc� n�o possui acesso a esta �rea');
}

if($_POST) {
	$produtos->criarProduto($_POST);
	die('<meta http-equiv="refresh" content="0;url=index.php">');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<title>Loja 412 | Criar produto</title>
</head>
<body>
<h1>Criar produto</h1>

<form method="POST" action="criarProduto.php">
	<label>ISBN</label>
	<input type="text" name="isbn" /><br /><br />
	
	<label>Autor</label>
	<input type="text" name="autor" /><br /><br />
	
	<label>T�tulo</label>
	<input type="text" name="titulo" /><br /><br />
	
	<label>Pre�o</label>
	<input type="text" name="preco" /><br /><br />
	
	<label>Sum�rio</label><br />
	<textarea rows="5" cols="30" name="sumario"></textarea><br /><br />
	
	<input type="submit" value="Enviar" />
</form>

</body>
</html>