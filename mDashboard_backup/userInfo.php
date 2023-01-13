<?php
require_once 'header.php';
$userID = $_REQUEST["userID"];
$sessID = $_REQUEST["sessID"];
require_once 'loginCheck.php';
$sql = "select u.userid, u.access as access_code, if( u.access = 1, '제어가능', '읽기전용' ) as access_name ,g.groupid as location_code, g.desc as location , u.desc as etc  from lgu_user as u join lgu_group as g ON u.groupid = g.groupid where userid=?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $userID);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, true);
if(count($row) > 0) {
    echo json_encode($row, JSON_UNESCAPED_UNICODE);
} else {
    echo NULL;
}
$stmt->free_result();
$stmt->close();

