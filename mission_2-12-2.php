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
	$id = 2;
	$pass = 1111;
	$sql = "SELECT id,password FROM GuestsInfo WHERE id = $id AND password = $pass";
	$result = $pdo->query($sql);
	//出力
	foreach($result as $row){
		echo $row['id'];
		echo $row['name'];
		echo $row['comment'];
		echo $row['password'].'<br>';
		
	}
?>