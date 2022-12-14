<?php

if (!session_id()) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../index.css">
    <link rel="stylesheet" href="./searchStyle.css">
    <title>SEARCH</title>
</head>
<body>
    <div id="contents">
        <header class="title">
            <h1>SEARCH</h1>
        </header>
        <section class="menu">
            <a href="../search/search.php"><h4 class="eachMenu">SEARCH</h4></a>
            <a href="../vote/index.html"><h4 class="eachMenu">VOTE</h4></a>
            <a href="../recommend/index.html"><h4 class="eachMenu">RECOMMEND</h4></a>
            <a href="../community/index.php"><h4 class="eachMenu">COMMUNITY</h4></a>
            <a href="../mypage/index.php"><h4 class="eachMenu">MYPAGE</h4></a>
        </section>
        <form action="searchQuery.php" type="post"><section class="search">
            <select name="category" class="category" id="category" onchange="showCondition(this)">
                <option value="film">영화</option>
                <option value="person">영화인</option>
            </select>
            <input class="searchWindow" type="text" name="searchKeyword">
            <button class="submit" type="submit">검색</button>
        </section>
        <section class="conditionField">
            <select name="condition" class="condition" id="condition" onchange="show(this)">
                <option value="default">전체</option>
                <option value="genre">장르</option>
                <option value="rate">관람등급</option>
                <option value="year">개봉연도</option>
            </select>
            <div class="conditions" id="person">
                <label><input type="radio" name="check" value="감독">영화감독</label>
                <label><input type="radio" name="check" value="배우">영화배우</label>
            </div>
            <div class="conditions" id="genre">
                <label><input type="radio" name="check" value="액션">액션</label>
                <label><input type="radio" name="check" value="코미디">코미디</label>
                <label><input type="radio" name="check" value="로맨스">로맨스</label>
                <label><input type="radio" name="check" value="드라마">드라마</label>
                <label><input type="radio" name="check" value="SF">SF/판타지</label>
                <label><input type="radio" name="check" value="애니메이션">애니메이션</label>
                <label><input type="radio" name="check" value="다큐멘터리">다큐</label>
                <label><input type="radio" name="check" value="공포">호러</label>
                <label><input type="radio" name="check" value="스릴러">스릴러</label>
            </div>
            <div class="conditions" id="rate">
                <label><input type="radio" name="check" value="전체">전체관람가</label>
                <label><input type="radio" name="check" value="12">12세이상 관람가</label>
                <label><input type="radio" name="check" value="15">15세이상 관람가</label>
                <label><input type="radio" name="check" value="청소년">청소년관람불가</label>
            </div>
            <div class="conditions" id="year">
                <label><input type="radio" name="check" value="2018">2018</label>
                <label><input type="radio" name="check" value="2019">2019</label>
                <label><input type="radio" name="check" value="2020">2020</label>
                <label><input type="radio" name="check" value="2021">2021</label>
                <label><input type="radio" name="check" value="2022">2022</label>
            </div>
        </section></form>

        <section class="cinemaTrend">
            <h3 class="trendTitle">CINEMA TREND</h3>
            <div class="trend1">
                <h4 class="trendSubTitle">유저들이 가장 많이 본 영화 TOP4</h4>
                <div class="resultList">

<?php

# DB Connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");

