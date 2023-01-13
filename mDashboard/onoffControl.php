<?php
require_once 'header.php';
    // Reverse Control    
    $id = $_REQUEST['id'];
    $md = $_REQUEST['mode'];
    $ime = $_REQUEST['ime'];


    print_r($id);
    print_r($md);
    print_r($ime);
    print_r($_REQUEST['ime']);

    if($md < 3){
        $sql = 'UPDATE lgu SET reset=? WHERE ime=?';
//         $sql = 'UPDATE lgu SET reset='.$md.' WHERE id='.$id;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('is', $md, $ime);
    }
    else{
        $sql = 'UPDATE lgu SET rssi_ctl=1 WHERE ime=?';
//         $sql = 'UPDATE lgu SET rssi_ctl=1 WHERE id='.$id;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $ime);
    }
    $stmt->execute();

    $stmt->free_result();
    $stmt->close();
    
    require_once 'footer.php';
?>
