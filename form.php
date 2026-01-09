<?php

require_once "db.php";
require_once "funcs.php";


//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM expenses");
$status = $stmt->execute();

//３．データ表示
$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    $view .=  '<table>';
    while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $view .= '<tr><td>'.h($result['date']).'</td><td>'. h($result['amount']).'</td><td>'. h($result['category_id']).'</td><td>'. h($result['payment']).'</td></tr>'. h($result['memo']).'</td></tr>';
    }
    $view .=  '</table>';
}
?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> 家計簿</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- 装飾要素 -->
    <div class="decoration"></div>
    <div class="decoration"></div>

    <!-- ヘッダー -->
    <header class="header">
        <div class="nav-container">
            <a href="#" class="logo">
                <i class="fas fa-chart-bar"></i>
                家計簿記帳一覧
            </a>
            <a href="index.php" class="nav-link">
                <i class="fas fa-plus"></i>
                家計簿登録
            </a>
        </div>
    </header>

    <!-- メインコンテンツ -->
    <main class="main-container">
        <div class="content-card">
            <h1 class="page-title"> 家計簿記帳一覧</h1>
            <p class="page-subtitle">投稿されたアンケートの回答一覧</p>
            
            <div class="data-container">
                <?php if(empty($view)): ?>
                    <!-- もし $view データがない場合の表示 -->
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <p>まだ記帳がありません</p>
                        <p style="margin-top: 0.5rem; font-size: 0.9rem; color: #999;">
                            今月最初の記帳をしてみましょう！
                        </p>
                    </div>
                <?php else: ?>
                    <!-- もし $view データが存在する場合 -->
                     <!-- <table> -->
                    <?= $view ?>
                    <!-- </table> -->
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>