if (mysqli_connect_errno()) {
    echo "<script>alert('connect error');</script>";
    exit();
}
else {
    $sql = "select m.movie_cd, m.movie_nm, m.imgUrl, cntMovie from movie m JOIN ( 
        select movie_cd, count(movie_cd) as 'cntMovie'
        from watch_movie
        group by movie_cd
    ) c on m.movie_cd = c.movie_cd order by c.cntMovie desc limit 4;";

    if($stmt = mysqli_prepare($conn, $sql)) {

            if (mysqli_stmt_execute($stmt)) {
                if ($res = mysqli_stmt_get_result($stmt)) {
                    while ($newArray = mysqli_fetch_array($res)) {
                        $url = './filmInfo.php?code='.$newArray["movie_cd"];
                        echo '
                        <a href="'.$url.'">
                    <div class="individual">
                        <div class="poster">
                            <img width="110px" height="110px" src="'.$newArray['imgUrl'].'">
                        </div>
                        <div class="resultText">
                            <p class="movieName">'.$newArray['movie_nm'].'</p>
                        </div>
                    </div> 
                    </a>';
    }}}}

    $sql2 = "select t.genre from (
        select a.userid, count(*) as cntMovie, b.genre
        from watch_movie a
        inner join movie b on a.movie_cd=b.movie_cd
        group by a.userid, b.genre
     ) t where t.cntMovie = (
         select max(i.cnt) from (
             select a.userid, count(*) as cnt, b.genre
              from watch_movie a
              inner join movie b on a.movie_cd=b.movie_cd
              where a.userid = ?
              group by b.genre
         ) i
     ) and t.userid = ?;";

     $genre = null;

     if($stmt = mysqli_prepare($conn, $sql2)) {
        if (mysqli_stmt_bind_param($stmt, "ss", $_SESSION['userId'], $_SESSION['userId'])) {
            if (mysqli_stmt_execute($stmt)) {
                if ($res = mysqli_stmt_get_result($stmt)) {
                    while ($newArray = mysqli_fetch_array($res)) {
                        $genre = $newArray['genre'];
}}}}}}

?>
                </div>
            </div>

            <div class="trend3">
            <h4 class="trendSubTitle">최신 개봉 영화 추천</h4>
            <div class="resultList">
                <?php
                    $sql3 = "select * from (
                        select movie_cd, movie_nm, imgUrl, open_dt
                        from movie
                        group by open_dt with rollup
                    ) a order by a.open_dt desc limit 8";
                
                    if($stmt = mysqli_prepare($conn, $sql3)) {
                
                            if (mysqli_stmt_execute($stmt)) {
                                if ($res = mysqli_stmt_get_result($stmt)) {
                                    while ($newArray = mysqli_fetch_array($res)) {
                                        $url = './filmInfo.php?code='.$newArray["movie_cd"];
                                        echo '
                                        <a href="'.$url.'">
                                    <div class="individual">
                                        <div class="poster">
                                            <img width="110px" height="110px" src="'.$newArray['imgUrl'].'">
                                        </div>
                                        <div class="resultText">
                                            <p class="movieName">'.$newArray['movie_nm'].'</p>
                                        </div>
                                    </div> 
                                    </a>';
                    }}}}

                    # close connection
                    mysqli_stmt_close($stmt);
                ?>
                </div>
            </div>
            
