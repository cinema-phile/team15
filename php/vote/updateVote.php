<?php
        $id = $_POST['id'];
        echo ".$id.";
        # DB Connection
        $conn = mysqli_connect("localhost", "team15", "team15", "team15");

        if (mysqli_connect_errno()) {
            echo "<script>alert('Log in fail');</script>";
            exit();
        } else {

            $sql = "update character_ranking set vote=vote+1 where character_id=".$id.";";
            $res = mysqli_query($conn, $sql);
            // echo ".$id.";
            header("Location:../../pages/vote/index.html");

        }


        mysqli_close($conn);

?>