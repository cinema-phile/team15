<?php
header('Content-Type: text/html; charset=utf-8');
/**
 * sign up
 * user input : id, pw, pw_confirm, name
 * INSERT 1 SELECT 1
 * DB input : userid, password, name, profile (random img)
 * error handle : duplicated id
 */

# DB connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");

if (mysqli_connect_errno()) {
    echo "<script>alert('Sign up fail');</script>";
} else {
    $insert_sql = "insert into users (userid, password, name, profile) values (?, ?, ?, ?)";
    $duplicate_sql = "select EXISTS (select * from users where userid = ?)";

    # allocate user input => $id, $pw, $pw_confirm, $name
    $id = $_GET['id_input'];
    $pw = $_GET['pw_input'];
    $pw_confirm = $_GET['pw_confirm'];
    $name = $_GET['name_input'];
    $profile = rand(1, 8);

    # prepare statement - verify duplicated id
    if($stmt = mysqli_prepare($conn, $duplicate_sql)) {
        mysqli_stmt_bind_param($stmt, "s", $id);
        # does not exist id_input
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $res);
            echo $res;
        }
    } else {
        echo "<script>alert('Sign up fail');</script>";
    }
    mysqli_stmt_close($stmt);
    
    if($res == 0) {
        # prepare statement - insert user info
        if($stmt = mysqli_prepare($conn, $insert_sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $id, $pw, $name, $profile);

            # pw confirm
            if ($pw == $pw_confirm) {
                # insert user info
                if(mysqli_stmt_execute($stmt)) {
                    # page redirect
                    header("Location:../index.html");
                    exit();
                } else {
                    echo "<script>alert('Sign up fail');</script>";
                }
            } else {
                echo "<script>alert('비밀번호가 일치하지 않습니다.');</script>";
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