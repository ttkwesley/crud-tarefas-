<?php

class Tarefa
{
	//Atributos 
	private $id;
	private $id_status;
	private $tarefa;
	private $data_cadastro;

	//Metodos magicos get e set // responsaveis por resgatar valores ou mudar suas atribuiçoes
	public function __get($atributo)
	{
		return $this->$atributo;
	}

	public function __set($atributo, $valor)
	{
		$this->$atributo = $valor;
		return $this;
	}
}
