<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>사용자 등록</title>

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
          <h1 class="h3 mb-2 text-gray-800">사용자 등록</h1>

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
              <form method="post" id="frm_user" name="frm_user">
                <input type="hidden" name="userID" id="userID" value="<?php echo($_REQUEST["userID"]);?>">
                <input type="hidden" name="sessID" id="sessID" value="<?php echo($_REQUEST["sessID"]);?>"> 
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>ID</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" name="userid_input" id="userid_input">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>비밀번호</h6>
                    <input type="password" class="form-control form-control-user" name="new_password_input" id="new_password_input" >
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>권한</h6>
                    <select name="access_code_input" id="access_code_input" class="form-control form-control-user">
                      <option disabled="disabled" >------------------</option>
                      <option value='0'>읽기전용</option>
                      <option value='1'>제어가능</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>담당 지역 변경</h6>
                  
                    <select name="groupid_input" id="groupid_input" class="form-control form-control-user">
                      <option disabled="disabled" >------------------</option>
                      <option value='0' >미정</option>
                      <option value='1'>서울지역</option>
                      <option value='2'>대전지역</option>
                      <option value='3'>대구지역</option>
                      <option value='4'>부산지역</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>기타</h6>
                    <input type="text" class="form-control form-control-user" name="etc_input" id="etc_input">
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
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/datatables.js"></script>

</body>

</html>

<script type="text/javascript">
function create(){
  var userid = $("#userid_input").val();
  var new_password = $("#new_password_input").val();
  var access_code = $("#access_code_input").val();
  var groupid = $("#groupid_input").val();
  var etc = $("#etc_input").val();

  if(userid== ''){
		alert("ID를 입력해주세요");
    document.getElementById("userid_input").focus();
	}
	else if(new_password== ''){
		alert("비밀번호를 입력해주세요");
    document.getElementById("new_password_input").focus();
	}
  else{
    if(confirm("등록하시겠습니까?")== true){
    //location.replace("./userCreate.php?userid="+userid+"&new_password="+new_password+"&access_code="+access_code+"&groupid="+groupid+"&etc="+etc);
    var f = document.frm_user;
	  f.action = "./userCreate.php";
	  f.submit();
    }
    else{
    } 
  }
}

function back_page(){
  var f = document.frm_user;
	f.action = "./userList.php";
	f.submit();
}

function confirm_id(){
  window.open("./userCreate_idCheck?userid=admin", "popup01", "'location=no, directories=no,resizable=no,status=no,toolbar=no,menubar=no, width=340,height=253,left=0, top=0, scrollbars=no'");
}
</script>