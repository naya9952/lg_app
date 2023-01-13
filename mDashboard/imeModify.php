<?php
//장비 정보 수정 코드
require_once 'header.php';
//require_once 'loginCheck.php';
$ime = $_REQUEST["ime"];
$groupid = $_REQUEST["groupid"];
$desc = $_REQUEST["desc"];
$userID = $_REQUEST["userID"];
$sessID = $_REQUEST["sessID"];
$tmp = $conn->prepare("UPDATE lgu SET groupid=?, `desc`=?  WHERE ime=?;");  
$tmp->bind_param('iss', $groupid, $desc, $ime);
$tmp->execute();  
$tmp->free_result();
$tmp->close();
require_once 'footer.php';
//Header("Location:./imeInfo.php?ime=".$ime); 

    echo "<html>\n";
	echo "<body onload='document.form1.submit();'>\n";
	echo "<form name='form1' method='post' action='./imeInfo.php'>\n";
    echo "<input type='hidden' name='ime_c' value=".$ime.">\n";
    echo "<input type='hidden' name='userID' value=".$userID.">\n";
    echo "<input type='hidden' name='sessID' value=".$sessID.">\n";
	echo "</form>\n";
	echo "</body>\n";
	echo "</html>";
?>



