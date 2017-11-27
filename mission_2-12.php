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
	$sql = 'SELECT * FROM GuestsInfo';
	$result = $pdo->query($sql);
	//出力
	foreach($result as $row){
		echo $row['id'];
		echo $row['name'];
		echo $row['comment'];
		echo $row['password'].'<br>';
		
	}
?>