<div class="trend2">
                <h4 class="trendSubTitle">내가 가장 많이 감상한 영화 장르</h4>
                <div class="genreImg"><img id="defaultImg" src="../../img/cinema.png"></div>
                <h2 class="genreTitle"><?=$genre?></h2>
            </div>

            <div class="trend4">
                <h4 class="trendSubTitle">연도별 장르 평점</h4>
                <h3>2018</h3>
                <div class="resultList_genre">

                    <?php
                        $sql4 = "SELECT open_yr, rep_genre, avg(rate) from movie where open_yr >= 2018 GROUP BY open_yr, rep_genre with ROLLUP;";

                        if($stmt = mysqli_prepare($conn, $sql4)) {
                            if (mysqli_stmt_execute($stmt)) {
                                if ($res = mysqli_stmt_get_result($stmt)) {
                                    while ($newArray = mysqli_fetch_array($res)) {
                                        $rate = round($newArray['avg(rate)'],2);
                                        if ($newArray['rep_genre'] != NULL && $newArray['open_yr'] == "2018") {
                                            echo '
                                            <div class="rateTxt">
                                                <p>'.$newArray['rep_genre'].'</p>
                                                <p>'.$rate.'</p>
                                            </div>
                                            ';
                                        }}}}}   
                    ?>
                </div>
                <h3>2019</h3>
                <div class="resultList_genre">
                    <?php
                        $sql4 = "SELECT open_yr, rep_genre, avg(rate) from movie where open_yr >= 2018 GROUP BY open_yr, rep_genre with ROLLUP;";

                        if($stmt = mysqli_prepare($conn, $sql4)) {
                            if (mysqli_stmt_execute($stmt)) {
                                if ($res = mysqli_stmt_get_result($stmt)) {
                                    while ($newArray = mysqli_fetch_array($res)) {
                                        $rate = round($newArray['avg(rate)'],2);
                                        if ($newArray['rep_genre'] != NULL && $newArray['open_yr'] == "2019") {
                                            echo '
                                            <div class="rateTxt">
                                                <p>'.$newArray['rep_genre'].'</p>
                                                <p>'.$rate.'</p>
                                            </div>
                                            ';
                                        }}}}}   
                    ?>
                </div>
                <h3>2020</h3>
                <div class="resultList_genre">
                    <?php
                        $sql4 = "SELECT open_yr, rep_genre, avg(rate) from movie where open_yr >= 2018 GROUP BY open_yr, rep_genre with ROLLUP;";

                        if($stmt = mysqli_prepare($conn, $sql4)) {
                            if (mysqli_stmt_execute($stmt)) {
                                if ($res = mysqli_stmt_get_result($stmt)) {
                                    while ($newArray = mysqli_fetch_array($res)) {
                                        $rate = round($newArray['avg(rate)'],2);
                                        if ($newArray['rep_genre'] != NULL && $newArray['open_yr'] == "2020") {
                                            echo '
                                            <div class="rateTxt">
                                                <p>'.$newArray['rep_genre'].'</p>
                                                <p>'.$rate.'</p>
                                            </div>
                                            ';
                                        }}}}}   
                    ?>
                </div>
                <h3>2021</h3>
                <div class="resultList_genre">
                    <?php
                        $sql4 = "SELECT open_yr, rep_genre, avg(rate) from movie where open_yr >= 2018 GROUP BY open_yr, rep_genre with ROLLUP;";

                        if($stmt = mysqli_prepare($conn, $sql4)) {
                            if (mysqli_stmt_execute($stmt)) {
                                if ($res = mysqli_stmt_get_result($stmt)) {
                                    while ($newArray = mysqli_fetch_array($res)) {
                                        $rate = round($newArray['avg(rate)'],2);
                                        if ($newArray['rep_genre'] != NULL && $newArray['open_yr'] == "2021") {
                                            echo '
                                            <div class="rateTxt">
                                                <p>'.$newArray['rep_genre'].'</p>
                                                <p>'.$rate.'</p>
                                            </div>
                                            ';
                                        }}}}}   
                    ?>
                    </div>
                <h3>2022</h3>
                <div class="resultList_genre">
                    <?php
                        $sql4 = "SELECT open_yr, rep_genre, avg(rate) from movie where open_yr >= 2018 GROUP BY open_yr, rep_genre with ROLLUP;";

                        if($stmt = mysqli_prepare($conn, $sql4)) {
                            if (mysqli_stmt_execute($stmt)) {
                                if ($res = mysqli_stmt_get_result($stmt)) {
                                    while ($newArray = mysqli_fetch_array($res)) {
                                        $rate = round($newArray['avg(rate)'],2);
                                        if ($newArray['rep_genre'] != NULL && $newArray['open_yr'] == "2022") {
                                            echo '
                                            <div class="rateTxt">
                                                <p>'.$newArray['rep_genre'].'</p>
                                                <p>'.$rate.'</p>
                                            </div>
                                            ';
                                        }}}}}   
                                    # close connection
                                    mysqli_stmt_close($stmt);
                                    mysqli_close($conn);
                    ?>
                </div>

        </section>

    </div>
    

    <script src="search.js" charset="utf-8">
    </script>
    </body>
</html>