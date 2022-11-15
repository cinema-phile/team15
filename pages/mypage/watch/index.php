<?php
header('Content-Type: text/html; charset=utf-8');

if (!session_id()) {
    session_start();
}
$id = $_SESSION['userId'];
// echo "$id";


function getUserWatchedMovieArray($conn, $id){

    $res = array();


    #prepare statement
    $sql="select movie_nm, imgUrl, directors, runtime, open_yr, genre from movie where movie_cd IN (select movie_cd from watch_movie where userid=?);";
    
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $id);

        # run the query
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $movie_nm, $imgUrl, $directors,$runtime, $open_yr, $genre);
            while(mysqli_stmt_fetch($stmt)) {
                $movie = [
                    "movie_nm" => $movie_nm,
                    "imgUrl" => $imgUrl,
                    "directors" => $directors,
                    "runtime"=>$runtime,
                    "open_yr" => $open_yr,
                    "genre"=>explode(",", $genre) 
                ];
                array_push( $res, $movie);

            }
            //print_r($res);
        } else {
            echo "<script>alert('fail execute the query');</script>";
            exit();
        }
        
    
    }else {
        echo "<script>alert('Fail prepare the statement');</script>";
        exit();

    }
    # close connection
    mysqli_stmt_close($stmt);

    return $res;

}

# DB Connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");


if (mysqli_connect_errno()) {
    echo "<script>alert('Log in fail');</script>";
    exit();
} else {


    $userWatchedMovies=getUserWatchedMovieArray($conn, $id);
    // print_r($userLikedMovies);
    mysqli_close($conn);

}

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../../../index.css">
    <title>My Page - Likes</title>
</head>
<body>
    <header>
        <h1 class="title">My Page</h1>
    </header>

    <section class="likes-block">
        <p class="likes-title">관심 표시한 영화 모아보기</p>
        <div class="likes-items">
        <?php
            for ($i=0; $i < count($userWatchedMovies); $i++) {
        ?>
            <div class="likes-item">
                <img class = "item-img" src=<?=$userWatchedMovies[$i]['imgUrl']?> />
                <p class="item-title"><?=$userWatchedMovies[$i]['movie_nm']?></p>
                <p class="item-description"><?=$userWatchedMovies[$i]['directors']?></p>
                <div>
                    <span class="item-description"><?=$userWatchedMovies[$i]['genre'][0]?></span>
                    <span class="item-description"><?=$userWatchedMovies[$i]['genre'][1]?></span>
                </div>
                <div>
                    <span class="item-description"><?=$userWatchedMovies[$i]['open_yr']?></span>
                    <span class="item-description"><?=$userWatchedMovies[$i]['runtime']?></span> 
                </div>
            </div>
        <?php
            }
        ?>

           
        </div>

    </section>
    <div class = "btn-block">
    <button onclick="window.location.href='../../mypage/index.php'">뒤로 가기</button>
    </div>

</body>
</html>