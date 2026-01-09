<?php
//共通に使う関数を記述

//htmlコード入力を文字列化する関数
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str,ENT_QUOTES);
}