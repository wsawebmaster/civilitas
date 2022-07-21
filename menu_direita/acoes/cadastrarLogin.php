<?php
require("conexao.php");
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$re = filter_input(INPUT_POST, 're', FILTER_SANITIZE_STRING);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

$checar_duplicidade = $conexao->prepare('SELECT email FROM usuarios WHERE email = ?');
$checar_duplicidade->execute([$email]);
$count = $checar_duplicidade->rowCount();


	if ($checar_duplicidade->rowCount() > 0) {
		$email = $checar_duplicidade->fetch(PDO::FETCH_OBJ);

	//email já existe
	echo json_encode(array("erro" => 1, "mensagem" => "Email já existe!"));
	//echo ("<script>location.href='cadastrarLogin.php'</script>");
	} else {
	//realizar cadastro
	$conexao->query("INSERT INTO usuarios (nome, email, re, senha) VALUES('$nome', '$email', '$re', '$senha')");
	echo json_encode(array("erro" => 1, "mensagem" => "Cadastro Realizado com sucesso!"));
	}

?>




