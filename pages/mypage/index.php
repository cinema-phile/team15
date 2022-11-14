<?php

include ("../../php/mypage/showInfo.php");

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../index.css">
        <!--<link  rel="stylesheet" href="../../php/mypage/showInfo.php">-->
        <link rel="stylesheet" href="./index.css"/>
        <title>MyPage</title>
    </head>
    <body>
        <header>
            <h1 class="title">My Page</h1>
        </header>
        <div class="menu">
            <a href="../search/index.html"><h4 class="eachMenu">SEARCH</h4></a>
            <a href="../vote/index.html"><h4 class="eachMenu">VOTE</h4></a>
            <a href="../recommend/index.html"><h4 class="eachMenu">RECOMMEND</h4></a>
            <a href="../community/index.html"><h4 class="eachMenu">COMMUNITY</h4></a>
            <a href="../mypage/index.php"><h4 class="eachMenu">MYPAGE</h4></a>
        </div>
        <section class="me">
            <div class="me-info">
                <img src="../../img/profile-50.svg"/>
                <div class="text-block">
                    <p><?php echo $preferGenre; ?>를 사랑하는</p>
                    <p><?php echo $name; ?>님</p>
                </div>
            </div>

            <img src="../../img/arrow-red.svg" onclick="window.location.href='../../pages/mypage/info.php'">
        </section>

        <main class="interest-block">

            <section class="interest-movie">
                <div class="text-block">
                    <p>관심 영화 모아보기</p>
                    <p><?php echo $movieCnt; ?>개</p>
                </div>
                <img src="../../img/arrow-red.svg">
            </section>
            <section class="interest-actor">
                <div class="text-block">
                    <p>관심 배우 모아보기</p>
                    <p><?php echo $peopleCnt; ?>개</p>
                </div>
                <img src="../../img/arrow-red.svg">
            </section>
        </main>
        <section class="watch">
            <div class="text-block">
                <p>관람 내역</p>
                <p><?php echo $movieCnt; ?>개</p>
            </div>

            <div class="text-block">
                <p>최근 관람 영화</p>
                <p><?php echo $recentMovie; ?></p>
            </div>

            <div class="text-block">
                <p>관람 목록</p>
                <p>보러가기</p>
            </div>
        </section>
        <div class = "btn-block">
                    <button type="submit">로그 아웃</button>
                <button>회원 탈퇴</button>
            </div>

    </body>
</html>