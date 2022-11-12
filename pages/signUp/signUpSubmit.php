<?php

$id = $_POST["id_input"];
$name = $_POST["name_input"];
$pw = $_POST["pw_input"];
$pw_confirm = $_POST["pw_confirm"];

if ($pw != $pw_confirm) {
    echo "비밀번호를 확인해 주세요";
    exit();
}
else {
    echo "회원가입 성공 -> 테스트용 페이지";
}

if ($id == NULL || $name == NULL || $pw == NULL || $pw_confirm == NULL) {
    echo "아직 작성하지 않은 항목이 있습니다. 모든 항목을 작성해 주세요";
    exit();
}

$mysqli = mysqli_connect ("localhost","team15","team15","team15");

if(mysqli_connect_error()){
    prinf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
else{

    $sql = "";

}

?>