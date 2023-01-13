<?php
require_once 'header.php';
$userID = $_REQUEST["userID"];
$sessID = session_id();
$tmp = $conn->prepare("INSERT INTO `fapl`.`lgu_sess` (`sess_key`, `userid`, `time`) VALUES (?, ?, NOW());");  
$tmp->bind_param('ss', $sessID, $userID);
$tmp->execute();  
$tmp->free_result();
$tmp->close();

require_once 'footer.php';
?>


