
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../index.css"/>
    <link rel="stylesheet" href="../../pages/vote/index.css"/>
    <title>Board</title>
</head>
<body>
    <header>
        <h1 class="title">LEADER BOARD</h1>
    </header>
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

# DB Connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");


$sex = $_POST['sex'];

if ($sex=="남자"){
    $sql = "select cast_nm from characters where sex='남자' and character_id IN (select character_id from character_ranking order by vote desc) limit 3;";
}
elseif($sex=="여자"){
    $sql = "select cast_nm from characters where sex='여자' and character_id IN (select character_id from character_ranking order by vote desc) limit 3;";
}
else{
    $sql = "select cast_nm from characters where character_id IN (select character_id from character_ranking order by vote desc) limit 3;";
}


if (mysqli_connect_errno()) {
    echo "<script>alert('Log in fail');</script>";
    exit();
} else {
    echo '<p >'.$sex.'</p>';
    $result = mysqli_query( $conn, $sql );
    echo '<section class = "rank-bar">';

    while( $row = mysqli_fetch_array( $result ) ) {
        echo '전체보기';
        echo '<span >'.$sex.'</span>';
        echo '<div>';
        echo  '<img  src="../../img/profile-50.svg" />';
        echo ' <div class="bar-2">';
        echo '<span class="bar-name">'.$row["cast_nm"].'</span>';
        echo '<span class="bar-vote">구준표</span>';
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

$sex = $_POST['sex'];

if ($sex=="남자"){
    $sql = "select cast_nm from characters where sex='남자' and character_id IN (select character_id from character_ranking order by vote desc);";
}
elseif($sex=="여자"){
    $sql = "select cast_nm from characters where sex='여자' and character_id IN (select character_id from character_ranking order by vote desc);";
}
else{
    $sql = "select cast_nm from characters where character_id IN (select character_id from character_ranking order by vote desc);";
}

if (mysqli_connect_errno()) {
    echo "<script>alert('Log in fail');</script>";
    exit();
} else {
    echo '<p >'.$sex.'</p>';
    $sql =  "select cast_nm from characters where character_id IN (select character_id from character_ranking order by vote desc)";
    $result = mysqli_query( $conn, $sql );
    $cnt=1;
    echo '<section class = "rank-block">';
    echo '<ol>';
    while( $row = mysqli_fetch_array( $result ) ) {
        echo  '<li class="rank-content">';
        echo '<div class = "rank-num">'.$cnt++.'</div>';
        echo    '<div class = "rank-profile">';
        echo      '<img  src="../../img/profile-50.svg" />';
        echo        '<div>';
        echo            '<span class = "profile-name">'.$row["cast_nm"].'</span>';
        echo            '<span class = "profile-movie">꽃보다 남자</span>';
        echo        '</div>';  
        echo   '</div>';
        echo    '<div class = "rank-vote"> 1,2389 </div>';
        echo '<form action="../../php/vote/makeVote.php" method="post">';
        echo    '<button class="rank-btn" name ="id" value=1  type="submit">투표하기</button>';
        echo '</form>';
        echo    '</li>';

       
      }
      echo '</ol>';
      echo '</section>';
    mysqli_close($conn);

}

?>
    
</body>
</html>

