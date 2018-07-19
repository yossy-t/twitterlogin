<?php

// xss対策
function es ($data) {
  //$dataが配列の場合
  //is_arrayは配列かどうかを判定するメソッド
  if (is_array($data)) {
    return array_map(__METHOD__,$data);
  }  else {
    //HTMLエスケープ
    return htmlspecialchars($data, ENT_QUOTES, "UTF-8");
    }
  
}
//配列の文字コードチェック
function cken (array $data) {
  $result = true;
  // foreachは配列の繰り返し処理(この場合は連想配列)
  foreach ($data as $key => $value) {
    if (is_array($value)) {
      //配列の場合が文字列に結合する
      //implodeは配列の中身を結合するメソッド
      $value = implode("", $value);
    }
    if (!mb_check_encoding($value,"UTF-8")) {
      //文字コードが一致しない時
      $result = false;
    }
  }
  return $result;
}
?>