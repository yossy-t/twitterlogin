<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>掲示板</title>
<link href="style.css" rel="stylesheet">
<!--CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<h1>twitterでログイン</h1>
<button type='button' class='btn btn-info btn-lg'><a href='http://127.0.0.1:8888/twitterlogin/login.php'>ログイン</a></button>
<?php
session_start();
var_dump($_SESSION);
?>
</body>
