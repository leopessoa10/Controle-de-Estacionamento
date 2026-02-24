<?php
//Função para listar todas as empresas
function listaEmpresa(){

    include("conexao.php");
    $sql = "SELECT * FROM empresa ORDER BY id_empresa;";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    $lista = '';
    $ativo = '';
    $icone = '';

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        
        foreach ($result as $coluna) {

            //Ativo: S ou N
            //if($coluna["flg_ativo"] == 'S')  $ativo = 'checked'; else $ativo = '';
            if($coluna["flg_ativo"] == 'S'){  
                $ativo = 'checked';
                $icone = '<h6><i class="fas fa-check-circle text-success"></i></h6>'; 
            }else{
                $ativo = '';
                $icone = '<h6><i class="fas fa-times-circle text-danger"></i></h6>';
            } 
            
            
            //***Verificar os dados da consulta SQL
            $lista .= 
            '<tr>'
                .'<td align="center">'.$coluna["id_empresa"].'</td>'
                .'<td>'.$coluna["nome"].'</td>'
                .'<td>'.$coluna["cnpj"].'</td>'
                .'<td>'.$coluna["telefone"].'</td>'
                .'<td>'.$coluna["cep"].'</td>'
                .'<td>'.$coluna["cidade"].'</td>'
                .'<td>'.$coluna["uf"].'</td>'
                .'<td align="center">'.$icone.'</td>'
                .'<td>'
                    .'<div class="row" align="center">'
                        .'<div class="col-6">'
                            .'<a href="#modalEditEmpresa'.$coluna["id_empresa"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar usuário"></i></h6>'
                            .'</a>'
                        .'</div>'
                        
                        .'<div class="col-6">'
                            .'<a href="#modalDeleteEmpresa'.$coluna["id_empresa"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Excluir usuário"></i></h6>'
                            .'</a>'
                        .'</div>'
                    .'</div>'
                .'</td>'
            .'</tr>'
            
            .'<div class="modal fade" id="modalEditEmpresa'.$coluna["id_empresa"].'">'
                .'<div class="modal-dialog modal-lg">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-info">'
                            .'<h4 class="modal-title">Alterar Empresa</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="backend/salvarEmpresa.php?funcao=A&codigo='.$coluna["id_empresa"].'" enctype="multipart/form-data">'              
                
                                .'<div class="row">'
                                    .'<div class="col-8">'
                                        .'<div class="form-group">'
                                            .'<label for="iNome">Nome</label>'
                                            .'<input required type="text" value="'.$coluna["nome"].'" class="form-control" id="iNome" name="nNome" maxlength="30" placeholder="Nome da Empresa">'
                                        .'</div>'
                                    .'</div>'
                    
                                    .'<div class="col-8">'
                                        .'<div class="form-group">'
                                            .'<label for="iCNPJ">CNPJ</label>'
                                            .'<input required type="text" value="'.$coluna["cnpj"].'" class="form-control" id="iCNPJ" name="nCNPJ" maxlength="14" placeholder="CNPJ da Empresa">'
                                        .'</div>'
                                    .'</div>'
                    
                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iTelefone">Telefone</label>'
                                            .'<input type="number" value="'.$coluna["telefone"].'" class="form-control" id="iTelefone" name="nTelefone" maxlength="13" placeholder="Telefone da Empresa" required>'
                                        .'</div>'
                                    .'</div>'
                                    
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for="iFoto">Foto</label>'
                                            .'<input type="file" class="form-control" id="iFoto" name="nFoto" accept="image/*">'
                                        .'</div>'
                                    .'</div>'
                                    
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<input type="checkbox" id="iAtivo" name="nAtivo" '.$ativo.'>'
                                            .'<label for="iAtivo">Empresa Ativa</label>'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iCEP">CEP</label>'
                                            .'<input type="text" value="'.$coluna["cep"].'" class="form-control" id="iCEP" name="nCEP" maxlength="9" placeholder="Digite o CEP sem hífen">'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iEndereco">Endereço</label>'
                                            .'<input type="text" value="'.$coluna["endereco"].'" class="form-control" id="iEndereco" name="nEndereco" maxlength="30" placeholder="Rua, Avenida, etc.">'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iNumero">Número</label>'
                                            .'<input type="number" value="'.$coluna["numero"].'" class="form-control" id="iNumero" name="nNumero" maxlength="5" placeholder="Número">'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iComplemento">Complemento (opcional)</label>'
                                            .'<input type="text" value="'.$coluna["complemento"].'" class="form-control" id="iComplemento" name="nComplemento" maxlength="60" placeholder="Complemento">'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iBairro">Bairro</label>'
                                            .'<input type="text" value="'.$coluna["bairro"].'" class="form-control" id="iBairro" name="nBairro" maxlength="30" placeholder="Bairro">'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iCidade">Cidade</label>'
                                            .'<input type="text" value="'.$coluna["cidade"].'" class="form-control" id="iCidade" name="nCidade" maxlength="30" placeholder="Cidade">'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iUF">UF</label>'
                                            .'<input type="text" value="'.$coluna["uf"].'" class="form-control" id="iUF" name="nUF" maxlength="2" placeholder="UF">'
                                        .'</div>'
                                    .'</div>'
                
                                .'</div>'
                
                                .'<div class="modal-footer">'
                                    .'<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>'
                                    .'<button type="submit" class="btn btn-success">Salvar</button>'
                                .'</div>'
                                
                            .'</form>'
                            
                        .'</div>'
                    .'</div>'
                .'</div>'
            .'</div>'
            
            .'<div class="modal fade" id="modalDeleteEmpresa'.$coluna["id_empresa"].'">'
                .'<div class="modal-dialog">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-danger">'
                            .'<h4 class="modal-title">Excluir Empresa: '.$coluna["id_empresa"].'</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="backend/salvarEmpresa.php?funcao=D&codigo='.$coluna["id_empresa"].'" enctype="multipart/form-data">'              

                                .'<div class="row">'
                                    .'<div class="col-12">'
                                        .'<h5>Deseja EXCLUIR a empresa '.$coluna["nome"].'?</h5>'
                                    .'</div>'
                                .'</div>'
                                
                                .'<div class="modal-footer">'
                                    .'<button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>'
                                    .'<button type="submit" class="btn btn-success">Sim</button>'
                                .'</div>'
                                
                            .'</form>'
                            
                        .'</div>'
                    .'</div>'
                .'</div>'
            .'</div>';            
        }    
    }
    
    return $lista;
}

//Próximo ID da empresa
function proxIdEmpresa(){

    $id = "";

    include("conexao.php");
    $sql = "SELECT MAX(id_empresa) AS Maior FROM empresa;";        
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
            $id = $coluna["Maior"] + 1;
        }        
    } 

    return $id;
}

