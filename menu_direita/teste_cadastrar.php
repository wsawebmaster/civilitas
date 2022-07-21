<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
        <link rel="stylesheet" type="text/css" href="style/login.css" />
  		<link rel="shortcut icon" href="style/img/favicon.ico" type="image/x-icon">
        <script type="text/javascript" src="script/jquery.js"></script>
        <script type="text/javascript" src="script/acesso.js"></script>
</head>
<body>
        <div id="mensagem"></div>
        
        <form class="formularioLogin" id="formularioLogin" method="POST"  action="">
			
            <header>Cadastro de Usuário</header><br />

            <input type="text" name="nome" id="nome" placeholder="Nome"/>
            <input type="text" name="email" id="email" placeholder="Login"/>
            <input type="password" name="senha" id="senha" placeholder="Senha"/>
            
            <!--<input type="submit" value="entrar" />-->
            <button id="btnEntrar">Entrar</button>
            
            <ul>
                <!-- <li><a href="recuperar_senha.php">Esqueci a senha</a></li> -->
                <li><a href="cadastrar.php">Cadastrar</a></li>
            </ul>
            
        </form>
        
</body>
</html>