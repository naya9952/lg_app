<?php
//작업 이력 추가 코드
require_once 'header.php';
//require_once 'loginCheck.php';
$userID = $_REQUEST["userid"];
$ime = $_REQUEST["ime_c"];
$desc = $_REQUEST["desc"];
$work_code = $_REQUEST["work_code"];
$userID = $_REQUEST["userID"];
$sessID = $_REQUEST["sessID"];
$tmp = $conn->prepare("INSERT INTO lgu_work (`userid`, `ime`, `dtime`, `desc`, `work_code`, `filename`) VALUES (?, ?, now(), ?,?, 'basic');");  
$tmp->bind_param('sssi', $userID, $ime, $desc, $work_code);
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
