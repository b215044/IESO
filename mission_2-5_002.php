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
	//ファイルの書き込み
	
	if(isset($_POST['write'])){
		if($_POST['flg'] != "flgon"){
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				//名前とコメントが入力されたら
				if(!empty($_POST['name'])){
					if(!empty($_POST['comment'])){
						$filenumber = count(file($filename))+1;//番号
						
						//配列fileRowに情報を入れる
						$fileRow = array(
							'filenumber' => count(file($filename))+1,
							'name' => $_POST['name'],
							'comment' => $_POST['comment'],
							'time' => date("Y/m/d H時i分s秒")
						);
						$fp = fopen($filename, 'a');
						fwrite($fp, $fileRow["filenumber"]."<>".$fileRow["name"]."<>".
								$fileRow["comment"]."<>".$fileRow["time"]."\n");
						fclose($fp);
					}else{
						
					}
				}else{
					
				}
				
				header('Location:'.$_SERVER['SCRIPT_NAME']);
				exit;
			}else{
				
			}
		}
	}
	
	//
	if(isset($_POST['deleatbutton'])){
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			if(isset($_POST['deleat'])){
				$code = $_POST['deleat'];
				if(ctype_digit($code)){
					$num = 1;
					$postFile = file($filename);
					for($i=0; $i < count($postFile);$i++){
						//
						$deList = explode('<>', $postFile[$i]);
						//
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
						unlink($filename);
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
	//編集
	if(isset($_POST['editbutton'])){
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
				if($edNum == $edList[0]){
					//名前とコメントをそれぞれ別の変数に入れる
					$edName = $edList[1];
					$edComment = $edList[2];
					$editFlg = "flgon";
				}
			}
		}
		//---echo $edName;
		//---echo "<br />";
		//---echo $edComment;
		//---echo "<br />";
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
							$edLists[1] = $_POST['name'];
							$edLists[2] = $_POST['comment'];
							$edLists[3] = date("Y/m/d H時i分s秒")."\n";
							//---echo "aaa";
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
										"<>".$edLists[3];
			}
			
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
		
		<form method="post" action="mission_2-5_002.php">
			<!-- 入力フォーム -->
		<p>名前<br /><input type="text" name="name" value="<?= $edName ?>" /></p>
		<p>コメント<br /><input type="text" name="comment" value="<?= $edComment ?>" /></p>
		<p><input type="submit" name="write" value="送信" /></p>
		<input type="hidden" name="flg" value="<?= $editFlg ?>" />
		<input type="hidden" name="editnum" value="<?= $edNum ?>" />
		</form>
		
		<form method = "post" action="mission_2-5_002.php">
			<!-- 削除フォーム -->
		<p> 削除対象番号 <br /><input type="text" name="deleat" /></p>
		<p><input type="submit" name="deleatbutton" vaule="削除" /></p>
		</form>
		<!-- 編集フォーム -->
		<form method = "post" action="mission_2-5_002.php">
		<p>編集対象番号<br /><input type="text" name="edit" /></p>
		<p><input type="submit" name="editbutton" value="編集" /></p>
		</form>
		<h2>-----投稿一覧-------</h2>
		<ul>
		<?php if(count($postFile)): ?>
			<?php foreach($postFile as $post): ?>
				<php if(empty($post)) continue; ?>
				 <!-- 投稿の記述をする -->
				<?php list($cnt, $name, $comment, $time) = explode("<>", $post) ?>
				<li><?php echo emp($cnt); ?> 名前:<?php echo emp($name) ?> <br/>
						コメント:<?php echo emp($comment); ?> <?php echo emp($time); ?>
				</li>
				<?php endforeach ?>
			<?php else: ?>
				<li>まだ投稿はありません</li>
			<?php endif; ?>
		</ul>
	</body>
</html>