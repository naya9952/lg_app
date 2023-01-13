<?php
require_once 'header.php';
require_once 'loginCheck.php';
$userID = $_REQUEST["userID"];
$sessID = $_REQUEST["sessID"];

/*평균온도,신호*/
$sql="select IFNULL(ROUND(AVG(a.tmp)/10, 1), 0) tmp, IFNULL(ROUND(AVG(a.rssi)), 0) rssi ";
$sql.="FROM (select AVG(temperature) tmp, AVG(rssi) rssi from lgu_history where dtime > subdate(now(), INTERVAL 24 HOUR) group by ime) a ";
error_log($sql);
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, true);
$stmt->free_result();
$stmt->close();
$tmp_avg = $row[0]['tmp'];
$rssi_avg = $row[0]['rssi'];
/*top5온도*/
$sql="select IFNULL(ROUND(AVG(a.tmp)/10, 1), 0) top5_tmp from (select ime, max(temperature) as tmp from lgu_history where dtime > subdate(now(), INTERVAL 10 MINUTE) group by ime order by tmp DESC LIMIT 5) a";
error_log($sql);
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, true);
$stmt->free_result();
$stmt->close();
$top5_tmp = $row[0]['top5_tmp'];

/*low5온도*/
$sql="select IFNULL(ROUND(AVG(a.rssi)), 0) low_rssi from (select ime, MIN(rssi) as rssi from lgu_history where dtime > subdate(now(), INTERVAL 10 MINUTE) group by ime order by rssi ASC LIMIT 5) a";
error_log($sql);
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, true);
$stmt->free_result();
$stmt->close();
$low5_rssi = $row[0]['low_rssi'];

$sql="select";
$sql.="  count(case WHEN a.state=1 then  a.state END) as run,";
$sql.="  count(case WHEN a.state=2 then  a.state END) as ac_fail,";
$sql.="  count(case WHEN a.state=3 then  a.state END) as elcb,";
$sql.="  count(case WHEN a.state=4 then  a.state END) as relay_off,";
$sql.="  count(case WHEN !(a.state>=1 AND a.state<=4) then  a.state END) as unknown_state,";
$sql.="  ROUND(count(case WHEN a.state=1 then  a.state END)/count(a.state)*100) as run_p,";
$sql.="  ROUND(count(case WHEN a.state=2 then  a.state END)/count(a.state)*100) as ac_fail_p,";
$sql.="  ROUND(count(case WHEN a.state=3 then  a.state END)/count(a.state)*100) as elcb_p,";
$sql.="  ROUND(count(case WHEN a.state=4 then  a.state END)/count(a.state)*100) as relay_off_p,";
$sql.="  ROUND(count(case WHEN !(a.state>=1 AND a.state<=4) then  a.state END)/count(a.state)*100) as unknown_state_p,";
$sql.="  ROUND(count(case WHEN a.temperature>600 then  a.temperature END)/count(a.temperature)*100) as tmp60over_p,";
$sql.="  ROUND(count(case WHEN a.temperature>500 AND a.temperature<=600 then  a.temperature END)/count(a.temperature)*100) as tmp50over_p,";
$sql.="  ROUND(count(case WHEN a.temperature>400 AND a.temperature<=500 then  a.temperature END)/count(a.temperature)*100) as tmp40over_p,";
$sql.="  ROUND(count(case WHEN a.temperature>300 AND a.temperature<=400 then  a.temperature END)/count(a.temperature)*100) as tmp30over_p,";
$sql.="  ROUND(count(case WHEN a.temperature<=300 then  a.temperature END)/count(a.temperature)*100) as tmp30under_p,";
$sql.="  ROUND(count(case WHEN a.rssi<-100 then  a.rssi END)/count(a.rssi)*100) as rssi100over_p,";
$sql.="  ROUND(count(case WHEN a.rssi<-85 AND a.rssi>=-100 then  a.rssi END)/count(a.rssi)*100) as rssi85over_p,";
$sql.="  ROUND(count(case WHEN a.rssi<-70 AND a.rssi>=-85 then  a.rssi END)/count(a.rssi)*100) as rssi70over_p,";
$sql.="  ROUND(count(case WHEN a.rssi<-55 AND a.rssi>=-70 then  a.rssi END)/count(a.rssi)*100) as rssi55over_p,";
$sql.="  ROUND(count(case WHEN a.rssi>=-55 then  a.rssi END)/count(a.rssi)*100) as rssi55under_p,";
$sql.="  count(a.state) as cnt";
$sql.=" from (";
$sql.="  select a.id, a.ime, a.cnt, a.eventtime, a.historytime, b.state, b.temperature, b.rssi";
$sql.="   from (";
$sql.="    select a.id, a.ime, a.flg, a.cnt, a.eventtime, max(b.dtime) as historytime, max(b.id) as historyid";
$sql.="    from (select a.id, a.ime, a.flg, count(c.ime) as cnt, max(c.dtime) as eventtime";
$sql.="          from lgu a";
$sql.="          left OUTER join lgu_event c on (a.ime=c.ime and c.dtime > subdate(now(), 20))";
$sql.="          group by a.id, a.ime) a";
$sql.="    left OUTER join lgu_history b on (a.ime=b.ime and b.dtime > subdate(now(), 20))";
$sql.="    group by a.id, a.ime, a.cnt, a.eventtime";
$sql.="   ) a left outer join lgu_history b on (a.ime=b.ime and a.historytime=b.dtime and a.historyid=b.id)";
$sql.="   where a.flg=1 order by a.id asc";
$sql.=" ) a";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, true);
$stmt->free_result();
$stmt->close();

