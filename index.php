<?php
session_start();
require 'db.php';

$form = $_SESSION['form'] ?? [
  'date' => '',
  'amount' => '',
  'major' => '',
  'sub' => '',
  'memo' => '',
];

$sql = "SELECT id, name, parent_id FROM categories ORDER BY id ASC";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 家計簿 - データ登録</title>
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
                <i class="fas fa-clipboard-list"></i>
                家計簿
            </a>
            <a href="form.php" class="nav-link">
                <i class="fas fa-list"></i>
                データ一覧
            </a>
        </div>
    </header>

    <!-- メインコンテンツ -->
    <main class="main-container form-page">
        <div class="form-card">
            <h1 class="form-title">📝 家計簿</h1>
            <p class="form-subtitle">支出を入力してください</p>
            <div id="wizard">
                <div class="card active" data-step="date">
                    <label for="name" class="form-label">
                        <i class="fa-solid fa-calendar-days"></i> 日付
                    </label>
                    <input type="date" id="date" >
                    <button data-next>次へ</button>
                </div>
                <div class="card" data-step="amount">
                    <label for="name" class="form-label">
                        <i class="fa-solid fa-money-bill-1"></i> 金額
                    </label>
                    <input type="number" id="amount" placeholder="例：324">
                    <button data-next>次へ</button>
                </div>
                <div class="card" data-step="category">
                    <label class="form-label">
                        <i class="fa-solid fa-layer-group"></i> カテゴリ
                    </label>

                    <select id="majorSelect">
                        <option value="">大分類</option>
                    </select>

                    <select id="subSelect"></select>
                    <select id="detailSelect"></select>

                    <button data-next>次へ</button>
                </div>
                <div class="card" data-step="payment">
                    <label for="name" class="form-label">
                        <i class="fa-solid fa-wallet"></i> 決済手段
                    </label>
                    <select id="payment" >
                        <option value="">選択</option>
                        <option value="現金">現金</option>
                        <option value="クレジットカード">クレジットカード</option>
                    </select>
                    <button data-next>次へ</button>
                </div>
                <div class="card" data-step="memo">
                    <label for="name" class="form-label">
                        <i class="fa-solid fa-clipboard"></i> メモ
                    </label>
                    <input type="text" id="memo" placeholder="メモ欄">
                    <button data-next>次へ</button>
                </div>
            </div>       
            
            <div class="card" data-step="confirm">
                <h3>入力内容の確認</h3>
                <ul id="confirmList">入力内容を確認してください</ul>
                <button type="button"  data-submit>登録する</button>
            </div>

            <form id="finalForm" method="post" action="save.php" hidden>
                <input type="date" name="date" value="<?= htmlspecialchars($form['date']) ?>">
                <input type="number" name="amount" value="<?= htmlspecialchars($form['amount']) ?>">
                <select name="major" id="major">
                <option value="">選択してください</option>
                <?php foreach ($majors as $m): ?>
                    <option value="<?= $m ?>"
                    <?= $form['major'] === $m ? 'selected' : '' ?>>
                    <?= $m ?>
                    </option>
                <?php endforeach; ?>
                </select>

                <button type="submit">保存</button>
            </form>

        </div>
    </main>


<script>
  const categories = <?= json_encode($categories, JSON_UNESCAPED_UNICODE) ?>;
  const formData = <?= json_encode($form, JSON_UNESCAPED_UNICODE) ?>;
</script>
<script src="js/main.js"></script>



</body>

</html>