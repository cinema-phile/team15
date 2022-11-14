<?php
header('Content-Type: text/html; charset=utf-8');

    if(!session_id()) {
            session_start();
    }

    session_unset(); // 세션제거
    
    
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
?>
