<?php
//사용자 정보 수정 코드
require_once 'header.php';
//require_once 'loginCheck.php';
$id = $_REQUEST["id"];
$ime = $_REQUEST["ime"];
$userID = $_REQUEST["userID"];
$sessID = $_REQUEST["sessID"];
$tmp = $conn->prepare("UPDATE lgu_work SET flg=0  WHERE id=?;");  
$tmp->bind_param('i', $id);
$tmp->execute();  
$tmp->free_result();
$tmp->close();

require_once 'footer.php';
    //Header("Location:./imeInfo.php?ime=".$ime); 
    echo "<html>\n";
	echo "<body onload='document.form1.submit();'>\n";
	echo "<form name='form1' method='post' action='./imeInfo.php'>\n";
    echo "<input type='hidden' name='userID' value=".$userID.">\n";
    echo "<input type='hidden' name='sessID' value=".$sessID.">\n";
    echo "<input type='hidden' name='ime_c' value=".$ime.">\n";
	echo "</form>\n";
	echo "</body>\n";
	echo "</html>";
?>
