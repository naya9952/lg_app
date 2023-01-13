<?php
require_once 'header.php';
//require_once 'loginCheck.php';
$ime = $_REQUEST["ime"];
$id = $_REQUEST["id"];
$sql = "select id, ime, (case state when 0 then 'OFF' when 1 then '정상동작' when 2 then 'AC정전' when 3 then 'ELCB TRIP' when 4 then 'Relay OFF' else '미확인' END) as state, `desc`, dtime from lgu_event where ime=? and dtime > subdate(NOW(), interval 30 day) order by id desc limit 50;";
$cnt = 0;
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $ime);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, false);
$array = array();

// error_log(print_r($row, 1));
// error_log(count($row));
if(count($row)>0){
    if($row[0][0] == $id)
    {
    	echo json_encode(null);
    }
    else{
        echo json_encode($row);
    }
}
//echo json_encode(NULL);
$stmt->free_result();
$stmt->close();
?>