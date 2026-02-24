<?php

    // Inicia a sessão se ainda não estiver iniciada.
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    include('funcoes.php');
    // Inclui a conexão com o banco de dados ANTES de usar $conn.
    include("conexao.php"); 

    $descricao      = $_POST["nDescricao"];
    $situacao       = $_POST["nSituacao"];
    $idEmpresa      = $_POST["nEmpresa"];
    $funcao         = $_GET["funcao"];
    $idVaga         = $_GET["codigo"];

    // Determina o status 'ativo' com base no checkbox.
    $ativo = isset($_POST["nAtivo"]) ? "S" : "N"; // Sua linha corrigida

    //Validar se é Inclusão ou Alteração ou Deletar
    if($funcao == "I"){

        //Busca o próximo ID na tabela
        $idVaga = proxIdVaga();

        if ($_SESSION['idTipoUsuario'] == 3) {
            // INSERT usando Prepared Statements para segurança contra SQL Injection
            $sql = "INSERT INTO vaga (id_vaga, descricao, situacao, flg_ativo, fk_id_empresa) VALUES (?, ?, ?, ?, ?);";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "isssi", $idVaga, $descricao, $situacao, $ativo, $idEmpresa);
        } else if ($_SESSION['idTipoUsuario'] == 1) {
            // INSERT usando Prepared Statements para segurança contra SQL Injection
            $sql = "INSERT INTO vaga (id_vaga, descricao, situacao, flg_ativo, fk_id_empresa) VALUES (?, ?, ?, ?, ?);";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "isssi", $idVaga, $descricao, $situacao, $ativo, $_SESSION['idEmpresa']);
        }
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['msg'] = '<p class="text-success">Vaga cadastrada com sucesso!</p>';
        } else {
            $_SESSION['msg'] = '<p class="text-danger">Erro ao cadastrar vaga: ' . mysqli_error($conn) . '</p>';
        }
        mysqli_stmt_close($stmt);

    } elseif ($funcao == "A") {

        // NOVO: Verifica situação e status 'flg_ativo' atuais da vaga no banco de dados (USANDO PREPARED STATEMENT)
            $query_atual = "SELECT situacao, flg_ativo FROM vaga WHERE id_vaga = ?";
            $stmt_atual = mysqli_prepare($conn, $query_atual);
            mysqli_stmt_bind_param($stmt_atual, "i", $idVaga);
            mysqli_stmt_execute($stmt_atual);
            $resultado_atual = mysqli_stmt_get_result($stmt_atual);
            $dadosVagaAtual = mysqli_fetch_assoc($resultado_atual);
            mysqli_stmt_close($stmt_atual);

        $situacaoAtual = $dadosVagaAtual['situacao'] ?? null; // Pega a situação atual do banco
        $flgAtivoAtual = $dadosVagaAtual['flg_ativo'] ?? null; // Pega o flg_ativo atual do banco

        // NOVO: VALIDAÇÃO CRÍTICA: Impedir inativação de vaga ocupada
        // Se a vaga está atualmente 'O' (Ocupada) E o usuário está tentando mudá-la para 'N' (Inativa)
        if ($situacaoAtual == 'O' && $ativo == 'N') {
            $_SESSION['msg'] = '<p class="text-danger">Erro: Uma vaga ocupada não pode ser inativada.</p>';
            mysqli_close($conn); // Importante: fecha a conexão antes de redirecionar
            header("Location: ../vagas.php"); // Redireciona de volta para a página de vagas
            exit(); // Encerra o script para evitar que o UPDATE abaixo seja executado
        }
        // FIM DA VALIDAÇÃO

        // UPDATE usando Prepared Statements para segurança
        if ($_SESSION['idTipoUsuario'] == 3) {
            $sql = "UPDATE vaga SET descricao = ?, situacao = ?, flg_ativo = ?, fk_id_empresa = ? WHERE id_vaga = ?;";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssii", $descricao, $situacao, $ativo, $idEmpresa, $idVaga);
        } else if ($_SESSION['idTipoUsuario'] == 1) {
            $sql = "UPDATE vaga SET descricao = ?, situacao = ?, flg_ativo = ?, fk_id_empresa = ? WHERE id_vaga = ?;";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssii", $descricao, $situacao, $ativo, $_SESSION['idEmpresa'], $idVaga);
        }

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['msg'] = '<p class="text-success">Vaga alterada com sucesso!</p>';

            // Verifica se houve alteração na situação para registrar movimentação
            if ($situacaoAtual !== null && $situacaoAtual !== $situacao) {
                if ($situacao === 'O') {
                    $tipoMov = 'E'; // Entrada
                } elseif ($situacao === 'L') {
                    $tipoMov = 'S'; // Saída
                }
        
                if (isset($tipoMov)) {
                    // INSERT para movimentacao usando Prepared Statements
                    $sqlMov = "INSERT INTO movimentacao (fk_id_vaga, tipo, data) VALUES (?, ?, NOW());";
                    $stmtMov = mysqli_prepare($conn, $sqlMov);
                    mysqli_stmt_bind_param($stmtMov, "is", $idVaga, $tipoMov);
                    mysqli_stmt_execute($stmtMov);
                    mysqli_stmt_close($stmtMov);
                }
            }
        } else {
            $_SESSION['msg'] = '<p class="text-danger">Erro ao alterar vaga: ' . mysqli_error($conn) . '</p>';
        }
        mysqli_stmt_close($stmt);
    
    } elseif ($funcao == "D") {

        // Exclui primeiro da tabela movimentacao (USANDO PREPARED STATEMENT)
        $sql = "DELETE FROM movimentacao WHERE fk_id_vaga = ?;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idVaga);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        // Depois exclui da tabela vaga (USANDO PREPARED STATEMENT)
        $sql = "DELETE FROM vaga WHERE id_vaga = ?;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idVaga);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION['msg'] = '<p class="text-success">Vaga excluída com sucesso!</p>';
    }

    mysqli_close($conn); // Fecha a conexão no final do script
    header("location: ../vagas.php"); // Redireciona para a página de vagas
    exit(); // Garante que o script pare de executar após o redirecionamento

?>