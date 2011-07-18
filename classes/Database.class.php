<?php
/**
* Classe de comunicação com o banco de dados, utilizando PHP Data Objects (PDO).
*
* Esta classe permite que você se comunique com o banco de dados de 
* forma fácil e rápida, removendo a necessidade de trabalhar com queries
* SQL todo o tempo. 
*
* @package Livraria412
*/

class Database {

	private $pdo;
	
	/**
	* Neste método iremos conectar com o banco de dados.
	*
	* @param string $servidor Servidor onde se encontra o banco de dados
	* @param string $banco Nome do banco de dados a ser usado
	* @param string $usuario Usuário do banco de dados
	* @param string $senha Senha do usuário do banco de dados
	*/	
	public function __construct() {
		global $config;
		
		try {
			/**
			* Criamos uma nova instância do PDO, passando os dados de conexão com o banco
			*/
			$this->pdo = new PDO("mysql:host={$config['servidor']};dbname={$config['banco']}", $config['usuario'], $config['senha']);
			/**
			* Setamos um atributo do PDO, chamado ERRMODE, e passamos a opção EXCEPTION.
			* Este modo de erro irá lançar uma exceção quando o PDO se deparar com um problema.
			* 
			* Existem também os modos: 
			* 
			* PDO::ERRMODE_SILENT: Apenas loga os erros
			* PDO::ERRMODE_WARNING: Além de logar o erro, emitirá uma mensagem de aviso no PHP
			* PDO::ERRMODE_EXCEPTION: Além de logar o erro, lançará uma exceção
			*/
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		} catch(PDOException $e) {
			echo "Opa, temos um erro no PDO!";
			
			/**
			* Salvamos o erro em nosso log de erros, usando a função file_put_contents
			*/
			file_put_contents('pdo_log.txt', $e->getMessage(), FILE_APPEND);  
		}  
	}
	
	/**
	* Neste método, simplificamos a criação de tabelas em um banco de dados
	* e, por padrão, criamos sempre um ID, com chave primária e auto-incrementação
	*
	* @param string $tabela Nome da tabela a ser criada
	* @param array $campos Campos a serem adicionados à tabela criada
	*/
	public function criarTabela($tabela, $campos) {
		$campos = implode(', ', $campos);
		$query = "CREATE TABLE $tabela (id int NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), $campos)";
		$this->pdo->exec($query);  
	}
	
	/**
	* Neste método, simplificamos a limpeza de tabelas
	*
	* @param string $tabela Nome da tabela a ser limpa
	*/
	public function limparTabela($tabela) {
		$query = "TRUNCATE TABLE $tabela";
		$this->pdo->exec($query);  
	}
	
	/**
	* Neste método, simplificamos a remoção de tabelas
	*
	* @param string $tabela Nome da tabela a ser removida
	*/
	public function removerTabela($tabela) {
		$query = "DROP TABLE $tabela";
		$this->pdo->exec($query);  
	}
	
	/**
	* Neste método, simplificamos a maneira de inserir dados em uma tabela.
	*
	* @param string $tabela Nome da tabela a receber dados
	* @param array $dados Dados a serem inseridos na tabela, em forma de um array multi-dimensional
	*/
	public function inserirDados($tabela, $dados) {
		
		/**
		* Para cada chave e valor em nosso array, criamos dois novos arrays.
		* Um com colunas, outro com valores.
		*
		* $valores é um array com os valores a serem inseridos, envolvidos em aspas simples: 'lorem ipsum'.
		* Logo abaixo usamos implode para transformar esses valores em uma string separada
		* por vírgulas: 'lorem ipsum', 'dolor sit amet', 'nepet quisquam'
		*
		* Depois, basta jogar essa string na nossa query.
		*/
		foreach($dados as $coluna => $valor) {
			$colunas[] = $coluna;
			$valores[] = "'$valor'"; // Envolvemos o valor em aspas simples para evitar erros na query SQL
		}
		
		/**
		* Transformamos nosso array de colunas em uma string, separada por vírgulas
		*/
		$colunas = implode(", ", $colunas);
		
		/**
		* Transformamos nosso array de valores em uma string, separada por vírgulas
		*/
		$valores = implode(", ", $valores);
		
		/**
		* Montamos nossa query SQL
		*/
		$query = "INSERT INTO $tabela ($colunas) VALUES ($valores)";
		
		/**
		* E executamos normalmente
		*/
		$this->pdo->exec($query);
	}
	
