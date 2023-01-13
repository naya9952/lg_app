<?php
//장비를 추가하는 코드
require_once 'header.php';
//require_once 'loginCheck.php';
$ime = $_REQUEST["ime_input"];
$state = 0;
$reset = 0;
$temperature = 0;
$rssi = 0;
$groupid = $_REQUEST["groupid_input"];
$desc = $_REQUEST["desc_input"];
$rssi_ctl = $_REQUEST["rssi_ctl_input"];
$userID = $_REQUEST["userID"];
$sessID = $_REQUEST["sessID"];
$tmp = $conn->prepare("INSERT INTO lgu (`ime`, `state`, `reset`, `temperature`, `rssi`, `dtime`, `groupid`, `desc`, `rssi_ctl`) VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, ?);");  
$tmp->bind_param('siiiiisi', $ime, $state, $reset, $temperature, $rssi, $groupid, $desc, $rssi_ctl);
$tmp->execute();  
$tmp->free_result();
$tmp->close();

require_once 'ImageUpload_basic.php';
require_once 'footer.php';
//Header("Location:./imeInfo.php?ime_c=".$ime."&userID=".$userID."&sessID=".$sessID); 

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
