<?php

//Função para buscar a descrição do tipo de usuário
function descrTipoUsuario($id){

    $descricao = "";

    include("conexao.php");
    $sql = "SELECT descricao FROM tipo_usuario WHERE id_tipo_usuario = $id;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $descricao = $coluna["descricao"];
        }        
    } 

    return $descricao;
}

//Função para montar o select/option
function optionTipoUsuario(){

    $option = "";

    include("conexao.php");
    $sql = "SELECT id_tipo_usuario, descricao FROM tipo_usuario ORDER BY descricao;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {
            // Ignorar um tipo de usuário específico (exemplo: id_tipo_usuario = 3)
            if ($coluna['id_tipo_usuario'] == 3) {
                continue; // Pula para o próximo registro
            }           
            //***Verificar os dados da consulta SQL            
            $option .= '<option value="'.$coluna['id_tipo_usuario'].'">'.$coluna['descricao'].'</option>';
        }        
    } 

    return $option;
}

// Descrição para gráfico de barras
function descrTipoUsuarioBarras(){

    $descricao = "";

    include("conexao.php");
    $sql = "SELECT descricao FROM tipo_usuario;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        $i = 1;
        foreach ($result as $coluna) {            
            //***Verificar os dados da consulta SQL
            if ($i < 3){
                $descricao .= "'".$coluna["descricao"]."',";
            }else{
                $descricao .= "'".$coluna["descricao"]."'";
            }

            $i++;
        }        
    } 

    return json_encode($descricao); // Retorna um array JSON válido
}

// Função para trazer a quantidade de usuários ativos por tipo de usuário
function qtdTipoUsuarioAtivo($tipoUsuario){

    include("conexao.php");

    $qtdTipoUsuarioAtivo = '0';

    // Monta a consulta SQL com base no tipo de usuário
    $sql = "SELECT COUNT(*) AS Qtd FROM usuario WHERE flg_ativo = 'S'";
    if ($tipoUsuario == '1' || $tipoUsuario == '2') {
        $sql .= " AND fk_id_tipo_usuario = '$tipoUsuario'";
    }

    // Executa a consulta
    $result = mysqli_query($conn, $sql);
    // Fecha a conexão
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL            
            $qtdTipoUsuarioAtivo = $coluna['Qtd']; 
        }        
    }  

    return $qtdTipoUsuarioAtivo;
}

function qtdTipoUsuarioInativo($tipoUsuario){

    include("conexao.php");

    $qtdTipoUsuarioInativo = '0';

    // Monta a consulta SQL com base no tipo de usuário
    $sql = "SELECT COUNT(*) AS Qtd FROM usuario WHERE flg_ativo = 'N'";
    if ($tipoUsuario == '1' || $tipoUsuario == '2') {
        $sql .= " AND fk_id_tipo_usuario = '$tipoUsuario'";
    }

    // Executa a consulta
    $result = mysqli_query($conn, $sql);
    // Fecha a conexão
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL            
            $qtdTipoUsuarioInativo = $coluna['Qtd'];
        }        
    }  

    return $qtdTipoUsuarioInativo;
}

function idTipoUsuario(){

    include("conexao.php");

    // Monta a consulta SQL com base no tipo de usuário
    $sql = "SELECT * FROM usuario WHERE fk_id_tipo_usuario = 1";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $tipo = $coluna["fk_id_tipo_usuario"];
        }        
    } 

    return $tipo;
}
?>