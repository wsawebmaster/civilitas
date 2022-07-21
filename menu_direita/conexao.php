<?php
/*     //Início da conexão com Banco de Dados via PDO
    define('HOST', 'localhost');
    define('USER', 'suportes_wagner');
    define('PASS', 'Andrade7@spi');
    define('DBNAME', 'suportes_suportespi');
    define('PORT', 3306);

    try {
    //Conexão especificando a porta
    $conn = new PDO('mysql:host' . HOST . ';port=' . PORT . ';dbname=' . DBNAME . ';charset=utf8', USER, PASS);
        //echo "Parabéns!! A conexão ao banco de dados via PDO foi realizada com sucesso!";
    } catch (PDOException $err) {
        echo 'Erro: Ops!! A conexão ao banco de dados não foi realizada. Erro gerado'.$err->getMessage();
    } */






// Via Mysqli
     $servidor = "localhost";
    $usuario = "suportes_wagner";
    $senha = "Andrade7@spi";
    $dbname = "suportes_suportespi";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
 
    /* Checa conexão */
    if($conn->connect_errno) {
        echo "Falha na conexão!" . $conn->connect_error;
        exit();
    }
?>