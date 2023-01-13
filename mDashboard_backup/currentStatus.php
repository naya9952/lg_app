<?php
require_once 'header.php';
$ime = $_REQUEST['ime'];

// require_once 'loginCheck.php';
$sql="select a.id, a.ime, b.state, '', b.temperature, b.rssi, a.historytime, a.desc";//, a.cnt, a.eventtime";
$sql.=" from (";
$sql.=" select a.id, a.desc, a.ime, a.cnt, a.eventtime, max(b.dtime) as historytime, max(b.id) as historyid";
$sql.=" from (select a.id, a.desc, a.ime, count(c.ime) as cnt, max(c.dtime) as eventtime";
$sql.=" from lgu a";
$sql.=" left OUTER join lgu_event c on (a.ime=c.ime and c.dtime > subdate(now(), 20))";
$sql.=" group by a.id, a.desc, a.ime) a";
$sql.=" left OUTER join lgu_history b on (a.ime=b.ime and b.dtime > subdate(now(), 20))";
$sql.=" group by a.id, a.desc, a.ime, a.cnt, a.eventtime";
$sql.=" ) a left outer join lgu_history b on (a.ime=b.ime and a.historytime=b.dtime and a.historyid=b.id)";
$sql.=" where a.ime=?";
// echo $sql;
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $ime);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, false);
//print_r($row);
echo json_encode($row);
$stmt->free_result();
$stmt->close();
require_once 'footer.php';
?>