<?php require_once 'header.php';
 require_once 'loginCheck.php'; 
 
            //사용자 전체 리스트 출력코드

            $sql = "select *,CASE state WHEN '0' THEN 'OFF' WHEN '1' THEN '정상동작' WHEN '2' THEN 'AC정전' WHEN '3' THEN 'ELCB TRIP' ELSE 'Relay OFF' END as 'state' from lgu_event order by id desc limit 500;";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $row = get_stmt_assoc_array($stmt, true);
            

 ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>전체 디바이스 이벤트</title>

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
          <h1 class="h3 mb-2 text-gray-800">전체 디바이스 이벤트</h1>
          <form method="post" id="frm" name="frm">
                  <input type="hidden" name="userID" id="userID" value="<?php echo($_REQUEST["userID"]);?>">
                  <input type="hidden" name="sessID" id="sessID" value="<?php echo($_REQUEST["sessID"]);?>">  
                  <input type="hidden" name="id" id="id">           
          </form>
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">

          
            <!--div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">중 제목(필요시)</h6>
            </div-->
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width='10%'>번호</th>
                      <th width='20%'>시간</th>
                      <th width='20%'>IME</th>
                      <th width='10%'>상태</th>
                      <th width='40%'>비고</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>번호</th>
                      <th>시간</th>
                      <th>IME</th>
                      <th>상태</th>
                      <th>비고</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  <?php
                  if(count($row) > 0) {
                    foreach ($row as $key => $value){
                    
                            ?>
                            <tr>
                            <?php
                            echo "<td>".$value['id']."</td>";
                            echo "<td>".$value['dtime']."</td>";
                            echo "<td>".$value['ime']."</td>";
                            echo "<td>".$value['state']."</td>";
                            echo "<td>".$value['desc']."</td>";
                            echo "</tr>";
                        
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
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
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

function info(id, userID, sessID){
  var f = document.frm;
	document.getElementById("id").value = id;
	f.action = "./userInfo2.php";
	f.submit();
}

function createForm(){
  var f = document.frm;
	f.action = "./userCreateForm.php";
	f.submit();
}
</script>