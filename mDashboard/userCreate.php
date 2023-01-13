<?php
//사용자 추가 코드
require_once 'header.php';
//require_once 'loginCheck.php';
$userID = $_REQUEST["userid_input"];
$Password = $_REQUEST["new_password_input"];
$Access = $_REQUEST["access_code_input"];
$groupID = $_REQUEST["groupid_input"];
$DESC = $_REQUEST["etc_input"];
$userID_c = $_REQUEST["userID"];
$sessID = $_REQUEST["sessID"];

$sql = "select EXISTS (select * from lgu_user where userid=?) as success;";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $userID);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, true);

if(count($row) > 0) {
    foreach ($row as $key => $value){
		if($value['success'] == '1')
		{
			echo "<html>\n";
			echo "<script type='text/javascript'>\n";
			echo "alert('이미 존재하는 아이디 입니다.');\n";
			echo "history.back()\n";
			echo "</script>\n";
			echo "</html>";


		}
		else{
			$tmp = $conn->prepare("INSERT INTO lgu_user (`userid`, `password`, `access`, `groupid`, `desc`) VALUES (?, sha1(?), ?, ?, ?);");  
			$tmp->bind_param('ssiis', $userID, $Password, $Access, $groupID, $DESC);
			$tmp->execute();  
			$tmp->free_result();
			$tmp->close();
			
			require_once 'footer.php';
			echo "<html>\n";
			echo "<body onload='document.form1.submit();'>\n";
			echo "<form name='form1' method='post' action='./userList.php'>\n";
			echo "<input type='hidden' name='userID' value=".$userID_c.">\n";
			echo "<input type='hidden' name='sessID' value=".$sessID.">\n";
			echo "</form>\n";
			echo "</body>\n";
			echo "</html>";
		}
	};
} else {
    echo NULL;
}




?>
