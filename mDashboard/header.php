<?php
    $mysqlip = "10.10.16.49";
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
    
    // $tmp = $conn->prepare("INSERT INTO lgu_event (id, ime, state, `desc`, dtime) VALUES((select a.id from (select max(id)+1 as id from lgu_event) a),(case FLOOR(0 + (RAND() * (10))) when 1 then '450061222990555' when 2 then '450061222990540'  when 3 then '450061222990590'  when 4 then '450061222990634'  when 5 then '450061222990797' when 6 then '450061222990757'  when 7 then '450061222990784'  when 8 then '450061222990588'  when 9 then '450061222990798'  when 10 then '450061222990603' end), FLOOR(0 + (RAND() * (5))), '설명입니다.', now())");
    // $tmp->execute();
    // $tmp->free_result();
    // $tmp->close();
    function IsNullOrEmptyString($str){
        return (!isset($str) || trim($str) === '');
    }
?>
