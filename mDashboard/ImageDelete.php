<?php
require_once 'header.php';
$ime = $_REQUEST["ime"];

$sql = "select filename from lgu_ime_images where ime=".$ime.";";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, true);
if(count($row) > 0) {
    foreach ($row as $key => $value){
        $deleteFilename = $value['filename'];
    };
} else {
    echo NULL;
}
$stmt->free_result();
$stmt->close();


 //기존 파일 삭제
 if($deleteFilename != "basic")
 {
    if( !unlink('../ime_Image/'. $deleteFilename) ) {
        //echo "failed\n";
    }
    else {
        //echo "success\n";
    }
 }

$tmp = $conn->prepare("UPDATE lgu_ime_images SET filename='basic', flg=0 WHERE ime=?;");  
$tmp->bind_param('s', $ime);
$tmp->execute();  
$tmp->free_result();
$tmp->close();


?>