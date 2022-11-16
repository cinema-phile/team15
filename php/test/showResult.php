<?php
    header('Content-Type: text/html; charset=utf-8');
    $genre = $_GET["genre"];


    function getTypeInfo($conn, $genre){
        $sql ="select type_title, type_content, url from test where type_nm=? limit 1;";
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $genre);
        }
        if(mysqli_stmt_execute($stmt)){

            # run the query
            if(mysqli_stmt_execute($stmt)) {

            mysqli_stmt_store_result($stmt);
            // SELECT, SHOW, DESCRIBE를 성공적으로 실행한 모든 쿼리에 대해 호출해야 함
            // 생성된 레코드셋을 가져와 저장함
            mysqli_stmt_bind_result($stmt, $type_title, $type_content, $url);
            // 검색 결과로 반환되는 레코드셋의 필드를 php 변수에 바인딩
            // mysqli_stmt_fetch 호출 전, 모든 필드가 바인드되어야 함

            
            $res = array();
            // POST로 넘겨받은 정보를 이용, 데이터를 response 배열로..
            $res["success"] = true;
            // response["success"] 선언
            
            // 필드 정보 출력
            while(mysqli_stmt_fetch($stmt)){

                $res["typeTitle"] = $type_title;
                $res["typeContent"] = $type_content;
                $res["imgUrl"]=$url;
                //echo $res["peopleCount"];
    

            }

            }
           
        }
        mysqli_stmt_close($stmt);
        return $res;
    }




    function getDirectors($conn, $genre){
         # prepare statement
         $res = array();
         $sql ="select people_nm from people where people_cd IN (select recom_director from test where type_nm=?);";
         //echo $sql;
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $genre);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $people_nm);
            while(mysqli_stmt_fetch($stmt)) {
                array_push($res,  $people_nm);
            }

            //print_r($res);


        } 
        else {
                echo "<script>alert('fail execute the query');</script>";
                exit();
        }
    
        mysqli_stmt_close($stmt);
        return $res;
    }

    function getMoviesFromDirector($conn, $genre, $director){
        //echo "$director";
        //echo "$genre";
        # prepare statement
        $res = array();
        $sql ="select movie_nm from movie where movie_cd IN (SELECT recom_movie FROM test where type_nm=? and recom_director=( select people_cd from people where people_nm = ? and rep_role_nm = '감독'));";
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ss', $genre, $director);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $movie_nm);
            while(mysqli_stmt_fetch($stmt)) {
                array_push($res,  $movie_nm);
            }

            //print_r($res);


        } 
        else {
                echo "<script>alert('fail execute the query');</script>";
                exit();
        }
    
        mysqli_stmt_close($stmt);
        return $res;

    }




    function getMultiMovieArray($conn, $genre, $typeDirectors){
        $res=array();

        for($i = 0;$i < count($typeDirectors);$i++){
                   
            //$director = $typeDirectors[$i];
            array_push($res, getMoviesFromDirector($conn, $genre,$typeDirectors[$i] ));

            //$moviesPerDirector=getMoviesFromDirector($conn, $genre,$director );
            //print_r($res[i]);
            
        }
        return res;


    }
 


    # DB Connection
    $conn = mysqli_connect("localhost", "team15", "team15", "team15");


    if (mysqli_connect_errno()) {
            echo "<script>alert('Log in fail');</script>";
            exit();
        } else {
                



                $typeTitle=getTypeInfo($conn, $genre)["typeTitle"];
                $typeContent=getTypeInfo($conn, $genre)["typeContent"];
                $typeImgUrl=getTypeInfo($conn, $genre)["imgUrl"];
                $typeDirectors=getDirectors($conn, $genre);
                $typeMovies1=getMoviesFromDirector($conn, $genre,$typeDirectors[0] );
                $typeMovies2=$typeDirectors[1]?getMoviesFromDirector($conn,  $genre, $typeDirectors[1]):NULL;

                        
            } 
    
        
        
    # close connection
    //mysqli_stmt_close($stmt);
    mysqli_close($conn);
    

?>