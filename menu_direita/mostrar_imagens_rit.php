<?php
session_start();
include_once 'acoes/conexao.php';

//echo '<center><h1><a href="dashboard.php#Modal_Rit_Lancados">Voltar</a></h1></center>';
//echo '<script>history.go(-1);</script>';
echo '<a href="javascript:history.go(-1)">Voltar</a>';

$adm = false;
if (isset($_SESSION["usuario"]) && is_array($_SESSION["usuario"])) {
    $adm = $_SESSION["usuario"][1];
}

//if (!$adm) {
//    echo '<h2><font color="red">Acesso não permitido para esse tipo de usuário, desculpe.</font><h3>';
//    exit;
//}

$stmt = $conexao->prepare("SELECT * FROM rit WHERE id=?");
$stmt->execute([$_GET['id']]);
$rit  = $stmt->fetch();

if (empty($rit)) {
    echo '<h2><font color="red">O RIT pesquisado não foi encontrado, desculpe.</font><h3>';
    exit;
}

$stmt    = $conexao->prepare("SELECT * FROM rit_imagens WHERE id_rit = ?");
$stmt->execute([$rit['id']]);
$imagens = $stmt->fetchAll();

if (!empty($imagens)) {
    
    $imagens_inexistentes = '';
    $imagens_existentes   = '';
    foreach ($imagens as $imagem) {

        if (!file_exists($imagem['path'])) {
            $imagens_inexistentes .= '<p>- '.$imagem['nome'].' - (<b>'.$imagem['path'].'</b>)</p>';
            continue;
        }

        $imagens_existentes .= '<img class="image" src="'.$imagem['path'].'" title="'.$imagem['nome'].'" />';
    }
    echo '<center>';
    echo '<style>
        body {
            font-family: "Titillium Web", sans-serif;
        }
        .image {
            height: 15rem;
            border-radius: 17px;
            padding: 5px;
        }
        .image:hover {
            height: 30rem;
            border-style: solid;
            border-color: red;
        }
        a {
            text-decoration: none;
            font-size: 2rem;
        }
        a:hover {
            color: rgb(3, 93, 3);
            text-decoration: underline;
        }
    </style>';

    if (!empty($imagens_existentes)) {
        echo '<div id="box_imagens_existentes">'.$imagens_existentes.'</div>';
    }
    if (!empty($imagens_inexistentes)) {
        echo '<div id="box_imagens_inexistentes"><font color="red">Imagens inexistentes:<br></font>'.$imagens_inexistentes.'</div>';
    }
} else {
    echo '<p><i><font color="blue">Nenhuma imagem cadastrada para esse RIT</font></i></p>';
}

//echo '<hr>'.json_encode($rit, JSON_PRETTY_PRINT);
