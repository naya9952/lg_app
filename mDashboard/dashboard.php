<?php
require_once 'header.php';
require_once 'loginCheck.php';
$userID = $_REQUEST["userID"];
$sessID = $_REQUEST["sessID"];
$sql="select a.id, a.ime, a.flg, a.cnt, a.eventtime, a.historytime, b.state, b.temperature, b.rssi";
$sql.=" from (";
$sql.=" select a.id, a.ime, a.cnt, a.flg, a.eventtime, max(b.dtime) as historytime, max(b.id) as historyid";
$sql.=" from (select a.id, a.ime, a.flg, count(c.ime) as cnt, max(c.dtime) as eventtime";
$sql.=" from lgu a";
$sql.=" left OUTER join lgu_event c on (a.ime=c.ime and c.dtime > subdate(now(), 20))";
$sql.=" group by a.id, a.ime) a";
$sql.=" left OUTER join lgu_history b on (a.ime=b.ime and b.dtime > subdate(now(), 20))";
$sql.=" group by a.id, a.ime, a.cnt, a.eventtime";
$sql.=" ) a left outer join lgu_history b on (a.ime=b.ime and a.historytime=b.dtime and a.historyid=b.id)";
$sql.=" where a.flg=1 order by a.id asc";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, true);
$stmt->free_result();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
<script src='http://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js'></script>  
      <link rel="stylesheet" href="./css/mstyle.css">
</head>
<body>
  <ul class="hexagon-grid-container">
<?php
    $idx = 0;
    foreach ($row as $value) {
        $tempColor = "gray";
        $rssiColor = "gray";
        $cellColor = "gray";
        if($value['temperature'] != "") {
            $tempColor = getColor("temperature", $value['temperature'], null);
        }
        if($value['rssi'] != "") {
            $rssiColor = getColor("rssi", $value['rssi'], null);
        }
        $cellColor = getColor("state", $value['state'], null);

        if($value['state'] == 1){
            $stx = 'Run';//녹색
        }
        else if($value['state'] == 2){
            $stx = 'AC Fail';//보라
        }
        else if($value['state'] == 3){
            $stx = 'ELCB';//빨강
        }
        else if($value['state'] == 4){
            $stx = 'Relay Off';//남색
        }
        else{
            $stx = '?';//회색
        }
?>
	<li class="hexagon hexagon-<?=$cellColor?>" onclick="javascript:goControl('<?=$value['ime']?>');">
		<div class="hexagon-inner">
			<span class="hexagon-name" id="ime<?=$idx?>"><?=$value['ime']?></span>
			<span class="hexagon-metric-label" id="rev<?=$idx?>"><?=$value['historytime']?></span>
			<span class="hexagon-icon-left hexagon-icon-<?=$tempColor?>" id="tmp<?=$idx?>"><?=is_numeric($value['temperature'])?($value['temperature']/10):$value['temperature']?> °C</span>
			<span class="hexagon-icon-right hexagon-icon-<?=$rssiColor?>" id="rsi<?=$idx?>"><?=$value['rssi']?> dBm</span>
			<span class="hexagon-featured-score" id="stt<?=$idx?>"><?=$stx?></span>
		</div>
	</li>

<?php 
    $idx++;
    }
?>
</ul>  
<script type="text/javascript">
function goControl(ime) {
	window.open("./control.php?ime="+ime, "popup01", "'location=no, directories=no,resizable=no,status=no,toolbar=no,menubar=no, width=340,height=253,left=0, top=0, scrollbars=no'");
}

setTimeout(function() {
//    location.replace("dashboard.php?&userID=" + "<?php echo $userID?>" + "&sessID=" + "<?php echo $sessID?>" );
	var isMobile = <?php  echo isset($isMobile)?(IsNullOrEmptyString($isMobile)?"true":$isMobile):"true"?>;
	var currentDom01 = document.getElementById('refreshForm');
	if(isMobile) {
		currentDom01.action="dashboard.php";
	} else {
		currentDom01.action="dashboardPC.php";
	}
	currentDom01.submit();
//    refreshDashboard(isMobile);
}, 10000);
</script>
<script  src="./js/script.js"></script>  

</body>
<form name="refreshForm" id="refreshForm" method="post">
  	<input type="hidden" name="userID" id="userID" value="<?php echo($_REQUEST["userID"]);?>">
  	<input type="hidden" name="sessID" id="sessID" value="<?php echo($_REQUEST["sessID"]);?>">
        <a class="nav-link" href="javascript:document.getElementById('refreshForm').submit();">
</html>
<?php

function getColor($type, $value, $value2)
{
    $color = "";
    if($type == "temperature") {
        if($value >= 600) {
            $color = "red";
        } else if($value >= 500 && $value < 600) {
            $color = "orange";
        } else if($value >= 400 && $value < 500) {
            $color = "yellow";
        } else if($value >= 100 && $value < 400) {
            $color = "green";
        } else if($value >= 0 && $value < 100) {
            $color = "yellow";
        } else if($value < 0) {
            $color = "blue";
        }
    } else if($type == "rssi") {
        if($value > -70) {
            $color = "green";
        } else if($value >= -85 && $value < -70) {
            $color = "yellow";
        } else if($value >= -100 && $value < -85) {
            $color = "orange";
        } else if($value < -100) {
            $color = "red";
        }
    } else if($type == "state") {
        if($value == 0) {
            $color = "gray";
        } else if($value == 1) {
            $color = "green";
        } else if($value == 2) {
            $color = "pupple";
        } else if($value == 3) {
            $color = "red";
        } else if($value == 4) {
            $color = "blue";
        } else {
            $color = "gray";
        }
    } else if($type == "cell") {
        if($value == "green" && $value2 == "green") {
            $color = "green";
        } else if($value == "gray" && $value2 =="gray") {
            $color = "gray";
        } else if($value == "red" || $value2 =="red") {
            $color = "red";
        } else {
            $color = "yellow";
        }
    }
    return $color;
}


require_once 'footer.php';
?>