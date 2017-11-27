<?php
	if(isset($_POST['comment'])){
		$comment = $_POST['comment'];
		echo $comment;
	}
?>
<!DOCUTYPE html>
<html lang = "ja">
	<head>
	<meta charset = "UTF-8">
		<title>mission_1-4</title>
	</head>
	<body>
		<h1>
			入力フォーム
		</h1>
		<form method="post" action="mission_1-4.php">
		<p><input type="text" name="comment"></p>
		<p><input type = "submit" value="送信/"></p>
		</form>
	</body>
</html>