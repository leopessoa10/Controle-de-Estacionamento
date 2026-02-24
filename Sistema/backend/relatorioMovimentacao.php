<?php
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }

    include('funcoes.php');

    //Filtros de tela
    $movimentacao   = $_POST["nMovimentacao"];
    $maxima = $_POST["hMax"];
    $minima = $_POST["hMin"];

    // Inicializar variáveis de WHERE
    //Campos para WHERE
    $whereMovimentacao = '';
    $where = '';
    $whereDescricao   = '';
    $whereMaxima = '';
    $whereMinima = '';
    
    //Sessões para retorno
    $_SESSION['relatMovi']      = '';
    $_SESSION['relatVagasDescr'] = '';
    $_SESSION['relatVagasIdEmpr'] = '';
   
    //Validar filtros
    if($movimentacao != '') {
        $whereMovimentacao = " AND mv.tipo LIKE '%".$movimentacao."%' ";
    }

    if($movimentacao == 'T') {
        $whereMovimentacao = " AND mv.tipo LIKE '%' ";
    }

    if ($minima != '') {
        $where .= " AND mv.data >= '" . $minima . "'";
    }
    
    if ($maxima != '') {
        $where .= " AND mv.data <= '" . $maxima . "'";
    }
     
    include("conexao.php");

    if($_SESSION['idTipoUsuario'] == 3){
        $sql = "SELECT  vg.id_vaga, 
                        vg.descricao AS descricao,
                        mv.tipo AS tipo,
                        mv.data AS data,
                        vg.id_vaga
                FROM movimentacao AS mv
                INNER JOIN vaga AS vg
                ON vg.id_vaga = mv.fk_id_vaga
                WHERE 1 = 1 
            $whereMovimentacao
            $where
            ;";
    }else{
        $idEmpresa = (int)$_SESSION['idEmpresa'];

        $sql = "SELECT  vg.id_vaga, 
                        vg.descricao AS descricao,
                        mv.tipo AS tipo,
                        mv.data AS data,
                        vg.id_vaga
                FROM movimentacao AS mv
                INNER JOIN vaga vg
                ON vg.id_vaga = mv.fk_id_vaga
                INNER JOIN empresa AS em 
                ON em.id_empresa = vg.fk_id_empresa 
                WHERE 1 = 1 
                AND em.id_empresa = $idEmpresa 

            $whereMovimentacao
            $where
            ;";
    }        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    $lista = '';

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {        
        
        foreach ($result as $coluna) {

            //***Verificar os dados da consulta SQL
            $lista .= 
            '<tr>'
                .'<td>'.$coluna["id_vaga"].'</td>'
                .'<td>'.$coluna["descricao"].'</td>'
                .'<td>'.(isset($coluna["tipo"]) ? $coluna["tipo"] : '').'</td>'
                .'<td>'.$coluna["data"].'</td>'
            .'</tr>';                       
        }    
    }
    
    $_SESSION['relatMovi']      = $lista;

    header("location: ../relatorio-movimentacao.php"); 
?>