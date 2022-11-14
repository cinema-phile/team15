<?php
header('Content-Type: text/html; charset=utf-8');
/**
 * log in
 * user input : id, pw
 * SELECT 1
*/

$id_input = $_POST['id_input'];
$pw_input = $_POST['pw_input'];

if (!session_id()) {
    session_start();
}

if ($id_input == NULL || $pw_input == NULL) {
    echo "<script>alert('아직 작성하지 않은 항목이 있습니다. 모든 항목을 작성해 주세요');</script>";
    exit();
}

# DB Connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");

if (mysqli_connect_errno()) {
    echo "<script>alert('Log in fail');</script>";
    exit();
} else {
    $sql = "select EXISTS (select * from users where userid = ? and password = ?)";

    # prepare statement
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $id_input, $pw_input);

        # run the query
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $res);
            while(mysqli_stmt_fetch($stmt)) {
                $success = $res;
            }
        } else {
            echo "<script>alert('Log in fail');</script>";
            exit();
        }

        # verify id & pw
        if ($success == 1) {
            # Success login
            $_SESSION['userId'] = $id_input;
            header("Location:./pages/search/search.php");
        } else {
            echo "<script>alert('Log in fail');</script>";
            exit();
        }
        
    } else {
        echo "<script>alert('Log in fail');</script>";
        exit();
    }

    # close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>