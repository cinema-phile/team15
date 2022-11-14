<?php
    header('Content-Type: text/html; charset=utf-8');

    if(!session_id()) {
        // id가 없을 경우 세션 시작
            session_start();
        }
    // 세션으로부터 userid 받아오기
    $id = $_SESSION['userId'];


    function getMovieCount($conn, $id){
            $sql ="select count(*) as MovieCount from star_movie where userid= ?";
            if($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $id);
            }
            if(mysqli_stmt_execute($stmt)){

                # run the query
                if(mysqli_stmt_execute($stmt)) {

                mysqli_stmt_store_result($stmt);
                // SELECT, SHOW, DESCRIBE를 성공적으로 실행한 모든 쿼리에 대해 호출해야 함
                // 생성된 레코드셋을 가져와 저장함
                mysqli_stmt_bind_result($stmt, $MovieCount);
                // 검색 결과로 반환되는 레코드셋의 필드를 php 변수에 바인딩
                // mysqli_stmt_fetch 호출 전, 모든 필드가 바인드되어야 함

                
                $res = array();
                // POST로 넘겨받은 정보를 이용, 데이터를 response 배열로..
                $res["success"] = true;
                // response["success"] 선언
                
                // 필드 정보 출력
                while(mysqli_stmt_fetch($stmt)){

                    $res["movieCount"] = $MovieCount;
        

                }

            }
            mysqli_stmt_close($stmt);
            return $res["movieCount"];
        }
    }


    function getPeopleCount($conn, $id){
            $sql ="select count(*) as peopleCount from star_people where userid= ?";
            if($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $id);
            }
            if(mysqli_stmt_execute($stmt)){

                # run the query
                if(mysqli_stmt_execute($stmt)) {

                mysqli_stmt_store_result($stmt);
                // SELECT, SHOW, DESCRIBE를 성공적으로 실행한 모든 쿼리에 대해 호출해야 함
                // 생성된 레코드셋을 가져와 저장함
                mysqli_stmt_bind_result($stmt, $peopleCount);
                // 검색 결과로 반환되는 레코드셋의 필드를 php 변수에 바인딩
                // mysqli_stmt_fetch 호출 전, 모든 필드가 바인드되어야 함

                
                $res = array();
                // POST로 넘겨받은 정보를 이용, 데이터를 response 배열로..
                $res["success"] = true;
                // response["success"] 선언
                
                // 필드 정보 출력
                while(mysqli_stmt_fetch($stmt)){

                    $res["peopleCount"] = $peopleCount;
                    //echo $res["peopleCount"];
        

                }

                }
               
            }
            mysqli_stmt_close($stmt);
            return $res["peopleCount"];
    }

     
    function getWatchCount($conn, $id){
        $sql ="select count(*) as watchCount from watch_movie where userid=?";
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $id);
        }
        if(mysqli_stmt_execute($stmt)){

            # run the query
            if(mysqli_stmt_execute($stmt)) {

            mysqli_stmt_store_result($stmt);
            // SELECT, SHOW, DESCRIBE를 성공적으로 실행한 모든 쿼리에 대해 호출해야 함
            // 생성된 레코드셋을 가져와 저장함
            mysqli_stmt_bind_result($stmt, $watchCount);
            // 검색 결과로 반환되는 레코드셋의 필드를 php 변수에 바인딩
            // mysqli_stmt_fetch 호출 전, 모든 필드가 바인드되어야 함

            
            $res = array();
            // POST로 넘겨받은 정보를 이용, 데이터를 response 배열로..
            $res["success"] = true;
            // response["success"] 선언
            
            // 필드 정보 출력
            while(mysqli_stmt_fetch($stmt)){

                $res["watchCount"] = $watchCount;
                //echo $res["watchCount"];


            }

            }
            
        }
        mysqli_stmt_close($stmt);
        return $res["watchCount"];
    }



    function getRecentMovie($conn,$id){
        $sql ="select movie_nm from movie where movie_cd=(select movie_cd from watch_movie where userid=? order by timestamps desc limit 1);";
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $id);
        }
        if(mysqli_stmt_execute($stmt)){

            # run the query
            if(mysqli_stmt_execute($stmt)) {

            mysqli_stmt_store_result($stmt);
            // SELECT, SHOW, DESCRIBE를 성공적으로 실행한 모든 쿼리에 대해 호출해야 함
            // 생성된 레코드셋을 가져와 저장함
            mysqli_stmt_bind_result($stmt, $movie_nm);
            // 검색 결과로 반환되는 레코드셋의 필드를 php 변수에 바인딩
            // mysqli_stmt_fetch 호출 전, 모든 필드가 바인드되어야 함

            
            $res = array();
            // POST로 넘겨받은 정보를 이용, 데이터를 response 배열로..
            $res["success"] = true;
            // response["success"] 선언
            
            // 필드 정보 출력
            while(mysqli_stmt_fetch($stmt)){

                $res["movie_nm"] = $movie_nm;
                // echo $res["movie_nm"];


            }

            }
           
        }
        mysqli_stmt_close($stmt);
        return $res["movie_nm"];
    }

    function getUserInfo($conn, $id){
        $sql ="select * from users where userid =?";
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $id);
        }


        # run the query
        if(mysqli_stmt_execute($stmt)) {

            mysqli_stmt_store_result($stmt);
            // SELECT, SHOW, DESCRIBE를 성공적으로 실행한 모든 쿼리에 대해 호출해야 함
            // 생성된 레코드셋을 가져와 저장함
            mysqli_stmt_bind_result($stmt, $userid,$password,$name,$profile);
            // 검색 결과로 반환되는 레코드셋의 필드를 php 변수에 바인딩
            // mysqli_stmt_fetch 호출 전, 모든 필드가 바인드되어야 함

            
            $res = array();
            // POST로 넘겨받은 정보를 이용, 데이터를 response 배열로..
            $res["success"] = true;
            // response["success"] 선언
            
            // 필드 정보 출력
            while(mysqli_stmt_fetch($stmt)){

                $res["userid"] = $userid;
                $res["password"] = $password;
                $res["name"] = $name;
                $res["profile"] = $profile;


            }

        }
        mysqli_stmt_close($stmt);
        return $res;
    }


    function getUserGenre($conn, $id){ 
        $sql ="select type_title from test where typeid=(select typeid from test_result where userid=?)";
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $id);
        }


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

                $res["type_title"] = $type_title;




            }

        }
        mysqli_stmt_close($stmt);
        return $res["type_title"];

    }
        
    


    

    # DB Connection
    $conn = mysqli_connect("localhost", "team15", "team15", "team15");


    if (mysqli_connect_errno()) {
            echo "<script>alert('Log in fail');</script>";
            exit();
        } else {
                $name=getUserInfo($conn, $id)["name"];
                $preferGenre =getUserGenre($conn,$id)?getUserGenre($conn,$id):"영화";
                $movieCnt = getMovieCount($conn, $id);
                $peopleCnt = getPeopleCount($conn, $id);
                $watchCnt=getWatchCount($conn, $id);
                $recentMovie=getRecentMovie($conn,$id);

            } 
    
        
        
    # close connection
    //mysqli_stmt_close($stmt);
    mysqli_close($conn);

?>