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
	$sql = 'CREATE TABLE GuestsInfo(id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,name varchar(255) NOT NULL,comment text,password varchar(32) NOT NULL)';
	if($result = $pdo->query($sql) == TRUE){
		echo "Table GuestsInfo created successfully";
	}else{
		echo "Error creating table:".$result->error;
	}
?>