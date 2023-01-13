<?php
//사용자 정보 출력 코드
require_once 'header.php';
$userID = $_REQUEST["userID"];
$sessID = $_REQUEST["sessID"];
//require_once 'loginCheck.php';
$sql = "select * from lgu_event order by id desc limit 50;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, true);
if(count($row) > 0) {
    //foreach ($row as $key => $value){
    //};
    echo json_encode($row, JSON_UNESCAPED_UNICODE);
} else {
    echo NULL;
}
$stmt->free_result();
$stmt->close();
?>
