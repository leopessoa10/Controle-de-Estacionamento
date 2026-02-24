<?php 
  session_start();
  include('backend/funcoes.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Projeto Modelo - Relatório de Vagas</title>

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
    $_SESSION['menu-n2'] = 'relatorio-vagas';
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
                    <h3 class="card-title">Relatório de Vagas</h3>
                  </div>

                </div>
              </div>

              <!-- /.card-header -->
              <div class="modal-body">
                <form method="POST" action="backend/relatorioVagas.php" enctype="multipart/form-data">              
                  
                  <div class="row">
                    <div class="col-5">
                      <div class="form-group">
                        <label for="iDescricao">Descrição:</label>
                        <input type="text" class="form-control" id="iDescricao" name="nDescricao" maxlength="7" value="<?php //echo $_SESSION['relatVagasDescr'];?>">
                      </div>
                    </div>
                  
            
                    
                    <div class="col-3">
                      <div class="form-group">
                        <label for="iEmpresa">Empresa:</label>
                        <select name="nEmpresa" id="iEmpresa" class="form-control">
                          <?php if($_SESSION['relatVagasEmpr'] != '0' && $_SESSION['relatVagasEmpr'] != ''){ ?>
                            <option value="<?php echo $_SESSION['relatVagasEmpr']; ?>"><?php echo descrEmpresa($_SESSION['relatVagasEmpr']); ?></option>
                          <?php } ?>
                          <option value="0">Todas</option>
                          <?php echo optionEmpresa();?>
                        </select>
                      </div>
                    </div>

                    <!--<div class="col-2">
                      <div class="form-group">
                        <label for="iQtdMin">Qtd. Mínima:</label>
                        <input type="number" class="form-control" id="iQtdMin" name="nQtdMin" min="0" value="<?php// echo $_SESSION['relatVagasMin'];?>">
                      </div>
                    </div>

                    <div class="col-2">
                      <div class="form-group">
                        <label for="iQtdMax">Qtd. Máxima:</label>
                        <input type="number" class="form-control" id="iQtdMax" name="nQtdMax" min="0" value="<?php //echo $_SESSION['relatVagasMax'];?>">
                      </div>
                    </div>-->

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
                      <th>Empresa</th>    
                      <th>Situação</th>    
                  </tr>
                  </thead>
                  <tbody>

                  <?php echo $_SESSION['relatVagas']; ?>
                  
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
