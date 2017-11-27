<?php
	//変数群 ミッション2－2
	$filename = 'inputcomment.txt';
	$fp = fopen($filename, 'a');
	
	/*
	 *プログラムの中身
	 *ミッション2－2
	*/
	if(isset($_POST['flg'])){
		$flg = $_POST['flg'];
	}else{
		$flg = 0;
	}
	if($flg == 0){
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

					$postList[$i] = $filenumberDe[$i].'<>';
					$postList[$i] .= $nameDe[$i].'<>'.$commentDe[$i].'<>';
					$postList[$i] .= $dateDe[$i];
					
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
	$nameEd = "";
	$commentEd = "";
	if(isset($_POST['editting'])){
		$code_2 = $_POST['editting'];
		   //echo($code);
		if(ctype_digit($code_2)){
			$posts = file($filename);
			for( $i = 0; $i < count($posts); $i++ ) {
				//文字列の分割
				$lists = explode('<>', $posts[$i]);
				if($code_2 == $lists[0]){
						$nameEd = $lists[1];
						$commentEd = $lists[2];
				}
			}
		}
	}
	
	if(flg == 1){
		$postEd = file($filename);
			for( $i = 0; $i < count($postEd); $i++ ) {
				//文字列の分割
				$listEd = explode('<>', $postEd[$i]);
				if($code_2 == $listEd[0]){
					$listEd[1] = $_POST['name'];
					$listEd[2] = $_POST['comment'];
					
					$postEd[$i] = $listEd[0]
						."<>名前：".$listEd[1]
						."<><br />コメント：".$listEd[2]
						."<>".date("Y年m月d日　H時i分s秒");
				}
			}
		if(isset($postEd)){
			unlink($filename);
			$fp = fopen($filename, 'a');
			foreach($posts as $postEd){
				fwrite($fp,$postEd.PHP_EOL);
			}
			fclose($fp);
		}
		$flg = 0;
	}
	//変数群　ミッション2－3
	$fp = fopen($filename, 'r');
	$text = file($filename);

	/*
	 *プログラムの中身
	 *ミッション2－3
	 */

	for( $i = 0; $i < count($text) ; $i++ ) {
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
		<form method="post" action="mission_2-5.php">

		<p>名前<br /><input type="text" name="name" value="<?php echo($nameEd);?>" /></p>
		<p>コメント<br /><input type="text" name="comment" value="<?php echo($commentEd);?>"/></p>
		<p><input type = "submit" value="送信"/></p>
		
		</form>
		<!-- 削除する番号入力フォームと削除するボタン-->
		<form method="post" action = "mission_2-5.php">

		<p>削除対象番号<br /><input type="text" name="deleat"/></p>
		<p><input type = "submit" value="削除"/></p>

		</form>
		<!-- 編集する番号入力フォームと編集内容を入力するフォーム -->
		<form method="post" action = "mission_2-5.php">

		<p>編集対象番号<br /><input type="text" name="editting"></p>
		<p><input type = "submit" value="編集"></p>
			<input type="hidden" name="flg" value=1/>
		</form>
	</body>
</html>