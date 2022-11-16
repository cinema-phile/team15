<?php
header('Content-Type: text/html; charset=utf-8');

if (!session_id()) {
    session_start();
}

# DB Connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");
$res = array();
$bestComment = array();
$executed = false;
$userId = $_SESSION['userId'];

if (mysqli_connect_errno()) {
    echo "<script>alert('Connection fail');</script>";
    exit();
} else {

    # user 정보 갖고오기
    $sql = "select name, profile from users where userid = ?";

    # prepare statement
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['userId']);

        # run the query
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $name, $profile);
            while(mysqli_stmt_fetch($stmt)) {
                $_SESSION['userName'] = $name;
                $_SESSION['profile'] = $profile;
            }
        } else {
            echo "<script>alert('fail execute the query');</script>";
            exit();
        }
        
    } else {
        echo "<script>alert('Fail prepare the statement');</script>";
        exit();
    }
    mysqli_stmt_close($stmt);
    
    # 게시글 출력
    $sql = "select f.boardid, f.title, f.content, f.timestamps, u.userid, u.name, u.profile
            from board as f
            inner join users as u on f.userid = u.userid
            where type = 'free'
            order by f.boardid desc";

    # prepare statement
    if($stmt = mysqli_prepare($conn, $sql)) {

        # run the query
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $boardid, $title, $content, $time, $writerId, $writer, $writer_profile);
            while(mysqli_stmt_fetch($stmt)) {
                array_push($res, [
                    "boardid" => $boardid,
                    "title" => $title,
                    "content" => $content,
                    "time" => $time,
                    "writerId" => $writerId,
                    "writer" => $writer,
                    "profile" => $writer_profile 
                ]);
            }
        } else {
            echo "<script>alert('fail execute the query');</script>";
            exit();
        }
        
    } else {
        echo "<script>alert('Fail prepare the statement');</script>";
        exit();
    }
    mysqli_stmt_close($stmt);

    # 댓글이 있는지 확인
    $sql = "select exists (select * from comment where boardid = ?)";

    # prepare statement
    if($stmt = mysqli_prepare($conn, $sql)) {
        for ($i=0; $i < count($res); $i++) { 
            $id = $res[$i]['boardid'];
            mysqli_stmt_bind_param($stmt,"s", $id);
    
            # run the query
            if(mysqli_stmt_execute($stmt)) {
                mysqli_stmt_bind_result($stmt, $exist);
                
                while(mysqli_stmt_fetch($stmt)) {
                    array_push($bestComment, $exist);
                }
            } else {
                echo "<script>alert('fail execute the query');</script>";
                exit();
            }
        }
    } else {
        echo "<script>alert('Fail prepare the statement');</script>";
        exit();
    }
    mysqli_stmt_close($stmt);

    # 베댓 출력 쿼리
    $sql = "select c.content, c.like_no, c.hate
            from comment as c
            where c.commentid = (
                select r.best from (
                    select b.commentid as best, max(b.diff) 
                    from (
                        select commentid, (a.like_no - a.hate) as diff
                        from comment as a
                    ) b where b.diff >= 1
                ) r
            ) and boardid = ? limit 1";

    # 베댓 있는지 확인
    for ($i=0; $i < count($bestComment); $i++) {
        if($bestComment[$i] == 1) {
            $executed = true;
            # prepare statement
            if($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $res[$i]['boardid']);
                
                # run the query
                if(mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_bind_result($stmt, $comment, $like, $hate);
                    
                    while(mysqli_stmt_fetch($stmt)) {
                        $res[$i] = $res[$i] + array(
                            "comment" => $comment,
                            "like" => $like,
                            "hate" => $hate

                        );
                    }
                } else {
                    echo "<script>alert('fail execute the query');</script>";
                    exit();
                }

            } else {
                echo "<script>alert('Fail prepare the statement');</script>";
                exit();
            }
        }

    }

    # close connection
    if($executed) {
        mysqli_stmt_close($stmt);
    }
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
            <div class="topMenu">
                <div class="category">
                    <h3 class="free" onclick="location.href='index.php'"><span id="span">자유게시판</span></h3>
                    <h3 class="info" onclick="location.href='community_info.php'">정보게시판</h3>
                </div>
                <?php
                # 다음 페이지에서 get으로 type값 받아감
                $url = "./community_newPost.php?type=free";
                ?>
                    <button class="button" onclick="location.href='<?=$url?>'">글쓰기</button>
                </a>
            </div>

            <?php
            for ($i=0; $i < count($res); $i++) {
                if($res[$i]['writerId'] == $userId) {
                    $url = "community_myPost.php?boardid=".$res[$i]['boardid'];
                } else {
                    $url = "community_each.php?boardid=".$res[$i]['boardid'];
                }
            ?>
            <div class="post" onclick="location.href='<?=$url?>'">
                <div class="eachProfile">
                    <img class="profileImg" src="<?=$profile?>">
                    <p class="nickName"><?=$res[$i]['writer']?></p>  
                </div>
                <div class="eachPost">
                    <div class="eachPostTop">
                        <h3 class="eachPostTitle"><?=$res[$i]['title']?></h3>
                        <div class="timeStamp"><?=$res[$i]['time']?></div>
                    </div>
                    
                    <h4 class="postContents">
                        <?=$res[$i]['content']?>
                    </h4>
                    <?php
                    if(array_key_exists('comment', $res[$i])) {
                    ?>
                    <div class="replIndex">BEST 댓글</div>
                    <div class="bestRepl">
                        <div class="text"><?=$res[$i]['comment']?></div>
                        <div class="replCount">
                        <div class="thumbUp"><img src="../../img/thumb_up.svg" width="16px" height="16px"></div>
                        <div class="thumbNum"><?=$res[$i]['like']?></div>
                        <div class="thumbUp"><img src="../../img/thumb_down.svg" width="16px" height="16px"></div>
                        <div class="thumbNum"><?=$res[$i]['hate']?></div>
                    </div>
                    </div>
                    <?php
                    }
                    ?>

                </div>
            </div>
            <?php
            }
            ?>
        </section>

    </div>
    
</body>
</html>