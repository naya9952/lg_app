<?php
//특정 작업 이력 리스트 코드
require_once 'header.php';
$ime = $_POST["ime_c"];
//$sessID = $_REQUEST["sessID"];
//require_once 'loginCheck.php';
$sql = "select *, if( work_code = 0, '작업중', '작업완료' ) as work_name from lgu_work where ime=? order by id desc;";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $ime);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, true);
?>
          <form method="post" id="frm_work" name="frm_work">
                  <input type="hidden" name="userID" id="userID" value="<?php echo($_POST["userID"]);?>">
                  <input type="hidden" name="sessID" id="sessID" value="<?php echo($_POST["sessID"]);?>">
                  <input type="hidden" name="ime_c" id="ime_c" value="<?php echo($_POST["ime_c"]);?>">
                  <input type="hidden" name="id" id="id">    
          </form>
<div class="card-body">
              <div class="table-responsive">
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>IME</th>
                      <th>작업내용</th>
                      <th>작업자</th>
                      <th>작업상태</th>
                      <th>최초 등록일</th>
                      <th>최근 수정일</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  if(count($row) > 0) {
                    foreach ($row as $key => $value){
                        if($value['flg'] != 0){
                          ?>
                          <tr style="cursor: pointer;" onMouseOver="this.style.backgroundColor='#e0f5fe'" 
                            onMouseOut="this.style.backgroundColor='#ffffff'" onclick="work_info('<?php echo $value['id'];?>')" >
                          <?php
                            echo "<td>".$value['id']."</td>";
                            echo "<td>".$value['ime']."</td>";
                            echo "<td>".$value['desc']."</td>";
                            echo "<td>".$value['userid']."</td>";
                            echo "<td>".$value['work_name']."</td>";
                            echo "<td>".$value['dtime']."</td>";
                            echo "<td>".$value['modi_dtime']."</td>";
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
<script type="text/javascript">

function work_info(id){
  var f = document.frm_work;
  var id_i = document.getElementById('id');
  id_i.value= id;
	f.action = "./workInfo.php";
	f.submit();
}
</script>