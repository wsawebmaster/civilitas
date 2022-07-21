<?php
//Credenciais de acesso ao BD
include_once 'conexao_pdo.php';


$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
//$id = $_GET['id']; menos seguro
//echo $id;
//Prepare query execute
$query_rit = "SELECT * FROM rit WHERE id='$id' LIMIT 1";
$result_rit = $conn->prepare($query_rit);
$result_rit->execute();
$row_rit = $result_rit->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Status RIT</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /*custom font*/
        @import url(https://fonts.googleapis.com/css?family=Montserrat);

        /* Global ======================= */
        :root {
            --dark-blue: #363f5f;
            --green: #49aa26;
            --light-green: #3dd705;
            --red: #e92929;
            --sombraColor: rgba(113, 0, 170, 0.945), 0 0.5rem 5rem rgba(113, 0, 170, 0.3);
        }


        body {
            color: black;
            font-family: montserrat, arial, verdana;
        }


        /*basic reset*/
        * {
            margin: 0;
            padding: 0;
        }

        html {
            height: 70vh;
            /*background-color: #437f81;*/
            background-color: #ededed;
            /*background: linear-gradient(rgba(196, 102, 0, 0.6), rgba(155, 89, 182, 0.6));	*/
        }

        /* Modal ======================= */
        .modal-overlay {
            /* Fundo escuro */
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            position: fixed;
            top: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            visibility: visible;
            z-index: 999;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal_editar_rit {
            /* Janela */
            background: #f0f2f5;
            padding: 2.4rem;
            width: 27rem;
            position: relative;
            z-index: 1;
        }

        /* Form ======================= */
        input {
            border: none;
            border-radius: 0.2rem;
            padding: 0.8rem;
            width: 100%;
            margin-top: 0.8rem;
        }

        .input-group,
        .select-group {
            margin-top: 0.8rem;
        }

        .input-group .help {
            opacity: 0.4;
        }

        .input-group.actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .input-group.actions.button,
        .input-group.actions button {
            width: 48%;
        }

        .select-group {
            height: 40px;
            color: #757575;
            border: none;
            border-radius: 0.2rem;
            padding: 0.8rem;
            width: 100%;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }

        /* Links & Buttons =================== */
        a {
            color: var(--green);
            text-decoration: none;
        }

        a:hover {
            color: var(--light-green);
        }

        .button.salve {
            width: 100%;
            height: 50px;
            border: none;
            color: white;
            background: var(--green);

            padding: 0;

            border-radius: 0.25rem;

            cursor: pointer;
        }

        .button.salve:hover {
            background: var(--light-green);
            font-weight: bold;
        }

        .button.new {
            display: inline-block;
            margin-top: 0.8rem;
        }

        .button.cancel {
            color: var(--red);
            border: 2px var(--red) solid;
            border-radius: 0.25rem;

            height: 50px;
            width: 47%;

            display: flex;
            align-items: center;
            justify-content: center;

            opacity: 0.6;
        }

        .button.cancel:hover {
            opacity: 1;
        }
    </style>
</head>

<body>




    <!-- Section: Início Modal Atualizar Andamento -->
    <div class="modal-overlay">
        <div class="modal_editar_rit">
            <div id="form">
                <h2>Editar RIT</h2>
                <div class="input-group">
                    <label class="sr-only" for="description">ID</label>
                    <input type="text" name="id" value="<?php echo $row_rit['id']; ?>" required maxlength="10" readonly><br />
                </div>

                <form method="POST" action="alterar_rit.php">
                    <label class="sr-only" for="description">Técnico</label>
                    <input type="text" name="nomecompleto" value="<?php echo $row_rit['tecnico']; ?>" required maxlength="150" readonly><br />

                    <label class="sr-only" for="description">Cidade</label>
                    <input type="text" name="cidade" value="<?php echo $row_rit['cidade']; ?>" required maxlength="150" readonly><br />

                    <label class="sr-only" for="description">Situação Atual</label>
                    <input type="text" name="situacao" value="<?php echo $row_rit['situacao']; ?>" required maxlength="150" readonly><br />

                    <label class="sr-only" for="description">RIT</label>
                    <select class="select-group" name="situacao" id="situacao">
                        <option value="Pendente">Pendente</option>
                        <option value="Em tratativa">Em tratativa</option>
                        <option value="Regularizado">Regularizado</option>
                    </select><br />

            </div>
            <div class="input-group actions">
                <input type="hidden" name="id" value="<?php echo $row_rit['id']; ?>" />
                <a href="javascript:history.go(-1)" class="button cancel">Cancelar</a>
                <button type="submit" class="button salve">Salvar</button>
            </div>
            </form>
        </div>
    </div>
    <!-- Section: Fim Modal Atualizar Andamento -->










</body>

</html>