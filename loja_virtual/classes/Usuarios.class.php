<?php
/**
* Classe de controle de usuários
*
* Esta classe permite que sejam gerenciados os usuários da loja, além de
* controlar o login e logout.
*
* @package Livraria412
*/

class Usuarios {
	
	private $db;
	
	/**
	* A função __construct é um método mágico. Este método será executado toda vez que o objeto for instanciado.
	*/	
	public function __construct() {
		$this->db = new Database;
	}
	
	/**
	* Neste método, simplificamos a maneira de logar usuários
	*
	* @param string $usuario Usuário a ser logado
	* @param string $senha Senha do usuário a ser logado
	* @return string Destino do usuário após o login (erro ou página inicial)
	*/
	public function logarUsuario($usuario, $senha) {
		$senha = md5($senha);
		$resultado = $this->db->pegarDado("usuarios", "*", "usuario = '$usuario' AND senha = '$senha'");
		
		if($resultado) {
			$_SESSION['sessao'] = 'logado';
			$_SESSION['uid'] = $resultado['id'];
			$_SESSION['user'] = $resultado['usuario'];
			$destino = "index.php";
		} else {
			$destino = "login.php?msg=erro";
		}

		return $destino;
	}
	
	/**
	* Neste método, simplificamos a maneira de deslogar usuários
	*/
	public function deslogarUsuario() {
		$_SESSION = array();
		session_destroy();
	}
	
	/**
	* Neste método, vamos verificar o status da sessão. Isto é, há algum usuário logado ou não?
	*
	* @return int Retornaremos 2, 1 ou 0, de acordo com o status do usuário: 2 é administrador, 1 é usuário logado e 0 é não-logado
	*/
	public function verificaStatus() {
		  if(isset($_SESSION['sessao']) && $_SESSION['sessao'] == 'logado'){
			$id = $_SESSION['uid'];
			$resultado = $this->db->pegarDado("usuarios", "admin", "id = $id");
			
			if($resultado['admin'] == 1) {
				return 2;
			} else {
				return 1;
			}
		} else {
			return 0;
		}
	}
	
	/**
	* Neste método, simplificamos a maneira de criar novos usuários
	*
	* @param string $usuario Usuário a ser criado
	* @param string $senha Senha do usuário a ser criado
	* @param string $admin O usuário é administrador?
	*/
	public function criarUsuario($usuario, $senha, $admin) {
		$senha = md5($senha);
		$this->db->inserirDados("usuarios", array('usuario' => $usuario, 'senha' => $senha, 'admin' => $admin));
	}
	
	/**
	* Neste método, simplificamos a maneira de alterar dados de usuários
	*
	* @param string $id ID do usuário a ser alterado
	* @param string $usuario Usuário a ser alterado
	* @param string $senha Senha do usuário a ser alterado
	*/
	public function alterarUsuario($id, $usuario, $senha, $admin) {
		// Caso a senha venha vazia, iremos alterar apenas os campos de usuário e admin
		if(empty($senha)) {
			$this->db->alterarDados("usuarios", "id = $id", array('usuario' => $usuario, 'admin' => $admin));
		} else {
			$senha = md5($senha);
			$this->db->alterarDados("usuarios", "id = $id", array('usuario' => $usuario, 'senha' => $senha, 'admin' => $admin));
		}
	}
	
	/**
	* Neste método, simplificamos a maneira de remover usuários
	*
	* @param string $id ID do usuário a ser removido
	*/
	public function removerUsuario($id) {
		$this->db->removerDados("usuarios", "id = $id");
	}
	
	/**
	* Neste método, listamos todos os usuários em nosso banco
	*
	* @return array Resultados da consulta ao banco de dados por usuários
	*/
	public function listarUsuarios() {
		$resultados = $this->db->pegarDados('usuarios', '*', '', '', '', '');
		
		return $resultados;
	}
}