<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../index.css"/>
    <link rel="stylesheet" href="../../pages/vote/index.css"/> 
    <title>VOTE</title>
</head>
<body>
    <header>
        <h1 class="title">VOTE</h1>
    </header>


    <?php
        $id = $_POST['id'];
        $sql = "select * from characters where character_id=".$id.";";
        # DB Connection
        $conn = mysqli_connect("localhost", "team15", "team15", "team15");

        if (mysqli_connect_errno()) {
            echo "<script>alert('Log in fail');</script>";
            exit();
        } else {
            $result = mysqli_query( $conn, $sql );
        }
        mysqli_close($conn);

    
    
        ?>
    ?>
    <section class="vote-block">
        <img  src="../../img/profile-150.svg" />
        <div class="profile-info">
            <span class = "profile-name">구준표</span>
            <span class = "profile-movie">꽃보다 남자</span>
        </div>
        <div class = "profile-description">
            <span>남주인공으로, 원작의 도묘지 츠카사 포지션이자 F4의 리더. 남주인공으로, 원작의 도묘지 츠카사 포지션이자 F4의 리더. 남주인공으로, 원작의 도묘지 츠카사 포지션이자 F4의 리더. 
                대한민국의 대표재벌 신화그룹의 후계자이다. 원작의 도묘지 츠카사와 마찬가지로 천상천하 유아독존의 전형적인 재벌2세 타입.</span>
        </div>
    </section>
    <section class = "btn-block">
        <form action="../../php/vote/makeVote.php" method="post">
            <button class="filter-btn" type="submit" name="id" value =1>결과 저장하기</button>
        </form>
        <button>다시 시작하기</button>
    </section>
</body>
</html>