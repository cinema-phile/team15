<?php
header('Content-Type: text/html; charset=utf-8');

$id = $_POST["id_input"];
$name = $_POST["name_input"];
$pw = $_POST["pw_input"];
$pw_confirm = $_POST["pw_confirm"];
$randNm = rand(1, 8);
# randNm에 따라서 switch문으로 img src 매핑
switch ($randNm) {
    case 1:
        $profile = "../../img/1.png";
        break;
    case 2:
        $profile = "../../img/2.png";
        break;
    case 3:
        $profile = "../../img/3.png";
        break;
    case 4:
        $profile ="../../img/4.png";
        break;
    case 5:
        $profile ="../../img/5.png";
        break;
    case 6:
        $profile = "../../img/6.png";
        break;
    case 7:
        $profile ="../../img/7.png";
        break;
    case 8:
        $profile = "../../img/8.png";
        break;
    
    default:
        $profile = "../../img/1.png";
        break;
}

if ($pw != $pw_confirm) {
    echo "<script>alert('비밀번호를 확인해 주세요');</script>";
    exit();
}

if ($id == NULL || $name == NULL || $pw == NULL || $pw_confirm == NULL) {
    echo "<script>alert('아직 작성하지 않은 항목이 있습니다. 모든 항목을 작성해 주세요');</script>";
    exit();
}

# DB connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");

if (mysqli_connect_errno()) {
    echo "<script>alert('Sign up fail');</script>";
    exit();
} else {
    $insert_sql = "insert into users (userid, password, name, profile) values (?, ?, ?, ?)";
    $duplicate_sql = "select EXISTS (select * from users where userid = ?)";

    # prepare statement - verify duplicated id
    if($stmt = mysqli_prepare($conn, $duplicate_sql)) {
        mysqli_stmt_bind_param($stmt, 's', $id);
        # does not exist id_input
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $res);
            while(mysqli_stmt_fetch($stmt)) {
                $duplicated = $res;
            }
        } else {
            echo "<script>alert('Sign up fail');</script>";
            exit();
        }
    } else {
        echo "<script>alert('Sign up fail');</script>";
        exit();
    }
    mysqli_stmt_close($stmt);

    if($duplicated == 0) {
        # prepare statement - insert user info
        if($stmt = mysqli_prepare($conn, $insert_sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $id, $pw, $name, $profile);

            # insert user info
            if(mysqli_stmt_execute($stmt)) {
                # page redirect
                header("Location:../../index.html");
                exit();
            } else {
                echo "<script>alert('Sign up fail');</script>";
                exit();
            }
        } else {
            echo "<script>alert('Sign up fail');</script>";
            exit();
        }
    } else {
        echo "<script>alert('Duplicated id');</script>";
        exit();
    }

    # close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

?>