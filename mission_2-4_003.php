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
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			//名前とコメントが入力されたら
			if(isset($_POST['name'])){
				if(isset($_POST['comment'])){
					$comment = $_POST['comment'];
					$comment = htmlspecialchars($comment);
					$comment = str_replace("\n", "<br>", $comment);
					$comment = $comment."\n";
					$filenumber = count(file($filename))+1;//番号
					
					//配列fileRowに情報を入れる
					$fileRow = array(
						'filenumber' => count(file($filename))+1,
						'name' =>$_POST['name'],
						'comment' => $_POST['comment'],
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
		
		<form method="post" action="mission_2-4_003.php">
			<!-- 入力フォーム -->
		<p>名前<br /><input type="text" name="name"/></p>
		<p>コメント<br /><input type="text" name="comment"/></p>
		<p><input type="submit" name="write" value="送信"/></p>

		</form>
		
		<form method = "post" action="mission_2-4_003.php">
			<!-- 削除フォーム -->
		<p> 削除対象番号 <br /><input type="text" name="deleat"></p>
		<p><input type="submit" name="deleatbutton" vaule="削除"></p>
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