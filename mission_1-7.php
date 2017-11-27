<!DOCUTYPE html>
<html lang = "ja">
	<head>
	<meta charset = "UTF-8">
		<title>mission_1-7</title>
	</head>
	<body>
		<h1>
			入力フォーム
		</h1>
		<form method="post" action="mission_1-7.php">
		<p><input type="text" name="comment"/></p>
		<p><input type = "submit" value="送信"/></p>
		</form>
	</body>
</html>
<?php
	$filename = 'comment.txt';
	$fp = fopen($filename, 'a+');
	if(isset($_POST['comment'])){
		$comment = $_POST['comment'];
		//echo $comment;
		fwrite($fp,$comment.PHP_EOL);
	}

	$text = file($filename);
	// 取得したファイルデータ(配列)を全て表示する
	for( $i = 0; $i < count($text); ++$i ) {
    	//配列を順番に表示する
		echo( $text[$i] . "<br />\n" );
	}
	fclose($fp);
?>