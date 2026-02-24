<?php 
  session_start();
  include('backend/funcoes.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ParkWay - Empresas</title>

  <!-- CSS -->
  <?php include('partes/css.php'); ?>
  <!-- Fim CSS -->

</head>
<body class="hold-transition sidebar-mini layout-fixed pagina-empresas">
<div class="wrapper">

  <!-- Navbar -->
  <?php include('partes/navbar.php'); ?>
  <!-- Fim Navbar -->

  <!-- Sidebar -->
  <?php 
    $_SESSION['menu-n1'] = 'administrador';
    $_SESSION['menu-n2'] = 'empresas';
    include('partes/sidebar.php'); 
  ?>
  <!-- Fim Sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <!-- Espaço -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  
                  <div class="col-9">
                    <h3 class="card-title">Empresas</h3>
                  </div>
                  
                  <div class="col-3" align="right">
                    <button id="novaEmpresaBotao" type="button" class="btn btn-success" data-toggle="modal" data-target="#novaEmpresaModal">
                      Nova Empresa
                    </button>
                  </div>

                </div>
              </div>

              

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabela" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>CNPJ</th>
                      <th>Telefone</th>
                      <th>CEP</th>
                      <th>Cidade</th>
                      <th>UF</th>
                      <th>Ativo</th>                
                      <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php echo listaEmpresa(); ?>
                  
                  </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->

      <div class="modal fade" id="novaEmpresaModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header bg-success">
              <h4 class="modal-title">Nova Empresa</h4>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="backend/salvarEmpresa.php?funcao=I" enctype="multipart/form-data">              
                
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="iNome">Nome:</label>
                      <input required type="text" class="form-control" id="iNome" name="nNome" maxlength="30" placeholder="Nome da Empresa">
                    </div>
                  </div>

                  <div class="col-7">
                    <div class="form-group">
                      <label for="iCNPJ">CNPJ:</label>
                      <input required type="text" class="form-control" id="iCNPJ" name="nCNPJ" maxlength="14" placeholder="CNPJ da Empresa">
                    </div>
                  </div>

                  <div class="col-5">
                    <div class="form-group">
                      <label for="iTelefone">Telefone:</label>
                      <input required type="number" class="form-control" id="iTelefone" name="nTelefone" maxlength="13" placeholder="Telefone da Empresa">
                    </div>
                  </div>
                
                  <div class="col-12">
                    <div class="form-group">
                      <label for="iFoto">Foto:</label>
                      <input type="file" class="form-control" id="iFoto" name="nFoto" accept="image/*">
                    </div>
                  </div>
                
                  <div class="col-12">
                    <div class="form-group">
                      <input type="checkbox" id="iAtivo" name="nAtivo">
                      <label for="iAtivo">Empresa Ativa</label>
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="iCEP">CEP</label>
                      <input id="iCEP"  name="nCEP" type="text" maxlength="9" class="form-control cep" placeholder="Digite o CEP sem hífen" required>
                    </div>
                  </div>
                  
                  <div class="col-9">
                    <div class="form-group">
                      <label for="iEndereco">Endereço</label>
                      <input id="iEndereco" required name="nEndereco" type="text" maxlength="30" class="form-control" placeholder="Rua, Avenida, etc.">
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="iNumero">Número</label>
                      <input id="iNumero" required name="nNumero" type="number" maxlength="5" class="form-control" placeholder="Número">
                    </div>
                  </div>

                  <div class="col-9">
                    <div class="form-group">
                      <label for="iComplemento">Complemento (opcional)</label>
                      <input id="iComplemento"  name="nComplemento" type="text" maxlength="60" class="form-control" placeholder="Complemento">
                    </div>
                  </div>

                  <div class="col-5">
                    <div class="form-group">
                      <label for="iBairro">Bairro</label>
                      <input id="iBairro" required name="nBairro" type="text" maxlength="30" class="form-control" placeholder="Bairro">
                    </div>
                  </div>
                  
                  <div class="col-5">
                    <div class="form-group">
                      <label for="iCidade">Cidade</label>
                      <input id="iCidade" required name="nCidade" type="text" maxlength="30" class="form-control" placeholder="Cidade">
                    </div>
                  </div>

                  <div class="col-2">
                    <div class="form-group">
                      <label for="iUF">UF</label>
                      <input id="iUF" required name="nUF" type="text" maxlength="2" class="form-control" placeholder="UF">
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
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

    </section>
    <!-- /.content -->
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- JS -->
<?php include('partes/js.php'); ?>
<!-- Fim JS -->

<script>
  $(function () {
    $('#tabela').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,

      language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json"
      }
    });
  });
</script>

</body>
</html>
