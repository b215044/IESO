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
	//テーブルの作成
	$sql = 'CREATE TABLE IF NOT EXISTS GuestsInfo('
					.'id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,'
					.'name varchar(255) NOT NULL,'
					.'comment text,'
					.'time varchar(32) NOT NULL,'
					.'password varchar(32) NOT NULL)';
	if($result = $pdo->query($sql) == TRUE){
	}else{
		echo "Error creating table:".$result->error;
	}
	
	//データベースの書き込み
	
	if(isset($_POST['write'])){
		if($_POST['flg'] != "flgon"){
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				//名前とコメントが入力されたら
				if(!empty($_POST['name'])){
					if(!empty($_POST['comment'])){
						//配列fileRowに情報を入れる
						$fileRow = array(
							'name' => $_POST['name'],
							'comment' => $_POST['comment'],
							'time' => date("Y/m/d H時i分s秒"),
							'pass' => $_POST['pass']
						);
						$sql="INSERT INTO GuestsInfo("
									."name,comment,time,password"
									.") VALUES("
									.":name,:comment,:time,:password)";
						$stmt = $pdo->prepare($sql);
						$params = array(':name' => $fileRow['name'], 
														':comment' => $fileRow['comment'],
														':time' => $fileRow['time'],
														':password'=>$fileRow['pass']);
						$stmt -> execute($params);
					}else{
						echo "コメント欄が空欄になっています";
					}
				}else{
					echo "名前欄が空欄になっています";
				}
				
				header('Location:'.$_SERVER['SCRIPT_NAME']);
				exit;
			}
		}
	}
	
	//削除
	
	if(isset($_POST['deleatbutton'])){
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			if(isset($_POST['deleat'])){
				if(isset($_POST['depass'])){
					$passDe = $_POST['depass'];
					$codeDe = $_POST['deleat'];
					if(ctype_digit($codeDe)){
						$sql = "SELECT * FROM GuestsInfo WHERE id = :id AND password = :pass";
						$stmt = $pdo->prepare($sql);
						$params = array(':id' => $codeDe,':pass' => $passDe);
						$result = $stmt->execute($params);
						foreach($stmt as $row){
							$both = $row['id'];
						}
						//削除コードとidが一緒なら、
						//---echo $codeDe;
						//---echo "<br>";
						//---echo $both;
						//---echo "<br>";
						if($codeDe == $both){
							$sql = "DELETE FROM GuestsInfo WHERE id = :id";
							$stmt = $pdo->prepare($sql);
							$params = array(':id' => $both);
							$stmt->execute($params);
						}
					}
				}
			}
			header('Location:'.$_SERVER['SCRIPT_NAME']);
			exit;
		}
	}
	//編集
	if(isset($_POST['editbutton'])){
		//もし、パスが空じゃなければ
		if(isset($_POST['edpass'])){
			//もし、POST送信edit（編集番号）が空じゃなければ
			if(isset($_POST['edit'])){
				//編集番号を取得する
				$codeEd = $_POST['edit'];
				$passEd = $_POST['edpass'];
				//
				if(ctype_digit($codeEd)){
					$sql = "SELECT * FROM GuestsInfo WHERE id = :id AND password = :pass";
					$stmt = $pdo->prepare($sql);
					$params = array(':id' => $codeEd,':pass' => $passEd);
					$stmt->execute($params);
					foreach($stmt as $row){
						$both = $row['id'];
						$bothname = $row['name'];
						$bothcomment = $row['comment'];
						$bothpass = $row['password'];
					}
					//投稿番号と編集番号を比較する
					if($codeEd == $both){
						//名前とコメントをそれぞれ別の変数に入れる
						$edName = $bothname;
						$edComment = $bothcomment;
						$edPass = $bothpass;
						$editFlg = "flgon";
					}
				}
			}
			//---echo $edName;
			//---echo "<br />";
			//---echo $edComment;
			//---echo "<br />";
			//---echo $edPass;
		}else{
			echo "passが入力されていません";
		}
	}
	
	if(isset($_POST['write'])){
		if($_POST['flg'] == "flgon"){
			//---echo "aaa";
			$codeEd = $_POST['editnum'];
			//---echo $edNumber;
			//投稿番号と編集番号を比較する
			$sql = "SELECT * FROM GuestsInfo WHERE id = :id";
			$stmt = $pdo->prepare($sql);
			$params = array(':id' => $codeEd);
			$stmt->execute($params);
			foreach($stmt as $row){
				$both = $row['id'];
			}
			//---echo $codeEd;
			if($codeEd == $both){
				if(isset($_POST['name'])){
					if(isset($_POST['comment'])){
						//更新作業
						//---echo "aaa";
						//更新する内容を配列に入れる
						$fileRow = array(
						'name' => $_POST['name'],
						'comment' => $_POST['comment'],
						'time' => date("Y/m/d H時i分s秒"),
						'pass' => $_POST['pass']);
						
						//mysqlのupdateで更新をす
						$sql = "UPDATE GuestsInfo SET name = :name , comment = :comment , time = :time, password = :password WHERE id = :value";
						$stmt = $pdo->prepare($sql);
						$params = array(':name' => $fileRow['name'],
														':comment' => $fileRow['comment'],
														':time' => $fileRow['time'],
														':password'=>$fileRow['pass'],
														':value' => $codeEd);
						$stmt->execute($params);
					}else{
						echo "編集の内容が書かれていません。\n編集は完全ではありません";
					}
				}else{
					echo "編集後の名前が入力されていません。\n編集は完全ではありません";
				}
			}
			unset($editFlg);
		}
	}
	//---echo $editFlg;
	//htmlに特殊文字を反映させる
	function emp($s){
		return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
	}
