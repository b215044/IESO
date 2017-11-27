<?php
	$filename = 'comment.txt';
	$fp = fopen($filename, 'w');
	if(isset($_POST['comment'])){
		$comment = $_POST['comment'];
		//echo $comment;
		fwrite($fp,$comment);
	}
	fclose($fp);
?>
<!DOCUTYPE html>
<html lang = "ja">
	<head>
	<meta charset = "UTF-8">
		<title>mission_1-5</title>
	</head>
	<body>
		<h1>
			入力フォーム
		</h1>
		<form method="post" action="mission_1-5.php">
		<p><input type="text" name="comment"/></p>
		<p><input type = "submit" value="送信"/></p>
		</form>
	</body>
</html>