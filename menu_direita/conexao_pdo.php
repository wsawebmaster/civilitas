<?php

//Credenciais de acesso ao BD
define('HOST', 'localhost');
define('USER', 'suportes_wagner');
define('PASS', 'Andrade7@spi');
define('DBNAME', 'suportes_suportespi');

$conn = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME . ';charset=utf8', USER, PASS);
//echo "Parabéns!! A conexão ao banco de dados via PDO ocorreu normalmente!";
//echo "Parabéns!! A conexão ao banco de dados via PDO ocorreu normalmente!. Existem ".mysqli_num_rows($sql)." registros.";
?>