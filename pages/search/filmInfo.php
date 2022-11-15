<?php
header('Content-Type: text/html; charset=utf-8');

if (!session_id()) {
    session_start();
}
$num = 0;
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

<?php 
    $code = $_GET['code']; /*movie code from url*/
    $i = 0;

    # DB Connection
    $conn = mysqli_connect("localhost", "team15", "team15", "team15");
    $userId = $_SESSION['userId'];

    if (mysqli_connect_errno()) {
        echo "<script>alert('connect error');</script>";
        exit();
    }

    else {

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
                            $num2 = round($num, 2);
        }}}}};

        $sql = "select m.*, c.cast_nm, p.people_cd, p.people_nm, p.profile, p.sex
        from movie as m
        left join characters as c on m.movie_cd = c.movie_cd
        left join people as p on c.people_cd = p.people_cd
        where m.movie_cd = ?";

        if($stmt = mysqli_prepare($conn, $sql)) {
            if (mysqli_stmt_bind_param($stmt, "s", $code)) {
                if (mysqli_stmt_execute($stmt)) {
                    if ($res = mysqli_stmt_get_result($stmt)) {
                        while ($newArray = mysqli_fetch_array($res)) {

                            $url = 'http://localhost/filmography.php?code='.$newArray["people_cd"];

                            if ($i<1) {
                                echo '
                                <section class="filmInfo">
                                    <div class="topLayout">
                                        <div class="poster">
                                            <img src="'.$newArray['imgUrl'].'" width="240px" height="313px">
                                        </div>
                                        <div class="infoLayout">
                                            <div class="titleNtag">
                                                <p class="filmTitle">'.$newArray['movie_nm'].'</p>
                                                <img id="tag" src="../../img/tag.svg">
                                            </div>
                                        <div class="detailinfo">
                                            <p>감독 | '.$newArray['directors'].'</p>
                                            <p>개봉연도 | '.$newArray['open_yr'].'</p>
                                            <p>장르 | '.$newArray['genre'].'</p>
                                        </div>
                                        <div class="watched">회원의 <span id="span">'.$num2.'%</span>가 이 영화를 관람했습니다</div>
                                        <button class="watchedBtn" onclick="watchedBtnClicked();">봤어요!</button>
                                        </div> 
                                    </div>
                                    <p class="listTitle">스토리</p>
                                    <h5 class="story">'.$newArray['story'].'</h5>
                                    <section class="actorList">
                                        <p class="listTitle">출연 배우</p>
                                        <div class="actorProfile">';
                            }$i++;
                            if (1) {
                            echo '
                            <a href="'.$url.'">
                            <div class="individualActor">
                            <div class="actorImg">'; 

                                if ($newArray['profile'] != NULL) {
                                    echo '<img id="pic" src="https://'.$newArray['profile'].'">';
                                }
                                else if ($newArray['profile'] == NULL && $newArray['sex'] == '여자'){ 
                                    echo '<img id="pic" src="../../img/woman.png"> ';
                                }
                                else {
                                    echo '<img id="pic" src="../../img/man.png"> ';
                                }
                                echo '
                                    </div>
                                    <div class="actorText">
                                    <p class="actorName">'.$newArray['people_nm'].'</p>
                                    <p class="actorChar">'.$newArray['cast_nm'].'</p>
                                    </div>
                                    </div>
                                    </a>';
                                }
    }}}}}}
?>
</div>

</section>
</section>

</div>
<script>
    var index = -10;
    function watchedBtnClicked() {
        index *= -1;
        console.log(index);
        document.getElementById('tag').style = "z-index: "+index;
        
        if (index == 10) {
            /*< ?php
                $sql4 = "insert into watch_movie (userid, movie_cd) values (?, ?)";

                if($stmt = mysqli_prepare($conn, $sql4)) {
                    if (mysqli_stmt_bind_param($stmt, "ss", $userId, $code)) {
                        mysqli_stmt_execute($stmt);
                }};

            ?> */
        }
        else {
            
            /*< ?php
                $sql5 = "delete from watch_movie where userid = ? and movie_cd = ?";

                if($stmt = mysqli_prepare($conn, $sql5)) {
                    if (mysqli_stmt_bind_param($stmt, "ss", $userId, $code)) {
                        mysqli_stmt_execute($stmt);
                }}; 
            ?> */
        } 
    }
</script>
</body>
</html>