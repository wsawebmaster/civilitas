<?php
error_reporting(E_ALL);
ini_set('display_errors',true);

session_start();
include_once 'acoes/conexao.php';

unset($_SESSION['msg']);
unset($_SESSION['erros_imagens']);

//Receber os dados do formulário

$monitor          = filter_input(INPUT_POST, 'monitor', FILTER_SANITIZE_STRING);
$cidade           = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
$area           = filter_input(INPUT_POST, 'area', FILTER_SANITIZE_STRING);
$tecnico          = filter_input(INPUT_POST, 'tecnico', FILTER_SANITIZE_STRING);
$data_atividade   = filter_input(INPUT_POST, 'data_atividade', FILTER_SANITIZE_STRING);
$servico          = filter_input(INPUT_POST, 'servico', FILTER_SANITIZE_STRING);
$atividade        = filter_input(INPUT_POST, 'atividade', FILTER_SANITIZE_STRING);
$designador       = filter_input(INPUT_POST, 'designador', FILTER_SANITIZE_STRING);
$pon              = filter_input(INPUT_POST, 'pon', FILTER_SANITIZE_STRING);
$tecnologia       = filter_input(INPUT_POST, 'tecnologia', FILTER_SANITIZE_STRING);
$contador_defeito = filter_input(INPUT_POST, 'contador_defeito', FILTER_SANITIZE_STRING);

$rede_externa  = filter_input(INPUT_POST, 'rede_externa', FILTER_SANITIZE_STRING);
$rede_interna  = filter_input(INPUT_POST, 'rede_interna', FILTER_SANITIZE_STRING);
$sobre_tecnico = filter_input(INPUT_POST, 'sobre_tecnico', FILTER_SANITIZE_STRING);
$orientacoes   = filter_input(INPUT_POST, 'orientacoes', FILTER_SANITIZE_STRING);
$observacoes   = filter_input(INPUT_POST, 'observacoes', FILTER_SANITIZE_STRING);
$resumo  = filter_input(INPUT_POST, 'resumo', FILTER_SANITIZE_STRING);
$situacao = NULL;
if($resumo == 'Experiência') {
    $situacao = 'Pendente';
}
date_default_timezone_set('America/Sao_Paulo');

function saveImage($arquivo, $i, $diretorio)
{
    $validextensions = array("jpeg", "jpg", "png");
    $basename        = basename($arquivo['name'][$i]);
    $ext             = explode('.', $basename);
    $file_extension  = end($ext);
    $novo_nome       = uniqid() . '-' . $basename;

    //Diretório onde o arquivo vai ser salvo
    $caminho_completo = "{$diretorio}/{$novo_nome}";

    $status = move_uploaded_file($arquivo['tmp_name'][$i], $caminho_completo);

    if (!$status) {
        if (!isset($_SESSION['erros_imagens'])) {
            $_SESSION['erros_imagens'] = [];
        }

        $_SESSION['erros_imagens'][] = 'Erro ao realizar o upload da imagem: ' . $caminho_completo;
    }

    return [
        'status' => $status,
        'nome' => $basename,
        'caminho' => $caminho_completo
    ];
}

function apagarImagens(array $imagens)
{
    foreach ($imagens as $imagem) {
        unlink($imagem);
    }
}

