<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // Inclui funcoes.php para ter acesso a descrEmpresa(), reduzTamanhoVagaFuncionario(),
    // mostraIdVaga(), mostraVagaActions(), etc.
    include('funcoes.php');
    require_once('conexaoPDO.php'); // Ou seu arquivo de conexão mysqli, se estiver usando mysqli na funcoes.php

    // Pega o id enviado por GET na URL
    $opcaoFiltro = isset($_GET['opcaoFiltro']) ? $_GET['opcaoFiltro'] : '';

    // Valida o tipo de usuário e a empresa para aplicar o filtro de permissão
    $idTipoUsuario = isset($_SESSION['idTipoUsuario']) ? $_SESSION['idTipoUsuario'] : null;
    $idEmpresaUsuario = isset($_SESSION['idEmpresa']) ? $_SESSION['idEmpresa'] : null;

    // Se o filtro estiver vazio ou não houver dados de sessão, vamos carregar todas as vagas (respeitando a empresa do usuário)
    // Caso contrário, aplicamos o filtro normalmente.
    if ($idTipoUsuario !== null && $idEmpresaUsuario !== null) {
        echo getVagasPorSituacao($opcaoFiltro, $idTipoUsuario, $idEmpresaUsuario);
    } else {
        echo '<div class="col-12"><p class="text-center">Sessão não iniciada ou dados do usuário não definidos.</p></div>';
    }

    // Função para montar a lista filtrada
    function getVagasPorSituacao($situacaoFiltro, $idTipoUsuario, $idEmpresaUsuario){
        include("conexao.php"); // Certifique-se que conexao.php está configurado para mysqli

        $lista = "";
        $whereConditions = []; // Array para armazenar as condições da cláusula WHERE

        // Adiciona a condição de filtro de situação, se houver uma selecionada
        if (!empty($situacaoFiltro)) {
            if ($situacaoFiltro == 'L') { // Vagas Livres (situação='L' e flg_ativo='S')
                $whereConditions[] = "situacao = 'L' AND flg_ativo = 'S'";
            } elseif ($situacaoFiltro == 'O') { // Vagas Ocupadas (situação='O' e flg_ativo = 'S')
                $whereConditions[] = "situacao = 'O' AND flg_ativo = 'S'";
            } elseif ($situacaoFiltro == 'N') { // Vagas Inativas (flg_ativo='N')
                $whereConditions[] = "flg_ativo = 'N'";
            }
        }

        // Adiciona o filtro de empresa com base no tipo de usuário, assim como em listaVagas()
        if ($idTipoUsuario == 2 || $idTipoUsuario == 1) { // Admin ou Funcionário
            $whereConditions[] = "fk_id_empresa = $idEmpresaUsuario";
        } elseif ($idTipoUsuario == 3) { // Dono - não adiciona filtro de empresa, ele vê todas
            // Nenhuma condição de empresa para o dono
        } else {
             // Tipo de usuário inválido, não deve retornar nenhuma vaga
             return '<div class="col-12"><p class="text-center">Permissão de usuário inválida para filtrar vagas.</p></div>';
        }

        // Constrói a cláusula WHERE final
        $whereClause = "";
        if (!empty($whereConditions)) {
            $whereClause = " WHERE " . implode(" AND ", $whereConditions);
        }

        $sql = "SELECT * FROM vaga" . $whereClause . " ORDER BY descricao;";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $coluna) {
                $vaga_id = $coluna["id_vaga"];
                $descricao = htmlspecialchars($coluna["descricao"]);
                $situacao = htmlspecialchars($coluna["situacao"]);
                $flg_ativo = $coluna["flg_ativo"];
                $id_empresa = htmlspecialchars($coluna["fk_id_empresa"]);
                $empresa_nome = descrEmpresa($coluna["fk_id_empresa"]);

                // Garante que $ativo e $icone sempre tenham um valor inicial
                $ativo = '';
                $icone = '<h6><i class="fas fa-times-circle text-danger"></i></h6>'; // Valor padrão para 'inativa' ou 'desconhecida'

                if ($flg_ativo == 'S') {
                    $ativo = 'checked';
                    $icone = '<h6><i class="fas fa-check-circle text-success"></i></h6>';
                }

                // Garante que $card_class, $display_situacao_text e $iconToggle sempre tenham um valor inicial
                $card_class = 'inativa'; // Valor padrão, caso não caia em nenhuma condição específica
                $display_situacao_text = 'INATIVA'; // Valor padrão
                $iconToggle = 'fa-toggle-off text-success'; // Valor padrão, pode ser ajustado se a vaga for inativa e não tiver toggle

                if ($flg_ativo == 'N') {
                    $card_class = 'inativa';
                    $display_situacao_text = 'INATIVA';
                    // Se a vaga está inativa, o toggle de situação não deve aparecer ou ter uma aparência específica
                    // Você pode decidir se quer que o ícone de toggle apareça para vagas inativas
                    // Se não, o valor padrão 'fa-toggle-off text-success' não será usado, pois o mostraVagaActions já lida com isso.
                    // Mas é importante que $iconToggle esteja definido para evitar o Warning.
                } else {
                    if ($situacao == 'L') {
                        $card_class = 'livre';
                        $display_situacao_text = 'LIVRE';
                        $iconToggle = 'fa-toggle-off text-success'; // Ícone para trocar para ocupada
                    } elseif ($situacao == 'O') {
                        $card_class = 'ocupada';
                        $display_situacao_text = 'OCUPADA';
                        $iconToggle = 'fa-toggle-on text-danger'; // Ícone para trocar para livre
                    } else {
                        // Caso um valor inesperado para $situacao (e flg_ativo é 'S')
                        $card_class = 'inativa'; // Pode ser uma classe para 'erro' ou 'desconhecida' se tiver CSS para isso
                        $display_situacao_text = 'DESCONHECIDA';
                        // Para situação desconhecida, defina um ícone padrão ou um que indique erro
                        $iconToggle = 'fa-question-circle text-warning'; // Exemplo: um ponto de interrogação
                    }
                }

                $lista .= '
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <div class=" '. reduzTamanhoVagaFuncionario() .' ' . $card_class . '">
                        ' . mostraIdVaga($vaga_id) . '
                        <div class="vaga-descricao">'.$descricao.'</div>
                        <div class="vaga-status">'.$display_situacao_text.'</div>
                        <div class="vaga-actions">
                            '. mostraVagaActions($vaga_id, $iconToggle, $card_class) .'
                        </div>
                    </div>
                </div>';

                // Modais de Edição e Exclusão também devem ser gerados aqui para que as ações funcionem
                $lista .= '
                <div class="modal fade" id="modalEditVaga'.$vaga_id.'">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h4 class="modal-title">Alterar Vaga</h4>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="backend/salvarVaga.php?funcao=A&codigo='.$vaga_id.'" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="form-group">
                                                <label for="editDescricao'.$vaga_id.'">Descrição:</label>
                                                <input type="text" id="editDescricao'.$vaga_id.'" name="nDescricao" value="'.$descricao.'" class="form-control"  maxlength="80">
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="editEmpresa'.$vaga_id.'">Empresa:</label>
                                                <select name="nEmpresa" id="editEmpresa'.$vaga_id.'" class="form-control" required>
                                                    <option value="'.$id_empresa.'">'.$empresa_nome.'</option>';
                $lista .= optionEmpresa(); // Assuming optionEmpresa() is available in funcoes.php
                $lista .= '
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-8">
                                            <div class="form-group">
                                                <label for="editSituacao'.$vaga_id.'">Situação:</label>
                                                <select class="form-control" id="editSituacao'.$vaga_id.'" name="nSituacao">
                                                    <option value="L" '.($situacao == 'L' ? 'selected' : '').'>Livre</option>
                                                    <option value="O" '.($situacao == 'O' ? 'selected' : '').'>Ocupada</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="checkbox" id="editAtivo'.$vaga_id.'" name="nAtivo" '.$ativo.'>
                                                <label for="editAtivo'.$vaga_id.'">Vaga Ativa</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                        <button type="submit" class="btn btn-success">Salvar</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>';

                $lista .= '
                <div class="modal fade" id="modalDeleteVaga'.$vaga_id.'">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h4 class="modal-title">Excluir Vaga: '.$vaga_id.'</h4>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="backend/salvarVaga.php?funcao=D&codigo='.$vaga_id.'" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5>Deseja EXCLUIR a vaga '.$descricao.'?</h5>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                                        <button type="submit" class="btn btn-success">Sim</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            // Se não encontrou vagas para o filtro
            $lista .= '<div class="col-12"><p class="text-center">Nenhuma vaga encontrada para o filtro selecionado.</p></div>';
        }

        mysqli_close($conn); // Fecha a conexão
        return $lista;
    }
?>