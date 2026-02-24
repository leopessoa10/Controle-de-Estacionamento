<?php
//Função para listar todos os usuários
function listaUsuario(){

    include("conexao.php");
    if (isset($_SESSION['idTipoUsuario']) && isset($_SESSION['idEmpresa'])) {
        $idTipoUsuario = $_SESSION['idTipoUsuario'];
        $idEmpresaUsuario = $_SESSION['idEmpresa'];

        if ($idTipoUsuario == 3) {
            // Dono vê todos usuários e suas empresas
            $sql = "
                SELECT u.*, e.nome AS nome_empresa 
                FROM usuario u
                LEFT JOIN empresa e ON u.fk_id_empresa = e.id_empresa
                ORDER BY u.id_usuario;
            ";
        } elseif ($idTipoUsuario == 2 || $idTipoUsuario == 1) {
            // Outros veem só usuários da própria empresa
            $sql = "SELECT * FROM usuario WHERE fk_id_empresa = $idEmpresaUsuario ORDER BY id_usuario;";
        } else {
            return "Tipo de usuário inválido.";
        }
    } else {
        return "Sessão não iniciada ou dados do usuário não definidos.";
    }
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    $lista = '';
    $ativo = '';
    $icone = '';

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        
        foreach ($result as $coluna) {
            // Ignorar um tipo de usuário específico (exemplo: tipo 3)
            if ($coluna["fk_id_tipo_usuario"] == 3) {
                continue; // Pula para o próximo registro
            }

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
                .'<td align="center">'.$coluna["id_usuario"].'</td>'
                .'<td align="center">'.descrTipoUsuario($coluna["fk_id_tipo_usuario"]).'</td>'
                .'<td>'.$coluna["nome"].'</td>'
                .'<td>'.$coluna["email"].'</td>';
                if ($_SESSION['idTipoUsuario'] == 3) {
                    $lista .= '<td>'.descrEmpresa($coluna["fk_id_empresa"]).'</td>';
                }
            $lista .= 
                '<td align="center">'.$icone.'</td>'
                .'<td>'
                    .'<div class="row" align="center">'
                        .'<div class="col-6">'
                            .'<a href="#modalEditUsuario'.$coluna["id_usuario"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar usuário"></i></h6>'
                            .'</a>'
                        .'</div>'
                        
                        .'<div class="col-6">'
                            .'<a href="#modalDeleteUsuario'.$coluna["id_usuario"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Excluir usuário"></i></h6>'
                            .'</a>'
                        .'</div>'
                    .'</div>'
                .'</td>'
            .'</tr>'
            
            .'<div class="modal fade" id="modalEditUsuario'.$coluna["id_usuario"].'">'
                .'<div class="modal-dialog modal-lg">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-info">'
                            .'<h4 class="modal-title">Alterar Usuário</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="backend/salvarUsuario.php?funcao=A&codigo='.$coluna["id_usuario"].'" enctype="multipart/form-data">'              
                
                                .'<div class="row">'
                                    .'<div class="col-8">'
                                        .'<div class="form-group">'
                                            .'<label for="iNome">Nome:</label>'
                                            .'<input type="text" value="'.$coluna["nome"].'" class="form-control" id="iNome" name="nNome" maxlength="30">'
                                        .'</div>'
                                    .'</div>'
                    
                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iTipoUsuario">Tipo de Usuário:</label>'
                                            .'<select id="iTipoUsuario" name="nTipoUsuario" class="form-control" required>'
                                                .'<option value="'.$coluna["fk_id_tipo_usuario"].'">'.descrTipoUsuario($coluna["fk_id_tipo_usuario"]).'</option>'
                                                .optionTipoUsuario()
                                            .'</select>'
                                        .'</div>'
                                    .'</div>'
                    
                                    .'<div class="col-8">'
                                        .'<div class="form-group">'
                                            .'<label for="iEmail">Email:</label>'
                                            .'<input type="email" value="'.$coluna["email"].'" class="form-control" id="iEmail" name="nEmail" maxlength="30">'
                                        .'</div>'
                                    .'</div>'
                    
                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iSenha">Senha:</label>'
                                            .'<input type="text" value="" class="form-control" id="iSenha" name="nSenha" maxlength="32">'
                                        .'</div>'
                                    .'</div>'
                                    
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for="iFoto">Foto:</label>'
                                            .'<input type="file" class="form-control" id="iFoto" name="nFoto" accept="image/*">'
                                        .'</div>'
                                    .'</div>'
                                    
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<input type="checkbox" id="iAtivo" name="nAtivo" '.$ativo.'>'
                                            .'<label for="iAtivo">Usuário Ativo</label>'
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
            
            .'<div class="modal fade" id="modalDeleteUsuario'.$coluna["id_usuario"].'">'
                .'<div class="modal-dialog">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-danger">'
                            .'<h4 class="modal-title">Excluir Usuário: '.$coluna["id_usuario"].'</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="backend/salvarUsuario.php?funcao=D&codigo='.$coluna["id_usuario"].'" enctype="multipart/form-data">'              

                                .'<div class="row">'
                                    .'<div class="col-12">'
                                        .'<h5>Deseja EXCLUIR o usuário '.$coluna["nome"].'?</h5>'
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

//Próximo ID do usuário
function proxIdUsuario(){

    $id = "";

    include("conexao.php");
    $sql = "SELECT MAX(id_usuario) AS Maior FROM usuario;";        
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

//Função para buscar o tipo de acesso do usuário
function tipoAcessoUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT fk_id_tipo_usuario FROM usuario WHERE id_usuario = $id;";        
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
            if($coluna["fk_id_tipo_usuario"] == 1){
                //Admin
                $resp = '<option value="1">Admin</option>'
                        .'<option value="2">Funcionário</option>';
            }else{
                //Funcionário
                $resp = '<option value="2">Funcionário</option>'
                        .'<option value="1">Admin</option>';
            }
        }        
    } 

    return $resp;
}

//Função para buscar a foto do usuário
function fotoUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT foto FROM usuario WHERE id_usuario = $id;";        
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

//Função para buscar o nome do usuário
function nomeUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT nome FROM usuario WHERE id_usuario = $id;";        
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

//Função para buscar o login do usuário
function loginUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT email FROM usuario WHERE id_usuario = $id;";        
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
            $resp = $coluna["email"];
        }        
    } 

    return $resp;
}

//Função para buscar a flag flg_ativo do usuário
function ativoUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT flg_ativo FROM usuario WHERE id_usuario = $id;";        
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

//Função para retornar a qtd de usuários ativos
function qtdUsuariosAtivos(){
    $qtd = 0;

    include("conexao.php");

    $sql = "SELECT COUNT(*) AS Qtd FROM usuario WHERE flg_ativo = 'S';";

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

//Função para retornar a qtd de usuários registrados / cadastrados
function qtdUsuariosRegistrados(){
    $qtd = 0;

    include("conexao.php");
    $sql = "SELECT COUNT(*) AS Qtd FROM usuario;";

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

?>