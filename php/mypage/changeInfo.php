<?php

if(!session_id()) {
    // id가 없을 경우 세션 시작
        session_start();
    }


    //echo $_SESSION['userId'];
    $id = $_SESSION['userId'];

$wantChange=$_POST["wantChange"];
echo ".$wantChange.";

if($wantChange=="True"){


    echo ".$id.";

    $name = $_POST['name'];
    echo ".$name.";


    $password = $_POST['password'];
    echo ".$password.";

    # DB Connection
    $conn = mysqli_connect("localhost", "team15", "team15", "team15");
    if (mysqli_connect_errno()) {
        echo "<script>alert('Log in fail');</script>";
        exit();
    } else {
        $sql="UPDATE users SET password = ?, name = ? WHERE userid = ?;";
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $password, $name, $id);
            # run the query
            mysqli_stmt_execute($stmt);
               header("Location:../../pages/mypage/index.php");

               
        
        }

}
}








?>