<?php
//사용자 정보 수정 코드
require_once 'header.php';
//require_once 'loginCheck.php';
$id = $_REQUEST["id"];
$userID = $_REQUEST["userID"];
$sessID = $_REQUEST["sessID"];
$tmp = $conn->prepare("UPDATE lgu_user SET flg=0  WHERE id=?;");  
$tmp->bind_param('i', $id);
$tmp->execute();  
$tmp->free_result();
$tmp->close();

require_once 'footer.php';
echo "<html>\n";
echo "<body onload='document.form1.submit();'>\n";
echo "<form name='form1' method='post' action='./userList.php'>\n";
echo "<input type='hidden' name='userID' value=".$userID.">\n";
echo "<input type='hidden' name='sessID' value=".$sessID.">\n";
echo "</form>\n";
echo "</body>\n";
echo "</html>";
?>