$run_cnt = $row[0]['run'];
$ac_fail_cnt = $row[0]['ac_fail'];
$elcb_cnt = $row[0]['elcb'];
$relay_off_cnt = $row[0]['relay_off'];
$unknown_cnt = $row[0]['unknown_state'];

$run_percent = $row[0]['run_p'];
$ac_fail_percent = $row[0]['ac_fail_p'];
$elcb_percent = $row[0]['elcb_p'];
$relay_off_percent = $row[0]['relay_off_p'];

$tmp60over_percent = $row[0]['tmp60over_p'];
$tmp50over_percent = $row[0]['tmp50over_p'];
$tmp40over_percent = $row[0]['tmp40over_p'];
$tmp30over_percent = $row[0]['tmp30over_p'];
$tmp30under_percent = $row[0]['tmp30under_p'];

$rssi100over_percent = $row[0]['rssi100over_p'];
$rssi85over_percent = $row[0]['rssi85over_p'];
$rssi70over_percent = $row[0]['rssi70over_p'];
$rssi55over_percent = $row[0]['rssi55over_p'];
$rssi55under_percent = $row[0]['rssi55under_p'];

$sql="select * from lgu_event where dtime > subdate(now(), INTERVAL 1 HOUR) order by dtime desc LIMIT 10 ";
error_log($sql);
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, true);
$stmt->free_result();
$stmt->close();

