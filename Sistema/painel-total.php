<?php 
  session_start();
  include('backend/funcoes.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ParkWay - Dashboard</title>

    <!-- CSS -->
    <?php include('partes/css.php'); ?>
    <!-- Fim CSS -->

  </head>
  <body class="hold-transition sidebar-mini layout-fixed paginas-dashboard">
    <div class="wrapper">

      <!-- Navbar -->
      <?php include('partes/navbar.php'); ?>
      <!-- Fim Navbar -->

      <!-- Sidebar -->
      <?php 
        $_SESSION['menu-n1'] = 'administrador';
        $_SESSION['menu-n2'] = 'painel-total';
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

            <?php echo botaoFiltrarEmpresa(); ?>

            <!-- Small boxes (Stat box) -->
            <div class="row">
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php echo qtdVagasAtivas();?></h3>

                    <p>Vagas Ativas</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-check-circle"></i>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3><?php echo qtdEntradas();?></h3>

                    <p>Entradas Totais</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-sign-in-alt"></i>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><?php echo qtdSaidas();?></h3>

                    <p>Saídas Totais</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-sign-out-alt signout-exclusive"></i>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><?php echo TempoMedioTotal();?></h3>

                    <p>Tempo Médio de</p>
                    <p> Permanência Total</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-parking"></i>
                  </div>
                </div>
              </div>
              
              <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
              <!-- Left col -->
              <section class="col-lg-6 connectedSortable">
                  
                <!-- BAR CHART -->
                <div class="card text-success">
                  <div class="card-header">
                    <h3 class="card-title">Entradas e Saídas Totais</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool text-success" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="chart">
                      <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->

              </section>

              <section class="col-lg-6 connectedSortable">
                  
                <!-- BAR CHART -->
                <div class="card text-success">
                  <div class="card-header">
                    <h3 class="card-title">Permanências por Hora Total</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool text-success" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="chart">
                      <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->

              </section>
              <!-- /.Left col -->
            </div>
            <!-- /.row (main row) -->
          </div><!-- /.container-fluid -->
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
        var areaChartData = {
          //labels  : ['Administrador','Empresa','Comum'],
          labels  : ['Movimentações'],
          datasets: [
            
            {
              label               : 'Entradas',
              backgroundColor     : 'rgba(0, 255, 0, 0.5)',
              borderColor         : 'rgba(0, 255, 0, 0.5)',
              borderWidth         : 0,
              pointRadius          : false,
              pointColor          : '#3b8bba',
              pointStrokeColor    : 'rgba(0, 255, 0, 0.5)',
              pointHighlightFill  : '#fff',
              pointHighlightStroke: 'rgba(0, 255, 0, 0.5)',
              data                : [<?php echo qtdEntradas(); ?>]
            },
            
            {
              label               : 'Saídas',
              backgroundColor     : 'rgba(255, 0, 0, 0.5)',
              borderColor         : 'rgba(255, 0, 0, 0.5)',
              borderWidth         : 0,
              pointRadius         : false,
              pointColor          : 'rgba(255, 0, 0, 0.5)',
              pointStrokeColor    : '#c1c7d1',
              pointHighlightFill  : '#fff',
              pointHighlightStroke: 'rgba(255, 0, 0, 0.5)',
              data                : [<?php echo qtdSaidas(); ?>]
            },
            
          ]
        }
        
        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp0
        barChartData.datasets[1] = temp1

        var barChartOptions = {
          responsive              : true,
          maintainAspectRatio     : false,
          datasetFill             : false,
          // Scales para o gráfico começar no valor '0 (zero)'
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }

        new Chart(barChartCanvas, {
          type: 'bar',
          data: barChartData,
          options: barChartOptions
        })
        // GRÁFICO DE PIZZA
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        var pieData = {
          labels: ['Acima de 1 Hora', 'Abaixo de 1 Hora'],
          datasets: [{
            data: [<?php echo intval(qtdAcimaHora()); ?>, <?php echo intval(qtdAbaixoHora()); ?>],
            backgroundColor: ['rgba(0, 255, 0, 0.5)', 'rgba(255, 0, 0, 0.5)'],
            borderColor: ['#00ff00', '#ff0000'],
            borderWidth: 1
          }]
        }

        var pieOptions = {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }

        new Chart(pieChartCanvas, {
          type: 'pie',
          data: pieData,
          options: pieOptions
        })
    </script>

    <script>
      $('#filtrarEmpresaBtn').on('click', function () {
        const idEmpresa = $('#iFiltroEmpresa').val();

        if (!idEmpresa) {
          location.reload();
          return;
        }

        $.ajax({
          url: 'backend/filtroEmpresaTotal.php', // Aqui é a mudança!
          type: 'POST',
          dataType: 'json',
          data: { idEmpresa },
          success: function (dados) {
            if (dados.erro) {
              alert(dados.erro);
              return;
            }

            // Atualiza os cards
            $('.small-box.bg-info h3').text(dados.vagasAtivas);
            $('.small-box.bg-warning h3').text(dados.qtdEntradas);
            $('.small-box.bg-danger:eq(0) h3').text(dados.qtdSaidas);
            $('.small-box.bg-danger:eq(1) h3').text(dados.tempoMedio);

            // Atualiza gráfico de barras
            barChart.data.datasets[0].data = [dados.qtdEntradas];
            barChart.data.datasets[1].data = [dados.qtdSaidas];
            barChart.update();

            // Atualiza gráfico de pizza
            pieChart.data.datasets[0].data = [dados.acima1h, dados.abaixo1h];
            pieChart.update();

            $('#filtroEmpresaModal').modal('hide');
          },
          error: function () {
            alert('Erro ao buscar dados da empresa.');
          }
        });
      });
    </script>

  </body>
</html>
