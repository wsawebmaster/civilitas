<?php

	include_once 'conexao.php';


if(isset($_POST['btnCadastrar'])) {

	// 1 - Registro  dos dados
		//verifica se não existir sessão aberta ele inicia
	if(!isset($_SESSION))
		session_start();

	foreach($_POST as $chave=>$valor) // percorre todos os post armazenando seus dados na sessão
		$_SESSION[$chave] = $mysqli->real_escape_string($valor);

	// 2 - Validação dos dados
	if(strlen($_SESSION['nome']) == 0) 
		$erro[] = "Preencha o campo Nome";

	if(strlen($_SESSION['email'], '@') != 1 || substr_count($_SESSION['email'], '.') < 1 || substr_count($_SESSION['email'], '.') > 2) 
		$erro[] = "Preencha o email corretamente";

	if(strlen($_SESSION['senha']) < 6 || strlen($_SESSION['senha']) > 16)
		$erro[] = "A senha deve ter no mínimo 6 caracteres";

	if(strcmp($_SESSION['senha'], $_SESSION['csenha']) != 0)
		$erro[] = "As senhas devem ser idênticas";
	// 3 - Inserção no Bando e redirecionamento
	if(count($erro) == 0) {
		$confirma = $conexao->query("INSERT INTO usuarios (
			nome, 
			email, 
			senha) 
			VALUES(
			'$_SESSION[nome]', 
			'$_SESSION[email]', 
			'$_SESSION[senha]'
			)");
	}
	
}
?>




