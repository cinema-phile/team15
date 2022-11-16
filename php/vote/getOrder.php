
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../pages/vote/index.css"/>
    <link rel="stylesheet" type="text/css" href="../../index.css"/>
    <title>Board</title>
</head>
<body>
<div id="contents">
    <header>
        <h1 class="title">LEADER BOARD</h1>
    </header>        
    <div class="menu">
            <a href="../../pages/search/search.php"><h4 class="eachMenu">SEARCH</h4></a>
            <a href="../../pages/vote/index.html"><h4 class="eachMenu">VOTE</h4></a>
            <a href="../../pages/recommend/index.html"><h4 class="eachMenu">RECOMMEND</h4></a>
            <a href="../../pages/community/index.php"><h4 class="eachMenu">COMMUNITY</h4></a>
            <a href="../../pages/mypage/index.php"><h4 class="eachMenu">MYPAGE</h4></a>
        </div>


    <section class = "filter-block">
        <form action="../../php/vote/getOrder.php" method="post">
            <button class="filter-btn" type="submit" name="sex" value = "남성&여성">전체보기</button>
        </form>
        <form action="../../php/vote/getOrder.php" method="post">
            <button class="filter-btn" type="submit" name="sex" value = "여자">여성</button>
        </form>
        <form action="../../php/vote/getOrder.php" method="post">
            <button class="filter-btn" type="submit" name="sex" value = "남자">남성</button>
        </form>
    </section>

<!--상위 3개를 출력하는 php-->


<?php


function getVoteNum( $conn, $id) {
    // $conn = mysqli_connect("localhost", "team15", "team15", "team15");
    $sql =  "select vote from character_ranking where character_id=".$id.";";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    // echo '<h1>'.$row['vote'].'</h1>';
    if(isset($row['vote'])) {
        return $row['vote'];
    } else {
        return 0;
    }
    
}


function getMovieTitle($conn, $id){
    $sql ="select movie_nm from movie where movie_cd=(select movie_cd from characters a inner join  character_ranking b on a.character_id=b.character_id where a.character_id=".$id.");";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    // echo '<h1>'.$row['vote'].'</h1>';
    return $row['movie_nm'];
}


function getActorImg($conn,$id){
    //$sql="select profile from people where people_cd=(select people_cd from characters where character_id=(select character_id from character_ranking where character_id=".$id."));";
    $sql="select profile from people where people_cd=(select people_cd from characters where character_id=(select character_id from character_ranking where character_id=".$id."));";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    //echo '<h1>'.$row['profile'].'</h1>';
    return $row['profile'];
}



# DB Connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");

if(isset($_POST['sex'])) {
    $sex = $_POST['sex'];
} else {
    $sex = null;
}

if ($sex=="남자"){
    $sql="select rank() over (order by vote desc), cast_nm, a.character_id from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='' and sex='남자' limit 3;";
}
elseif($sex=="여자"){
    $sql = "select rank() over (order by vote desc), cast_nm, a.character_id from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='' and sex='여자' limit 3;";
}
else{
   $sql = "select rank() over (order by vote desc), cast_nm, a.character_id from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='' limit 3;";
}


if (mysqli_connect_errno()) {
    echo "<script>alert('Log in fail');</script>";
    exit();
} else {
    // echo '<p >'.$sex.'</p>';
    $result = mysqli_query( $conn, $sql );
    echo '<section class = "rank-bar">';
    $rank = 1;

    while( $row = mysqli_fetch_array( $result ) ) {

        $id = $row["character_id"]; // id
        $name = $row["cast_nm"]; // 배역 명 
        $rank=$row["rank() over (order by vote desc)"]; // 등수
        $voteNum = getVoteNum($conn, $id);
        $imgUrl=getActorImg($conn,$id);
        echo '<div>';
        echo      '<img class="bar-img" src="'.$imgUrl.'" />';
        echo ' <div class="bar-'.$rank.'">';
        echo '<span class="bar-name">'.$name.'</span>';
        echo '<span class="bar-vote">'.$voteNum.'</span>';
        echo '</div>';
        echo '</div>';



      }
      echo '</section>';
    }

      mysqli_close($conn);

    
    
    ?>

<!-- 순위를 출력하는 목록-->
<?php
header('Content-Type: text/html; charset=utf-8');
/**
 * show all rank
 * "전체보기" 버튼 클릭
 * SELECT 1
**/

# DB Connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");

$cnt=1;

if(isset($_POST['sex'])) {
    $sex = $_POST['sex'];
} else {
    $sex = null;
}

if ($sex=="남자"){
    $sql = "select rank() over (order by vote desc), cast_nm, a.character_id from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='' and sex='남자';";
}
elseif($sex=="여자"){
    $sql = "select rank() over (order by vote desc), cast_nm, a.character_id from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='' and sex='여자';";
}
else{
    $sql = "select rank() over (order by vote desc), cast_nm, a.character_id from characters a inner join character_ranking b on a.character_id=b.character_id where cast_nm!='';";
}

if (mysqli_connect_errno()) {
    echo "<script>alert('Log in fail');</script>";
    exit();
} else {
    $result = mysqli_query( $conn, $sql );
    echo '<section class = "rank-block">';
    echo '<ol>';
    while( $row = mysqli_fetch_array( $result ) ) {
        $id = $row["character_id"]; // id
        $name = $row["cast_nm"]; // 배역 명 
        $rank=$row["rank() over (order by vote desc)"]; // 등수
        // $voteNum=getVoteNum($conn, $id);
        $voteNum = getVoteNum($conn, $id);
        $movieTitle= getMovieTitle($conn, $id);
        $imgUrl=getActorImg($conn,$id);


        echo  '<li class="rank-content">';
        echo '<div class = "rank-num">'.$rank.'</div>';
        echo    '<div class = "rank-profile">';
        echo      '<img class="bar-img" src="'.$imgUrl.'" />';
        echo        '<div>';
        echo            '<span class = "profile-name">'.$name.'</span>';
        echo            '<span class = "profile-movie">'.$movieTitle.'</span>';
        echo        '</div>';  
        echo   '</div>';
        echo   '<div class="rank-btn-block">';
        echo    '<div class = "rank-vote">'.$voteNum.'</div>';
        echo '<form action="makeVote.php" method="post">';
        echo    '<button class="rank-btn" name ="id" value='.$id.' >투표하기</button>';
        echo '</form>';
        echo   '</div>';
        echo    '</li>';

       
      }
      echo '</ol>';
      echo '</section>';
    mysqli_close($conn);

}

?>
    </div>
</body>
</html>
