<?php

//workList excel로 내보내기
require_once 'header.php';
$sessID = $_REQUEST["sessID"];
require_once 'loginCheck.php';
header('Content-Type: application/vnd.ms-excel');
header('Content-type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename=dev_event'.date("YmdHis").'.xls');
header('Content-Description: PHP4 Generated Data' );
$sql="select *,CASE state WHEN '0' THEN 'OFF' WHEN '1' THEN '정상동작' WHEN '2' THEN 'AC정전' WHEN '3' THEN 'ELCB TRIP' ELSE 'Relay OFF' END as 'state' from lgu_event order by id desc limit 1000;";

$stmt = $conn->prepare($sql);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, true);
$stmt->free_result();
$stmt->close();
              $EXCEL_FILE  = "<table border=1 width=100% cellspacing=0>";
              $EXCEL_FILE .= "<thead>";
              $EXCEL_FILE .= "<tr>";
              $EXCEL_FILE .= "<th bgcolor=yellow>시간</th>";
              $EXCEL_FILE .= "<th bgcolor=yellow>IME</th>";
              $EXCEL_FILE .= "<th bgcolor=yellow>상태</th>";
              $EXCEL_FILE .= "<th bgcolor=yellow>비고</th>";
              $EXCEL_FILE .= "</tr>";
              $EXCEL_FILE .= "</thead>"; 
              $EXCEL_FILE .= "<tbody>"; 
              $EXCEL_FILE .= "<tr>";
              if(count($row) > 0) {
                foreach ($row as $key => $value){
                    if(count($row) > 0){
                        $EXCEL_FILE .= "<td>".$value['dtime']."</td>";
                        $EXCEL_FILE .= "<td>".$value['ime']."&nbsp</td>";
                        $EXCEL_FILE .= "<td>".$value['state']."</td>";
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
echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'> ";
echo $EXCEL_FILE;


?>