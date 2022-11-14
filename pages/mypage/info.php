<?php

include ("../../php/mypage/showInfo.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../index.css">
        <!--<link  rel="stylesheet" href="../../php/mypage/showInfo.php">-->
        <link rel="stylesheet" href="./index.css"/>
    <title>My Page - Info</title>
</head>
<body>
    <header>
        <h1 class="title">My Page</h1>
    </header>
    <section class = "info-block">

        <form action="../../php/mypage/changeInfo.php" method="POST">
            <img src="../../img/profile-150.svg"/>
            <div class="info-profile">
                <div>
                    <label>이름</label>
                    <input type="text" name="name" value= <?php echo $name; ?>>
                </div>
                <div>
                    <label>아이디</label>
                    <input type="text" name="id" value=<?php echo $userid; ?> disabled/>
                </div>
                <div>
                    <label>비밀번호</label>
                    <input type="text" name="password" value=<?php echo $password; ?>> 
                </div>
                <div class = "btn-block">
                    <button type="submit" name="wantChange" value=True >정보 변경</button>
                    <button type = "submit" name="wantChange" value=False>뒤로 가기</button>
            </div>

            </div>

        </form>

    </section>


    
</body>
</html>