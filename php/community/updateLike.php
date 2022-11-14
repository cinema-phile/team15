<?php
header('Content-Type: text/html; charset=utf-8');

# DB connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");
$isMine = $_GET['isMine'];

if (mysqli_connect_errno()) {
    echo "<script>alert('Connection fail');</script>";
    exit();
} else {
    $sql = "update comment set like_no = (like_no + 1) where commentid = ?";

    # prepare statement
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $_GET['commentid']);
        
        if(mysqli_stmt_execute($stmt)) {
            if($isMine) {
                header("Location:../../pages/community/community_myPost.php?boardid=".$_GET['boardid']);
            } else {
                header("Location:../../pages/community/community_each.php?boardid=".$_GET['boardid']);
            }
        } else {
            echo "<script>alert('좋아요 실패');</script>";
            exit();
        }
    } else {
        echo "<script>alert('좋아요 실패');</script>";
        exit();
    }

    # close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

?>