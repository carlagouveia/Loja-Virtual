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
	$id = $_GET['id'];
}

if($_POST) {
	$produtos->alterarProduto($id, $_POST);
	die('<meta http-equiv="refresh" content="0;url=index.php">');
}

$produto = $db->pegarDado("livros", "*", "id = $id");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<title>Loja 412 | Alterar produto</title>
</head>
<body>
<h1>Alterar produto</h1>

<form method="POST" action="alterarProduto.php?id=<?php echo $id; ?>">
	<label>ISBN</label>
	<input type="text" name="isbn" value="<?php echo $produto['isbn']; ?>" /><br /><br />
	
	<label>Autor</label>
	<input type="text" name="autor" value="<?php echo $produto['autor']; ?>" /><br /><br />
	
	<label>T�tulo</label>
	<input type="text" name="titulo" value="<?php echo $produto['titulo']; ?>" /><br /><br />
	
	<label>Pre�o</label>
	<input type="text" name="preco" value="<?php echo $produto['preco']; ?>" /><br /><br />
	
	<label>Sum�rio</label><br />
	<textarea rows="5" cols="30" name="sumario"><?php echo $produto['sumario']; ?></textarea><br /><br />
	
	<input type="submit" value="Enviar" />
</form>

</body>
</html>