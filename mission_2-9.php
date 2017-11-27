<?php
	$dsn = '';
	$userName = "";
	$userPass = "";
	//データベースへの接続
	try{
		$pdo = new PDO($dsn,$userName,$userPass);
	}
	catch(PDOException $e){
		print('error'.$e->getMessage());
		exit();
	}
	$stmt = $pdo->query('SET NAMES utf8');
	//テーブル一覧を表示する
	$stmt = $pdo->query('SHOW TABLES');
	foreach($stmt as $re){
		echo $re[0];
		echo '<br>';
	}
?>