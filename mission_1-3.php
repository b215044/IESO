<?php
	$filename = 'kadai2.txt';
	//echo $filename;
	$fp = fopen($filename, 'r');
	$size = filesize("kadai2.txt");
	$data = fread($fp,$size);

	echo $data;
	fclose($fp);
?>