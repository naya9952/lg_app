<?php
    $mysqlip = "10.10.12.101";
    //DB IP
    $mysqlTableSpace = "fapl";
    ///DB NAME
    $mysqlUserId = "root";
    //DB user ID
    $mysqlUserPass = "Test123$";
    //DB user Password
    
    $conn = new mysqli($mysqlip,$mysqlUserId,$mysqlUserPass,$mysqlTableSpace);
    function get_stmt_assoc_array($stmt, $isKeyValue)
    {
        $row = array();
        $result = array();
        if($isKeyValue == true) {
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result'), $params);
            while ($stmt->fetch()) {
                foreach($row as $key => $val)
                {
                    $c[$key] = $val;
                }
                $result[] = $c;
            }
        } else {
            $tmp = $stmt->get_result();
            $result = mysqli_fetch_all($tmp);
        }
        return $result;
    }
?>