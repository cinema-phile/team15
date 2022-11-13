<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../index.css">
    <link rel="stylesheet" href="searchStyle.css">
    <title>SEARCH</title>
</head>
<body>
    <div id="contents">
        <header class="title">
            <p>SEARCH</p>
        </header>
        <section class="menu">
            <a href="../search/index.html"><h4 class="eachMenu">SEARCH</h4></a>
            <a href="../vote/index.html"><h4 class="eachMenu">VOTE</h4></a>
            <a href="../recommend/index.html"><h4 class="eachMenu">RECOMMEND</h4></a>
            <a href="../community/index.html"><h4 class="eachMenu">COMMUNITY</h4></a>
            <a href="../mypage/index.html"><h4 class="eachMenu">MYPAGE</h4></a>
        </section>
        
        <section class="result">
            <?php
            if ($_GET['category'] == "film") {
            echo '
            <h3 class="resultText">검색하신 단어 <span id="span">'.$_GET['searchKeyword'].'</span>이 제목에 포함된 ';
                if ($_GET['check'] == "액션" || $_GET['check'] == "코미디" || $_GET['check'] == "로맨스" || $_GET['check'] == "드라마" || 
                $_GET['check'] == "SF" || $_GET['check'] == "애니메이션" || $_GET['check'] == "다큐멘터리" || $_GET['check'] == "공포" || $_GET['check'] == "스릴러") {
                    echo ' '.$_GET['check'].' 장르의 영화입니다.</h3>';
                }
                else {
                    echo '영화입니다.</h3>';
                }
            }
            else {
            echo '
            <h3 class="resultText">검색하신 단어 <span id="span">'.$_GET['searchKeyword'].'</span>이 이름에 포함된 영화인입니다.</h3>';
            }?>
            <div class="resultList">

<?php

$searchKeyword = $_GET['searchKeyword'];
$category = $_GET['category'];
$condition = $_GET['condition'];
$check = $_GET['check'];

# DB Connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");

if (mysqli_connect_errno()) {
    echo "<script>alert('connect error');</script>";
    exit();
}
else {

if ($category == "film") {

    if ($check == NULL) {

        $sql = "select movie_nm, open_yr, imgUrl, movie_cd from movie where INSTR(movie_nm, ?);";

    if($stmt = mysqli_prepare($conn, $sql)) {
        if (mysqli_stmt_bind_param($stmt, "s", $searchKeyword)) {
            if (mysqli_stmt_execute($stmt)) {
                if ($res = mysqli_stmt_get_result($stmt)) {
                    while ($newArray = mysqli_fetch_array($res)) {
                        echo '
                        <div class="individual" onclick="post('.$newArray["movie_cd"].');">
                            <div class="poster">
                                <img src="'.$newArray["imgUrl"].'" width=110px height=110px>
                            </div>
                            <div class="resultText">
                                <p class="movieName">'.$newArray["movie_cd"].'</p>
                                <p class="year">'.$newArray["open_yr"].'</p>
                            </div>
                        </div>';
                        
        }}}}}
    }

    else {

            if ($check == "액션" || $check == "코미디" || $check == "로맨스" || $check == "드라마" || 
            $check == "SF" || $check == "애니메이션" || $check == "다큐멘터리" || $check == "공포" || $check == "스릴러") {
                $sql2 = "select movie_nm, open_yr, imgUrl, movie_cd from movie where INSTR(movie_nm, ?) and INSTR(genre, ?);";

                if($stmt = mysqli_prepare($conn, $sql2)) {
                    if (mysqli_stmt_bind_param($stmt, "ss", $searchKeyword, $check)) {
                        if (mysqli_stmt_execute($stmt)) {
                            if ($res = mysqli_stmt_get_result($stmt)) {
                                while ($newArray = mysqli_fetch_array($res)) {
                                    echo '
                                    <div class="individual">
                                    <div class="poster">
                                    <img src="'.$newArray["imgUrl"].'" width=110px height=110px>
                                    </div>
                                    <div class="resultText">
                                    <p class="movieName">'.$newArray["movie_nm"].'</p>
                                    <p class="year">'.$newArray["open_yr"].'</p>
                                    </div>
                                    </div>';
                                    
                }
            }}}}
            }

            else if ($check == "전체" || $check == "청소년" || $check == "12" || $check == "15") {
                $sql3 = "select * from (
                    select movie_cd, movie_nm, open_yr, imgUrl, movie_cd
                    from movie
                    where INSTR(movie_nm, ?) and INSTR(age, ?)
                    group by open_yr with rollup
                ) a order by a.open_yr desc;";

                if($stmt = mysqli_prepare($conn, $sql3)) {
                    if (mysqli_stmt_bind_param($stmt, "ss", $searchKeyword, $check)) {
                        if (mysqli_stmt_execute($stmt)) {
                            if ($res = mysqli_stmt_get_result($stmt)) {
                                while ($newArray = mysqli_fetch_array($res)) {
                                    echo '
                                    <div class="individual">
                                    <div class="poster">
                                    <img src="'.$newArray["imgUrl"].'" width=110px height=110px>
                                    </div>
                                    <div class="resultText">
                                    <p class="movieName">'.$newArray["movie_nm"].'</p>
                                    <p class="year">'.$newArray["open_yr"].'</p>
                                    </div>
                                    </div>';
                                    
                                }
                            }}}}
            }
    }
}
else {
    if ($check == NULL) {
        $sql4 = "select people_cd, people_nm, rep_role_nm, sex, profile from people where INSTR(people_nm, ?);";

        if($stmt = mysqli_prepare($conn, $sql4)) {
            if (mysqli_stmt_bind_param($stmt, "s", $searchKeyword)) {
                if (mysqli_stmt_execute($stmt)) {
                    if ($res = mysqli_stmt_get_result($stmt)) {
                        while ($newArray = mysqli_fetch_array($res)) {
                            echo '
                            <div class="individual">
                            <div class="pic">';
                            if ($newArray["profile"] != NULL) {
                                echo '<img id="pic" src="https://'.$newArray["profile"].'">';
                            }
                            echo '</div>
                            <div class="resultText">
                            <p class="personName">'.$newArray["people_nm"].'</p>
                            <p class="role">'.$newArray["rep_role_nm"].'</p>
                            </div>
                            </div>';
        }
    }}}}
    }
    else {
        $sql5 = "select people_cd, people_nm, rep_role_nm, sex, profile from people where INSTR(people_nm, ?) and INSTR(rep_role_nm, ?);";

        if($stmt = mysqli_prepare($conn, $sql5)) {
            if (mysqli_stmt_bind_param($stmt, "ss", $searchKeyword, $check)) {
                if (mysqli_stmt_execute($stmt)) {
                    if ($res = mysqli_stmt_get_result($stmt)) {
                        while ($newArray = mysqli_fetch_array($res)) {
                            
                            echo '
                            <div class="individual">
                            <div class="pic">';
                            if ($newArray["profile"] != NULL) {
                                echo '<img id="pic" src="https://'.$newArray["profile"].'">';
                            }
                            echo '</div>
                            <div class="resultText">
                            <p class="personName">'.$newArray["people_nm"].'</p>
                            <p class="role">'.$newArray["rep_role_nm"].'</p>
                            </div>
                            </div>';
        }}}}}}
    }
}


?>
</div> 
        </section>

</div>
<!--
<script>
    function post(code) {
    var url = "http://localhost/filmInfo.php?code="+code;
    location.href(url);
-->
</script>
</body>
</html>