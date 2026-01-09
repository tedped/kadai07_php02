<?php

try {
  //ID:'root', Password: xamppは 空白 ''
  $pdo = new PDO('mysql:dbname=gs_kadai07;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}