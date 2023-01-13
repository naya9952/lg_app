<?php
//사용자 정보 수정 코드
require_once 'header.php';
//require_once 'loginCheck.php';
$ime = $_REQUEST["ime"];
$userID = $_REQUEST["userID"];
$sessID = $_REQUEST["sessID"];
$tmp = $conn->prepare("UPDATE lgu SET flg=0  WHERE ime=?;");  
$tmp->bind_param('s', $ime);
$tmp->execute();  
$tmp->free_result();
$tmp->close();

require_once 'ImageDelete.php';
require_once 'footer.php';
//Header("Location:./imeList.php?"); 
    echo "<html>\n";
	echo "<body onload='document.form1.submit();'>\n";
	echo "<form name='form1' method='post' action='./imeList.php'>\n";
    echo "<input type='hidden' name='userID' value=".$userID.">\n";
    echo "<input type='hidden' name='sessID' value=".$sessID.">\n";
	echo "</form>\n";
	echo "</body>\n";
	echo "</html>";
?>
