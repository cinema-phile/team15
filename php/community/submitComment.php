<?php
header('Content-Type: text/html; charset=utf-8');

if (!session_id()) {
    session_start();
}

$comment = $_POST["comment"];

if ($comment == NULL) {
    echo "<script>alert('댓글을 작성해 주세요');</script>";
    exit();
}

# DB connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");

if (mysqli_connect_errno()) {
    echo "<script>alert('Connection fail');</script>";
    exit();
} else {
    $sql = "insert into comment (boardid, userid, content) values (?, ?, ?);";

    # prepare statement
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'sss', $_GET['boardid'], $_SESSION['userId'], $comment);
        
        if(mysqli_stmt_execute($stmt)) {
            header("Location:../../pages/community/community_each.php?boardid=".$_GET['boardid']);
        } else {
            echo "<script>alert('댓글 작성 실패');</script>";
            exit();
        }
    } else {
        echo "<script>alert('댓글 작성 실패');</script>";
        exit();
    }

    # close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

?>