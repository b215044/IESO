<?php
	$filename = 'inputcomment.txt';
	
	function emp($s){
		return htmlspcialchars($s, ENT_QUOTES, 'UTF-8');
	}
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST['name'])){
			if(isset($_POST['comment'])){
				$comment = $_POST['comment'];
				$comment = htmlspecialchars($comment);
				$comment = str_replace("\n", "<br>", $comment);
				$comment = $comment."\n";
				$filenumber = count(file($filename))+1;//番号
				
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
	//
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
		<form method="post" action="mission_2-3_001.php">

		<p>名前<br /><input type="text" name="name"/></p>
		<p>コメント<br /><input type="text" name="comment"/></p>
		<p><input type="submit" name="write" value="送信"/></p>

		</form>
		<h2>-----投稿一覧-------</h2>
		<ul>
		<?php if(count($postFile)): ?>
			<?php foreach($postFile as $post): ?>
				<php if(empty($post)) continue; ?>
				<?php list($cnt, $name, $comment, $time) = explode("<>", $post) ?>
				<li><?php echo $cnt; ?> 名前:<?php echo $name ?> <br/>
						コメント:<?php echo $comment; ?> <?php echo $time; ?>
				</li>
				<?php endforeach ?>
			<?php else: ?>
				<li>まだ投稿はありません</li>
			<?php endif; ?>
		</ul>
	</body>
</html>