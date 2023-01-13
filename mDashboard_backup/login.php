<?php
require_once 'header.php';
require_once 'sessOut.php';
$userID = $_REQUEST["userID"];
$userPass = $_REQUEST["userPass"];
$returnURL = $_REQUEST["returnURL"];
$ime = "";
$sql = "select userid, access, groupid from lgu_user where userid=? and password=sha1(?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $userID, $userPass);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, true);


if(count($row) > 0) {
    session_start();
    //DB에 저장 할 세션 값 얻어오기위해 임시로 세션 파일 생성
    $sessID = session_id();
    require_once 'creat_sess.php';
    $GLOBALS["userID"] = $userID;
    $GLOBALS['access'] = $row[0]['access'];
    $GLOBALS['groupid'] = $row[0]['groupid'];
    $row[0]['confirm'] = "OK";
    $row[0]['message'] =  "true";
    $row[0]['sessID'] =  $sessID;

    session_destroy(); 
    //서버에 임시로 생성된 세선 파일 삭제

} else {
    $GLOBALS["userID"] = $userID;
    $GLOBALS['access'] = $row[0]['access'];
    $GLOBALS['groupid'] = $row[0]['groupid'];
    $row[0]["confirm"] =  "false";
    $row[0]["message"] = iconv("EUC-KR", "UTF-8", "['ID/PASS를 정확히 입력하십시오.']");
    $row[0]['sessID'] =  null;
    
}
echo json_encode($row);
$stmt->free_result();
$stmt->close();
require_once 'footer.php';
error_log($sessID);
if(!IsNullOrEmptyString($returnURL)) {
    //header("Location: index.php?userID=".$userID."&sessID=".$sessID."&ime=".$ime);

    echo "<html>\n";
	echo "<body onload='document.form1.submit();'>\n";
	echo "<form name='form1' method='post' action='./index.php'>\n";
    echo "<input type='hidden' name='userID' value=".$userID.">\n";
    echo "<input type='hidden' name='sessID' value=".$sessID.">\n";
    //echo "<input type='hidden' name='ime' value=".$ime.">\n";
	echo "</form>\n";
	echo "</body>\n";
	echo "</html>"; 
    exit();
}
?>


