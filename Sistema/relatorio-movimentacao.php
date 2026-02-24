<?php 
  session_start();
  include('backend/funcoes.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> SA - Relatório de Movimentação</title>

  <!-- CSS -->
  <?php include('partes/css.php'); ?>
  <!-- Fim CSS -->

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include('partes/navbar.php'); ?>
  <!-- Fim Navbar -->

  <!-- Sidebar -->
  <?php 
    $_SESSION['menu-n1'] = 'relatorio';
    $_SESSION['menu-n2'] = 'relatorio-movimentacao';
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
                  
                  <div class="col-12">
                    <h3 class="card-title">Relatório de Movimentação</h3>
                  </div>

                </div>
              </div>

              <!-- /.card-header -->
              <div class="modal-body">
                <form method="POST" action="backend/relatorioMovimentacao.php" enctype="multipart/form-data">              
                  
                  <div class="row">
                    <div class="col-4">
                      <div class="form-group">
                        <label for="iMovimentacao">Tipo de Movimentação:</label>
                        <select name= "nMovimentacao" id="iMovimentacao" class="form-control">
                          <option value="T">Todas</option>    
                          <option value="E">Entrada</option>
                          <option value="S">Saída</option>
                        </select>
                      </div>
                    </div>
                  
                    <div class="row">
                    <div class="col-5">
                      <div class="form-group">
                        <label for="hMin">Data Mínima</label>
                        <input type="datetime-local" id="hMin" name="hMin">
                      </div>
                    </div>

                    <div class="row">
                    <div class="col-5">
                      <div class="form-group">
                        <label for="hMax">Data Máxima</label>
                        <input type="datetime-local" id="hMax" name="hMax">
                      </div>
                    </div>
                    
                  </div>

                  <div align="right">
                    <button type="submit" class="btn btn-primary">Processar</button>
                  </div>
                  
                </form>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            
          </div>
          <!-- /.col -->

          <div class="col-12">
            <div class="card">             

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th>ID</th>
                      <th>Descrição</th>
                      <th>Movimentação</th>
                      <th>Data e Hora</th>       
                  </tr>
                  </thead>
                  <tbody>

                  <?php echo $_SESSION['relatMovi']; ?>
                  
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
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');    
  });

</script>

</body>
</html>
