<?php

class Conexao
{
	//Atributos para a realização da conexao com o banco de dados 
	private $host = 'localhost'; //hospedagem
	private $dbname = 'php_com_pdo'; //nome do banco de dados
	private $user = 'root'; //usuario definido no atributo do objeto ser usado nos metodos
	private $pass = ''; //senhha definido no atributo do objeto para ser usado nos metodos
	//Metodos
	public function conectar()
	{
		try { //Tenta realizar a conexão 

			$conexao = new PDO(
				"mysql:host=$this->host;dbname=$this->dbname", //Define o banco de dados como mysql
				"$this->user", //usuario faz o retorno direto do objeto
				"$this->pass" //senha faz o retorno direto do objeto
			);

			return $conexao;
		} catch (PDOException $e) { //Caso a conexão falhe realizada entra no bloco do catch para tratamento do erro
			echo '<p>' . $e->getMessage() . '</p>';
		}
	}
}
