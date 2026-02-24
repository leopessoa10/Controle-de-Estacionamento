<?php 
  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }

  include('backend/funcoes.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projeto Modelo - Perfil</title>

    <!-- CSS -->
    <?php include('partes/css.php'); ?>
    <!-- Fim CSS -->

  </head>
  <body class="hold-transition sidebar-mini layout-fixed pagina-perfil">
    <div class="wrapper">

      <!-- Navbar -->
      <?php include('partes/navbar.php'); ?>
      <!-- Fim Navbar -->

      <!-- Sidebar -->
      <?php 
        $_SESSION['menu-n1'] = '';
        $_SESSION['menu-n2'] = 'perfil';
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
                  <!-- Card-header -->
                  <div class="card-header">
                    <div class="row">
                      
                      <div class="col-12">
                        <h3 class="card-title">Meu Perfil</h3>
                      </div>
                      
                    </div>
                  </div>
                  <!-- /.card-header -->
                  
                  <div class="card-body card-body1-perfil">

                    <form method="POST" action="backend/salvarPerfil.php" enctype="multipart/form-data">
                      <div class="card-body card-body2-perfil">
                          <div class="row">	
                              
                              <div class="col-12">
                                  <div class="row">	
                              
                                    <div class="col-12">
                                      <div class="row">
                                        <div class="col-3 text-center">
                                          <div class="foto-perfil mx-auto">
                                            <img alt="<?php echo $_SESSION['NomeLogin']; ?>" src="<?php echo $_SESSION['FotoLogin']; ?>"  class="foto">
                                            <div class="trocar-imagem">
                                              <i class="fas fa-camera upload-button"></i>
                                              <p>Alterar Foto</p>
                                              <input class="arquivo" name="nFoto" id="iFoto" type="file" title="" accept="image/*"/>
                                            </div>
                                          </div>
                                        </div>	
                                        <div class="col-9">
                                          <div class="row">											
                                            <div class="col-7">
                                              <div class="form-group">
                                                <label for="iNome">Nome</label>
                                                <input name="nNome" id="iNome" type="text" maxlength="30" class="form-control" 
                                                  value="<?php echo $_SESSION['NomeLogin']; ?>" required>
                                              </div>
                                            </div>											
                                            <div class="col-5">
                                              <div class="form-group">
                                                <label>Nível de Acesso</label>
                                                <input readonly name="nNivelAcesso" id="iNivelAcesso" type="text" maxlength="20" class="form-control" 
                                                  value="<?php echo $_SESSION['DescricaoTipoUsuario']; ?>">
                                              </div>
                                            </div>	
                                            <div class="col-7">
                                              <div class="form-group">
                                                <label>E-mail</label>
                                                <input readonly name="nEmail" id="iEmail" type="email" maxlength="30" class="form-control" 
                                                  value="<?php echo $_SESSION['EmailLogin']; ?>">
                                              </div>
                                            </div>		
                                            <div class="col-5">
                                              <div class="form-group">
                                                <label>Alterar Senha</label>
                                                <input name="nAlterarSenha" id="iAlterarSenha" type="password" class="form-control" 
                                                  value="" placeholder="Digite sua nova senha...">
                                                  <i class="fas fa-eye-slash toggle-password"
                                                    style="cursor: pointer;"></i>
                                              </div>
                                            </div>
                                            <div class="col-7">
                                              <div class="form-group">
                                                <label>Empresa</label>
                                                <input readonly name="nEmpresa" id="iEmpresa" type="text" maxlength="30" class="form-control" 
                                                  value="<?php echo $_SESSION['NomeEmpresa']; ?>">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                  </div>
                              </div>
                              
                          </div>
                      </div>	

                      <div class="card-action" align="right">
                        <a href="perfil.php" class="btn btn-danger" data-toggle="tooltip" title="Cancelar a operação">
                          <span>Cancelar</span>
                        </a>
                        <input type="submit" class="btn btn-success" value="Salvar" data-toggle="tooltip" title="Salvar as alterações no perfil">
                      </div>
                    </form>
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

        </section>
        <!-- /.main content -->
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
        });
      });
    </script>

    <script>
        document.querySelector('.toggle-password').addEventListener('click', function () {
            const passwordInput = document.getElementById('iAlterarSenha');
            const icon = this;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    </script>

  </body>
</html>
