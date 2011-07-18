<?php

require('./autoloader.php');

$usuarios = new Usuarios();
$status = $usuarios->verificaStatus();

if($status != 0) {
	die("Você já está logado!");
}

if($_POST) {
	$destino = $usuarios->logarUsuario($_POST['usuario'], $_POST['senha']);
	die("<meta http-equiv='refresh' content='0;url=$destino'>");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<title>Loja 412 | Login</title>
</head>
<body>
<h1>Login</h1>
<p><?php if(isset($_GET['msg']) && $_GET['msg']) { echo "Usuário ou senha errados!"; } ?></p>
<form method="POST" action="login.php">
	<label>Usuário</label>
	<input type="text" name="usuario" /><br /><br />
	
	<label>Senha</label>
	<input type="password" name="senha" /><br /><br />
	
	<input type="submit" value="Enviar" />
</form>

</body>
</html>