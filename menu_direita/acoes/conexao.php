<?php
    $server = "127.0.0.1";
    $usuario = "suportes_wagner";
    $senha = "Andrade7@spi";
    $banco = "suportes_suportespi"; //videoaula //suportes_suportespi

    try{
        $conexao = new PDO("mysql:host=$server;dbname=$banco", $usuario, $senha);
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexao->exec('SET CHARACTER SET utf8');
        
        //echo "Conexão realizada com êxito!";
    }catch(PDOException $erro){
        //echo "Ocorreu um erro de conexao: {$erro->getMessage()}";
        $conexao = null;
    }
?>