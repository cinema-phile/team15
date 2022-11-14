<?php



$wantChange=$_POST["wantChange"];
echo ".$wantChange.";

if($wantChange=="True"){

    $name = $_POST['name'];
    echo ".$name.";


    $password = $_POST['password'];
    echo ".$password.";

}

header("Location:../../pages/mypage/index.php");






?>