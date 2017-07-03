<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<title>画像認証</title>
</head>
 
<body>

<?php
	// セッション開始
	session_start();	
	//文字化け防止に、言語と文字コードを明示的に指定。
	mb_language("Japanese");
	mb_internal_encoding("UTF-8");
	// 設定項目
	define("LOGIN_ENABLE_SEC", 300);// 表示した画像でログインを許可する期間(秒)
	define("IMAGE_SIZE_X",150);// 回転前の画像サイズ（横）
	define("IMAGE_SIZE_Y", 80);// 回転前の画像サイズ（縦）
	define("STRING_NUM_MIN", 5);// 表示する最低文字数
	define("STRING_NUM_MAX", 6);// 表示する最大文字数
	define("FONT_SIZE_MIN", 12);// 最低フォントサイズ
	define("FONT_SIZE_MAX", 20);// 最大フォントサイズ		
	define("CHAR_ANGLE", 15);// 文字の傾き角度の範囲
	define("IMAGE_TYPE", "jpeg");// "jpeg" or "png"
	//商用フリーのIPAフォント(６種類）
	$arr_font = array("ipaexg.ttf","ipaexm.ttf","ipag.ttf","ipagp.ttf","ipam.ttf","ipamp.ttf");
	// 画像に表示する文字列を作る(ひらがなのみ）
	// カタカナや平易な漢字を追加するのもあり
	$s = "あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわをんがぎぐげござじずぜぞだぢづでど";
	
	// 乱数のシードを設定する
	mt_srand(hexdec(bin2hex(openssl_random_pseudo_bytes(4))) );
	// ランダム文字列を生成
	$string = "";
	for($i=0; $i<mt_rand(STRING_NUM_MIN, STRING_NUM_MAX); $i++) {
		$string .= mb_substr($s,mt_rand(0,mb_strlen($s)-1),1);
	}
	//画像表示した文字列(正解)をセッション変数に入れる
	 $_SESSION['captcha_auth'] = $string;
	
	// 画像サイズを指定して、画像オブジェクトを生成
	$im = imagecreate(IMAGE_SIZE_X, IMAGE_SIZE_Y);
	// 背景色を指定(白色)
	imagecolorallocate($im, mt_rand(100,255), mt_rand(100,255), mt_rand(100,255));
	$black = imagecolorallocate($im, 0, 0, 0);
	$white= imagecolorallocate($im, 255, 255, 255);
	$gray  = imagecolorallocate($im, 196, 196, 196);
		
		
	// 可視性を低くさせるために、文字数の２倍のダミーの線を入れる
	for($i=0; $i<mb_strlen($string)*2; $i++) {
		imageline($im, mt_rand(0,IMAGE_SIZE_X - 1),mt_rand(0,IMAGE_SIZE_Y - 1),mt_rand(0,IMAGE_SIZE_X - 1),mt_rand(0,IMAGE_SIZE_Y - 1), $gray);
	}
	
	//ユーザに入力させるための文字を表示
	for($i=0; $i<mb_strlen($string); $i++) {
		
	
		//横軸は順番があるので、文字順にある程度決まっている。
		$x = (IMAGE_SIZE_X / mb_strlen($string)) * $i + mt_rand(-3,3);
		// 縦軸は、中心部分を基準にランダムに表示
		$y = IMAGE_SIZE_Y/2 + mt_rand(-IMAGE_SIZE_Y/4 , IMAGE_SIZE_Y/4);
		// 文字の傾き
		$r = mt_rand(-CHAR_ANGLE, CHAR_ANGLE);	
		
		// １文字ずつ出力
		imagettftext(
			$im, 									// 文字を書く画像
			mt_rand(FONT_SIZE_MIN, FONT_SIZE_MAX), 	// 文字のフォントサイズ
			$r, 									// 文字の角度
			$x, $y, 								// 文字の座標
			imagecolorallocate(						// 文字の色(ほぼ黒だが、わずかに揺らぎを発生させている)
				$im, 
				mt_rand(0,3), 
				mt_rand(0,3), 
				mt_rand(0,3)), 
			$arr_font[mt_rand(0,count($arr_font)-1)], 	//文字のフォントを指定
			mb_substr(mb_convert_encoding($string, "UTF-8"), $i, 1, "UTF-8")	//書き出す文字そのもの
		);
	}
	
	// 可視性を低くさせるために、わずかに画像を回転させる
	$im = imagerotate($im, mt_rand(-2,2), $white);
	//画像形式に合わせてヘッダ出力
	if (IMAGE_TYPE == "jpeg") {
		header('Content-type: image/jpeg');
		imagejpeg($im);
	} else {
		header('Content-type: image/png');
		imagepng($im);
	}
	
	//最後にリソース廃棄
	imagedestroy($im);	
?>


<img src="./create_captcha.php" alt="captcha_image" title="captcha_image" />
<form id="captcha_form" name="captcha_form" method="post" action="ans.php">
 
<input type="text"  id="captcha_text" name="captcha_text">
<button type="button" onclick="location.reload();">リロード</button>
<button type="submit" value="送信">送信</button>
 
</form>
 
</body>
</html>