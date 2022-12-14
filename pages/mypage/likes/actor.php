<?php
header('Content-Type: text/html; charset=utf-8');

if (!session_id()) {
    session_start();
}
$id = $_SESSION['userId'];
// echo "$id";

function getUserLikedActorArray($conn, $id){
    $res=array();

    #prepare statement
    $sql="select people_nm, people_nm_en, profile, filmo_names, sex from people where people_cd IN (select people_cd from star_people where userid=?);";


    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $id);

       # run the query
       if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $people_nm, $people_nm_en, $profile, $filmo_names, $sex);
                while(mysqli_stmt_fetch($stmt)){
                    $actor = [
                        "people_nm"=>$people_nm, 
                        "people_nm_en"=>$people_nm_en,
                        "profile"=>$profile,
                        "filmo_names"=>explode("|",$filmo_names),
                        "sex"=>$sex


                    ];
                    array_push($res, $actor);

                }
            }else {
                echo "<script>alert('fail execute the query');</script>";
                exit();
            }
    }
    
    else {
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

    $userLikedActor=getUserLikedActorArray($conn, $id);
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
        <p class="likes-title">?????? ?????? ????????????</p>
        <div class="likes-items">

        <?php
            for ($i=0; $i < count($userLikedActor); $i++) {
        ?>
            <div class="likes-item">
                <?php
                if($userLikedActor[$i]['profile'] != NULL) {
                    $profile = $userLikedActor[$i]['profile'];
                ?>
                    <img class ="item-img" src=<?=$profile?> />
                <?php
                } else if ($userLikedActor[$i]['sex'] == '??????'){
                ?>
                    <img class ="item-img" src='../../../img/woman.png' />
                <?php
                } else {
                ?>
                    <img class ="item-img" src='../../../img/man.png' />
                <?php
                }
                $name = ($userLikedActor[$i]['people_nm_en'] != NULL) ? $userLikedActor[$i]['people_nm_en'] : $userLikedActor[$i]['people_nm'];
                ?>
                <p class="item-title"><?=$name?></p>
                <?php
                if(isset($userLikedActor[$i]['filmo_names'][0])) {
                ?>
                <span class="item-description"><?=$userLikedActor[$i]['filmo_names'][0]?></span>
                <?php
                } if(isset($userLikedActor[$i]['filmo_names'][1])) {
                ?>
                <span class="item-description"><?=$userLikedActor[$i]['filmo_names'][1]?></span>
                <?php
                }
                ?>
            </div>
        <?php
            }
        ?>


        </div>

    </section>
    <div class = "btn-block">
        <button onclick="window.location.href='../../mypage/index.php'">?????? ??????</button>
    </div>

</body>
</html>