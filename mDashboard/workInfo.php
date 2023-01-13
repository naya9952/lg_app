<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>작업 내역 상세</title>

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
            $id = $_REQUEST["id"];
            $sessID = $_REQUEST["sessID"];
            require_once 'loginCheck.php';
            $sql = "select *, if( work_code = 0, '작업중', '작업완료' ) as work_name from lgu_work where id = ?;";
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
        <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h1 class="h3 mb-2 text-gray-800">작업 내역 상세</h1>
                    </div>
                    <div class="col-sm-6">
                      
                  </div>
                  
                </div>
          <!-- Page Heading -->
          <div class="card shadow mb-4">
          <form method="post" id="frm_ime" name="frm_ime">
                  <input type="hidden" name="userID" id="userID" value="<?php echo($_POST["userID"]);?>">
                  <input type="hidden" name="sessID" id="sessID" value="<?php echo($_POST["sessID"]);?>">
                  <input type="hidden" name="ime_c" id="ime_c" value="<?php echo($_POST["ime_c"]);?>">   
                  <input type="hidden" name="id" id="id" value="<?php echo($_POST["id"]);?>">
          </form>
            <div class="card-header py-3">
                      <a href="#" id="delete_btn" onclick="work_delete();" style="float:right; display:none;" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fas fa-trash"></i>
                        </span>
                        <span class="text">삭 제</span>
                      </a>
                      <a href="#" id="modify_btn" onclick="modify();" style="float:right; margin-right:10px; display:none;" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fas fa-pencil-alt"></i>
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
                    <h6>ime</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="ime" value="<?php echo $value['ime'] ?>" readonly>
                    <input type="hidden" id="ime_hidden" value="<?php echo $value['ime'] ?>">
                    <input type="hidden" id="id_hidden" value="<?php echo $value['id'] ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>최초 등록일</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="dtime" value="<?php echo $value['dtime'] ?>" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>최근 수정일</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="dtime" value="<?php echo $value['modi_dtime'] ?>" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>작업 내용</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="desc" value="<?php echo $value['desc'] ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>작업자</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="userid" value="<?php echo $value['userid']?>" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>작업 상태</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="work_name" value="<?php echo $value['work_name'] ?>" readonly>
                  </div>
                </div>
                <div class="form-group row" id="work_code_div">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>작업 상태 수정</h6>
                    <select id="work_code" class="form-control form-control-user">
                      <option value='<?php echo $value['work_code'] ?>' selected><?php echo $value['work_name'] ?></option>
                      <option disabled="disabled" >------------------</option>
                      <option value='0'>작업중</option>
                      <option value='1'>작업완료</option>
                    </select>
                  </div>
                </div>
            </div>
          </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">작업 사진</h6>
            </div>
            <div class="card-body">
                <div class="my-2">
                  <div>
                    <img style="margin-bottom: 5px; border: 3px solid black; border-radius:
                     7px; -moz-border-radius: 7px; -khtml-border-radius: 7px; -webkit-border-radius: 7px; 
                     "src=../work_Image/<?php echo$value['filename']?> width='305' height='300'/>
                  </div>
                  <form action="workImageModify.php" method="post" enctype="multipart/form-data">
                    <input  type="hidden" name="id" id="id" value="<?php echo $value['id'] ?>">
                    <input type="hidden" name="Image_userID" id="userID" value="<?php echo($_POST["userID"]);?>">
                    <input type="hidden" name="Image_sessID" id="sessID" value="<?php echo($_POST["sessID"]);?>">
                    <input  type="hidden" name="Image_ime" id="ime" value="<?php echo $value['ime'] ?>">
                    <label for="fileToUpload" id="find_image_label" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fas fa-image"></i>
                        </span>
                        <span class="text">이미지 찾기</span>
                      </label>
                      <input type="file" accept="image/*" class="modal" name="fileToUpload" id="fileToUpload" onchange= selectImage();>
                    <label for="image_submit"  class="btn btn-secondary btn-icon-split" id="image_label">
                        <span class="icon text-white-50">
                          <i class="fas fa-exchange-alt"></i>
                        </span>
                        <span class="text">이미지 변경</span>
                      </label>
                      <input type="submit" onclick= imageChange(); class="modal" value="이미지 변경" name="submit" id="image_submit" disabled>
                  </form>
                  <div class="form-group row" id="file_name_div">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                      <h6>선택한 파일</h6>
                      <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="file_name" readonly>
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
var desc = document.getElementById("desc");
var work_code_div = document.getElementById("work_code_div");
var find_image_label = document.getElementById("find_image_label");
var image_label = document.getElementById("image_label");
var file_name_div = document.getElementById("file_name_div");

if(userID == userid || userID == 'admin')
  {
    modify_btn.style.display = "inline";
    delete_btn.style.display = "inline";
  }
else{
    work_code_div.style.display = "none";
    desc.readOnly = "true";
    find_image_label.style.display = "none";
    image_label.style.display = "none";
    file_name_div.style.display = "none";
  }
}

function modify(){
  var id = $("#id").val();
  var ime = $("#ime_c").val();
  var desc = $("#desc").val();
  var work_code = $("#work_code").val();
  var userID = $("#userID").val();
  var sessID = $("#sessID").val();
  if(confirm("수정하시겠습니까?")== true){
		location.replace("./workModify.php?id="+id+"&desc="+desc+"&work_code="+work_code+"&userID="+userID+"&sessID="+sessID+"&ime_c="+ime);  
		}
	else{
		}
  
}

function work_delete(){
  var ime = $("#ime_hidden").val();
  var id = $("#id_hidden").val();
  var userID = $("#userID").val();
  var sessID = $("#sessID").val();
  if(confirm("삭제하시겠습니까?")== true){
		location.replace("./workDelete.php?ime="+ime+"&id="+id+"&userID="+userID+"&sessID="+sessID);  
		}
	else{
		}
  
}

function imageChange(){
 alert("이미지가 변경되었습니다.");
}

function selectImage(){
  var image_name = $("#fileToUpload").val();
  var button_joinus = document.getElementById('image_submit');
  var label_image = document.getElementById('image_label');
  var file_name = document.getElementById('file_name');
  button_joinus.disabled = false;
  label_image.className= "btn btn-success btn-icon-split";
  file_name.value= image_name;
}

function back_page(){
  var f = document.frm_ime;
	f.action = "./imeInfo.php";
	f.submit();
}
</script>