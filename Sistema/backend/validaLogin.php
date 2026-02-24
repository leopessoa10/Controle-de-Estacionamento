<?php
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }

    include("funcoes.php");
    include("conexao.php");

    $_SESSION['logado'] = 0; // Por padrão, o usuário não está logado

    $email = stripslashes($_POST["nEmail"]);
    $senha = stripslashes($_POST["nSenha"]);

    //$_POST - Valor enviado pelo FORM através da propriedade NAME do elemento HTML 
    //$_GET - Valor enviado pelo FORM através da URL
    //$_SESSION - Variável criada pelo usuário no PHP

    $sql = "SELECT usu.*,
                   emp.nome as nome_empresa,
                   emp.foto as foto_empresa,
                   tip.descricao as descricao_tipo_usuario
            FROM usuario AS usu
            INNER JOIN empresa AS emp ON usu.fk_id_empresa = emp.id_empresa
            INNER JOIN tipo_usuario AS tip ON usu.fk_id_tipo_usuario = tip.id_tipo_usuario
            WHERE usu.email = ? AND usu.senha = MD5(?);"; // Usando placeholders

    $stmt = mysqli_prepare($conn, $sql); // Prepara a query
    mysqli_stmt_bind_param($stmt, "ss", $email, $senha); // Vincula os parâmetros como strings
    mysqli_stmt_execute($stmt); // Executa a query
    $resultLogin = mysqli_stmt_get_result($stmt); // Pega o resultado

    mysqli_close($conn); // Fecha a conexão após obter os resultados

    //Validar se tem retorno do BD
    if (mysqli_num_rows($resultLogin) > 0) {  

        foreach ($resultLogin as $coluna) {
            // Login bem-sucedido
            //***Verificar os dados da consulta SQL
            $_SESSION['idTipoUsuario']  = $coluna['fk_id_tipo_usuario'];
            $_SESSION['DescricaoTipoUsuario']  = $coluna['descricao_tipo_usuario'];
            $_SESSION['logado']         = 1;
            $_SESSION['idLogin']        = $coluna['id_usuario'];
            $_SESSION['NomeLogin']      = $coluna['nome'];
            $_SESSION['EmailLogin']     = $coluna['email'];
            $_SESSION['FotoLogin']      = $coluna['foto'];
            $_SESSION['AtivoLogin']     = $coluna['flg_ativo'];
            $_SESSION['idEmpresa']      = $coluna['fk_id_empresa'];
            $_SESSION['NomeEmpresa']      = $coluna['nome_empresa'];
            $_SESSION['FotoEmpresa']      = $coluna['foto_empresa'];

            // Redireciona para a tela inicial
            header('location: ../painel.php');
            exit(); // É crucial usar exit() após header()
        }        
    }else{
        // Login falhou
        $_SESSION['msg_login'] = "Login ou Senha incorretos"; // Define a mensagem de erro na sessão
        // Redireciona de volta para a página de login
        header('location: ../../'); // Redireciona para o index.php
        exit(); // É crucial usar exit() após header()
    } 

    

?>