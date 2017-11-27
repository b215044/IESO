<?php
	//テーブル名:GuestsInfo
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
	$sql = "DELETE FROM GuestsInfo WHERE id = :id";
	
	$stmt = $pdo->prepare($sql);
	
	$params = array(':id'=>1);
	
	if($stmt->execute($params)){
		echo '削除完了しました。';
	}else{
		echo '削除失敗しました。';
	}
?>