<?php
    require("conexao.php");

    if(isset($_POST["login"]) && isset($_POST["senha"]) && $conexao != null){
        $query = $conexao->prepare("SELECT * FROM usuarios WHERE email = ? ");
        $query->execute(array($_POST["login"]));

        //echo $query->rowCount();
        
         if($query->rowCount()){
            $user = $query->fetchAll(PDO::FETCH_ASSOC)[0];
            
            if(password_verify($_POST['senha'], $user['senha'])){

            session_start();
            $_SESSION["usuario"] = array($user["nome"], $user["perfil"]);

            echo json_encode(array("erro" => 0));
            //echo "<script>window.location = '../dashboard.php'</script>";
            }else{
        echo json_encode(array("erro" => 1, "mensagem" => "Dados incorretos!"));
        }
        }else{
        echo json_encode(array("erro" => 1, "mensagem" => "Dados incorretos!"));
        }
     }else{
        echo json_encode(array("erro" => 1, "mensagem" => "Ocorreu um erro interno no servidor"));
    }
?>