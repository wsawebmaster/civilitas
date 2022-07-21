<?php
if(isset($_POST['email'])) {
	include_once 'conexao.php';
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
	$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

	//if($nome == "" | $email == "" | $senha == "") {
	//	echo "teste";
	//echo  "<script>alert('Preencha todos os campos!');</script>";
	//echo ("<script>location.href='../cadastrar.html'</script>");

    //  header("Location: ../cadastrar.html");
	//}else{
    $conexao->query("INSERT INTO usuarios (nome, email, senha) VALUES('$nome', '$email', '$senha')");
	//}
	echo  "<script>alert('Dados cadastrados com sucesso!');</script>";
	echo ("<script>location.href='../index.php'</script>");
}
?>




