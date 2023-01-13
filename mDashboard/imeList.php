<?php require_once 'header.php';
require_once 'loginCheck.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>디바이스 관리</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
          <h1 class="h3 mb-2 text-gray-800">디바이스 리스트</h1>
          <form method="post" id="frm" name="frm">
                  <input type="hidden" name="userID" id="userID" value="<?php echo($_REQUEST["userID"]);?>">
                  <input type="hidden" name="sessID" id="sessID" value="<?php echo($_REQUEST["sessID"]);?>"> 
                  <input type="hidden" name="ime_c" id="ime_c" >       
          </form>
          
          <div class="card shadow mb-4">
          
          <div class="card-header py-3" id="create_div" style="float:right; display:none;">

                  
                      <a href="#" onclick="createForm()" style="float:right;" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">등 록</span>
                      </a>
            </div>
          </div>


          <!-- DataTales Example -->
          <div class="card shadow mb-4">

          <?php
          //장비 리스트를 출력하는 코드
          $sql="select a.id, a.ime,a.reset, a.dtime, a.flg, a.`desc`, CASE b.state WHEN '0' THEN 'OFF' WHEN '1' THEN '정상동작' WHEN '2' THEN 'AC정전' WHEN '3' THEN 'ELCB TRIP' ELSE 'Relay OFF' END as 'state', b.temperature, b.rssi";
          $sql.=" from (";
          $sql.=" select a.id, a.ime, a.cnt,a.reset, a.flg, a.dtime, a.`desc`, a.eventtime, max(b.dtime) as historytime, max(b.id) as historyid";
          $sql.=" from (select a.id, a.ime, a.reset, a.flg, a.dtime, a.`desc`,count(c.ime) as cnt, max(c.dtime) as eventtime";
          $sql.=" from lgu a";
          $sql.=" left OUTER join lgu_event c on (a.ime=c.ime and c.dtime > subdate(now(), 20))";
          $sql.=" group by a.id, a.ime) a";
          $sql.=" left OUTER join lgu_history b on (a.ime=b.ime and b.dtime > subdate(now(), 20))";
          $sql.=" group by a.id, a.ime, a.cnt, a.eventtime";
          $sql.=" ) a left outer join lgu_history b on (a.ime=b.ime and a.historytime=b.dtime and a.historyid=b.id)";
          $sql.=" where a.flg=1 order by a.id asc";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $row = get_stmt_assoc_array($stmt, true);
          ?>
          
          <!--div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">중 제목(필요시)</h6>
            </div-->
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>IME</th>
                      <th>상태</th>
                      <th>RESET</th>
                      <th>온도</th>
                      <th>신호세기</th>
                      <th>등록일</th>
                      <th>위치</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>IME</th>
                      <th>상태</th>
                      <th>RESET</th>
                      <th>온도</th>
                      <th>신호세기</th>
                      <th>등록일</th>
                      <th>위치</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  <?php
                  if(count($row) > 0) {
                    foreach ($row as $key => $value){
                        if($value['flg'] != 0){
                          ?>
                          <tr style="cursor: pointer;" onMouseOver="this.style.backgroundColor='#e0f5fe'" 
                            onMouseOut="this.style.backgroundColor='#ffffff'" onclick="info('<?php echo $value['ime'];?>','<?php echo $_REQUEST['userID']; ?>','<?php echo $_REQUEST['sessID']; ?>')" >
                          <?php
                            echo "<td>".$value['id']."</td>";
                            echo "<td>".$value['ime']."</td>";
                            echo "<td>".$value['state']."</td>";
                            echo "<td>".$value['reset']."</td>";
                            echo "<td>".($value['temperature']/10)."</td>";
                            echo "<td>".$value['rssi']."</td>";
                            echo "<td>".$value['dtime']."</td>";
                            echo "<td>".$value['desc']."</td>";
                            echo "</tr>";
                        }
                    };
                    $stmt->free_result();
                    $stmt->close(); 
                } else {
                    echo NULL;
                }
                  ?>  
                  </tbody>
                </table>
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
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/datatables.js"></script>

</body>

</html>
<script type="text/javascript">

window.onload = function () { 

var userID = $("#userID").val();
var create_div = document.getElementById("create_div");
  if(userID == 'admin')
  {
    create_div.style.display = "inline";
    
  }
}

function info(ime, userID, sessID){
  var f = document.frm;
	document.getElementById("ime_c").value = ime;
  var ime_c = document.getElementById('ime_c');
  ime_c.value= ime;
	f.action = "./imeInfo.php";
	f.submit();
}

function createForm(){
  var f = document.frm;
	f.action = "./imeCreateForm.php";
	f.submit();
}
</script>