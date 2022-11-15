<?php
header('Content-Type: text/html; charset=utf-8');

# DB connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");
$boardid=$_GET['boardid'];

if (mysqli_connect_errno()) {
    echo "<script>alert('Connetion fail');</script>";
    exit();
} else {
    $sql = "delete from b, c
                using board as b
                left join comment as c
                on b.boardid = c.boardid
            where b.boardid = ?";

    # prepare statement
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $boardid);
        
        if(mysqli_stmt_execute($stmt)) {
            header("Location:../../pages/community/index.php");
        } else {
            echo "<script>alert('게시글 삭제 실패');</script>";
            exit();
        }
    } else {
        echo "<script>alert('게시글 삭제 실패');</script>";
        exit();
    }

    # close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

?>