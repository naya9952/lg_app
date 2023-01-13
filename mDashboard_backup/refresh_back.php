<?php
require_once 'header.php';
//DB 연결 헤더Load
//require_once 'loginCheck.php';
$ime = $_REQUEST["ime"];
$id = $_REQUEST["id"];

$COMF = "select * from (select id from lgu_history where ime=? order by id desc limit 1) as a order by id asc;";
$stmt2 = $conn->prepare($COMF);
$stmt2->bind_param('i', $ime);
$stmt2->execute();
$row2 = get_stmt_assoc_array($stmt2, true); // true = key:value 값으로 나타남 || flase 시 값만 표시함
$stmt2->free_result();
$stmt2->close();
$str = strcmp($id, $row2);
//최신 마지막 데이터 값 얻기

foreach ($row2 as $key => $value){
    $strA = $value['id'];
    //비교 할 기존 마지막 데이터 값 
};

$str = strcmp($id, $strA);
if($str) {
    $sql = "select * from (select * from lgu_history where ime=? and dtime > subdate(NOW(), interval 30 day) order by id desc limit 20) as a order by id asc;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $ime);
    $stmt->execute();
    $row = get_stmt_assoc_array($stmt, false);
    $array = array();
    echo json_encode($row);
    $stmt->free_result();
    $stmt->close();
    //최신 마지막 데이터와 기존 마지막 데이터 값이 다를 경우 최신 데이터 그래프에 작성
}
else {
    echo json_encode(NULL);
    //최신 마지막 데이터와 기존 마지막 데이터의 값이 같음 (그래프 그림x)
}

?>