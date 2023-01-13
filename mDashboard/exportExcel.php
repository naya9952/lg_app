<?php

//workList excel로 내보내기
require_once 'header.php';
$sessID = $_REQUEST["sessID"];
require_once 'loginCheck.php';
header('Content-Type: application/vnd.ms-excel');
header('Content-type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename=dev_state'.date("YmdHis").'.xls');
header('Content-Description: PHP4 Generated Data' );

$sql="select a.id, a.ime,a.reset, a.dtime, a.flg, a.`desc`, CASE b.state WHEN '0' THEN 'OFF' WHEN '1' THEN '정상동작' WHEN '2' THEN 'AC정전' WHEN '3' THEN 'ELCB TRIP' ELSE 'Relay OFF' END as 'state', b.temperature, b.rssi";
$sql.=" from (";
$sql.=" select a.id, a.ime, a.cnt,a.reset, a.flg, a.dtime, a.`desc`, a.eventtime, max(b.dtime) as historytime, max(b.id) as historyid";
$sql.=" from (select a.id, a.ime, a.reset, a.flg, a.dtime, a.`desc`,count(c.ime) as cnt, max(c.dtime) as eventtime";
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
              $EXCEL_FILE  = "<table border=1 width=100% cellspacing=0>";
              $EXCEL_FILE .= "<thead>";
              $EXCEL_FILE .= "<tr>";
              $EXCEL_FILE .= "<th>ID</th>";
              $EXCEL_FILE .= "<th>IME</th>";
              $EXCEL_FILE .= "<th>상태</th>";
              $EXCEL_FILE .= "<th>RESET</th>";
              $EXCEL_FILE .= "<th>온도</th>";
              $EXCEL_FILE .= "<th>신호세기</th>";
              $EXCEL_FILE .= "<th>추가일자</th>";
              $EXCEL_FILE .= "<th>위치</th>";
              $EXCEL_FILE .= "</tr>";
              $EXCEL_FILE .= "</thead>"; 
              $EXCEL_FILE .= "<tbody>"; 
              $EXCEL_FILE .= "<tr>";
              if(count($row) > 0) {
                foreach ($row as $key => $value){
                    if($value['flg'] != 0){
                        $EXCEL_FILE .= "<td>".$value['id']."</td>";
                        $EXCEL_FILE .= "<td>".$value['ime']."&nbsp</td>";
                        $EXCEL_FILE .= "<td>".$value['state']."</td>";
                        $EXCEL_FILE .= "<td>".$value['reset']."</td>";
                        $EXCEL_FILE .= "<td>".($value['temperature']/10)."</td>";
                        $EXCEL_FILE .= "<td>".$value['rssi']."</td>";
                        $EXCEL_FILE .= "<td>".$value['dtime']."</td>";
                        $EXCEL_FILE .= "<td>".$value['desc']."</td>";
                        $EXCEL_FILE .= "</tr>";
                    }
                };
                $stmt->free_result();
                $stmt->close(); 
            } else {
                echo NULL;
            }
            $excel_content .= "</tbody>"; 
            $excel_content .= "</table>"; 
$EXCEL_FILE .= "</table>";
echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
echo $EXCEL_FILE;
?>