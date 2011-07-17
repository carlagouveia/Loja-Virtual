<?php

require('../autoloader.php');

$usuarios = new Usuarios();
$status = $usuarios->verificaStatus();
$db = new Database;

if($status != 2) {
	die('Voc� n�o possui acesso a esta �rea');
}

if($_POST) {
	$usuarios->criarUsuario($_POST['usuario'], $_POST['senha'], $_POST['admin']);
	die('<meta http-equiv="refresh" content="0;url=index.php">');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<title>Loja 412 | Criar usu�rio</title>
</head>
<body>
<h1>Criar usu�rio</h1>

<form method="POST" action="criarUsuario.php">
	<label>Usu�rio</label>
	<input type="text" name="usuario" /><br /><br />
	
	<label>Senha</label>
	<input type="password" name="senha" /><br /><br />
	
	<label>Administrador?</label>
	<select name="admin">
		<option value="1">Sim</option>
		<option value="0">N�o</option>
	</select><br /><br />
	
	<input type="submit" value="Enviar" />
</form>

</body>
</html>