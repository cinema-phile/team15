<?php

include ("../../php/test/showResult.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../index.css">
    <link rel="stylesheet" href="./index.css"/>
    <title>Document</title>
</head>
<body>
    <div id="contents">
        <header>
            <h1 class="title">Recommend</h1>
        </header>
        <div class="menu">
            <a href="../search/search.php"><h4 class="eachMenu">SEARCH</h4></a>
            <a href="../vote/index.html"><h4 class="eachMenu">VOTE</h4></a>
            <a href="../recommend/index.html"><h4 class="eachMenu">RECOMMEND</h4></a>
            <a href="../community/index.php"><h4 class="eachMenu">COMMUNITY</h4></a>
            <a href="../mypage/index.html"><h4 class="eachMenu">MYPAGE</h4></a>
        </div>

         <!--테스트 결과-->
         <section class="result genre">
            <div class = "genre-img">
                <img src="../../img/horror.svg"/>
            </div>
            <div class="genre-text">
                <span class="title3 text-main"><?php echo $typeTitle; ?></span>
                <span class="title5"><?php echo $typeContent; ?></span>

            </div>
           
         </section>

         <section class="result list">
            <p class="title3 list-title">탕탕! 취향 저격</p>
            <div class="item">
                <span class="title4"><?php echo $directorFirstName; ?></span> 
                <div class="title4 line"></div>
                <span class="title5 movie-title">쏘우</span>
                <span class="title5 movie-title">컨저링</span>
                <span class="title5 movie-title">인시디어스</span>
            </div>   
        </section>
         <div class="btn">
            <button class="btn-main php">결과 저장하기
                <form method="get"  action="../../php/test/saveResult.php">
                    <input class="btn-main input" type="submit" name="genre" id="genre" value="" /><br/>
                </form>
            </button>

       
            <button class="btn-optional" onclick="js:retest()">다시 검사하기</button>
        </div>

    </div>
    <!--<script src="./genreData.js" charset="utf-8"></script>
    <script src="./result.js" charset="utf-8"></script>-->
</body>
</html>