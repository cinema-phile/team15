<?php
header('Content-Type: text/html; charset=utf-8');

if(!session_id()) {
    session_start();
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = mysqli_connect("localhost", "team15", "team15", "team15");

if (mysqli_connect_errno()) {
	printf("Connection failed: %s\n", mysqli_connect_error());
	exit();
}

$mysqli->begin_transaction();


try{
	$mysqli->query("delete from comment_free where userid ='".$_SESSION['userId']."'");
	$mysqli->query("delete from comment_information where userid='".$_SESSION['userId']."'");
	$mysqli->query("delete from board_free where userid='".$_SESSION['userId']."'");
	$mysqli->query("delete from board_information where userid='".$_SESSION['userId']."'");
	$mysqli->query("delete from test_result where userid='".$_SESSION['userId']."'");
	$mysqli->query("delete from star_movie where userid='".$_SESSION['userId']."'");
	$mysqli->query("delete from star_people where userid='".$_SESSION['userId']."'");
	$mysqli->query("delete from watch_movie where userid='".$_SESSION['userId']."'");
	$mysqli->query("delete from users where userid='".$_SESSION['userId']."'");

	/* If code reaches this point without errors, then commit the data */
	$mysqli->commit();
	session_unset(); 

    // 세션 ID 값이 저장되어 있는 쿠키 삭제
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
        session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy(); // 세션삭제

} catch (mysqli_sql_exception $exception) {
	$mysqli->rollback();
	throw $exception;
}
header("Location:../../index.html");

?>
