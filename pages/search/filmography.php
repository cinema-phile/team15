<?php
header('Content-Type: text/html; charset=utf-8');

if (!session_id()) {
    session_start();
}
?>

<?php
    $code = $_GET['code'];

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
                                $profile = " src= 'https://".$newArray['profile']."'";
                            }
                            else if ($newArray['profile'] == NULL && $newArray['sex'] == "여자") {
                                $profile = " src= '../../img/woman.png'";
                            }
                            else {
                                $profile = " src= '../../img/man.png'";
                            }

                        }}}}}


        $sql3 = "insert into star_people (userid, people_cd) values (?, ?);";
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
            <a href="../search/index.html"><h4 class="eachMenu">SEARCH</h4></a>
            <a href="../vote/index.html"><h4 class="eachMenu">VOTE</h4></a>
            <a href="../recommend/index.html"><h4 class="eachMenu">RECOMMEND</h4></a>
            <a href="../community/index.html"><h4 class="eachMenu">COMMUNITY</h4></a>
            <a href="../mypage/index.html"><h4 class="eachMenu">MYPAGE</h4></a>
        </section>

        <section class="profile">
            <img class="profileimg" <?=$profile?>>
            <div class="profiletitle">
                <img id="star" src="../../img/star_empty.svg" onclick="starClicked();">
                <div class="nameLayout"><p class="name"><?=$people_nm?></p><br><p class="name_eng"><?=$people_nm_en?></p></div>
            </div>
        </section>


        <section class="filmolist">
            <div class="fanscore">
                <div class="fanscore-L">나의 팬 지수 <span id="fanscorespan">%</span> | 평균 팬 지수 <span id="fanscorespan">%</span></div>
                <p class="fanscore-R"><span id="span">23522</span> 작품 중 <span id="span">231</span> 개 관람</p>
            </div>
            <progress class="fanGraph" min="0" max="100" value="22.8"></progress>


            <div class="characterList">
<?php

            $sql2 = "select m.movie_cd, m.movie_nm, m.imgUrl, c.cast_nm
            from characters as c
            left join movie as m on m.movie_cd = c.movie_cd
            left join people as p on c.people_cd = p.people_cd
            where c.people_cd = ?;";

            if($stmt = mysqli_prepare($conn, $sql2)) {
                if (mysqli_stmt_bind_param($stmt, "s", $code)) {
                    if (mysqli_stmt_execute($stmt)) {
                        if ($res = mysqli_stmt_get_result($stmt)) {
                            while ($newArray = mysqli_fetch_array($res)) {
                                
                                $movie_nm = $newArray['movie_nm'];
                                $cast_nm = $newArray['cast_nm'];
                                $imgUrl = $newArray['imgUrl'];
                                $url = 'http://localhost/team15/pages/search/filmInfo.php?code='.$newArray["movie_cd"];
                                echo '
                                <a href="'.$url.'">
                                <div class="individualChar">
                                <div class="charProfileImg">
                                    <!-- <img class="tag" src="../../img/tag.svg"> -->
                                    <img id="charPic" src="'.$imgUrl.'">
                                </div>
                                <div class="charText">
                                    <p class="charName">'.$cast_nm.'</p>
                                    <p class="charMovie">'.$movie_nm.'</p>
                                </div>
                                </div>
                                </a>';
                                
            }}}}}
?>
            </div>
        </section>
    </div>
    <script>
        var index = 0;
        function starClicked() {
            index++;
            if (index%2 == 0) {
                document.getElementById('star').src="../../img/star_empty.svg";
            }
            else {
                document.getElementById('star').src="../../img/star_full.svg";
            }
        }
    </script>
</body>
</html>