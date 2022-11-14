<?php
header('Content-Type: text/html; charset=utf-8');

if (!session_id()) {
    session_start();
}

# DB Connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");
$res = array();
$best_comment = array();
$comment = array();
$boardid = $_GET['boardid'];
$executed = false;

if (mysqli_connect_errno()) {
    echo "<script>alert('Connection fail');</script>";
    exit();
} else {
    
    # 게시글 상세 출력
    $sql = "select f.title, f.content, f.timestamps, u.userid, u.name, u.profile
            from board as f
            inner join users as u on f.userid = u.userid
            where f.boardid = ?";

    # prepare statement
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $boardid);

        # run the query
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $title, $content, $time, $writerId, $writer, $writer_profile);
            while(mysqli_stmt_fetch($stmt)) {
                $res = [
                    "title" => $title,
                    "content" => $content,
                    "time" => $time,
                    "writerId" => $writerId,
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
    mysqli_stmt_close($stmt);

    # 베댓 있는지 확인
    $sql = "select exists (select * from comment where boardid = ? and like_no > 0)";

    # prepare statement
    if($stmt = mysqli_prepare($conn, $sql)) { 
        mysqli_stmt_bind_param($stmt,"s", $boardid);

        # run the query
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $exist);
            
            while(mysqli_stmt_fetch($stmt)) {
                $exist = $exist;
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

    # 베댓 2개 출력 쿼리
    $sql = "select c.commentid, c.userid, c.content, c.like_no, c.hate from comment as c join (
                select commentid, (a.like_no - a.hate) as diff
                from comment as a
                where a.boardid = ?
            ) b on c.commentid = b.commentid
            where b.diff >= 1
            order by b.diff desc limit 2";

    # 베댓이 있는 경우에만
    if($exist == 1) {
        $executed = true;
        # prepare statement
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $boardid);

            # run the query
            if(mysqli_stmt_execute($stmt)) {
                mysqli_stmt_bind_result($stmt, $id, $c_user, $c_content, $like, $hate);
    
                while(mysqli_stmt_fetch($stmt)) {
                    array_push($best_comment, [
                        "c_id" => $id,
                        "c_user" => $c_user,
                        "c_content" => $c_content,
                        "like" => $like,
                        "hate" => $hate
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
    }
    if($executed) {
        mysqli_stmt_close($stmt);
    }

    # 댓글 출력
    $sql = 'select c.userid, c.commentid, c.content, c.timestamps, c.like_no, c.hate
            from comment as c
            where boardid = ?
            order by commentid';

    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $boardid);

        # run the query
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $c_writer, $c_id, $c_content, $c_time, $c_like, $c_hate);

            while(mysqli_stmt_fetch($stmt)) {
                array_push($comment, [
                    "c_id" => $c_id,
                    "c_writer" => $c_writer,
                    "c_content" => $c_content,
                    "c_time" => $c_time,
                    "c_like" => $c_like,
                    "c_hate" => $c_hate
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
            <a href="../mypage/index.html"><h4 class="eachMenu">MYPAGE</h4></a>
        </section>
        <section class="board">
            <div class="post">
                
                <div class="eachPost">
                    <div class="myPostLayout">
                        <div class="eachProfile">
                            <div class="profileImg">
                                <!-- <img src=""> -->
                            </div>
                            <p class="nickName"><?=$res['writer']?></p>
                        </div>
                        <div class="postButtons">
                            <div onclick="location.href='./community_edit.php?boardid=<?=$boardid?>'">
                                <button class="postEdit">수정</button>
                            </div>
                            <div onclick="location.href='../../php/community/deletePost.php?boardid=<?=$boardid?>'">
                                <button class="postDelete">삭제</button>
                            </div>
                        </div>
                    </div>

               
                    <div class="each_eachPostTop">
                        <h3 class="eachPostTitle"><?=$res['title']?></h3>
                        <div class="timeStamp"><?=$res['time']?></div>
                    </div>
                        <div class="postContents_each">
                            <?=$res['content']?>
                        </div>
                        <div class="replIndex">BEST 댓글</div>
                        <?php
                        for ($i=0; $i < count($best_comment); $i++) {
                        ?>
                        <div class="bestRepl_each">
                            <div class="text"><?=$best_comment[$i]['c_content']?></div>
                            <div class="replCount">
                                <div onclick="location.href='../../php/community/updateLike.php?isMine=true&boardid=<?=$boardid?>&commentid=<?=$best_comment[$i]['c_id']?>'">
                                    <label for="hiddenBtn" class="thumb">
                                        <div class="thumbUp_2" type="submit"><img src="../../img/thumb_up.svg" width="16px" height="16px"></div>
                                        <div class="thumbNum"><?=$best_comment[$i]['like']?></div>
                                    </label>
                                </div>
                                <div onclick="location.href='../../php/community/updateHate.php?isMine=true&boardid=<?=$boardid?>&commentid=<?=$best_comment[$i]['c_id']?>'">
                                    <label for="hiddenBtn" class="thumb">
                                        <div class="thumbDown_2" type="submit"><img src="../../img/thumb_down.svg" width="16px" height="16px"></div>
                                        <div class="thumbNum"><?=$best_comment[$i]['hate']?></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
    
                        <div class="repl">
                            <div class="replIndex">최신 댓글</div>
                            <?php
                            for ($i=0; $i < count($comment); $i++) {
                            ?>
                            <div class="repl_each">
                                <div class="text"><?=$comment[$i]['c_content']?></div>
                                <div class="replCount">
                                    <div onclick="location.href='../../php/community/updateLike.php?isMine=true&boardid=<?=$boardid?>&commentid=<?=$comment[$i]['c_id']?>'">
                                        <label for="hiddenBtn" class="thumb"> 
                                        <div class="thumbUp_2" type="submit"><img src="../../img/thumb_up.svg" width="16px" height="16px"></div>
                                        <div class="thumbNum"><?=$comment[$i]['c_like']?></div>
                                        </label>
                                    </div>
                                    <div onclick="location.href='../../php/community/updateHate.php?isMine=true&boardid=<?=$boardid?>&commentid=<?=$best_comment[$i]['c_id']?>'">
                                        <label for="hiddenBtn" class="thumb">
                                        <div class="thumbDown_2" type="submit"><img src="../../img/thumb_down.svg" width="16px" height="16px"></div>
                                        <div class="thumbNum"><?=$comment[$i]['c_hate']?></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        </div>
                        <form action="../../php/community/submitComment.php?boardid=<?=$boardid?>&isMine=true" method="post">
                        <div class="replPost">
                            <input class="replPostContents" name="comment">
                            <button class="replButton" type=submit>댓글 작성</button>
                        </div>
                        </form>
    
                    </div>
                </div>
    
            </section>
    
        </div>
        
    </body>
    </html>