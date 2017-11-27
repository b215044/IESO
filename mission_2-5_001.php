<?php
	$filename = 'inputcomment.txt';
	//htmlに特殊文字を反映させる
	function emp($s){
		return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
	}
	//ファイルがあれば、ファイルを開く。
	//なければ、空のファイルを作る
	if(file_exists($filename)){
		$postFile = file($filename, FILE_IGNORE_NEW_LINES);
	}else{
		touch($filename);
		$postFile = file($filename, FILE_IGNORE_NEW_LINES);
	}
	/* ファイル書き込み */
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		//名前とコメントが入力されたら
		if(isset($_POST['name'])){
			if(isset($_POST['comment'])){
				$comment = $_POST['comment'];
				$comment = htmlspecialchars($comment);
				$comment = str_replace("\n", "<br>", $comment);
				$filenumber = count(file($filename))+1;//番号
				
				//配列fileRowに情報を入れる
				$fileRow = array(
					'filenumber' => count(file($filename))+1,
					'name' =>$_POST['name'],
					'comment' => $comment,
					'time' => date("Y/m/d H時i分s秒")
				);
				$fp = fopen($filename, 'a');
				fwrite($fp, $fileRow["filenumber"]."<>".$fileRow["name"]."<>".
						$fileRow["comment"]."<>".$fileRow["time"]."\n");
				fclose($fp);
			}else{
				$a=1;
			}
		}else{
			$a=1;
		}
		
		header('Location:'.$_SERVER['SCRIPT_NAME']);
		exit;
	}else{
		
	}
	/* 削除 */
	if(isset($_POST['deleatbutton'])){
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			if(isset($_POST['deleat'])){
			//削除コード(数字)を受け取る
				$code = $_POST['deleat'];
				if(ctype_digit($code)){
					$num = 1;
					$postFile = file($filename);
					for($i=0; $i < count($postFile);$i++){
						//ファイルを分割する
						$deList = explode('<>', $postFile[$i]);
						//分割した際の数字部分とコードを比べる
						if($code != $deList[0]){
							$nameDe[$i] = $deList[1];
							$commentDe[$i] = $deList[2];
							$dateDe[$i] = $deList[3];
							$filenumberDe[$i] = $num;
							
							$postList = $filenumberDe[$i].'<>';
							$postList .= $nameDe[$i].'<>';
							$postList .= $commentDe[$i].'<>';
							$postList .= $dateDe[$i];
							
							$num++;
							$form[$i] = $postList;
						}
					}
					if(isset($form)){
					//上書きするためにいったんファイルを消す
						unlink($filename);
					//追記モードで追記をしていく
						$fp = fopen($filename, 'a');
						foreach($form as $forms){
							fwrite($fp, $forms);
						}
						fclose($fp);
					}
				}
			}
			header('Location:'.$_SERVER['SCRIPT_NAME']);
			exit;
		}
	}
	
	/* 編集 */
	if(isset($_POST['editting'])){
	//編集フォームの中身が空じゃないなら
	//編集コードを取得する
		$code2 = $_POST['editting'];
		if(ctype_digit($code2)){
			$postFile = file($filename);
			for($j=0;$j < count($postFile);$j++){
			//ファイルを分割する
				$listEd = explode('<>', $postFile[j]);
			//編集コードと分割した際の数字を比べる
				var_dump($listEd);
				echo $code2;
				if($code2 == $listEd[0]){
			//nameEdに名前の部分をいれ、commentEdにコメント部分を入れる
					echo $listEd[1];
					$nameEd = $listEd[1];
					$commentEd = $listEd[2];
					echo $nameEd;
					echo $commentEd;
					
				}
			}
		}echo "a";
	}

	//ファイルがあれば、ファイルを開く。
	//なければ、空のファイルを作る
	if(file_exists($filename)){
		$postFile = file($filename, FILE_IGNORE_NEW_LINES);
	}else{
		touch($filename);
		$postFile = file($filename, FILE_IGNORE_NEW_LINES);
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
		
		<form method="post" action="mission_2-5_001.php">
			<!-- 入力フォーム -->
		<p>名前<br /><input type="text" name="name" ></p>
		<p>コメント<br /><input type="text" name="comment" ></p>
		<p><input type="submit" name="write" value="送信"></p>
		</form>
		
		<form method = "post" action="mission_2-5_001.php">
			<!-- 削除フォーム -->
		<p> 削除対象番号 <br />
		<input type="text" name="deleat" ></p>
		<p><input type="submit" name="deleatbutton" vaule="削除" ></p>
		
		</form>
			<!-- 編集フォーム -->
		<form method = "post" action="mission_2-5_001.php">
		
		<p>編集対象番号 <br />
		<input type="text" name="editting"></p>
		<p><input type="submit" name="edittingbutton" value="編集"></p>
		
		</form>
		
		<h2>-----投稿一覧-------</h2>
		<ul>
		<?php if(count($postFile)): ?>
			<?php foreach($postFile as $post): ?>
				<php if(empty($post)) continue; ?>
				 <!-- 投稿の記述をする -->
				<?php list($cnt, $name, $comment, $time) = explode("<>", $post) ?>
				<?php if(isset($name)): ?>
				<li style="list-style:none">
				<?php echo emp($cnt); ?> 
				<?php echo emp("名前:".$name) ?> <br/>
				<?php echo emp("コメント:".$comment); ?>
				<?php echo emp($time); ?>
				</li>
				<?php endif; ?>
				<?php endforeach ?>
			<?php else: ?>
				<li>まだ投稿はありません</li>
			<?php endif; ?>
		</ul>
	</body>
</html>