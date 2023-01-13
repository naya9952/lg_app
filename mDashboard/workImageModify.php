<?php
$target_dir = "../work_Image/";
require_once 'header.php';
$file_name = sha1(date("YmdHis"));
$rand = strtoupper(substr(uniqid(sha1(time())),0,5));
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$savefile = $target_dir . $file_name;
$id = $_POST["id"];
$ime = $_POST["Image_ime"];
$userID = $_POST["Image_userID"];
$sessID = $_POST["Image_sessID"];

$sql = "select filename from lgu_work where id=".$id.";";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = get_stmt_assoc_array($stmt, true);
if(count($row) > 0) {
    foreach ($row as $key => $value){
        $deleteFilename = $value['filename'];
    };
} else {
    echo NULL;
}
$stmt->free_result();
$stmt->close();


//기존 파일 삭제
if($deleteFilename != "basic")
{
    if( !unlink('../work_Image/'. $deleteFilename) ) {
        //echo "failed\n";
    }
    else {
        //echo "success\n";
    }
}

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "파일을 찾을 수 없습니다.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "죄송합니다. 이미 같은 이름의 파일이 존재합니다.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "죄송합니다. 사진의 크기가 너무 큽니다.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "죄송합니다, JPG, JPEG, PNG & GIF 형식만 등록 할 수 있습니다.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "죄송합니다. 사진을 등록 할 수 없습니다.";
// if everything is ok, try to upload file
} else {

    //echo $_FILES["fileToUpload"]["tmp_name"];
    //echo $target_file;

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $savefile)) {
        $tmp = $conn->prepare("UPDATE lgu_work SET filename=? WHERE id=?;");  
        $tmp->bind_param('si', $file_name, $id);
        $tmp->execute();  
        $tmp->free_result();
        $tmp->close();
        //Header("Location:./workInfo.php?id=".$id); 
        echo "<html>\n";
        echo "<body onload='document.form1.submit();'>\n";
        echo "<form name='form1' method='post' action='./workInfo.php'>\n";
        echo "<input type='hidden' name='userID' value=".$userID.">\n";
        echo "<input type='hidden' name='sessID' value=".$sessID.">\n";
        echo "<input type='hidden' name='id' value=".$id.">\n";
        echo "<input type='hidden' name='ime_c' value=".$ime.">\n";
        echo "</form>\n";
        echo "</body>\n";
        echo "</html>";
    } else {
        echo "<p>죄송합니다. 사진 등록에 오류가 발생하였습니다.</p>";
		echo "<br><button type='button' onclick='history.back()'>돌아가기</button>";
    }
}
?>