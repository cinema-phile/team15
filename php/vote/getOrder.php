
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


function getVoteNum( $conn, $id) {
    // $conn = mysqli_connect("localhost", "team15", "team15", "team15");
    $sql =  "select vote from character_ranking where character_id=".$id.";";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    // echo '<h1>'.$row['vote'].'</h1>';
    return $row['vote'];
}


# DB Connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");


$sex = $_POST['sex'];

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

    while( $row = mysqli_fetch_array( $result ) ) {

        $id = $row["character_id"]; // id
        $name = $row["cast_nm"]; // 배역 명 
        $rank=$row["rank() over (order by vote desc)"]; // 등수
        getVoteNum($conn, "153");
        echo '<div>';
        echo  '<img  src="../../img/profile-50.svg" />';
        echo ' <div class="bar-'.$rank.'">';
        echo '<span class="bar-name">'.$row["cast_nm"].'</span>';
        echo '<span class="bar-vote">'.$name.'</span>';
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


        echo  '<li class="rank-content">';
        echo '<div class = "rank-num">'.$rank.'</div>';
        echo    '<div class = "rank-profile">';
        echo      '<img  src="../../img/profile-50.svg" />';
        echo        '<div>';
        echo            '<span class = "profile-name">'.$name.'</span>';
        echo            '<span class = "profile-movie">꽃보다 남자</span>';
        echo        '</div>';  
        echo   '</div>';
        echo    '<div class = "rank-vote">'.$voteNum.'</div>';
        echo '<form action="../../php/vote/makeVote.php" method="post">';
        echo    '<button class="rank-btn" name ="id" value='.$id.'  type="submit">투표하기</button>';
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

