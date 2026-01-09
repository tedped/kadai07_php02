<?php
require_once "db.php";

//1. POSTデータ取得
$date = $_POST['date']?? '';
$amount = $_POST['amount']?? '';
$categoryId = $_POST['category_id'] ?? '';
$payment = $_POST['payment']?? '';
$memo = $_POST['memo']?? '';

// バリデーション
if ($date === '' || !is_numeric($amount)) {
  exit('Invalid input');
}

// 2. SQL文を用意
// user_idは仮置きのため完全放置
$sql = "INSERT INTO 
  expenses(id, user_id, date, amount, category_id, payment, memo, created_at, updated_at) 
  VALUES(NULL, NULL, :date, :amount, :category_id, :payment, :memo, NOW(), NOW())";

$stmt = $pdo->prepare($sql);

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR
$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$stmt->bindValue(':amount', (int)$amount, PDO::PARAM_INT);
$stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
$stmt->bindValue(':payment', $payment, PDO::PARAM_STR);
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: index.php");
  // exit();
}
?>
