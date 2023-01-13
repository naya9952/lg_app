<?php
require_once 'header.php';
$userID = $_REQUEST["userID"];
$sessID = $_REQUEST["sessID"];
$sql = "select EXISTS (select * from lgu_sess where sess_key=? and userid=?) as success;";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $sessID, $userID);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, false);
if($row[0][0] == 0) {
echo "세션이 만료되었습니다. 다시 로그인 해주십시오.";
    exit();
}
else {
    //로그인 성공이벤트 필요하면 여기에 코드삽입
}
?>
