<?php
header('Content-Type: text/html; charset=utf-8');

if (!session_id()) {
    session_start();
}

$watch_rate = 0;
$code = $_GET['code']; /*movie code from url*/
$movie_info = array();
$watched = false;
$txt = "안 봤어요!";
$isStar = false;

# DB Connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");
$userId = $_SESSION['userId'];

if (mysqli_connect_errno()) {
    echo "<script>alert('connect error');</script>";
    exit();
}

else {

    $sql1 = "select EXISTS (select * from watch_movie where userid = ? and movie_cd = ?);";

    if($stmt = mysqli_prepare($conn, $sql1)) {
        if (mysqli_stmt_bind_param($stmt, 'ss', $userId, $code)) {
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_bind_result($stmt, $res);

                while(mysqli_stmt_fetch($stmt)) {
                    if ($res == 1) {
                        $watched = true;
                        $txt = "봤어요!";
                    }
                    else {
                        $watched = false;
                        $txt = "안 봤어요!";
    }}}}}

    $sql0 = "select cntMovie, cntUser from ( 
                select movie_cd, count(movie_cd) as 'cntMovie'
                from watch_movie
                group by movie_cd
            ) c, (
                select count(*) as 'cntUser'
                from users
            ) u where c.movie_cd = ?;";

    if($stmt = mysqli_prepare($conn, $sql0)) {
        if (mysqli_stmt_bind_param($stmt, "s", $code)) {
            if (mysqli_stmt_execute($stmt)) {
                if ($res = mysqli_stmt_get_result($stmt)) {
                    while ($newArray = mysqli_fetch_array($res)) {
                        $num = $newArray['cntMovie'] / $newArray['cntUser'] * 100;
                        $watch_rate = round($num, 2);
    }}}}};

    $sql = "select m.imgUrl, m.movie_nm, m.directors, m.open_yr, m.genre, m.story,
            c.cast_nm, p.people_cd, p.people_nm, p.profile, p.sex
            from movie as m
            left join characters as c on m.movie_cd = c.movie_cd
            left join people as p on c.people_cd = p.people_cd
            where m.movie_cd = ?";

    if($stmt = mysqli_prepare($conn, $sql)) {
        if (mysqli_stmt_bind_param($stmt, "s", $code)) {
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_bind_result($stmt, $imgUrl, $movie_nm, $directors, $open_yr, $genre, $story, 
                                        $cast_nm, $people_cd, $people_nm, $profile, $sex);
                    while (mysqli_stmt_fetch($stmt)) {
                        array_push($movie_info, [
                            "imgUrl" => $imgUrl,
                            "movie_nm" => $movie_nm,
                            "directors" => $directors,
                            "open_yr" => $open_yr,
                            "genre" => $genre,
                            "story" => $story,
                            "cast_nm" => $cast_nm,
                            "people_cd" => $people_cd,
                            "people_nm" => $people_nm,
                            "profile" => $profile,
                            "sex" => $sex
                        ]); 
    }}}}}

    # 즐겨찾기 등록 / 해제
    $sql1 = "select EXISTS (select * from star_movie where userid = ? and movie_cd = ?);";

    if($stmt = mysqli_prepare($conn, $sql1)) {
        if (mysqli_stmt_bind_param($stmt, 'ss', $userId, $code)) {
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_bind_result($stmt, $res);

                while(mysqli_stmt_fetch($stmt)) {
                    if ($res == 1) {
                        $isStar = true;
                    }
                    else {
                        $isStar = false;
    }}}}}

    # close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../index.css">
    <link rel="stylesheet" href="FILMstyle.css">
    <title>FILM</title>
</head>
<body>
    <div id="contents">
        <header class="title">
            <h1>FILM</h1>
        </header>
        <section class="menu">
            <a href="../search/search.php"><h4 class="eachMenu">SEARCH</h4></a>
            <a href="../vote/index.html"><h4 class="eachMenu">VOTE</h4></a>
            <a href="../recommend/index.html"><h4 class="eachMenu">RECOMMEND</h4></a>
            <a href="../community/index.php"><h4 class="eachMenu">COMMUNITY</h4></a>
            <a href="../mypage/index.php"><h4 class="eachMenu">MYPAGE</h4></a>
        </section>
        
        <section class="filmInfo">
            <div class="topLayout">
                <div class="poster">
                    <img src="<?=$movie_info[0]['imgUrl']?>" width="240px" height="313px">
                </div>
                <div class="infoLayout">
                    <div class="titleNtag">
                        <p class="filmTitle"><?=$movie_info[0]['movie_nm']?></p>
                        <?php
                        if($watched) {
                        ?>
                        <img id="tag" src="../../img/tag.svg">
                        <?php
                        } else {
                        ?>
                        <div id="tag"></div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="detailinfo">
                        <p>감독 | <?=$movie_info[0]['directors']?></p>
                        <p>개봉연도 | <?=$movie_info[0]['open_yr']?></p>
                        <p>장르 | <?=$movie_info[0]['genre']?></p>
                    </div>
                    <div class="watched">회원의 <span id="span"><?=$watch_rate?>%</span>가 이 영화를 관람했습니다</div>
                    <form action="../../php/search/watched_insert.php?movie_cd=<?=$code?>" method="post">
                    <button class="watchedBtn" type="submit"><?=$txt?></button>
                    </form>
                </div>
            </div>
            <?php
            $url = "../../php/search/star_movie_insert.php?movie_cd=".$code;
            if(!$isStar) {
            ?>
                <img id="star" src="../../img/star_empty.svg" onclick="location.href='<?=$url?>'">
            <?php
            } else {
            ?>
                <img id="star" src="../../img/star_full.svg" onclick="location.href='<?=$url?>'">
            <?php
            }
            ?>
            <p class="listTitle">스토리</p>
            <h5 class="story"><?=$movie_info[0]['story']?></h5>
            <section class="actorList">
                <p class="listTitle">출연 배우</p>
                <div class="actorProfile">
                    <?php
                    for ($i=0; $i < count($movie_info); $i++) { 
                        $url = './filmography.php?code='.$movie_info[$i]["people_cd"];
                    ?>
                    <a href="<?=$url?>">
                        <div class="individualActor">
                            <div class="actorImg">

                                <?php
                                if($movie_info[$i]['profile'] != null) {
                                ?>
                                <img id="pic" src="<?=$movie_info[$i]['profile']?>"> <!-- profile != null -->
                                <?php
                                } else if ($movie_info[$i]['profile'] != null && $movie_info[$i]['sex'] == '여자') {
                                ?>
                                <img id="pic" src="../../img/woman.png"> <!-- profile == null && 여자 -->
                                <?php
                                } else {
                                ?>
                                <img id="pic" src="../../img/man.png"> <!-- else -->
                                <?php
                                }
                                ?>
                    
                            </div>
                            <div class="actorText">
                                <p class="actorName"><?=$movie_info[$i]['people_nm']?></p>
                                <p class="actorChar"><?=$movie_info[$i]['cast_nm']?></p>
                            </div>
                        </div>
                    </a>
                    <?php
                    }
                    ?>
                </div>
            </section>
        </section>

    </div>
</body>
</html>
