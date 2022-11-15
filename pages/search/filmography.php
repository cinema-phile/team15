<?php
header('Content-Type: text/html; charset=utf-8');

if (!session_id()) {
    session_start();
}
$filmoList = array();
$code = $_GET['code'];
$isStar = false;

# DB Connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");
$userId = $_SESSION['userId'];

if (mysqli_connect_errno()) {
    echo "<script>alert('connect error');</script>";
    exit();
}
else {
    $sql = "select people_nm, people_nm_en, sex, profile from people where people_cd = ?;";

    if($stmt = mysqli_prepare($conn, $sql)) {
        if (mysqli_stmt_bind_param($stmt, "s", $code)) {
            if (mysqli_stmt_execute($stmt)) {
                if ($res = mysqli_stmt_get_result($stmt)) {
                    while ($newArray = mysqli_fetch_array($res)) {

                        $people_nm = $newArray['people_nm'];
                        $people_nm_en = $newArray['people_nm_en'];

                        if ($newArray['profile'] != NULL) {
                            $profile = " src= '".$newArray['profile']."'";
                        }
                        else if ($newArray['profile'] == NULL && $newArray['sex'] == "여자") {
                            $profile = " src= '../../img/woman.png'";
                        }
                        else {
                            $profile = " src= '../../img/man.png'";
                        }

                    }}}}}

    $sql3 = "insert into star_people (userid, people_cd) values (?, ?);";

    $sql2 = "select m.movie_cd, m.movie_nm, m.imgUrl, c.cast_nm
            from characters as c
            left join movie as m on m.movie_cd = c.movie_cd
            left join people as p on c.people_cd = p.people_cd
            where c.people_cd = ?;";

    if($stmt = mysqli_prepare($conn, $sql2)) {
        if (mysqli_stmt_bind_param($stmt, "s", $code)) {
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_bind_result($stmt, $movie_cd, $movie_nm, $imgUrl, $cast_nm);

                while(mysqli_stmt_fetch($stmt)) {
                    array_push($filmoList, [
                        "movie_cd" => $movie_cd,
                        "movie_nm" => $movie_nm,
                        "imgUrl" => $imgUrl,
                        "cast_nm" => $cast_nm
                    ]);
                }
            }
        }
    }

    # USER 팬지수 계산
    $cnt = 0;
    $sql = "select EXISTS (
                select * from watch_movie where userid = ? and movie_cd = ?
            )";
    if($stmt = mysqli_prepare($conn, $sql)) {
        for ($i=0; $i < count($filmoList); $i++) { 
            $movie_cd = $filmoList[$i]['movie_cd'];
            if(mysqli_stmt_bind_param($stmt, 'ss', $userId, $movie_cd)) {
                if(mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_bind_result($stmt, $watched);
                    while(mysqli_stmt_fetch($stmt)) {
                        if($watched == 1) {
                            $cnt = $cnt + 1;
                        }
                    }
                }
            }
        }

    }

    $fanRate = round($cnt / count($filmoList) * 100, 2);

    # 즐겨찾기 등록 / 해제
    $sql1 = "select EXISTS (select * from star_people where userid = ? and people_cd = ?);";

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

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../index.css">
    <link rel="stylesheet" href="filmoStyle.css">
    <title>FILMOGRAPHY</title>
</head>
<body>
    <div id="contents">
        <header class="title">
            <h1>FILMOGRAPHY</h1>
        </header>
        <section class="menu">
            <a href="../search/search.php"><h4 class="eachMenu">SEARCH</h4></a>
            <a href="../vote/index.html"><h4 class="eachMenu">VOTE</h4></a>
            <a href="../recommend/index.html"><h4 class="eachMenu">RECOMMEND</h4></a>
            <a href="../community/index.php"><h4 class="eachMenu">COMMUNITY</h4></a>
            <a href="../mypage/index.php"><h4 class="eachMenu">MYPAGE</h4></a>
        </section>

        <section class="profile">
            <img class="profileimg" <?=$profile?>>
            <div class="profiletitle">
            <?php
            $url = "../../php/search/star_insert.php?people_cd=".$code;
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
            <div class="nameLayout"><p class="name"><?=$people_nm?></p><br><p class="name_eng"><?=$people_nm_en?></p></div>
            </div>
        </section>

        <section class="filmolist">
            <div class="fanscore">
                <div class="fanscore-L">나의 팬 지수 <span id="fanscorespan"><?=$fanRate?>%</span></div>
                <p class="fanscore-R"><span id="span"><?=count($filmoList)?></span> 작품 중 <span id="span"><?=$cnt?></span> 개 관람</p>
            </div>
            <progress class="fanGraph" min="0" max="100" value="<?=$fanRate?>"></progress>


            <div class="characterList">
                <?php
                for ($i=0; $i < count($filmoList); $i++) { 
                    $url = './filmInfo.php?code='.$filmoList[$i]['movie_cd'];
                ?>
                <a href="<?=$url?>">
                <div class="individualChar">
                    <div class="charProfileImg">
                        <!-- <img class="tag" src="../../img/tag.svg"> -->
                        <img id="charPic" src="<?=$filmoList[$i]['imgUrl']?>">
                    </div>
                    <div class="charText">
                        <p class="charName"><?=$filmoList[$i]['cast_nm']?></p>
                        <p class="charMovie"><?=$filmoList[$i]['movie_nm']?></p>
                    </div>
                </div>
                <?php
                }
                ?>
                </a>
            </div>
        </section>
    </div>
</body>
</html>