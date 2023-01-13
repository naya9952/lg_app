<?php
require_once 'header.php';

$tmp = $conn->prepare("delete from lgu_sess where time < subdate(NOW(), interval 24 hour);");  
$tmp->execute();  
$tmp->free_result();
$tmp->close();


?>


