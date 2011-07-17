<?php
/**
* Implementação de auto-carregamento de classes
*
* O método __autoload é executado toda vez que um objeto é instanciado
* permitindo assim que nós mandemos o PHP carregar a classe correspondente
* automaticamente. Isso poupa nosso tempo e bastante memória. 
*
* 
* @package Livraria412
*/

session_start();

$config = array(
	'servidor' => 'localhost',
	'banco' => 'loja',
	'usuario' => 'root',
	'senha' => '123456'
); 

function __autoload($classe){
	require_once('classes/'.$classe.'.class.php');
}

