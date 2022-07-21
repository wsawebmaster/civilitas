<?php
//Credenciais de acesso ao BD
  include_once 'conexao_pdo.php';

function dia_atual()
{
    $hoje = getdate();
}
$hoje = date('d/m/Y');

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $situacao = filter_input(INPUT_POST, 'situacao', FILTER_SANITIZE_STRIPPED);

    $query_rit= "UPDATE rit SET 
        situacao='$situacao', 
        atualizado=NOW() 
        WHERE id='$id'";

    $result_rit = $conn->prepare($query_rit);
	$result_rit->execute();

    if($result_rit->execute()){
    $_SESSION['msg'] = "<div style='padding: 10px;margin-bottom: 20px;border: 1px solid transparent;border-radius: 4px;background: #dff0d8;text-align: center;font-size: 1rem;font-weight: bold;margin-top: 40px;color: #3c763d;border-color: #d6e9c6;'>Atualizado com êxito!</div>";
    header("Location: dashboard.php");
    } else {
    echo 'Falha na Atualização!';
    }

?>