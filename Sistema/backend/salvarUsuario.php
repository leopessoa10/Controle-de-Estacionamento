<?php
    session_start(); // ✅ Inicia a sessão corretamente

    include("conexao.php");
    include('funcoes.php');

    // ✅ Verifica se a sessão está ativa e se idEmpresa está definida
    if (!isset($_SESSION['idEmpresa'])) {
        die("Erro: Sessão não iniciada ou idEmpresa não definida.");
    }

    $idEmpresa = $_SESSION['idEmpresa'];

    $tipoUsuario    = $_POST["nTipoUsuario"] ?? '';
    $nome           = $_POST["nNome"] ?? '';
    $email          = $_POST["nEmail"] ?? '';
    $senha          = $_POST["nSenha"] ?? '';
    $empresa        = $_POST["nEmpresa"] ?? '';
    $funcao         = $_GET["funcao"] ?? '';
    $idUsuario      = isset($_GET["codigo"]) ? $_GET["codigo"] : null;
    $ativo          = isset($_POST["nAtivo"]) && $_POST["nAtivo"] == "on" ? "S" : "N";

    // ✅ Verifica se empresa existe no banco para evitar erro de chave estrangeira
    $verificaEmpresa = mysqli_query($conn, "SELECT id_empresa FROM empresa WHERE id_empresa = '$idEmpresa'");
    if (mysqli_num_rows($verificaEmpresa) == 0) {
        die("Erro: A empresa com ID $idEmpresa não existe.");
    }

    // Função de inclusão
    if ($funcao == "I") {

        $idUsuario = proxIdUsuario(); // Busca o próximo ID disponível
        $foto = '';

        // Foto do usuário (inclusão)
        if (!empty($_FILES['nFoto']['tmp_name'])) {
            $ext = pathinfo($_FILES['nFoto']['name'], PATHINFO_EXTENSION);
            $novo_nome = "foto-" . $idUsuario . '.' . $ext;
            $diretorio = '../dist/img/usuarios/';
            if (!is_dir($diretorio)) {
                mkdir($diretorio, 0755, true);
            }

            $caminho_completo = $diretorio . $novo_nome;
            if (move_uploaded_file($_FILES['nFoto']['tmp_name'], $caminho_completo)) {
                $foto = 'dist/img/usuarios/' . $novo_nome;
            }
        }

        // INSERT
        if ($_SESSION['idTipoUsuario'] == 3) {
        $sql = "INSERT INTO usuario 
                (id_usuario, fk_id_tipo_usuario, nome, email, senha, foto, flg_ativo, fk_id_empresa) 
                VALUES 
                ($idUsuario, $tipoUsuario, '$nome', '$email', md5('$senha'), '$foto', '$ativo', '$empresa')";
        } else if ($_SESSION['idTipoUsuario'] == 1) {
        $sql = "INSERT INTO usuario 
            (id_usuario, fk_id_tipo_usuario, nome, email, senha, foto, flg_ativo, fk_id_empresa) 
            VALUES 
            ($idUsuario, $tipoUsuario, '$nome', '$email', md5('$senha'), '$foto', '$ativo', '$idEmpresa')";
        }

    } elseif ($funcao == "A") {

        // UPDATE
        $setSenha = ($senha != '') ? "senha = md5('$senha'), " : "";

        $sql = "UPDATE usuario 
                SET fk_id_tipo_usuario = $tipoUsuario, 
                    nome = '$nome', 
                    email = '$email', 
                    $setSenha
                    flg_ativo = '$ativo'
                WHERE id_usuario = $idUsuario";

        mysqli_query($conn, $sql); // Executa primeiro update

        // ✅ Atualiza foto se enviada
        if (!empty($_FILES['nFoto']['tmp_name'])) {
            $ext = pathinfo($_FILES['nFoto']['name'], PATHINFO_EXTENSION);
            $novo_nome = "foto-" . $idUsuario . '.' . $ext;
            $diretorio = '../dist/img/usuarios/';
            if (!is_dir($diretorio)) {
                mkdir($diretorio, 0755, true);
            }

            $caminho_completo = $diretorio . $novo_nome;
            if (move_uploaded_file($_FILES['nFoto']['tmp_name'], $caminho_completo)) {
                $diretorioImg = 'dist/img/usuarios/' . $novo_nome;

                $sqlFoto = "UPDATE usuario SET foto = '$diretorioImg' WHERE id_usuario = $idUsuario";
                if (!mysqli_query($conn, $sqlFoto)) {
                    die("Erro ao atualizar foto: " . mysqli_error($conn));
                }

                $_SESSION['FotoLogin'] = $diretorioImg;
            }
        }

    } elseif ($funcao == "D") {
        // DELETE
        $sql = "DELETE FROM usuario WHERE id_usuario = $idUsuario";
    }

    // ✅ Executa INSERT ou DELETE se definido
    if (isset($sql)) {
        if (!mysqli_query($conn, $sql)) {
            die("Erro ao executar operação: " . mysqli_error($conn));
        }
    }

    // ✅ Atualiza sessão com nome/email do usuário (geralmente usado no login)
    $_SESSION['NomeLogin'] = $nome;
    $_SESSION['EmailLogin'] = $email;

    mysqli_close($conn);
    header("Location: ../usuarios.php");
    exit;
?>
