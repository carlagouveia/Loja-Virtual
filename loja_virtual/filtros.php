<?php

require('./autoloader.php');

$usuarios = new Usuarios();
$status = $usuarios->verificaStatus();
$db = new Database;


if($status == 0) {
	die('Você não possui acesso a esta área');
}

if(empty($_SESSION['uid'])) {
	die('<meta http-equiv="refresh" content="0;url=index.php">');
} else {
	$id = $_SESSION['uid'];
}

if($_POST) {
	$usuarios->alterarUsuario($id, $_POST['usuario'], $_POST['senha'], 0);
	die('<meta http-equiv="refresh" content="0;url=index.php">');
}

$usuario = $db->pegarDado("usuarios", "*", "id = $id");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<title>Loja 412 | Minha conta</title>
</head>
<body>
<h1>Minha conta</h1>

<form method="POST" action="conta.php?id=<?php echo $id; ?>">
	<label>Usuário</label>
	<input type="text" name="usuario" value="<?php echo $usuario['usuario']; ?>" /><br /><br />
	
	<label>Senha</label>
	<input type="password" name="senha" value="" /><br /><br />
	
	<input type="submit" value="Enviar" />
</form>

</body>
</html>