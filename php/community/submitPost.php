<?php
header('Content-Type: text/html; charset=utf-8');

if (!session_id()) {
    session_start();
}

$title = $_POST["titleInput"];
$content = $_POST["postContent"];

if ($title == NULL || $content == NULL) {
    echo "<script>alert('아직 작성하지 않은 항목이 있습니다. 모든 항목을 작성해 주세요');</script>";
    exit();
}

# DB connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");

if (mysqli_connect_errno()) {
    echo "<script>alert('Sign up fail');</script>";
    exit();
} else {
    $sql = "insert into board (userid, title, content, type) values (?, ?, ?, ?)";

    # prepare statement
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'ssss', $_SESSION['userId'], $title, $content, $_GET['type']);
        
        if(mysqli_stmt_execute($stmt)) {
            header("Location:../../pages/community/index.php");
        } else {
            echo "<script>alert('게시글 작성 실패');</script>";
            exit();
        }
    } else {
        echo "<script>alert('게시글 작성 실패');</script>";
        exit();
    }

    # close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

?>