?>
<!DOCUTYPE html>
<html lang = "ja">
	<head>
	<meta charset = "UTF-8">
		<title>楽器人</title>
	</head>
	<body>
		<h1>
			ベースのためのブログ
		</h1>
		
		<form method="post" action="mission_2-15_001.php">
			<!-- 入力フォーム -->
		<p>名前<br /><input type="text" name="name" value="<?= $edName ?>" /></p>
		<p>コメント<br /><input type="text" name="comment" value="<?= $edComment ?>" /></p>
		<p>pass:<input type="password" name="pass" 
				value="<?= $edPass ?>" size="4" maxlength="4" 
				<?php if($editFlg == "flgon"): ?> readonly <?php endif ?>></p>
		<p><input type="submit" name="write" value="送信" /></p>
		
		<input type="hidden" name="flg" value="<?= $editFlg ?>" />
		<input type="hidden" name="editnum" value="<?= $codeEd ?>" />
		</form>
		
		<form method = "post" action="mission_2-15_001.php">
			<!-- 削除フォーム -->
		<p> 削除対象番号 <br /><input type="text" name="deleat" /></p>
		<p>pass:<input type="password" name="depass" size="4" maxlength="4"></p>
		<p><input type="submit" name="deleatbutton" vaule="削除" /></p>
		</form>
		<!-- 編集フォーム -->
		<form method = "post" action="mission_2-15_001.php">
		<p>編集対象番号<br /><input type="text" name="edit" /></p>
		<p>pass:<input type="password" name="edpass" size="4" maxlength="4"></p>
		<p><input type="submit" name="editbutton" value="編集" /></p>
		</form>
		<h2>-----投稿一覧-------</h2>
		<ul>
		<?php $sql = "SELECT * FROM GuestsInfo"; ?>
		<?php $result = $pdo->query($sql); ?>
		<?php $rowcount = 0; ?>
			<?php foreach($result as $row): ?>
				<php if(empty($row)) continue; ?>
				 <!-- 投稿の記述をする -->
				<li><?php echo emp($row['id']); ?> 名前:<?php echo emp($row['name']) ?> <br/>
						コメント:<?php echo emp($row['comment']); ?> <?php echo emp($row['time']); ?>
				</li>
			<?php $rowcount++;?>
			<?php endforeach ?>
		<?php if($rowcount == 0): ?>
			<li>まだ投稿はありません</li>
		<?php endif; ?>
		</ul>
	</body>
</html>