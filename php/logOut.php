    <?php
        session_unset($_SESSION["userId"]);
        session_destroy();
        echo '<h1>로그아웃 하였습니다.</h1>';
    ?>
