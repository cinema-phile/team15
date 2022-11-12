<?php

$id = $_POST["id_input"];
$name = $_POST["name_input"];
$pw = $_POST["pw_input"];
$pw_confirm = $_POST["pw_confirm"];
$profile = rand(1, 8);

if ($pw != $pw_confirm) {
    echo "비밀번호를 확인해 주세요";
    exit();
}

if ($id == NULL || $name == NULL || $pw == NULL || $pw_confirm == NULL) {
    echo "아직 작성하지 않은 항목이 있습니다. 모든 항목을 작성해 주세요";
    exit();
}

# DB connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");

if (mysqli_connect_errno()) {
    echo "<script>alert('Sign up fail');</script>";
} else {
    $insert_sql = "insert into users (userid, password, name, profile) values (?, ?, ?, ?)";
    $duplicate_sql = "select EXISTS (select * from users where userid = ?)";

    # prepare statement - verify duplicated id
    if($stmt = mysqli_prepare($conn, $duplicate_sql)) {
        mysqli_stmt_bind_param($stmt, "s", $id);
        # does not exist id_input
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $res);
            print($res);
        }
    } else {
        echo "<script>alert('Sign up fail');</script>";
    }
    mysqli_stmt_close($stmt);
    
    if($res == 0) {
        # prepare statement - insert user info
        if($stmt = mysqli_prepare($conn, $insert_sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $id, $pw, $name, $profile);

            # insert user info
            if(mysqli_stmt_execute($stmt)) {
                # page redirect
                header("Location:../index.html");
                exit();
            } else {
                echo "<script>alert('Sign up fail');</script>";
            }
        } else {
            echo "<script>alert('Sign up fail');</script>";
        }
    } else {
        echo "<script>alert('Duplicated id');</script>";
    }

    # close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

?>