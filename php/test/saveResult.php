<?php
    header('Content-Type: text/html; charset=utf-8');
    // echo $_GET["genre"];
    
    if(!session_id()) {
        // id가 없을 경우 세션 시작
            session_start();
        }
        $type_nm = $_GET["genre"];
        $id = $_SESSION['userId'];


        # DB Connection
        $conn = mysqli_connect("localhost", "team15", "team15", "team15");


        function checkResultExist($conn, $id){
            $sql = "select exists (select * from test_result where userid=?) as exist;";
            # run the query
            $res = 0;
            # prepare statement
            if($stmt = mysqli_prepare($conn, $sql)) { 
                mysqli_stmt_bind_param($stmt,"s", $id);

                # run the query
                if(mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_bind_result($stmt, $exist);
                    
                    while(mysqli_stmt_fetch($stmt)) {
                        $res = $exist;
                    }
                } else {
                    echo "<script>alert('fail execute the query');</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Fail prepare the statement');</script>";
                exit();
            }
            // echo $res;
            return $res;
        }

        function insertResult($conn, $id, $type_nm){

            $sql="insert into test_result values (? , (select typeid from test where type_nm=? limit 1));";
 
            if($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ss", $id, $type_nm);
                # run the query
                if(mysqli_stmt_execute($stmt)) {
                    header("Location:../../pages/search/search.php");
 
                   
                } else {
                    echo "<script>alert('Log in fail');</script>";
                    exit();
                }
                

                    }

        }

        function updateResult($conn, $id, $type_nm){

            $sql="update test_result set typeid=(select typeid from test where type_nm=? limit 1) where userid=?;";
 
            if($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ss", $type_nm,$id);
                # run the query
                if(mysqli_stmt_execute($stmt)) {
                    header("Location:../../pages/search/search.php");
 
                   
                } else {
                    echo "<script>alert('Log in fail');</script>";
                    exit();
                }
                

                    }

        }

       if (mysqli_connect_errno()) {
            echo "<script>alert('Log in fail');</script>";
            exit();
        } else {

            $isRecord=checkResultExist($conn, $id);
            if ($isRecord==0){

                insertResult($conn, $id, $type_nm);

            }
            else{
                updateResult($conn, $id, $type_nm);

            }



        
        }
    # close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

?>