?>
<!DOCTYPE html>
<html lang="ko">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>IoT Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
<?php require_once 'sidebar.php';?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
<?php require_once 'topbar.php';?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">통합 대시보드</h1>
            
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-file-excel"></i>　EXPORT
                    </button>
                    <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="./exportExcel.php?userID=<?php echo $userID ?>&sessID=<?php echo $sessID ?>">디바이스 현황</a>
                      <a class="dropdown-item" href="./exportExcel_event.php?userID=<?php echo $userID ?>&sessID=<?php echo $sessID ?>">디바이스 이벤트</a>
                    </div>
                  
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">평균온도 (최근 24시간)/TOP5 온도(현재)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo($tmp_avg);?>°C / <?php echo($top5_tmp);?> °C</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-thermometer-full fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">평균신호품질(최근 24시간)/LOW5 품질(현재)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo($rssi_avg);?>dbm / <?php echo($low5_rssi);?>dbm</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-rss fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">정상 작동 중 (현재)</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo($run_percent);?>%</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo($run_percent);?>%" aria-valuenow="<?php echo($run_percent);?>" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-heartbeat fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
		</div>

          <!-- Content Row -->

          <div class="row">

            <!-- Area Chart -->
            <!-- Bar Chart -->
             <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">온도범위</h6>
                </div>
                <div class="card-body">
                  <h4 class="small font-weight-bold">60°C 이상 <span class="float-right"><?php echo($tmp60over_percent);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo($tmp60over_percent);?>%" aria-valuenow="<?php echo($tmp60over_percent);?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">50°C ~ 60°C <span class="float-right"><?php echo($tmp50over_percent);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo($tmp50over_percent);?>%" aria-valuenow="<?php echo($tmp50over_percent);?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">40°C ~ 50°C <span class="float-right"><?php echo($tmp40over_percent);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo($tmp40over_percent);?>%" aria-valuenow="<?php echo($tmp40over_percent);?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">30°C ~ 40°C <span class="float-right"><?php echo($tmp30over_percent);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo($tmp30over_percent);?>%" aria-valuenow="<?php echo($tmp30over_percent);?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">30°CC 이하 <span class="float-right"><?php echo($tmp30under_percent);?>%</span></h4>
                  <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 1<?php echo($tmp30under_percent);?>%" aria-valuenow="<?php echo($tmp30under_percent);?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  &nbsp;
                </div>
              </div>
             </div>
            <!-- Bar Chart -->
             <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">신호 품질 범위</h6>
                </div>
                <div class="card-body">
                  <h4 class="small font-weight-bold">-100dbm 이상 <span class="float-right"><?php echo($rssi100over_percent);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo($rssi100over_percent);?>%" aria-valuenow="<?php echo($rssi100over_percent);?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">-85dbm ~ -100dbm <span class="float-right"><?php echo($rssi85over_percent);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo($rssi85over_percent);?>%" aria-valuenow="<?php echo($rssi85over_percent);?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">-70dbm ~ -85dbm <span class="float-right"><?php echo($rssi70over_percent);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo($rssi70over_percent);?>%" aria-valuenow="<?php echo($rssi70over_percent);?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">-55dbm ~ -70dbm <span class="float-right"><?php echo($rssi55over_percent);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo($rssi55over_percent);?>%" aria-valuenow="<?php echo($rssi55over_percent);?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">-55dbm 이하 <span class="float-right">C<?php echo($rssi55under_percent);?>%</span></h4>
                  <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo($rssi55under_percent);?>%" aria-valuenow="1<?php echo($rssi55under_percent);?>0" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  &nbsp;
                </div>
              </div>
             </div>

            <!-- Pie Chart -->
             <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">작동 상태</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Run
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-danger"></i> AC Fail
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Relay Off
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-warning"></i> ELCB
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-secondary"></i> unknown
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->
          <div class="row">

            <div class="col-xl-8 col-lg-7">

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">최근 이벤트</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>시간</th>
                      <th>IME</th>
                      <th>상태</th>
                      <th>비고</th>
                    </tr>
                  </thead>
                  <tbody>
<?php
    $idx = 0;
    foreach ($row as $value) {
      
        if($value['state'] == 1){
            $stx = 'Run';//녹색
        }
        else if($value['state'] == 2){
            $stx = 'AC Fail';//보라
        }
        else if($value['state'] == 3){
            $stx = 'ELCB';//빨강
        }
        else if($value['state'] == 4){
            $stx = 'Relay Off';//남색
        }
        else{
            $stx = 'unknown';//회색
        }
?>
                    <tr>
                      <td><?php echo($value['dtime']);?></td>
                      <td><?php echo($value['ime']);?></td>
                      <td><?php echo($stx);?></td>
                      <td><?php echo($value['desc']);?></td>
                    </tr>
<?php
    }
?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
</div>



          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
<?php require_once 'footer2.php';?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
<?php require_once 'goLogout.php';?>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
//Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';

  // Pie Chart Example
  var ctx = document.getElementById("myPieChart");
  var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ["Run", "AC Fail", "Relay Off", "ELCB", "unknown"],
      datasets: [{
        data: [<?php echo($run_cnt);?>, <?php echo($ac_fail_cnt);?>, <?php echo($relay_off_cnt);?>, <?php echo($elcb_cnt);?>, <?php echo($unknown_cnt);?>],
        backgroundColor: ['#1cc88a', '#e74a3b', '#36b9cc', '#f6c23e', '#858796'],
        hoverBackgroundColor: ['#2fdc9f', '#fa5f4f', '#4acedf', '#ffd84f', '#999dac'],
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: {
        display: false
      },
      cutoutPercentage: 80,
    },
  });

  </script>

</body>

</html>
<?php 
require_once 'footer.php';
?>