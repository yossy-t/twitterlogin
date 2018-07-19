<?php
//セッションスタート
session_start();
//セッション破棄
session_destroy();
//セッション変数初期化
$_SESSION[''] = array();
//ログインページへリダイレクト
header("Location: http://127.0.0.1:8888/twitterlogin/index.php");
?>