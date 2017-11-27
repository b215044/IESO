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
		<form method="post" action="mission_2-2.php">
		<p>名前<br /><input type="text" name="name"/></p>
		<p>コメント<br /><input type="text" name="comment"/></p>
		<p><input type = "submit" value="送信"/></p>
		</form>
	</body>
</html>
<?php
	$filename = 'inputcomment.txt';
	$fp = fopen($filename, 'a');
	
	if(isset($_POST['name'])){
		if(isset($_POST['comment'])){
			$name = $_POST['name'];//名前
			$comment = $_POST['comment'];//コメントの変数
			$filenumber = count(file($filename))+1;//番号
			//名前とコメントの結合
			$nameandcomment = "{".$filenumber."}<>{";
			$nameandcomment .= $name."}<>{".$comment."}<>{";
			$nameandcomment .= date("Y年m月d日　H時i分s秒P")."}";

			fwrite($fp,$nameandcomment.PHP_EOL);
		}
	}
	fclose($fp);
?>