<?php
header('Content-Type: text/html; charset=utf-8');

if (!session_id()) {
    session_start();
}

$userId = $_SESSION['userId'];
$people_cd = $_GET['people_cd'];

# DB connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");

if (mysqli_connect_errno()) {
    echo "<script>alert('Connection fail');</script>";
    exit();
}
else {

    $sql0 = "select EXISTS (select * from star_people where userid = ? and people_cd = ?);";

    # prepare statement
    if($stmt = mysqli_prepare($conn, $sql0)) {
        if (mysqli_stmt_bind_param($stmt, 'ss', $userId, $people_cd)) {
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_bind_result($stmt, $res);
                while(mysqli_stmt_fetch($stmt)) {
                    $isStar = $res;
                }
            }
        }
        else {
            echo "<script>alert('error');</script>";
            exit();
    }}

    

    if ($isStar != 1) { #즐겨찾기 안 함 -> 넣어야함
        $sql1 = "insert into star_people (userid, people_cd) values (?, ?);"; #즐겨찾기 목록에 넣기
        # prepare statement
        if($stmt = mysqli_prepare($conn, $sql1)) {
            if (mysqli_stmt_bind_param($stmt, 'ss', $userId, $people_cd)) {
                if(mysqli_stmt_execute(($stmt))) {
                    header("Location:../../pages/search/filmography.php?code=".$people_cd);
                }
            }
        }
    }
    else { #즐겨찾기 함 -> 삭제해야함
        $sql2 = "delete from star_people where userid = ? and people_cd = ?;"; #즐겨찾기 목록에서 지우기
        # prepare statement
        if($stmt = mysqli_prepare($conn, $sql2)) {
            if (mysqli_stmt_bind_param($stmt, 'ss', $userId, $people_cd)) {
                if(mysqli_stmt_execute(($stmt))) {
                    header("Location:../../pages/search/filmography.php?code=".$people_cd);
                }
            }
        }
    }

    # close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
}


?>