if ((!$designador) || (!$tecnico)) { // Se não encontar os campos irá interromper o cadastro no BD e exibirá o alerta
    $_SESSION['msg'] = "<div style='padding: 10px;margin-bottom: 20px;border: 1px solid transparent;border-radius: 4px;background: rgba(252, 248, 227, 0.9);text-align: center;font-size: 1rem;font-weight: bold;margin-top: 40px;color: #8a6d3b;border-color: #faebcc;'>Necessário buscar ao menos um Designador!</div>";
} else {

    $checar_duplicidade = $conexao->prepare('SELECT id FROM rit WHERE atividade = ?');
    $checar_duplicidade->execute([$atividade]);
    $count = $checar_duplicidade->rowCount();

    if ($count > 0) {
        $_SESSION['msg'] = "<div style='padding: 10px;margin-bottom: 20px;border: 1px solid transparent;border-radius: 4px;background: rgba(252, 248, 227, 0.9);text-align: center;font-size: 1rem;font-weight: bold;margin-top: 40px;color: #8a6d3b;border-color: #faebcc;'>Atividade já cadastrada anteriormente!</div>";
    } else {
        $conexao->beginTransaction();

        //Inserir no BD
        $sql_insert = "INSERT INTO rit (
            monitor,
            cidade,
            area,
            tecnico,
            data_atividade,
            servico,
            atividade,
            designador,
            pon,
            tecnologia,
            contador_defeito,

            rede_externa,
            rede_interna,
            sobre_tecnico,
            orientacoes,
            observacoes,
            resumo,
            situacao
            )
            VALUES (
            :monitor,
            :cidade,
            :area,
            :tecnico,
            :data_atividade,
            :servico,
            :atividade,
            :designador,
            :pon,
            :tecnologia,
            :contador_defeito,

            :rede_externa,
            :rede_interna,
            :sobre_tecnico,
            :orientacoes,
            :observacoes,
            :resumo,
            :situacao
            )";
        $insert_msg = $conexao->prepare($sql_insert);
        $insert_msg->bindParam(':monitor', $monitor);
        $insert_msg->bindParam(':cidade', $cidade);
        $insert_msg->bindParam(':area', $area);
        $insert_msg->bindParam(':tecnico', $tecnico);
        $insert_msg->bindParam(':data_atividade', $data_atividade);
        $insert_msg->bindParam(':servico', $servico);
        $insert_msg->bindParam(':atividade', $atividade);
        $insert_msg->bindParam(':designador', $designador);
        $insert_msg->bindParam(':pon', $pon);
        $insert_msg->bindParam(':tecnologia', $tecnologia);
        $insert_msg->bindParam(':contador_defeito', $contador_defeito);

        $insert_msg->bindParam(':rede_externa', $rede_externa);
        $insert_msg->bindParam(':rede_interna', $rede_interna);
        $insert_msg->bindParam(':sobre_tecnico', $sobre_tecnico);
        $insert_msg->bindParam(':orientacoes', $orientacoes);
        $insert_msg->bindParam(':observacoes', $observacoes);
        $insert_msg->bindParam(':resumo', $resumo);
        if(is_null($situacao)) {
            $insert_msg->bindParam(':situacao', $situacao,\PDO::PARAM_NULL);
        } else {
            $insert_msg->bindParam(':situacao', $situacao);
        }
        if ($insert_msg->execute()) {
            //Recuperar último ID inserido no banco de dados
            $ultimo_id = $conexao->lastInsertId();

            $hoje = date('d-m-Y');
            $path = "imagens_rit/{$hoje}";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imagens_com_sucesso = [];
            //echo json_encode($_FILES); exit;
            if (!empty($_FILES['image']['name'][0])) {

                for ($i = 0; $i < count($_FILES['image']['name']); $i++) {
                    $resultado_imagem = saveImage($_FILES['image'], $i, $path);

                    if (!$resultado_imagem['status']) {
                        continue;
                    }

                    $imagens_com_sucesso[] = $resultado_imagem['caminho'];
                    $sql_insert_imagens    = "INSERT INTO rit_imagens (
                        nome,
                        path,
                        id_rit
                    )
                    VALUES (
                        :nome,
                        :path,
                        :id_rit
                    )";
                    $insert_image          = $conexao->prepare($sql_insert_imagens);
                    $insert_image->bindParam(':nome', $resultado_imagem['nome']);
                    $insert_image->bindParam(':path', $resultado_imagem['caminho']);
                    $insert_image->bindParam(':id_rit', $ultimo_id);
                    $insert_image->execute();
                }
            }

            if (!isset($_SESSION['erros_imagens'])) {
                $conexao->commit();
                $sucesso  = true;
                $mensagem = 'Cadastro RIT e upload de todas imagens realizados com sucesso!';
            } else {
                $sucesso  = false;
                $mensagem = 'Cadastro RIT não realizado devido a falha em suas dependências.<br>';
                $mensagem .= implode('<br>', $_SESSION['erros_imagens']);
                $conexao->rollBack();
                apagarImagens($imagens_com_sucesso);
            }

            if ($sucesso) {
                $_SESSION['msg'] = "<div style='padding: 10px;margin-bottom: 20px;border: 1px solid transparent;border-radius: 4px;background: #dff0d8;text-align: center;font-size: 1rem;font-weight: bold;margin-top: 40px;color: #3c763d;border-color: #d6e9c6;'>$mensagem</div>";
            } else {
                $_SESSION['msg'] = "<div style='padding: 10px;margin-bottom: 20px;border: 1px solid transparent;border-radius: 4px;background: #fcf8e3;text-align: center;font-size: 1rem;font-weight: bold;margin-top: 40px;color: #8a6d3b;border-color: #faebcc;'><span style='color:red;'>$mensagem</span></div>";
            }
        } else {
            $_SESSION['msg'] = "<div style='padding: 10px;margin-bottom: 20px;border: 1px solid transparent;border-radius: 4px;background: rgba(0, 0, 0, 0.5);text-align: center;font-size: 1rem;font-weight: bold;margin-top: 40;color: #a94442;border-color: #ebccd1;'>Falha na tentativa de  cadastro RIT!</div>";
        }
    }
}


header("Location: dashboard.php");
