<?php
    $conn = mysqli_connect('localhost','root','Test123$','mysql');
    $sql = "SELECT * FROM user;";
    $result = MYSQLI_QUERY($conn, $sql);
    $row = mysqli_fetch_all($result);
    echo json_encode($row);
    $result->free();
?>
