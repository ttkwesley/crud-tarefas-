<?php
//Link de ligamentos dos scripts para fazer as instancias das classe 
require "../../app_lista_tarefas/tarefa.model.php";
require "../../app_lista_tarefas/tarefa.service.php";
require "../../app_lista_tarefas/conexao.php";


$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

if ($acao == 'inserir') { //Logica responsavel por inserir os dados digitado pelo usuario na lista de tarefas visual 
	$tarefa = new Tarefa();
	$tarefa->__set('tarefa', $_POST['tarefa']);

	$conexao = new Conexao();

	$tarefaService = new TarefaService($conexao, $tarefa); //tarefa service recebe como parametros $conexao e $tarefa
	$tarefaService->inserir(); //metodo configurado no tarefa service

	header('Location: nova_tarefa.php?inclusao=1');
} else if ($acao == 'recuperar') { //Logica responsavel por recuperar os dados do banco de dados digitado pelo usuario nos formulario do front end 

	$tarefa = new Tarefa();
	$conexao = new Conexao();

	$tarefaService = new TarefaService($conexao, $tarefa); //tarefa service recebe como parametros $conexao e $tarefa
	$tarefas = $tarefaService->recuperar(); //metodo configurado no tarefa service

} else if ($acao == 'atualizar') { //Logica responsavel por atualizar os itens da lista de tarefas ao clicar no icone de atualizar

	$tarefa = new Tarefa();
	$tarefa->__set('id', $_POST['id'])->__set('tarefa', $_POST['tarefa']);

	$conexao = new Conexao();

	$tarefaService = new TarefaService($conexao, $tarefa); //tarefa service recebe como parametros $conexao e $tarefa
	if ($tarefaService->atualizar()) {

		if (isset($_GET['pag']) and $_GET['pag'] == 'index') {  //Verifica se o retorno apos o metodo realizado será pagina index ou todas tarefas
			header('location: index.php');
		} else {
			header('location: todas_tarefas.php');
		}
	}
} else if ($acao == 'remover') { //Logica responsavel por remover o itens da lista ao clicar no icone de remover

	$tarefa = new Tarefa();
	$tarefa->__set('id', $_GET['id']);

	$conexao = new Conexao();

	$tarefaService = new TarefaService($conexao, $tarefa); //tarefa service recebe como parametros $conexao e $tarefa
	$tarefaService->remover(); //metodo configurado no tarefa service

	if (isset($_GET['pag']) and $_GET['pag'] == 'index') {  //Verifica se o retorno apos o metodo realizado será pagina index ou todas tarefas
		header('location: index.php');
	} else {
		header('location: todas_tarefas.php');
	}
} else if ($acao == 'marcarRealizada') { //Logica responsavel por marcar as tarefas como realiza ao clicar no icone de concluido
	$tarefa = new Tarefa();
	$tarefa->__set('id', $_GET['id'])->__set('id_status', 2); // 2 == realizada

	$conexao = new Conexao();

	$tarefaService = new TarefaService($conexao, $tarefa); //tarefa service recebe como parametros $conexao e $tarefa
	$tarefaService->marcarRealizada(); //metodo configurado no tarefa service

	if (isset($_GET['pag']) and $_GET['pag'] == 'index') { //Verifica se o retorno apos o metodo realizado será pagina index ou todas tarefas
		header('location: index.php');
	} else {
		header('location: todas_tarefas.php');
	}
} else if ($acao == 'tarefasPendentes') { //Logica responsavel por mostrar as tarefas pendentes na index

	$tarefa = new Tarefa();
	$tarefa->__set('id_status', 1); //1 == pendente
	$conexao = new Conexao();

	$tarefaService = new TarefaService($conexao, $tarefa); //tarefa service recebe como parametros $conexao e $tarefa
	$tarefas = $tarefaService->tarefasPendentes(); //metodo configurado no tarefa service
}
