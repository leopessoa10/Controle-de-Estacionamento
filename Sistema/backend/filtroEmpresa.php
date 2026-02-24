<?php
    session_start();
    header('Content-Type: application/json');

    include("conexao.php");

    if (!isset($_SESSION['idTipoUsuario']) || $_SESSION['idTipoUsuario'] != 3) {
        echo json_encode(["erro" => "Acesso não autorizado."]);
        exit;
    }

    if (!isset($_POST['idEmpresa']) || empty($_POST['idEmpresa'])) {
        echo json_encode(["erro" => "Empresa não informada."]);
        exit;
    }

    $idEmpresa = intval($_POST['idEmpresa']); // Sanitiza o valor

    // Define as queries
    $sqlVagasAtivas = "
        SELECT COUNT(*) AS vagas_ativas
        FROM vaga
        WHERE flg_ativo = 'S' AND fk_id_empresa = $idEmpresa;
    ";

    $sqlEntradas = "
        SELECT COUNT(*) AS Qtd
        FROM movimentacao AS mov
        INNER JOIN vaga AS vag ON mov.fk_id_vaga = vag.id_vaga
        WHERE tipo = 'E' AND vag.fk_id_empresa = $idEmpresa AND DATE(data) = CURDATE();
    ";

    $sqlSaidas = "
        SELECT COUNT(*) AS Qtd
        FROM movimentacao AS mov
        INNER JOIN vaga AS vag ON mov.fk_id_vaga = vag.id_vaga
        WHERE tipo = 'S' AND vag.fk_id_empresa = $idEmpresa AND DATE(data) = CURDATE();
    ";

    $sqlTempoMedio = "
        SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(saida.data, entrada.data)))) AS media_tempo
        FROM movimentacao entrada
        JOIN movimentacao saida ON saida.fk_id_vaga = entrada.fk_id_vaga
            AND saida.tipo = 'S'
            AND saida.data = (
                SELECT MIN(mv2.data)
                FROM movimentacao mv2
                WHERE mv2.fk_id_vaga = entrada.fk_id_vaga
                    AND mv2.tipo = 'S'
                    AND mv2.data > entrada.data
            )
        JOIN vaga v ON entrada.fk_id_vaga = v.id_vaga
        WHERE entrada.tipo = 'E'
        AND v.fk_id_empresa = $idEmpresa
        AND DATE(entrada.data) = CURDATE();
    ";

    $sqlAcima1h = "
        SELECT COUNT(*) AS acima_1h
        FROM (
            SELECT mv_e.data AS entrada,
                (
                    SELECT MIN(mv_s.data)
                    FROM movimentacao mv_s
                    WHERE mv_s.fk_id_vaga = mv_e.fk_id_vaga
                    AND mv_s.tipo = 'S'
                    AND mv_s.data > mv_e.data
                ) AS saida
            FROM movimentacao mv_e
            INNER JOIN vaga v ON mv_e.fk_id_vaga = v.id_vaga
            WHERE mv_e.tipo = 'E'
            AND v.fk_id_empresa = $idEmpresa
            AND DATE(mv_e.data) = CURDATE()
        ) AS sub
        WHERE saida IS NOT NULL
        AND TIMEDIFF(saida, entrada) > '01:00:00';
    ";

    $sqlAbaixo1h = "
        SELECT COUNT(*) AS abaixo_1h
        FROM (
            SELECT mv_e.data AS entrada,
                (
                    SELECT MIN(mv_s.data)
                    FROM movimentacao mv_s
                    WHERE mv_s.fk_id_vaga = mv_e.fk_id_vaga
                    AND mv_s.tipo = 'S'
                    AND mv_s.data > mv_e.data
                ) AS saida
            FROM movimentacao mv_e
            INNER JOIN vaga v ON mv_e.fk_id_vaga = v.id_vaga
            WHERE mv_e.tipo = 'E'
            AND v.fk_id_empresa = $idEmpresa
            AND DATE(mv_e.data) = CURDATE()
        ) AS sub
        WHERE saida IS NOT NULL
        AND TIMEDIFF(saida, entrada) <= '01:00:00';
    ";

    // Função para execução simples
    function getValor($conn, $sql, $coluna) {
        $res = mysqli_query($conn, $sql);
        if ($res && $row = mysqli_fetch_assoc($res)) {
            return $row[$coluna] ?? 0;
        }
        return 0;
    }

    $retorno = [
        "vagasAtivas"   => getValor($conn, $sqlVagasAtivas, "vagas_ativas"),
        "qtdEntradas"   => getValor($conn, $sqlEntradas, "Qtd"),
        "qtdSaidas"     => getValor($conn, $sqlSaidas, "Qtd"),
        "tempoMedio"    => getValor($conn, $sqlTempoMedio, "media_tempo") ?: "00:00",
        "acima1h"       => getValor($conn, $sqlAcima1h, "acima_1h"),
        "abaixo1h"      => getValor($conn, $sqlAbaixo1h, "abaixo_1h"),
    ];

    mysqli_close($conn);
    echo json_encode($retorno);

?>