<?php
    session_start(); // <-- Adicione esta linha no início do arquivo

    include('conexao.php');
    include('funcoes.php');

    if (isset($_GET['id'])) {
        $idVaga = intval($_GET['id']);

        // Consulta situação atual
        $query = "SELECT situacao FROM vaga WHERE id_vaga = $idVaga";
        $res = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($res);

        if ($row) {
            $situacaoAtual = $row['situacao'];
            $novaSituacao = ($situacaoAtual === 'L') ? 'O' : 'L';
            $tipoMov = ($novaSituacao === 'O') ? 'E' : 'S';

            // Atualiza situação
            $sqlUpdate = "UPDATE vaga SET situacao = '$novaSituacao' WHERE id_vaga = $idVaga";
            mysqli_query($conn, $sqlUpdate);

            // Registra movimentação
            $sqlMov = "INSERT INTO movimentacao (fk_id_vaga, tipo, data)
                    VALUES ($idVaga, '$tipoMov', NOW())";
            mysqli_query($conn, $sqlMov);
        }
    }

    mysqli_close($conn);
    header("Location: ../vagas.php");
    exit;
?>