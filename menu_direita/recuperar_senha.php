<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Recuperar</title>
        <link rel="stylesheet" type="text/css" href="style/login.css" />
  		<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
        <script type="text/javascript" src="script/jquery.js"></script>


	</head>
	<body>
        <div id="mensagem"></div>
		<form class="formularioRecuperar" method="POST" action="acoes/recuperar_senha.php">
			        <header>Recuperar Senha</header><br />

				<input type="email" name="email" id="email" placeholder="E-mail" required>
				<button type="submit" name="btnRecuperar">Recuperar</button>

            <ul>
                <li><a href="index.php">Entrar</a></li>
            </ul>

			</form>
	</body>
</html>