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
	
	$sql="INSERT INTO GuestsInfo(name,comment,date,password) VALUES(:name,:comment,:password)";
	$stmt = $pdo->prepare($sql);
	
	$username = "IWATA";
	$usercomment = "aisu";
	$userpass = "1234";
	
	$params = array(':name' => $username, ':comment' => $usercomment,':password'=>$userpass);
	
	$stmt -> execute($params);
?>