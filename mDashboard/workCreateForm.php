<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>작업 내역 등록</title>

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
          <h1 class="h3 mb-2 text-gray-800">작업 내역 등록</h1>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
                      <a href="#" onclick="back_page();" style="float:right; margin-right:10px;" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="far fa-times-circle"></i>
                        </span>
                        <span class="text">취 소</span>
                      </a>   
                      <a href="#" onclick="create();" style="float:right; margin-right:10px;" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="far fa-check-circle"></i>
                        </span>
                        <span class="text">확 인</span>
                      </a>        
            </div>
          </div>
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">기본 정보</h6>
            </div>
            <div class="card-body">

              <form method="post" id="frm_work" name="frm_work">
                <input type="hidden" name="userID" id="userID" value="<?php echo($_REQUEST["userID"]);?>">
                <input type="hidden" name="sessID" id="sessID" value="<?php echo($_REQUEST["sessID"]);?>"> 
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>ime</h6>
                    <input type="text" class="form-control form-control-user" name="ime_c" id="ime_c" value=<?php echo $_REQUEST["ime_c"]; ?> readonly >
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>작성자</h6>
                    <input type="text" class="form-control form-control-user" name="userid" id="userid" value="<?php echo($_REQUEST["userID"]);?>" readonly >
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>작업 내용</h6>
                    <input type="text" class="form-control form-control-user" name="desc" id="desc" >
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>작업 상태</h6>
                    <select name="work_code" id="work_code" class="form-control form-control-user">
                      <option disabled="disabled" >------------------</option>
                      <option value='0'>작업중</option>
                      <option value='1'>작업완료</option>
                    </select>
                  </div>
                </div>
              </form>

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
function create(){
  var userid = $("#userid").val();
  var ime = $("#ime").val();
  var desc = $("#desc").val();
  var work_code = $("#work_code").val();
  if(desc== ''){
		alert("작업 내용을 입력해주세요");
    document.getElementById("desc").focus();
	}
  else{
    if(confirm("등록하시겠습니까?")== true){
		//location.replace("./workCreate.php?userid="+userid+"&ime="+ime+"&desc="+desc+"&work_code="+ work_code);  
    var f = document.frm_work;
	  f.action = "./workCreate.php";
	  f.submit();
    }
    else{
    } 
  }
}
function back_page() {
  var f = document.frm_work;
	f.action = "./imeInfo.php";
	f.submit();
}
</script>