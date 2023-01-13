<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>사용자 상세</title>

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

        <?php
            //사용자 정보 출력 코드
            require_once 'header.php';
            $userID = $_REQUEST["userID"];
            $sessID = $_REQUEST["sessID"];
            $id = $_REQUEST["id"];
            //require_once 'loginCheck.php';
            $sql = "select u.userid, u.password, u.access as access_code, u.groupid, if( u.access = 1, '제어가능', '읽기전용' ) as access_name ,g.groupid as location_code, g.desc as location , u.desc as etc  from lgu_user as u join lgu_group as g ON u.groupid = g.groupid where id=?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $row = get_stmt_assoc_array($stmt, true);
            if(count($row) > 0) {
                foreach ($row as $key => $value){
                };
            } else {
                echo NULL;
            }
            $stmt->free_result();
            $stmt->close();
            ?>


        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">사용자 상세</h1>

          <div class="card shadow mb-4">

          <form method="post" id="frm_user" name="frm_user">
                  <input type="hidden" name="userID" id="userID" value="<?php echo($_POST["userID"]);?>">
                  <input type="hidden" name="sessID" id="sessID" value="<?php echo($_POST["sessID"]);?>">
                  <input type="hidden" name="id" id="id" value="<?php echo($_POST["id"]);?>">
          </form>
            <div class="card-header py-3">
                      <a href="#" id="delete_btn" onclick="user_delete();" style="float:right; display:none;" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fas fa-trash"></i>
                        </span>
                        <span class="text">삭 제</span>
                      </a>
                      <a href="#" id="modify_btn" onclick="modify();" style="float:right; margin-right:10px; display:none;" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fas fa-pencil-alt "></i>
                        </span>
                        <span class="text">수 정</span>
                      </a>
                      <a href="#" onclick="back_page();" style="float:right; margin-right:10px;" class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text">목 록</span>
                      </a>        
            </div>
          </div>


          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">기본 정보</h6>
            </div>
            <div class="card-body">

            
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>ID</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="userid" value="<?php echo $value['userid'] ?>" readonly>
                  </div>
                </div>
                <div class="form-group row" id="new_password_div">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>새로운 비밀번호</h6>
                    <input type="password" class="form-control form-control-user" id="new_password" >
                  </div>
                </div>
                <div class="form-group row" id="confirm_password_div">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>비밀번호 확인</h6>
                    <input type="password" class="form-control form-control-user" id="confirm_password" onchange= confirm_password(); >
                  </div>
                  <div id="confirm_no"  style="margin-top:35px; display:none">
                    <h6 style="color:red;">비밀번호가 일치하지 않습니다.</h6>
                  </div>
                  <div id="confirm_yes"  style="margin-top:35px; display:none">
                    <h6 style="color:green;">비밀번호가 일치합니다.</h6>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>권한</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="access_name" value="<?php echo $value['access_name'] ?>" readonly>
                  </div>
                </div>
                <div class="form-group row" id="access_code_div">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>권한 변경</h6>
                    <select id="access_code" class="form-control form-control-user">
                      <option value='<?php echo $value['access_code'] ?>' selected><?php echo $value['access_name'] ?></option>
                      <option disabled="disabled" >------------------</option>
                      <option value='0'>읽기전용</option>
                      <option value='1'>제어가능</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>담당 지역</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="location" value="<?php echo $value['location'] ?>" readonly>
                  </div>
                </div>
                <div class="form-group row" id="groupid_div">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>담당 지역 변경</h6>
                  
                    <select id="groupid" class="form-control form-control-user">
                      <option value='<?php echo $value['groupid'] ?>' selected><?php echo $value['location'] ?></option>
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
                    <input type="text" class="form-control form-control-user" id="etc" value="<?php echo $value['etc'] ?>" >
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
window.onload = function () { 

var userID = $("#userID").val();
var userid = $("#userid").val();
var delete_btn = document.getElementById("delete_btn");
var modify_btn = document.getElementById("modify_btn");
var new_password = document.getElementById("new_password_div");
var confirm_password = document.getElementById("confirm_password_div");
var access_code = document.getElementById("access_code_div");
var groupid = document.getElementById("groupid_div");
var etc = document.getElementById("etc");
if(userID == userid || userID == 'admin')
{
  modify_btn.style.display = "inline";
  delete_btn.style.display = "inline";
}
else{
  new_password.style.display = "none";
  confirm_password.style.display = "none";
  access_code.style.display = "none";
  groupid.style.display = "none";
  etc.readOnly = "true";
}
}

function modify(){
  var id = $("#id").val();
  var access_code = $("#access_code").val();
  var groupid = $("#groupid").val();
  var etc = $("#etc").val();
  var userID = $("#userID").val();
  var sessID = $("#sessID").val();
  var new_password = $("#new_password").val();
  var confirm_password = $("#confirm_password").val();
  var confirm_no = document.getElementById("confirm_no");
  var confirm_yes = document.getElementById("confirm_yes");

  if(new_password != confirm_password)
    {
      alert("비밀번호를 확인해 주세요.");
    }
    else {
      if(confirm("수정하시겠습니까?")== true){
		    location.replace("./userModify.php?id="+id+"&new_password="+new_password+"&access_code="+access_code+"&groupid="+groupid+"&etc="+etc+"&userID="+userID+"&sessID="+sessID);  
      }
      else{
      } 
    } 
}

function user_delete(){
  var userID = $("#userID").val();
  var sessID = $("#sessID").val();
  var id = $("#id").val();
  if(confirm("삭제하시겠습니까?")== true){
		location.replace("./userDelete.php?id="+id+"&userID="+userID+"&sessID="+sessID);  
	}
	else{
	} 
}

function confirm_password()
{
  var new_password = $("#new_password").val();
  var confirm_password = $("#confirm_password").val();
  var confirm_no = document.getElementById("confirm_no");
  var confirm_yes = document.getElementById("confirm_yes");

    if(new_password == "" && confirm_password == "")
    {
      confirm_no.style.display = "none";
      confirm_yes.style.display = "none";
    }
    else {
        if(new_password != confirm_password)
      {
        confirm_no.style.display = "inline";
        confirm_yes.style.display = "none";
      }
      else {
        confirm_no.style.display = "none";
        confirm_yes.style.display = "inline";
      }
    }  
    
}

function back_page(){
  var f = document.frm_user;
	f.action = "./userList.php";
	f.submit();
}
</script>