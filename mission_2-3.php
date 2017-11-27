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
		<form method="get" action="mission_2-3.php">
		<p>名前<br /><input type="text" name="name"/></p>
		<p>コメント<br /><input type="text" name="comment"/></p>
		<p><input type = "submit" value="送信"/></p>
		</form>
	</body>
</html>
<?php
	$filename = 'inputcomment.txt';
	$fp = fopen($filename, 'a');
	
	if(isset($_GET['name'])){
		if(isset($_GET['comment'])){
			$name = $_GET['name'];//名前
			$comment = $_GET['comment'];//コメントの変数
			$filenumber = count(file($filename))+1;//番号
			//名前とコメントの結合
			$nameandcomment = $filenumber.'<>';
			$nameandcomment .= "名前:".$name.'<><br />コメント:'.$comment.'<>';
			$nameandcomment .= date("Y年m月d日　H時i分s秒");

			fwrite($fp,$nameandcomment.PHP_EOL);
		}
	}
	fclose($fp);
	$fp = fopen($filename, 'r');
	$text = file($filename);
	
	for( $i = 0; $i < count($text); $i++ ) {
		$lists = explode('<>', $text[$i]);
		for($j = 0;$j < count($lists);$j++){
			echo($lists[$j]." ");
		}
		echo "<br />\n";
	}
	fclose($fp);
?>