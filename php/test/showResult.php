<?php
    header('Content-Type: text/html; charset=utf-8');
    $genre = $_GET["genre"];


    function getTypeTitle($conn, $genre){
        $sql ="select type_title from test where type_nm=? limit 1;";
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $genre);
        }
        if(mysqli_stmt_execute($stmt)){

            # run the query
            if(mysqli_stmt_execute($stmt)) {

            mysqli_stmt_store_result($stmt);
            // SELECT, SHOW, DESCRIBE를 성공적으로 실행한 모든 쿼리에 대해 호출해야 함
            // 생성된 레코드셋을 가져와 저장함
            mysqli_stmt_bind_result($stmt, $type_title);
            // 검색 결과로 반환되는 레코드셋의 필드를 php 변수에 바인딩
            // mysqli_stmt_fetch 호출 전, 모든 필드가 바인드되어야 함

            
            $res = array();
            // POST로 넘겨받은 정보를 이용, 데이터를 response 배열로..
            $res["success"] = true;
            // response["success"] 선언
            
            // 필드 정보 출력
            while(mysqli_stmt_fetch($stmt)){

                $res["typeTitle"] = $type_title;
                //echo $res["peopleCount"];
    

            }

            }
           
        }
        mysqli_stmt_close($stmt);
        return $res["typeTitle"];
    }


    function getTypeContent($conn, $genre){

        $sql ="select type_content from test where type_nm=? limit 1;";
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $genre);
        }
        if(mysqli_stmt_execute($stmt)){

            # run the query
            if(mysqli_stmt_execute($stmt)) {

            mysqli_stmt_store_result($stmt);
            // SELECT, SHOW, DESCRIBE를 성공적으로 실행한 모든 쿼리에 대해 호출해야 함
            // 생성된 레코드셋을 가져와 저장함
            mysqli_stmt_bind_result($stmt, $type_content);
            // 검색 결과로 반환되는 레코드셋의 필드를 php 변수에 바인딩
            // mysqli_stmt_fetch 호출 전, 모든 필드가 바인드되어야 함

            
            $res = array();
            // POST로 넘겨받은 정보를 이용, 데이터를 response 배열로..
            $res["success"] = true;
            // response["success"] 선언
            
            // 필드 정보 출력
            while(mysqli_stmt_fetch($stmt)){

                $res["typeContent"] = $type_content;
                //echo $res["peopleCount"];
    

            }

            }
           
        }
        mysqli_stmt_close($stmt);
        return $res["typeContent"];

    }





 


    # DB Connection
    $conn = mysqli_connect("localhost", "team15", "team15", "team15");


    if (mysqli_connect_errno()) {
            echo "<script>alert('Log in fail');</script>";
            exit();
        } else {

                $typeTitle=getTypeTitle($conn, $genre);
                $typeContent=getTypeContent($conn, $genre);
 
                          
            } 
    
        
        
    # close connection
    //mysqli_stmt_close($stmt);
    mysqli_close($conn);
    

?>