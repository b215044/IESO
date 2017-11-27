<?php
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$filename = 'inputcomment.txt';

		if(isset($_POST['name', 'comment'])){
			$comment = $_POST['comment'];
			$comment = htmlspecialchars($comment);
			$comment = str_replace("\n", "<br>", $comment);
			$comment = $comment."\n";
			$filenumber = count(file($filename))+1;//番号
			
			$fileRow = array(
				'filenumber' => count(file($filename))+1,
				'name' =>$_POST['name'],
				'comment' => $_POST['comment'],
				'time' => date("Y/m/d H:i;s")
			);
			$fp = fopen($filename, 'a');
			fwrite($fp, $fileRow["filenumber"]."<>".$fileRow["name"]."<>".
					$fileRow["comment"]."<>".$fileRow["time"]."\n");
			fclose($fp);
		}
		
		header('Location:'.$_SERVER['SCRIPT_NAME']);
		exit;
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
		<form method="post" action="mission_2-2_001.php">

		<p>名前<br /><input type="text" name="name"/></p>
		<p>コメント<br /><input type="text" name="comment"/></p>
		<p><input type="submit" value="送信"/></p>

		</form>
	</body>
</html>
