<?php

require('./autoloader.php');

$usuarios = new Usuarios();
$produtos = new Produtos();
$carrinho = new Carrinho();
$status = $usuarios->verificaStatus();
$db = new Database;

if($status == 0) {
	die('Você precisa se registrar para comprar algum produto. Portanto, <a href="registrar.php">registre-se!</a>');
} else {
	$login = 'Olá '. $_SESSION['user'] .'! <a href="carrinho.php">Meu carrinho</a> | <a href="conta.php">Minha conta</a> | <a href="logout.php">Sair</a>';
}

if(isset($_GET['adiciona'])) {
	$carrinho->adicionarProduto($_GET['adiciona']);
}

if(isset($_POST['esvaziar'])) {
	$carrinho->esvaziarCarrinho();
}

if(isset($_POST['atualizar'])) {
	// Para cada produto em nosso carrinho, chamaremos o método de alteração de quantidade
	foreach($_POST['produto'] as $chave => $produto) {
		$carrinho->alterarQuantidade($produto, $_POST['quantidade'][$chave]);
	}
	
	// Caso o checkbox de remoção tenha sido marcado
	if(isset($_POST['remover'])) {
		// Itere entre os valores marcados e chame o método de remoção com o value do checkbox
		foreach($_POST['remover'] as $produto) {
			$carrinho->removerProduto($produto); 
		}
	}
}

if(isset($_POST['compra'])) {

	foreach($_POST['produto'] as $key => $value) {
		$quantidade = $_POST['quantidade'][$key];
		$produto = $db->pegarDado("livros", "*", "id = $value");
		
		// Criamos um dado pré-formatado com informações da compra. A partir daqui, podemos chamar um método de uma classe de boleto, cartão ou PagSeguro
		$compras[] = "[". $_SESSION['user'] ."-". $quantidade ."-". $produto['id'] ."-". $produto['titulo'] ."-". $produto['preco'] ."]";
	}
	
	$compras = implode(', ', $compras); // Unimos nossos dados pré-formatados, separados por vírgulas, para cada produto comprado
	$carrinho->esvaziarCarrinho();
	die("Compramos os itens: $compras"); // Mostramos na tela os itens comprados
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<title>Loja 412 | Carrinho de compras</title>
</head>
<body>
<h1>Bem-vindo à nossa loja!</h1>
<p><?php echo $login; ?></p>
<h2>Carrinho de compras</h2>
	<?php
	
	if(isset($_SESSION['compras'])) {
		$total = 0;
		
		echo '<form method="POST" action="carrinho.php">
		<table cellspacing="2" cellpadding="5" border="1">';
		
		foreach($carrinho->listarProdutos() as $produto) {
			$total += $produto['preco'] * $produto['quantidade'];
			echo "<tr>";
			echo "<td><strong>" . $produto['titulo'] . "</strong><input type='hidden' name='produto[]' value='" . $produto['id'] . "' /></td>\n";
			echo "<td><input type='text' name='quantidade[]' value='" . $produto['quantidade'] . "' /></td>\n";
			echo "<td><input type='checkbox' name='remover[]' value='" . $produto['id'] . "' /></td>\n";
			echo "</tr>";
		}
		
		echo "<tr><td colspan='3' align='right'><strong>Total:</strong> R$ $total</td></tr>";
		echo '<tr><td colspan="3" align="right"><input type="submit" name="compra" value="Finalizar compra" /> <input type="submit" name="esvaziar" value="Esvaziar carrinho" /> <input type="submit" name="atualizar" value="Atualizar carrinho" /></td></tr></table>';
	} else {
		echo "<p>Não há nada no carrinho.</p>";
	}
	
	?>
</table>
</form>
</body>
</html>