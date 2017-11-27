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
		<!-- 名前とコメントの入力フォームと送信するボタン -->
		<form method="post" action="mission_2-4_02.php">

		<p>名前<br /><input type="text" name="name"/></p>
		<p>コメント<br /><input type="text" name="comment"/></p>
		<p><input type = "submit" value="送信"/></p>

		</form>
		<!-- 削除する番号入力フォームと削除するボタン-->
		<form method="post" action = "mission_2-4_02.php">

		<p>削除対象番号<br /><input type="text" name="deleat"/></p>
		<p><input type = "submit" value="削除"/></p>

		</form>
	</body>
</html>
<?php
	//変数群 ミッション2－2
	$filename = 'inputcomment.txt';
	$fp = fopen($filename, 'a');

	/*
	 *プログラムの中身
	 *ミッション2－2
	*/
	if(isset($_POST['name'])){
		if(isset($_POST['comment'])){

			$name = $_POST['name'];//変数：名前
			$comment = $_POST['comment'];//変数：コメント
			$filenumber = count(file($filename))+1;//変数：番号

			//名前とコメントの結合

			$nameandcomment = $filenumber.'<>';
			$nameandcomment .= "名前:".$name.'<><br />コメント:'.$comment.'<>';
			$nameandcomment .= date("Y年m月d日　H時i分s秒");
			
			//ファイルへの書き出し
			fwrite($fp,$nameandcomment.PHP_EOL);
		}
	}
	fclose($fp);
	//
	if(isset($_POST['deleat'])){
		$code = $_POST['deleat'];
		   //echo($code);
		if(ctype_digit($code)){
			$num=1;
			$posts = file($filename);
			for( $i = 0; $i < count($posts); $i++ ) {
				//文字列の分割
				$lists = explode('<>', $posts[$i]);
				   //echo($lists[0]);
				//削除する番号か判断する
				if($code != $lists[0]){
					$nameDe[$i] = $lists[1];//変数：名前
					$commentDe[$i] = $lists[2];//変数：コメント
					$dateDe[$i] = $lists[3];
					$filenumberDe[$i] = $num;//変数：番号
					
					//名前とコメントの結合

					$postList = $filenumberDe[$i].'<>';
					$postList .= $nameDe[$i].'<>'.$commentDe[$i].'<>';
					$postList .= $dateDe[$i];
					
					$num++;
					$form[$i] = $postList[$i];
				}
			}
			if(isset($form)){
				   //echo($form[1]);
				unlink($filename);
				$fp = fopen($filename, 'a');
				
				foreach($form as $forms){
					fwrite($fp,$forms);
				}
				fclose($fp);
			}
			
		}else{
			header("location:numberError.php");
		}
	}
	
	//変数群　ミッション2－3
	$fp = fopen($filename, 'r');
	$text = file($filename);

	/*
	 *プログラムの中身
	 *ミッション2－3
	 */

	for( $i = 0; $i < count($text); $i++ ) {
		//文字列の分割
		$lists = explode('<>', $text[$i]);
		for($j = 0;$j < count($lists);$j++){
			//配列の個々での表示
			//配列textの一つ分を表示させる
			echo($lists[$j]." ");
		}
		echo "<br />\n";
	}
	fclose($fp);
?>