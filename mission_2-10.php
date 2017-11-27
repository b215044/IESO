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
	$stmt = $pdo->query('SHOW CREATE TABLE GuestsInfo');
	foreach($stmt as $re){
		print_r($re);
	}
?>