<?php 
  session_start();
  include('backend/funcoes.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Parkway - Usuários</title>

  <!-- CSS -->
  <?php include('partes/css.php'); ?>
  <!-- Fim CSS -->

</head>
  <body class="hold-transition sidebar-mini layout-fixed pagina-usuarios">
    <div class="wrapper">

      <!-- Navbar -->
      <?php include('partes/navbar.php'); ?>
      <!-- Fim Navbar -->

      <!-- Sidebar -->
      <?php 
        $_SESSION['menu-n1'] = 'administrador';
        $_SESSION['menu-n2'] = 'usuarios';
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
                        <h3 class="card-title">Usuários</h3>
                      </div>
                      
                      <div class="col-3" align="right">
                        <button id="CriarNovoUsuario" type="button" class="btn btn-success new-user-but" data-toggle="modal" data-target="#novoUsuarioModal">
                          Novo Usuário
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
                          <th>Tipo de Usuário</th>
                          <th>Nome</th>
                          <th>Login</th>
                              <?php if ($_SESSION['idTipoUsuario'] == 3) { ?>
                                  <th>Empresa</th>
                              <?php } ?>
                          <th>Ativo</th>                
                          <th>Ações</th>
                      </tr>
                      </thead>
                      <tbody>

                      <?php echo listaUsuario(); ?>
                      
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

          <div class="modal fade" id="novoUsuarioModal">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header bg-success">
                  <h4 class="modal-title">Novo Usuário</h4>
                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="backend/salvarUsuario.php?funcao=I" enctype="multipart/form-data">              
                    
                    <div class="row">
                      <div class="col-8">
                        <div class="form-group">
                          <label for="iNome">Nome:</label>
                          <input type="text" class="form-control" id="iNome" name="nNome" maxlength="30" required>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group">
                          <label for="iTipoUsuario">Tipo de Usuário:</label>
                          <select id="iTipoUsuario" name="nTipoUsuario" class="form-control" required>
                            <option value="">Selecione...</option>
                            <?php echo optionTipoUsuario();?>
                          </select>
                        </div>
                      </div>

                      <div class="col-8">
                        <div class="form-group">
                          <label for="iEmail">Email:</label>
                          <input type="email" class="form-control" id="iEmail" name="nEmail" maxlength="30" required>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group">
                          <label for="iSenha">Senha:</label>
                          <input type="text" class="form-control" id="iSenha" name="nSenha" maxlength="6" required>
                        </div>
                      </div>
                    
                      <div class="col-8">
                        <div class="form-group">
                          <label for="iFoto">Foto:</label>
                          <input type="file" class="form-control" id="iFoto" name="nFoto" accept="image/*">
                        </div>
                      </div>

                      <?php if ($_SESSION['idTipoUsuario'] == 3): ?>
                      <div class="col-4">
                        <div class="form-group">
                          <label for="iEmpresa">Empresa:</label>
                          <select id="iEmpresa" name="nEmpresa" class="form-control" required>
                            <option value="">Selecione...</option>
                            <?php echo optionEmpresa();?>
                          </select>
                        </div>
                      </div>
                      <?php endif; ?>
                    
                      <div class="col-12">
                        <div class="form-group">
                          <input type="checkbox" id="iAtivo" name="nAtivo">
                          <label for="iAtivo">Usuário Ativo</label>
                        </div>
                      </div>

                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                      <button id="SalvarCriarUsuario" type="submit" class="btn btn-success">Salvar</button>
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
