<?php
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }

    include('funcoes.php');

    //Filtros de tela
    $descricao   = $_POST["nDescricao"];
    $idEmpresa = $_POST["nEmpresa"];
    $situacao = $_POST["nSituacao"];

    //Campos para WHERE
    $whereDescricao   = '';
    $whereIdEmpresa = '';
    
    //Sessões para retorno
    $_SESSION['relatVagas']      = '';
    $_SESSION['relatVagasDescr'] = '';
    $_SESSION['relatVagasIdEmpr'] = '';
   
    //Validar filtros
    if($descricao != '') {
        $whereDescricao = " AND vg.descricao LIKE '%".$descricao."%' ";
    }

    if($idEmpresa != '0') {
        $whereIdEmpresa = " AND vg.fk_id_empresa = ".$idEmpresa;
    }
    
    include("conexao.php");

    $sql = "SELECT vg.id_vaga, "
            ." vg.descricao AS Descrição, "
            ." em.nome AS Nome, "
            ." em.id_empresa AS IdEmpresa, "
            ." vg.situacao AS situacao, "
            ." vg.fk_id_empresa "
        ." FROM vaga vg "
        ." INNER JOIN empresa em "
        ." ON em.id_empresa = vg.fk_id_empresa " 
        ." WHERE 1 = 1 "
        .$whereDescricao
        .$whereIdEmpresa
        .";";
            
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
                .'<td>'.$coluna["Descrição"].'</td>'
                .'<td>'.$coluna["Nome"].'</td>'
                .'<td>'.$coluna["situacao"].'</td>'
            .'</tr>';                       
        }    
    }
    
    $_SESSION['relatVagas']      = $lista;
    $_SESSION['relatVagasDescr'] = $descricao;
    $_SESSION['relatVagasIdEmpr'] = $idEmpresa;

    header("location: ../relatorio-vagas.php"); 
?>