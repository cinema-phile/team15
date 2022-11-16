<?php
header('Content-Type: text/html; charset=utf-8');

if (!session_id()) {
    session_start();
}

# DB Connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");
$res = array();
$boardid = $_GET['boardid'];
$isNew=false;

if (mysqli_connect_errno()) {
    echo "<script>alert('Connection fail');</script>";
    exit();
} else {
    
    # 게시글 상세 출력
    $sql = "select f.title, f.content, f.type, u.name, u.profile
            from board as f
            inner join users as u on f.userid = u.userid
            where f.boardid = ?";

    # prepare statement
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $boardid);

        # run the query
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $title, $content, $type, $writer, $writer_profile);
            while(mysqli_stmt_fetch($stmt)) {
                $res = [
                    "title" => $title,
                    "content" => $content,
                    "type" => $type,
                    "writer" => $writer,
                    "profile" => $writer_profile 
                ];
            }
        } else {
            echo "<script>alert('fail execute the query');</script>";
            exit();
        }
        
    } else {
        echo "<script>alert('Fail prepare the statement');</script>";
        exit();
    }

    # close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../index.css">
    <link rel="stylesheet" href="./communityStyle.css">
    <title>Community</title>
</head>
<body>
    <div id="contents">
        <header class="title">
            <h1>Community</h1>
        </header>
        <section class="menu">
            <a href="../search/search.php"><h4 class="eachMenu">SEARCH</h4></a>
            <a href="../vote/index.html"><h4 class="eachMenu">VOTE</h4></a>
            <a href="../recommend/index.html"><h4 class="eachMenu">RECOMMEND</h4></a>
            <a href="../community/index.php"><h4 class="eachMenu">COMMUNITY</h4></a>
            <a href="../mypage/index.php"><h4 class="eachMenu">MYPAGE</h4></a>
        </section>
        <section class="board">
            <div class="post">
                
                <div class="eachPost">
                    <div class="eachProfile">
                        <div class="profileImg">
                            <img src="<?=$res['profile']?>">
                        </div>
                        <p class="nickName"><?=$_SESSION['userName']?></p>  
                    </div>
                    <form action="../../php/community/submitPost.php?isNew=<?=$isNew?>&boardid=<?=$boardid?>" method="post">
                        <div class="titleField">
                            <h4 class="postTitle">제목</h4>
                            <input class="titleInput" name="titleInput" value="<?=$res['title']?>">
                        </div>
                        <input class="newPostContents" name="postContent" value="<?=$res['content']?>">
                        <button class="button" type=submit>작성 완료</button>
                    </form>
                </div>
            </div>

        </section>

    </div>
    
</body>
</html>