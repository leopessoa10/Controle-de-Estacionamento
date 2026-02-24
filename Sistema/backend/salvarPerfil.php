<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    include('conexao.php');
    include('funcoes.php');

    $idUsuario = $_SESSION['idLogin'];
    $nome      = mysqli_real_escape_string($conn, $_POST['nNome']);
    $senha     = isset($_POST['nAlterarSenha']) ? mysqli_real_escape_string($conn, $_POST['nAlterarSenha']) : '';

    //Foto do perfil
    $diretorioImg = '';
    
    if (!empty($_FILES['nFoto']['tmp_name'])) {

        //Pega extensão e monta o novo nome do arquivo
        $ext = pathinfo($_FILES['nFoto']['name'], PATHINFO_EXTENSION);
        $novo_nome = "foto-" . $idUsuario . '.' . $ext;

        //Verifica se existe o diretório (ou cria)
        $diretorio = '../dist/img/usuarios/';
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0755, true);
        }

        //Grava o arquivo no diretório
        $caminho_completo = $diretorio . $novo_nome;
        if (move_uploaded_file($_FILES['nFoto']['tmp_name'], $caminho_completo)) {
            //Salva o diretório para colocar na tabela do BD
            $diretorioImg = 'dist/img/usuarios/' . $novo_nome;

            //Gravação no BD
            $sql = "UPDATE usuario
                    SET foto = '$diretorioImg'
                    WHERE id_usuario = $idUsuario";
            if (!mysqli_query($conn, $sql)) {
                die("Erro ao atualizar foto: " . mysqli_error($conn));
            }
            
          // Atualiza a sessão com o novo nome
            $_SESSION['FotoLogin'] = $diretorioImg;
        }
    }
    
    //Gravação no BD
    $sql = "UPDATE usuario 
            SET nome = '$nome'
            WHERE id_usuario = $idUsuario";
    if (!mysqli_query($conn, $sql)) {
        die("Erro ao atualizar nome: " . mysqli_error($conn));
    }
    // Atualiza a sessão com o novo caminho da foto
    $_SESSION['NomeLogin'] = $nome;

    //Gravação no BD
    if (!empty($senha)) {
        $sql = "UPDATE usuario
                SET senha = md5('$senha')
                WHERE id_usuario = $idUsuario";
        if (!mysqli_query($conn, $sql)) {
            die("Erro ao atualizar senha: " . mysqli_error($conn));
        }
    }

    mysqli_close($conn);
    header('location: ../perfil.php');
    exit;

    // Redireciona para a página anterior (última página acessada)
    //header('location: '.$_SERVER['HTTP_REFERER']);
?>