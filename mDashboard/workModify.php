<?php
//작업이력 수정 코드
require_once 'header.php';
//require_once 'loginCheck.php';
$id = $_REQUEST["id"];
$ime = $_REQUEST["ime_c"];
$desc = $_REQUEST["desc"];
$work_code = $_REQUEST["work_code"];
$userID = $_REQUEST["userID"];
$sessID = $_REQUEST["sessID"];
$tmp = $conn->prepare("UPDATE lgu_work SET `desc`=?, modi_dtime=now(), work_code=?  WHERE id=?;");  
$tmp->bind_param('sii', $desc, $work_code, $id);
$tmp->execute();  
$tmp->free_result();
$tmp->close();

require_once 'footer.php';
	echo "<html>\n";
	echo "<body onload='document.form1.submit();'>\n";
	echo "<form name='form1' method='post' action='./workInfo.php'>\n";
    echo "<input type='hidden' name='ime_c' value=".$ime.">\n";
    echo "<input type='hidden' name='id' value=".$id.">\n";
    echo "<input type='hidden' name='userID' value=".$userID.">\n";
    echo "<input type='hidden' name='sessID' value=".$sessID.">\n";
	echo "</form>\n";
	echo "</body>\n";
	echo "</html>"; 
?>


