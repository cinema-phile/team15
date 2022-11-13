<?php

header('Content-Type: text/html; charset=utf-8');
/**
 * log in
 * user input : id, pw
 * SELECT 1
*/

echo "1";



    # DB Connection

    # DB Connection
$conn = mysqli_connect("localhost", "team15", "team15", "team15");


$id= $_POST['id'];

if (mysqli_connect_errno()) {
    echo "<script>alert('Log in fail');</script>";
    exit();
} else {
   // $sql = "update character_ranking set vote=vote+1 where character_id=?";
    echo "id : ".$id." ,"
}
    /*# prepare statement
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);

        # run the query
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $res);
            while(mysqli_stmt_fetch($stmt)) {
                $success = $res;
            }
        } else {
            echo "<script>alert('Log in fail');</script>";
            exit();
        }

        # verify id & pw
        if ($success == 1) {
            # Success login
            $_SESSION['userId'] = $id_input;
            header("Location:../pages/search/search.html");
        } else {
            echo "<script>alert('Log in fail');</script>";
            exit();
        }
        
    } else {
        echo "<script>alert('Log in fail');</script>";
        exit();
    }

    # close connection
    mysqli_stmt_close($stmt);*/
    mysqli_close($conn);

?>

