<?php

require('./autoloader.php');

$usuarios = new Usuarios();
$produtos = new Produtos();
$status = $usuarios->verificaStatus();

if($status == 0) {
	$login = 'Você não está logado. Clique <a href="login.php">aqui</a> para logar, ou <a href="registrar.php">registre-se!</a>';
} elseif($status == 1) {
	$login = 'Olá '. $_SESSION['user'] .'! <a href="carrinho.php">Meu carrinho</a> | <a href="conta.php">Minha conta</a> | <a href="logout.php">Sair</a> |';
} else {
	$login = 'Olá '. $_SESSION['user'] .'! <a href="carrinho.php">Meu carrinho</a> | <a href="conta.php">Minha conta</a> | <a href="admin/">Admin</a> | <a href="logout.php">Sair</a>';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<title>Loja 412 | Os melhores livros de Linux!</title>
</head>
<body>
<h1>Bem-vindo à nossa loja!</h1>
<p><?php echo $login; ?></p>
<h2>Nossos produtos</h2>
<table cellspacing="2" cellpadding="5" border="1">
	<?php
		foreach($produtos->listarProdutos('', '', '', '', '') as $produto) {
			echo "<tr>";
			echo "<td><strong>" . $produto['titulo'] . "</strong><br /><strong>Autor:</strong> " . $produto['autor'] . "<br /><strong>ISBN:</strong> " . $produto['isbn'] . "<br /><br />" . $produto['sumario'] . "</td>\n";
			echo "<td>Apenas R$" . $produto['preco'] . "!<br /><a href='carrinho.php?adiciona=" . $produto['id'] . "'>Comprar!</a></td>\n";
			echo "</tr>";
		}
	?>
</table>
</body>
</html>