<?php

    include('conexao.php');
    include('funcoes.php');

    /* Anti SQL Injection
    $stmt = $conn->prepare("INSERT INTO empresa (nome, cnpj) VALUES (?, ?)");
    $stmt->bind_param("ss", $nome, $cnpj);
    $stmt->execute();

    Cada "?" representa um parâmetro a ser passado
    Cada "s", "i", "d" representa o tipo do parâmetro

    "s" = string
    "i" = integer (inteiro)
    "d" = double (decimal)
    "b" = blob (binário)


    Exemplo usando função reutilizável:

    function executaQuery($conn, $sql, $tipos, ...$params) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($tipos, ...$params);
        $stmt->execute();
        return $stmt;
    }

    $sql = "INSERT INTO empresa (nome, cnpj) VALUES (?, ?)";
    executaQuery($conn, $sql, "ss", $nome, $cnpj);
    */

    $nome           = mysqli_real_escape_string($conn, $_POST["nNome"]);
    $cnpj           = mysqli_real_escape_string($conn, $_POST["nCNPJ"]);
    $telefone       = mysqli_real_escape_string($conn, $_POST["nTelefone"]);
    $cep            = isset($_POST["nCEP"]) ? mysqli_real_escape_string($conn, $_POST['nCEP']) : '';
    $endereco       = isset($_POST["nEndereco"]) ? mysqli_real_escape_string($conn, $_POST['nEndereco']) : '';
    $numero         = isset($_POST["nNumero"]) ? mysqli_real_escape_string($conn, $_POST['nNumero']) : '';
    $complemento    = isset($_POST["nComplemento"]) ? mysqli_real_escape_string($conn, $_POST['nComplemento']) : '';
    $bairro         = isset($_POST["nBairro"]) ? mysqli_real_escape_string($conn, $_POST['nBairro']) : '';
    $cidade         = isset($_POST["nCidade"]) ? mysqli_real_escape_string($conn, $_POST['nCidade']) : '';
    $uf             = isset($_POST["nUF"]) ? mysqli_real_escape_string($conn, $_POST['nUF']) : '';

    $funcao         = $_GET["funcao"];
    $idEmpresa      = isset($_GET["codigo"]) ? $_GET["codigo"] : null;

    if($_POST["nAtivo"] == "on") $ativo = "S"; else $ativo = "N";


    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //Busca o próximo ID na tabela
        $idEmpresa = proxIdEmpresa();

        // Armazenar a foto do Usuário
        $diretorioImg = '';
        
        if (!empty($_FILES['nFoto']['tmp_name'])) {

            //Pega extensão e monta o novo nome do arquivo
            $ext = pathinfo($_FILES['nFoto']['name'], PATHINFO_EXTENSION);
            $novo_nome = "foto-" . $idEmpresa . '.' . $ext;

            //Verifica se existe o diretório (ou cria)
            $diretorio = '../dist/img/empresas/';
            if (!is_dir($diretorio)) {
                mkdir($diretorio, 0755, true);
            }

            //Grava o arquivo no diretório
            $caminho_completo = $diretorio . $novo_nome;
            if (move_uploaded_file($_FILES['nFoto']['tmp_name'], $caminho_completo)) {
                //Salva o diretório para colocar na tabela do BD
                $diretorioImg = 'dist/img/empresas/' . $novo_nome;
                
            }
        }
        // /.foto

        // Armazena o caminho da foto
        $foto = $diretorioImg;

        //INSERT
        $sql = "INSERT INTO empresa (id_empresa,nome,cnpj,telefone,foto,cep,endereco,numero,complemento,bairro,cidade,uf,flg_ativo) 
                VALUES ($idEmpresa,'$nome','$cnpj','$telefone','$foto','$cep','$endereco',
                        '$numero','$complemento','$bairro','$cidade','$uf','$ativo');";

    }elseif($funcao == "A"){
        //UPDATE
        $sql = "UPDATE empresa 
                SET nome        = '$nome', 
                    cnpj        = '$cnpj', 
                    telefone    = '$telefone', 
                    cep         = '$cep', 
                    endereco    = '$endereco', 
                    numero      = '$numero', 
                    complemento = '$complemento', 
                    bairro      = '$bairro', 
                    cidade      = '$cidade', 
                    uf          = '$uf', 
                    flg_ativo = '$ativo' 
                    WHERE id_empresa = $idEmpresa;";

 // Debugging line to check the SQL query

        //Foto do perfil
        $diretorioImg = '';
        
        if (!empty($_FILES['nFoto']['tmp_name'])) {

            //Pega extensão e monta o novo nome do arquivo
            $ext = pathinfo($_FILES['nFoto']['name'], PATHINFO_EXTENSION);
            $novo_nome = "foto-" . $idEmpresa . '.' . $ext;

            //Verifica se existe o diretório (ou cria)
            $diretorio = '../dist/img/empresas/';
            if (!is_dir($diretorio)) {
                mkdir($diretorio, 0755, true);
            }

            //Grava o arquivo no diretório
            $caminho_completo = $diretorio . $novo_nome;
            if (move_uploaded_file($_FILES['nFoto']['tmp_name'], $caminho_completo)) {
                //Salva o diretório para colocar na tabela do BD
                $diretorioImg = 'dist/img/empresas/' . $novo_nome;

                //Gravação no BD
                $sql = "UPDATE empresa
                        SET foto = '$diretorioImg'
                        WHERE id_empresa = $idEmpresa";
                if (!mysqli_query($conn, $sql)) {
                    die("Erro ao atualizar foto: " . mysqli_error($conn));
                }
                
                // Atualiza a sessão com o novo caminho da foto
                $_SESSION['FotoEmpresa'] = $diretorioImg;
            }
        }
        // /.foto

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM empresa 
                WHERE id_empresa = $idEmpresa;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../empresas.php");

?>