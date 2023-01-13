<?php
//사용자 정보 수정 코드
require_once 'header.php';
//require_once 'loginCheck.php';


$id = $_REQUEST["id"];
$Password = $_REQUEST["new_password"];
$Access = $_REQUEST["access_code"];
$groupID = $_REQUEST["groupid"];
$DESC = $_REQUEST["etc"];
$userID = $_REQUEST["userID"];
$sessID = $_REQUEST["sessID"];
if($Password == '')
{
    $tmp = $conn->prepare("UPDATE lgu_user SET  access=?, groupid=?, `desc`=?  WHERE id=?;");  
    $tmp->bind_param('iisi',  $Access, $groupID, $DESC, $id);
    $tmp->execute();  
    $tmp->free_result();
    $tmp->close();
}
else
{
    $tmp = $conn->prepare("UPDATE lgu_user SET password=sha1(?), access=?, groupid=?, `desc`=?  WHERE id=?;");  
    $tmp->bind_param('siisi', $Password, $Access, $groupID, $DESC, $id);
    $tmp->execute();  
    $tmp->free_result();
    $tmp->close();
}

require_once 'footer.php';

    echo "<html>\n";
	echo "<body onload='document.form1.submit();'>\n";
	echo "<form name='form1' method='post' action='./userInfo2.php'>\n";
    echo "<input type='hidden' name='id' value=".$id.">\n";
    echo "<input type='hidden' name='userID' value=".$userID.">\n";
    echo "<input type='hidden' name='sessID' value=".$sessID.">\n";
	echo "</form>\n";
	echo "</body>\n";
	echo "</html>"; 
?>
