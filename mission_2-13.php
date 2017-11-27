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
	$sql = "UPDATE GuestsInfo SET name = :name WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	
	$params = array(':name'=>'ayase',':id'=> '1');
	
	$flg = $stmt->execute($params);
	if($flg){
		echo '更新完了しました';
	}else{
		echo '更新失敗しました';
	}
?>