<?php


//CRUD
class TarefaService
{

	private $conexao;
	private $tarefa;

	public function __construct(Conexao $conexao, Tarefa $tarefa)
	{
		$this->conexao = $conexao->conectar();
		$this->tarefa = $tarefa;
	}
	//Metodos do crud
	public function inserir()
	{ //create
		$query = 'insert into tb_tarefas(tarefa)values(:tarefa)'; //Query responsavel pela inserção dos valores no banco de dados
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
		$stmt->execute();
	}

	public function recuperar() //Query responsavel pela recuperação dos valores no banco de dados
	{ //read 
		$query =  '
			select 
				t.id, s.status, t.tarefa 
			from 
				tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
		';
		$stmt = $this->conexao->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ); //Retorna ao valores como objeto ao inves de um array 
	}

	public function atualizar()
	{ //update

		$query = "update tb_tarefas set tarefa = ? where id = ?";  //Query responsavel pela atualização dos valores no banco de dados
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('tarefa'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute();
	}

	public function remover()
	{ //delete

		$query = 'delete from tb_tarefas where id = :id'; //Query responsavel pela remoçao dos valores no banco de dados
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id', $this->tarefa->__get('id'));
		$stmt->execute();
	}

	public function marcarRealizada() //Logica da função para marcar o item do realizado
	{ //

		$query = "update tb_tarefas set id_status = ? where id = ?";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('id_status'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute();
	}
	public function tarefasPendentes() //Logica das tarefas pendentes na index // E query responsavel pelo processo no banco de dados
	{
		$query = '
			select 
				t.id, s.status, t.tarefa 
			from 
				tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
			where 
				t.id_status = :id_status	
		';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
}
