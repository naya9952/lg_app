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

        <?php
            //사용자 정보 출력 코드
            require_once 'header.php';
            $ime = $_REQUEST["ime_c"];
            $sessID = $_REQUEST["sessID"];
            require_once 'loginCheck.php';
            $sql="select a.id, a.ime, a.reset, a.dtime, a.flg, a.`desc`, a.groupid, CASE b.state WHEN '0' THEN 'OFF' WHEN '1' THEN '정상동작' WHEN '2' THEN 'AC정전' WHEN '3' THEN 'ELCB TRIP' ELSE 'Relay OFF' END as 'state', b.temperature, b.rssi";
            $sql.=" from (";
            $sql.=" select a.id, a.ime, a.cnt,a.reset, a.flg, a.dtime, a.`desc`, a.eventtime, a.groupid, max(b.dtime) as historytime, max(b.id) as historyid";
            $sql.=" from (select a.id, a.ime, a.reset, a.flg, a.dtime, a.`desc`, a.groupid, count(c.ime) as cnt, max(c.dtime) as eventtime";
            $sql.=" from lgu a";
            $sql.=" left OUTER join lgu_event c on (a.ime=c.ime and c.dtime > subdate(now(), 20))";
            $sql.=" group by a.id, a.ime) a";
            $sql.=" left OUTER join lgu_history b on (a.ime=b.ime and b.dtime > subdate(now(), 20))";
            $sql.=" group by a.id, a.ime, a.cnt, a.eventtime";
            $sql.=" ) a left outer join lgu_history b on (a.ime=b.ime and a.historytime=b.dtime and a.historyid=b.id)";
            $sql.=" where a.ime=? order by a.id asc";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $ime);
            $stmt->execute();
            $row = get_stmt_assoc_array($stmt, true);
            $stmt->free_result();
            $stmt->close();

            $sql="select filename from lgu_ime_images where ime=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $ime);
            $stmt->execute();
            $row2= get_stmt_assoc_array($stmt, true);
            
            $stmt->free_result();
            $stmt->close();
            if(count($row) > 0) {
                foreach ($row as $key => $value){
                };
            } else {
                echo NULL;
            }
            if(count($row2) > 0) {
              foreach ($row2 as $key => $value_image){
              };
            } else {
                echo NULL;
            }
            ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
        <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h1 class="h3 mb-2 text-gray-800">디바이스 상세</h1>
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
          </form>
            <div class="card-header py-3">
            <?php require_once 'header.php';
                  require_once 'loginCheck.php'; ?>
                      <a href="#" id="delete_btn" onclick="ime_delete();" style="float:right; display:none;" class="btn btn-danger btn-icon-split">
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

            


            <form method="post" id="frm_ime_modi" name="frm_ime_modi">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>ime</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="ime" value="<?php echo $value['ime'] ?>" readonly>
                    <input type="hidden" id="ime_hidden" value="<?php echo $value['ime'] ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>등록일</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="dtime" value="<?php echo $value['dtime'] ?>" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>상태</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="state" value="<?php echo $value['state'] ?>" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>온도</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="temperature" value="<?php echo ($value['temperature']/10) ?>" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>신호세기</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="rssi" value="<?php echo $value['rssi'] ?>" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>위치</h6>
                    <input type="text" class="form-control form-control-user" id="desc" value="<?php echo $value['desc'] ?>">
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                  <a href="https://v4.map.naver.com/?query= <?php echo $value['desc'] ?>" target="_blank" style="float:left; margin-top:26px;" class="btn btn-info btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fas fa-map-marked-alt"></i>
                        </span>
                        <span class="text">위치보기</span>
                      </a>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>reset</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="reset" value="<?php echo $value['reset'] ?>" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>그룹ID</h6>
                    <input type="text" class="form-control form-control-user" id="groupid" value="<?php echo $value['groupid'] ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>rssi_ctl</h6>
                    <input type="text" style="font-weight:bold;" class="form-control form-control-user" id="rssi_ctl" value="<?php echo $value['rssi_ctl'] ?>" readonly>
                  </div>
                </div>
            </form>


            </div>
          </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">디바이스 사진</h6>
            </div>
            <div class="card-body">
                <div class="my-2">
                  <div>
                    <img style="margin-bottom: 5px; border: 3px solid black; border-radius:
                     7px; -moz-border-radius: 7px; -khtml-border-radius: 7px; -webkit-border-radius: 7px; 
                     "src=../ime_Image/<?php echo$value_image['filename']?> width='305' height='300'/>
                  </div>
                  <form action="ImageModify.php" method="post" enctype="multipart/form-data">
                    <input  type="hidden" name="Image_ime" id="ime" value="<?php echo $value['ime'] ?>">
                    <input type="hidden" name="Image_userID" id="userID" value="<?php echo($_POST["userID"]);?>">
                    <input type="hidden" name="Image_sessID" id="sessID" value="<?php echo($_POST["sessID"]);?>">
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
          
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">작업 내역</h6>
            </div>
            

            
            <div class="card-body">

            <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="#" onclick="work_create();" style="float:right;" class="btn btn-success btn-icon-split">
                  <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                  </span>
                  <span class="text">등 록</span>
                </a>
                </div></div>

                <div class="my-2"></div>
                <?php require_once 'workList.php';?>
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
var delete_btn = document.getElementById("delete_btn");
var modify_btn = document.getElementById("modify_btn");
var groupid = document.getElementById("groupid");
var desc = document.getElementById("desc");

var find_image_label = document.getElementById("find_image_label");
var image_label = document.getElementById("image_label");
var file_name_div = document.getElementById("file_name_div");
if(userID == 'admin') {
    modify_btn.style.display = "inline";
    delete_btn.style.display = "inline";
  }
else {
    groupid.readOnly = "true";
    desc.readOnly = "true";
    find_image_label.style.display = "none";
    image_label.style.display = "none";
    file_name_div.style.display = "none";
  }
}

function modify(){
  var ime = $("#ime_hidden").val();
  var desc = $("#desc").val();
  var groupid = $("#groupid").val();
  var userID = $("#userID").val();
  var sessID = $("#sessID").val();
  if(confirm("수정하시겠습니까?")== true){
		location.replace("./imeModify.php?ime="+ime+"&desc="+desc+"&groupid="+groupid+"&userID="+userID+"&sessID="+sessID);  
		}
	else{
		}
  
}

function ime_delete(){
  var ime = $("#ime_hidden").val();
  var userID = $("#userID").val();
  var sessID = $("#sessID").val();
  if(confirm("삭제하시겠습니까?")== true){
		location.replace("./imeDelete.php?ime="+ime+"&userID="+userID+"&sessID="+sessID);  
	}
	else{
	} 
}

function work_create(){
  var f = document.frm_ime;
	f.action = "./workCreateForm.php";
	f.submit();	 
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
	f.action = "./imeList.php";
	f.submit();
}
</script>