//Função para buscar a foto da empresa
function fotoEmpresa($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT foto FROM empresa WHERE id_empresa = $id;";        
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
            $resp = $coluna["foto"];
        }        
    } 

    return $resp;
}

//Função para buscar o nome da empresa
function nomeEmpresa($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT nome FROM empresa WHERE id_empresa = $id;";        
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
            $resp = $coluna["nome"];
        }        
    } 

    return $resp;
}

//Função para buscar a flag flg_ativo da empresa
function ativoEmpresa($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT flg_ativo FROM empresa WHERE id_empresa = $id;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        foreach ($result as $coluna) {            
            //***Verificar os dados da consulta SQL
            if($coluna["flg_ativo"] == 'S') $resp = 'checked'; else $resp = '';
        }        
    } 

    return $resp;
}

//Função para retornar a qtd de empresas ativas
function qtdEmpresasAtivas(){
    $qtd = 0;

    include("conexao.php");

    $sql = "SELECT COUNT(*) AS Qtd FROM empresa WHERE flg_ativo = 'S';";

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        foreach ($result as $coluna) {            
            //***Verificar os dados da consulta SQL
            $qtd = $coluna['Qtd'];
        }        
    }
    
    return $qtd;
}

/*
// Função para retornar a quantidade de usuários ativos por tipo
function qtdUsuariosAtivos($tipoUsuario = null) {
// <?php $qtdAdmins = qtdUsuariosAtivos('admin');
// <?php $qtdTodos = qtdUsuariosAtivos();
    $qtd = 0;

    include("conexao.php");

    // Verifica se foi passado um tipo de usuário
    if ($tipoUsuario !== null) {
        $sql = "SELECT COUNT(*) AS Qtd FROM usuarios WHERE flg_ativo = 'S' AND TipoUsuario = ?;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $tipoUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } else {
        $sql = "SELECT COUNT(*) AS Qtd FROM usuarios WHERE flg_ativo = 'S';";
        $result = mysqli_query($conn, $sql);
    }

    mysqli_close($conn);

    // Validar se tem retorno do BD
    if ($result && mysqli_num_rows($result) > 0) {
        $coluna = mysqli_fetch_assoc($result);
        $qtd = $coluna['Qtd'];
    }

    return $qtd;
}*/

//Função para retornar a qtd de empresas registradas / cadastradas
function qtdEmpresasRegistradas(){
    $qtd = 0;

    include("conexao.php");
    $sql = "SELECT COUNT(*) AS Qtd FROM empresa;";

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        foreach ($result as $coluna) {            
            //***Verificar os dados da consulta SQL
            $qtd = $coluna['Qtd'];
        }        
    }
    
    return $qtd;
}
function descrEmpresa($id){

    $descricao = "";

    include("conexao.php");
    $sql = "SELECT nome FROM empresa WHERE id_empresa = $id;";        
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
            $nome = $coluna["nome"];
        }        
    } 

    return $nome;
}
?>