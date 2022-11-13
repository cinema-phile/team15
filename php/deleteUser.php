<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = mysqli_connect("localhost", "root", "", "potatoo");

if (mysqli_connect_errno()) {
	printf("Connection failed: %s\n", mysqli_connect_error());
	exit();
}

$mysqli->begin_transaction();

/* userid 변수 받아오는 부분 추가해야함! */

try{
	$mysqli->query("delete from comment_free where userid='$userid'");
	$mysqli->query("delete from comment_information where userid='$userid'");
	$mysqli->query("delete from board_free where userid='$userid'");
	$mysqli->query("delete from board_information where userid='$userid'");
	$mysqli->query("delete from test_result where userid='$userid'");
	$mysqli->query("delete from star_movie where userid='$userid'");
	$mysqli->query("delete from star_people where userid='$userid'");
	$mysqli->query("delete from watch_movie where userid='$userid'");
	$mysqli->query("delete from users where userid='$userid'");

	/* If code reaches this point without errors, then commit the data */
	$mysqli->commit();
	echo 'commit';

} catch (mysqli_sql_exception on $exception) {
	$mysqli->rollback();
	throw $exception;
}

?>
