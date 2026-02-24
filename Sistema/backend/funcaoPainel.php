<?php

    function botaoFiltrarEmpresa() {
        $filtro_empresa = null;

        if ($_SESSION['idTipoUsuario'] == 3) {
            $filtro_empresa = 
            ' 
            <button type="button" class="btn btn-primary filtrar-empresa" data-toggle="modal" data-target="#filtroEmpresaModal">
                Filtrar por Empresa
            </button>

            <div class="modal fade" id="filtroEmpresaModal">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                    <h4 class="modal-title">Teste Ajax</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    <form method="POST" action="#" enctype="multipart/form-data">              
                        
                        <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                            <label for="iFiltroEmpresa">Escolha a Empresa:</label>
                            <select name="nFiltroEmpresa" id="iFiltroEmpresa" class="form-control" required>
                                <option value="">Todas as Empresas</option>';
            $filtro_empresa .=   optionEmpresa();
            $filtro_empresa .=
                            '</select>
                            </div>
                        </div> 
                        </div>

                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-success" id="filtrarEmpresaBtn">Filtrar</button>
                        </div>
                        
                    </form>

                    </div>
                    
                </div>
                <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal fade --> ';
        } else {
            $filtro_empresa = null;
        }
        return $filtro_empresa;
    }

?>