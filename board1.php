<?php
session_start();
if((isset($_SESSION['oauth_token']) && $_SESSION['oauth_token'] !== NULL) && (isset($_SESSION['oauth_token_secret']) && $_SESSION['oauth_token_secret'] !== NULL)){
echo "loginsuccess";
} else {
  header("Location:http://127.0.0.1:8888/twitterlogin/index.php");
}
?>

<?php
require_once('unit.php');
$gobackURL = "board1.php";
// 文字エンコードの検証
 if (!cken($_POST)) {
   header("Location:{$gobackURL}");
   exit();
 }
//  簡単なエラー処理
if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
  $errors = [];
if (!isset($_POST['name'])||($_POST['name']==="")) {
  $errors[] = "名前が空です";
}
if (!isset($_POST['subject'])||($_POST['subject']==="")) {
  $errors[] = "件名が空です";
}
if (!isset($_POST['text'])||($_POST['text']==="")) {
  $errors[] = "本文が空です";
}
if (count($errors)>0) {
  echo '<ol>';
  foreach ($errors as $value) {
    echo "<li>",$value,"</li>";
  }
  echo "</ol>";
  echo "<a href=",$gobackURL,">戻る</a>";
  exit();
}
}
//データベースユーザ
$user = 'borduser';
$password = 'bord33';
// 利用するデータベース
$dbName = 'borddb';
// Mysqlサーバ
$host = 'localhost:8889';
// MysqlのDSN文字列
$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
?>
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
<!-- 入力フォーム -->
<div class="container">
<div class="row">
  <div class="col-sm-5">
<form method="POST" action="<?php echo es($_SERVER['PHP_SELF']); ?>">

      <label>名前：</label>
        <div class="form-group">
      <input type="text" name="name" placeholder="名前" class="form-control">
        </div>
      <label>件名：</label>
      <div class="form-group">
         <input type="text" name="subject" placeholder="件名" class="form-control">
      </div>
      <label>本文：</label>
      <div class="form-group">
          <textarea name="text"cols="30" rows="10" class="form-control"></textarea>
      </div>
      <button type="submit">投稿</button>
  </ul>
</form>
</div>
<!-- 入力フォーム終わり -->
<!-- ログアウト -->
<button type='button' class='btn btn-default'><a href='http://127.0.0.1:8888/twitterlogin/logout.php'>Logout</a></button>

<?php

  $name = "";
  $subject = "";
  $text = "";

  if (isset($_POST['name'])) {
    $name = $_POST['name'];
  }
  if (isset($_POST['subject'])) {
    $subject = $_POST['subject'];
  }
  if (isset($_POST['text'])) {
    $text = $_POST['text'];
  }

// Mysqlデータベースへ接続
try {
  $pdo = new PDO ($dsn, $user, $password);
  // プリペアドステートメントのエミュレーションを無効にする
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  // 例外がスローされる設定にする
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // SQL文を作る
  if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
  $sql = "INSERT INTO content (name, subject, text) VALUES (:name, :subject, :text)";
  // プリペアドステートメントを作る
  $stm = $pdo->prepare($sql);
  // プレースホルダに値をバインドする
  $stm->bindValue(':name', $name, PDO::PARAM_STR);
  $stm->bindValue(':subject', $subject, PDO::PARAM_STR);
  $stm->bindValue(':text', $text, PDO::PARAM_STR);
  // SQL文を実行する
  if ($stm->execute()) {
  } else {
    echo "<span>追加エラーがありました</span><br>";
  };
  }
  // レコード追加後のレコードリストを取得する
  $sql ="SELECT * FROM content";
  // プリペアドステートメントを作る
  $stm = $pdo->prepare($sql);
  // SQL文を実行する
  $stm->execute();
  // 結果の取得(連想配列で受け取る)
  $result =$stm->fetchAll(PDO::FETCH_ASSOC);
  // テーブルのタイトル行
  echo "<div class='col-sm-6'>";
  foreach ($result as $row) {
    // 1行ずつテーブルに入れる
    echo "ID：", es($row['id']),"<br>";
    echo "件名：",es($row['subject']),"<br>";
    echo "本文：","<br>"; 
    echo es($row['text']),"<br>";
    echo "名前：", es($row['name']),"<br>";
    echo "<hr>";
  };
  } catch (Exception $e) {
    echo "<span>エラーがありました</span>";
    echo $e->getMessage();
  }
?>
</div>
</div>
</body>
</html>