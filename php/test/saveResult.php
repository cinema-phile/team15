<?php
    header('Content-Type: text/html; charset=utf-8');
    echo $_GET["genre"];
    
    if(!session_id()) {
        // id가 없을 경우 세션 시작
            session_start();
        }
        $type_nm = $_GET["genre"];

        //echo $_SESSION['userId'];
        $id = $_SESSION['userId'];

        /*$id = $_SESSION['userId'];*/

        //echo $type_nm;
        




        # DB Connection
        $conn = mysqli_connect("localhost", "team15", "team15", "team15");


       if (mysqli_connect_errno()) {
            echo "<script>alert('Log in fail');</script>";
            exit();
        } else {
            $sql="insert into test_result values (? , (select typeid from test where type_nm=? limit 1));";
 
            if($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ss", $id, $type_nm);
                # run the query
                if(mysqli_stmt_execute($stmt)) {
                    header("Location:../../pages/search/search.html");
                    //mysqli_stmt_bind_result($stmt, $res);
                    /*while(mysqli_stmt_fetch($stmt)) {
                        $success = $res;
                        echo $success;
                    }*/
                   
                } else {
                    echo "<script>alert('Log in fail');</script>";
                    exit();
                }
                


                # verify register test result
                /*if ($success == 1) {
                    header("Location:../pages/search/search.html");
                } else {
                    echo "<script>alert('Log in fail');</script>";
                    exit();
                }*/
                    }


        
        }
    # close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

?>