	/**
	* Neste método, simplificamos a maneira de alterar dados em uma tabela.
	*
	* @param string $tabela Nome da tabela a ter dados alterados
	* @param string $onde Onde os dados serão alterados
	* @param array $dados Dados a serem alterados na tabela, em forma de um array multi-dimensional
	*/
	public function alterarDados($tabela, $onde, $dados) {
		
		/**
		* Pegaremos os valores e campos recebidos no método e os organizaremos
		* de modo que fique mais fácil montar a query logo a seguir
		*/
		foreach($dados as $key => $value) {
			$values[] = "$key = '$value'";
		}
		
		/**
		* Transformamos nosso array de valores em uma string, separada por vírgulas
		*/
		$values = implode(", ", $values);
		
		/**
		* Montamos nossa query SQL
		*/
		$query = "UPDATE $tabela SET $values WHERE $onde";
		
		/**
		* E executamos normalmente
		*/
		$this->pdo->exec($query);
	}
	
	/**
	* Neste método, simplificamos a maneira de remover dados de uma tabela.
	*
	* @param string $tabela Nome da tabela a ter dados removidos
	* @param string $onde Onde os dados serão removidos
	*/
	public function removerDados($tabela, $onde = null) {

		/**
		* Montamos nossa query SQL
		*/
		$query = "DELETE FROM $tabela";
		
		/**
		* Caso tenhamos um valor de onde deletar dados, adicionamos a cláusula WHERE
		*/
		if(!empty($onde)) {
			$query .= " WHERE $onde";
		}
		
		/**
		* E executamos normalmente
		*/
		$this->pdo->exec($query);
	}
	
	/**
	* Neste método, simplificamos a maneira de consultar dados de uma tabela.
	*
	* @param string $tabela Nome da tabela a ter dados consultados
	* @param string $campos Quais campos serão selecionados na tabela
	* @param string $onde Onde os dados serão consultados
	* @param string $ordem Ordem dos dados a serem consultados
	* @param string $filtro Filtrar dados consultados por conter uma palavra
	* @param string $limite Limitar dados consultados
	*/
	public function pegarDados($tabela, $campos, $onde = null, $filtro = null, $ordem = null, $limite = null) {
		
		/**
		* Montamos nossa query SQL
		*/
		$query = "SELECT $campos FROM $tabela";
		
		/**
		* Caso tenhamos um valor de onde selecionar dados, adicionamos a cláusula WHERE
		*/
		if(!empty($onde)) {
			$query .= " WHERE $onde";
		}
		
		/**
		* Caso tenhamos um valor de como filtrar dados que contenham uma regra, adicionamos a cláusula LIKE
		*/
		if(!empty($filtro)) {
			$query .= " LIKE $filtro";
		}
		
		/**
		* Caso tenhamos um valor de como ordenar dados, adicionamos a cláusula ORDER BY
		*/
		if(!empty($ordem)) {
			$query .= " ORDER BY $ordem";
		}
		
		/**
		* Caso tenhamos um valor de como limitar os dados consultados, adicionamos a cláusula LIMIT
		*/
		if(!empty($limite)) {
			$query .= " LIMIT $limite";
		}
		
		/**
		* Executamos a query preparada
		*/
		$dados = $this->pdo->query($query);
		
		/**
		* E então guardamos os resultados dentro da variável resultados, que será retornada
		*/
		$resultados = $dados->fetchAll();
		
		return $resultados;
	}
	
	/**
	* Neste método, simplificamos a maneira de consultar apenas um dado de uma tabela
	*
	* @param string $tabela Nome da tabela a ter dados consultados
	* @param string $campos Quais campos serão selecionados na tabela
	* @param string $onde Onde os dados serão consultados
	*/
	public function pegarDado($tabela, $campos, $onde=null) {
		
		/**
		* Montamos nossa query SQL para pegar apenas um dado
		*/
		$query = "SELECT $campos FROM $tabela";
		
		/**
		* Selecionamos onde queremos pegar este dado
		*/
		if(!empty($onde)) {
			$query .= " WHERE $onde";
		}
		
		/**
		* Limitamos para apenas 1 resultado
		*/
		$query .= " LIMIT 1";
		
		/**
		* Executamos a query preparada
		*/
		$dado = $this->pdo->query($query);
		
		/**
		* E então guardamos os resultados dentro da variável resultados, que será retornada
		*/
		$resultado = $dado->fetch();
		
		return $resultado;
	}
}