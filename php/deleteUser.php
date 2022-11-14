<?php

if(!isset($_SESSION['userId'])) {
	/*login으로 redirect하는 부분 추가하기*/
    echo '세션 만료';

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
	echo 'commit';
	unset($_SESSION['userId']);
	echo 'unset session';

} catch (mysqli_sql_exception on $exception) {
	$mysqli->rollback();
	throw $exception;
}

?>
