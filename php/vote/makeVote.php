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
        
        header('Content-Type: text/html; charset=utf-8');

        
        
        $id = $_POST['id'];
        echo ".$id.";
        # DB Connection
        $conn = mysqli_connect("localhost", "team15", "team15", "team15");


        if (mysqli_connect_errno()) {
            echo "<script>alert('Log in fail');</script>";
            exit();
        } else {
            $sql1 = "select * from characters where character_id=".$id.";";
            $result = mysqli_query($conn, $sql1);
            $row = mysqli_fetch_array($result);
            $movie_id = $row["movie_cd"];
            $name=$row["cast_nm"];


            $sql2="select * from movie where movie_cd=".$movie_id.";";
            $result = mysqli_query($conn, $sql2);
            $row = mysqli_fetch_array($result);
            $detail=$row["story"];
            $movieTitle=$row["movie_nm"];


            echo '<section class="vote-block">';
            echo '<img  src="../../img/profile-150.svg" />';
            echo '<div class="profile-info">';
            echo    '<span class = "profile-name">'.$name.'</span>';
            echo    '<span class = "profile-movie">'.$movieTitle.'</span>';
            echo '</div>';
            echo '<div class = "profile-description">';
            echo    '<span>'.$detail.'</span>';
            echo '</div>';
            echo '</section>';

            echo '<section class = "btn-block">';
            echo '<form action="updateVote.php" method="post">';
            echo '   <button class="filter-btn" type="submit" name="id" value='.$id.'>투표하기</button>';
            echo '</form>';
            echo '<button>다시 시작하기</button>';
            echo '</section>';

        }
        mysqli_close($conn);

    
    
        ?>

</body>
</html>