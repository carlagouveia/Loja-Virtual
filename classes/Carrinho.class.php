<?php
/**
* Classe de carrinho de compras
*
* Esta classe permite que sejam gerenciados os produtos disponíveis
* no carrinho de compras.
*
* @package Livraria412
*/

class Carrinho {
	
	private $db;
	
	/**
	* A função __construct é um método mágico. Este método será executado toda vez que o objeto for instanciado.
	*/	
	public function __construct() {
		$this->db = new Database;
	}

	/**
	* Neste método, iremos adicionar produtos ao nosso carrinho, guardado na sessão
	*
	* @param string $produto Produto a ser adicionado ao carrinho
	*/
	public function adicionarProduto($produto) {
		/**
		* Caso o produto já esteja no carrinho, aumentamos a quantidade, senão, adicionamos ele
		*/
		if(isset($_SESSION['compras'][$produto])) {
			$_SESSION['compras'][$produto] += 1;			
		} else {
			$_SESSION['compras'][$produto] = 1;
		}
	}
	
	/**
	* Neste método, iremos remover produtos do nosso carrinho, guardado na sessão
	*
	* @param string $produto Produto a ser removido do carrinho
	*/
	public function removerProduto($produto) {
		/**
		* Removemos o produto especificado da nossa sessão
		*/
		unset($_SESSION['compras'][$produto]);
		
		/**
		* Caso este seja o último produto do carrinho, isto é, o array estiver vazio depois 
		* de remover o produto, removemos o array das compras
		*/
		if(empty($_SESSION['compras'])) {
			unset($_SESSION['compras']);
		}
	}
	
	/**
	* Neste método, iremos esvaziar o carrinho
	*/
	public function esvaziarCarrinho() {
		unset($_SESSION['compras']);
	}
	
	/**
	* Neste método, iremos alterar a quantidade de um produto do nosso carrinho.
	*
	* @param string $produto Produto a ter quantidade alterada no carrinho
	* @param string $quantidade Quantidade a ser alterada
	*/
	public function alterarQuantidade($produto, $quantidade) {
		if($quantidade == 0) {
			unset($_SESSION['compras'][$produto]);
		} else {
			$_SESSION['compras'][$produto] = $quantidade;
		}
	}
	
	/**
	* Neste método, iremos listar os produtos do nosso carrinho
	*/
	public function listarProdutos() {
		//pega o array de produtos do carrinho e percorre 
		// recuperando id do produto($key) e valor (qtde)
		foreach($_SESSION['compras'] as $key => $value) {
			$lista[$key] = $this->db->pegarDado("livros", "*", "id = $key");
			$lista[$key]['quantidade'] = $value;
		}
		
		return $lista;
	}
}