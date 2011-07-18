<?php

require('../autoloader.php');

$usuarios = new Usuarios();
$produtos = new Produtos();
$status = $usuarios->verificaStatus();
$db = new Database;

if($status != 2) {
	die('Voc� n�o possui acesso a esta �rea');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<title>Loja 412 | Painel de Controle</title>
</head>
<body>
<h1>Usu�rios</h1>
<a href='criarUsuario.php'>Criar usu�rio</a><br /><br />
<table cellspacing="2" cellpadding="5" border="1">
	<tr>
		<th>ID</th>
		<th>Usu�rio</th>
		<th>Op��es</th>
	</tr>
	<?php
		foreach($usuarios->listarUsuarios() as $usuario) {
			echo "<tr>";
			echo "<td>" . $usuario['id'] . "</td>\n";
			echo "<td>" . $usuario['usuario'] . "</td>\n";
			echo "<td><a href='alterarUsuario.php?id=" . $usuario['id'] . "'>Alterar</a> - <a href='removerUsuario.php?id=" . $usuario['id'] . "'>Remover</a></td>\n";
			echo "</tr>";
		}
	?>
</table>

<h1>Produtos</h1>
<a href='criarProduto.php'>Criar produto</a><br /><br />
<table cellspacing="2" cellpadding="5" border="1">
	<tr>
		<th>ID</th>
		<th>Produto</th>
		<th>Op��es</th>
	</tr>
	<?php
		foreach($produtos->listarProdutos('', '', '', '', '') as $produto) {
			echo "<tr>";
			echo "<td>" . $produto['id'] . "</td>\n";
			echo "<td>" . $produto['titulo'] . "</td>\n";
			echo "<td><a href='alterarProduto.php?id=" . $produto['id'] . "'>Alterar</a> - <a href='removerProduto.php?id=" . $produto['id'] . "'>Remover</a></td>\n";
			echo "</tr>";
		}
	?>
</table>

</body>
</html>