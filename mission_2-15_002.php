<?php
	//テーブル名:GuestsInfo
	$dsn = '';
	$userName = ""//username;
	$userPass = ""//userpass;
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
					.'id int(11) NOT NULL,'
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
						$sql = "SELECT * FROM GuestsInfo";
						$result = $pdo->query($sql);
						$num = 0;
						foreach($result as $row){
							$num++;
						}
						
						$fileRow = array(
							'id' => $num + 1,
							'name' => $_POST['name'],
							'comment' => $_POST['comment'],
							'time' => date("Y/m/d H時i分s秒"),
							'pass' => $_POST['pass']
						);
						$sql="INSERT INTO GuestsInfo("
									."id,name,comment,time,password"
									.") VALUES("
									.":id,:name,:comment,:time,:password)";
						
						$stmt = $pdo->prepare($sql);
						$params = array(':id' => $fileRow['id'],
														':name' => $fileRow['name'],
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
		//if($_SERVER["REQUEST_METHOD"] == "POST"){
			if(isset($_POST['deleat'])){
				if(isset($_POST['depass'])){
					$passDe = $_POST['depass'];
					$codeDe = $_POST['deleat'];
					if(ctype_digit($code)){
						//削除idと削除passwordが一致したときのidを取得する
						$sql = "SELECT * FROM GuestsInfo WHERE id = :id AND password = :pass";
						$stmt = $pdo->prepare($sql);
						$params = array(':id'=>$codeDe,':pass'=>$passDe);
						//削除コードとidが一緒なら、
						$result = $stmt->execute($params);
						echo($result);
						if($codeDe == $result['id']){
						echo "a"."<br>";
								$sql = "DELETE FROM GuestsInfo WHERE id = :id";
								$stmt = $pdo->prepare($sql);
								$params = array(':id' => $result['id']);
								$stmt->execute($params);
						}
						$sql = "SELECT * FROM GuestsInfo";
						$result = $pdo->query($sql);
						$rowcount = 0;
						foreach($result as $row){
							$sql = "UPDATE GuestsInfo SET id = :id WHERE id != :id";
							$stmt = $pdo->prepare($sql);
							
							$params = array(':id'=>$rowcount+1);
							
							$flg = $stmt->execute($params);
							$rowcount++;
						}
					}
				}
			}
			
		//	header('Location:'.$_SERVER['SCRIPT_NAME']);
		//	exit;
		//}
	}
	//編集
	/***if(isset($_POST['editbutton'])){
		$postFile = file($filename);
		//配列の数だけループさせる
		for($i=0;$i < count($postFile);$i++){
			//explodeで分割させる
			$edList = explode('<>', trim($postFile[$i]));
			if($_POST['edit'] == $edList[0]){
				$edpa = $edList[4];
			}
		}
		if($_POST['edpass'] == $edpa){
			//もし、POST送信edit（編集番号）が空じゃなければ
			if(isset($_POST['edit'])){
				//編集番号を取得する
				$edNum = $_POST['edit'];
				$edNumber = $edNum;
				//テキストファイルを読み込む
				$postFile = file($filename);
				//配列の数だけループさせる
				for($i=0;$i < count($postFile);$i++){
					//explodeで分割させる
					$edList = explode('<>', $postFile[$i]);
					//---var_dump($edList);
					//---echo "<br />";
					//投稿番号と編集番号を比較する
					//---echo $edList[4];
					//---echo $_POST['edpass'];
					if($_POST['edpass']."\n" == $edList[4]){
						if($edNum == $edList[0]){
							//名前とコメントをそれぞれ別の変数に入れる
							$edName = $edList[1];
							$edComment = $edList[2];
							$edPass = $edList[4];
							$editFlg = "flgon";
						}
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
			$edNumber = $_POST['editnum'];
			//---echo $edNumber;
			//テキストファイルを読み込む
			$postFile = file($filename);
			//配列の数だけループさせる
			for($i=0;$i < count($postFile);$i++){
				//explodeで分割させる
				$edLists = explode('<>', $postFile[$i]);
				//---var_dump($edLists);
				//---echo "<br />";
				//投稿番号と編集番号を比較する
				if($edNumber == $edLists[0]){
					if(isset($_POST['name'])){
						if(isset($_POST['comment'])){
							if(isset($_POST['pass'])){
								$edLists[1] = $_POST['name'];
								$edLists[2] = $_POST['comment'];
								$edLists[3] = date("Y/m/d H時i分s秒");
								$edLists[4] = $_POST['pass']."\n";
								//---echo "aaa";
							}
						}else{
							echo "編集の内容が書かれていません。\n編集は完全ではありません";
						}
					}else{
						echo "編集後の名前が入力されていません。\n編集は完全ではありません";
					}
				}
				$postEd[$i] = $edLists[0].
										"<>".$edLists[1].
										"<>".$edLists[2].
										"<>".$edLists[3].
										"<>".$edLists[4];
			}
			//---var_dump($postEd);
			if(isset($postEd)){
				unlink($filename);
				$fp = fopen($filename, 'a');
				foreach($postEd as $postsEd){
					fwrite($fp, $postsEd);
					//---echo($postsEd);
					//---echo "<br />";
				}
				fclose($fp);
			}
			unset($editFlg);
		}
	}
	***/
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
		
		<form method="post" action="mission_2-15_002.php">
		
			<!-- 入力フォーム -->
		<p>名前<br /><input type="text" name="name" value="<?= $edName ?>" /></p>
		<p>コメント<br /><input type="text" name="comment" value="<?= $edComment ?>" /></p>
		<p>pass:<input type="password" name="pass" 
				value="<?= $edPass ?>" size="4" maxlength="4" 
				<?php if($editFlg == "flgon"): ?> readonly <?php endif ?>></p>
		<p><input type="submit" name="write" value="送信" /></p>
		<input type="hidden" name="flg" value="<?= $editFlg ?>" />
		<input type="hidden" name="editnum" value="<?= $edNum ?>" />
		</form>
		
		<!-- 削除フォーム -->
		<form method = "post" action="mission_2-15_002.php">
		<p> 削除対象番号 <br /><input type="text" name="deleat" /></p>
		<p>pass:<input type="password" name="depass" size="4" maxlength="4"></p>
		<p><input type="submit" name="deleatbutton" vaule="削除" /></p>
		</form>
		
		<!-- 編集フォーム -->
		<form method = "post" action="mission_2-15_002.php">
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