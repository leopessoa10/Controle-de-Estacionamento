<?php 
  session_start();
  include('backend/funcoes.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ParkWay - Vagas</title>

    <!-- CSS -->
    <?php include('partes/css.php'); ?>
    <!-- Fim CSS -->

  </head>
  <body class="hold-transition sidebar-mini layout-fixed pagina-vagas">
    <div class="wrapper">

      <!-- Navbar -->
      <?php include('partes/navbar.php'); ?>
      <!-- Fim Navbar -->

      <!-- Sidebar -->
      <?php 
          if ($_SESSION['idTipoUsuario'] == 1 || $_SESSION['idTipoUsuario'] == 3) {
          $_SESSION['menu-n1'] = 'administrador';
          } else if ($_SESSION['idTipoUsuario'] == 2) {
          $_SESSION['menu-n1'] = 'funcionario';
         } else {
          $_SESSION['menu-n1'] = ''; // ou outro valor padrão
      }
      $_SESSION['menu-n2'] = 'vagas'; // submenu que quer ativar
      include('partes/sidebar.php'); 
    ?><!-- Fim Sidebar -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <div class="content-header">
          </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <div class="row">

                      <div class="col-6">
                        <h3 class="card-title">Vagas</h3>
                      </div>

                      <div class="col-6" align="right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filtrarVagas">
                          Filtrar Vagas
                        </button>
                        <?php echo botaoNovaVaga(); ?>
                      </div>

                    </div>
                  </div>

                  <div class="card-body vagas-container">
                      <div class="row" id="vagas-list-area">
                          <?php echo listaVagas(); ?>
                      </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          <?php echo renderizarNovaVagaModal(); ?>

          <div class="modal fade" id="filtrarVagas">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <h4 class="modal-title">Filtro de Vagas</h4>
                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="#" enctype="multipart/form-data" id="formFiltroVagas">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="iOpcaoFiltro">Filtrar por:</label>
                          <select name="nOpcaoFiltro" id="iOpcaoFiltro" class="form-control">
                            <option value="">Todas as Vagas</option>
                            <option value="L">Vagas Livres</option>
                            <option value="O">Vagas Ocupadas</option>
                            <option value="N">Vagas Inativas</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                      <button type="submit" class="btn btn-success">Filtrar</button>
                    </div>

                  </form>

                </div>

              </div>
              </div>
            </div>
          </section>
        </div>
      <!-- /.content-wrapper -->
          
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
      //== Inicialização
      $(document).ready(function() {

        // O evento de submit do formulário agora vai enviar o formulário para o PHP
        $('#formFiltroVagas').submit(function(e) {
          e.preventDefault(); // Evita o submit padrão do formulário

          var opcaoFiltro = $('#iOpcaoFiltro').val();

          // REMOVA O BLOCO 'if (opcaoFiltro !== "" && opcaoFiltro !== "0")'
          // e o 'else' correspondente que exibe a mensagem de erro.
          // O PHP agora lida com 'opcaoFiltro' vazio.

          // Requisição Ajax para carregar as vagas filtradas
          $.ajax({
            url: 'backend/carregaVagaFiltro.php',
            type: 'GET',
            data: { opcaoFiltro: opcaoFiltro }, // Passa o valor (pode ser vazio, como "")
            success: function(response) {
              // Insere o HTML retornado no div que lista as vagas
              $('#vagas-list-area').html(response);
              $('#filtrarVagas').modal('hide'); // Fecha o modal após o filtro
            },
            error: function(xhr, status, error) {
              console.error("Erro ao carregar vagas filtradas: " + error);
              // Melhorar a mensagem de erro para o usuário se necessário
              $('#vagas-list-area').html('<div class="col-12"><p class="text-center text-danger">Erro ao carregar vagas. Tente novamente.</p></div>');
            }
          });
        });

      });
    </script>

  </body>
</html>