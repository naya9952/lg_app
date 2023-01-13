<?php
require_once 'header.php';
$ime = $_REQUEST["ime_input"];
//echo $ime;
$tmp = $conn->prepare("INSERT INTO lgu_ime_images (`filename`, `ime`, `dtime`) VALUES ('basic', ?, now());");  
$tmp->bind_param('s', $ime);
$tmp->execute();  
$tmp->free_result();
$tmp->close();

?>