<?php
    header('Content-Type: text/html; charset=utf-8');
    echo $_GET["genre"];
    
    if(!session_id()) {
        // id가 없을 경우 세션 시작
            session_start();
        }
        echo $_SESSION['userId'];

        /*$id = $_SESSION['userId'];

        echo .$id.;*/
        

    # DB Connection
    $conn = mysqli_connect("localhost", "team15", "team15", "team15");

    if (mysqli_connect_errno()) {
        echo "<script>alert('Log in fail');</script>";
        exit();
    } else{

    }
?>