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
	$id = $_GET['id'];
}

if($_POST) {
	$usuarios->alterarUsuario($id, $_POST['usuario'], $_POST['senha'], $_POST['admin']);
	die('<meta http-equiv="refresh" content="0;url=index.php">');
}

$usuario = $db->pegarDado("usuarios", "*", "id = $id");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<title>Loja 412 | Alterar usu�rio</title>
</head>
<body>
<h1>Alterar usu�rio</h1>

<form method="POST" action="alterarUsuario.php?id=<?php echo $id; ?>">
	<label>Usu�rio</label>
	<input type="text" name="usuario" value="<?php echo $usuario['usuario']; ?>" /><br /><br />
	
	<label>Senha</label>
	<input type="password" name="senha" value="" /><br /><br />
	
	<label>Administrador?</label>
	<select name="admin">
		<option value="1" <?php if($usuario['admin'] == 1) { echo 'selected="selected"'; } ?>>Sim</option>
		<option value="0" <?php if($usuario['admin'] == 0) { echo 'selected="selected"'; } ?>>N�o</option>
	</select><br /><br />
	
	<input type="submit" value="Enviar" />
</form>

</body>
</html>