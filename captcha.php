<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<title>�摜�F��</title>
</head>
 
<body>

<?php
	// �Z�b�V�����J�n
	session_start();	
	//���������h�~�ɁA����ƕ����R�[�h�𖾎��I�Ɏw��B
	mb_language("Japanese");
	mb_internal_encoding("UTF-8");
	// �ݒ荀��
	define("LOGIN_ENABLE_SEC", 300);// �\�������摜�Ń��O�C�������������(�b)
	define("IMAGE_SIZE_X",150);// ��]�O�̉摜�T�C�Y�i���j
	define("IMAGE_SIZE_Y", 80);// ��]�O�̉摜�T�C�Y�i�c�j
	define("STRING_NUM_MIN", 5);// �\������Œᕶ����
	define("STRING_NUM_MAX", 6);// �\������ő啶����
	define("FONT_SIZE_MIN", 12);// �Œ�t�H���g�T�C�Y
	define("FONT_SIZE_MAX", 20);// �ő�t�H���g�T�C�Y		
	define("CHAR_ANGLE", 15);// �����̌X���p�x�͈̔�
	define("IMAGE_TYPE", "jpeg");// "jpeg" or "png"
	//���p�t���[��IPA�t�H���g(�U��ށj
	$arr_font = array("ipaexg.ttf","ipaexm.ttf","ipag.ttf","ipagp.ttf","ipam.ttf","ipamp.ttf");
	// �摜�ɕ\�����镶��������(�Ђ炪�Ȃ̂݁j
	// �J�^�J�i�╽�ՂȊ�����ǉ�����̂�����
	$s = "�����������������������������������ĂƂȂɂʂ˂̂͂Ђӂւق܂݂ނ߂�������������񂪂����������������������Âł�";
	
	// �����̃V�[�h��ݒ肷��
	mt_srand(hexdec(bin2hex(openssl_random_pseudo_bytes(4))) );
	// �����_��������𐶐�
	$string = "";
	for($i=0; $i<mt_rand(STRING_NUM_MIN, STRING_NUM_MAX); $i++) {
		$string .= mb_substr($s,mt_rand(0,mb_strlen($s)-1),1);
	}
	//�摜�\������������(����)���Z�b�V�����ϐ��ɓ����
	 $_SESSION['captcha_auth'] = $string;
	
	// �摜�T�C�Y���w�肵�āA�摜�I�u�W�F�N�g�𐶐�
	$im = imagecreate(IMAGE_SIZE_X, IMAGE_SIZE_Y);
	// �w�i�F���w��(���F)
	imagecolorallocate($im, mt_rand(100,255), mt_rand(100,255), mt_rand(100,255));
	$black = imagecolorallocate($im, 0, 0, 0);
	$white= imagecolorallocate($im, 255, 255, 255);
	$gray  = imagecolorallocate($im, 196, 196, 196);
		
		
	// ������Ⴍ�����邽�߂ɁA�������̂Q�{�̃_�~�[�̐�������
	for($i=0; $i<mb_strlen($string)*2; $i++) {
		imageline($im, mt_rand(0,IMAGE_SIZE_X - 1),mt_rand(0,IMAGE_SIZE_Y - 1),mt_rand(0,IMAGE_SIZE_X - 1),mt_rand(0,IMAGE_SIZE_Y - 1), $gray);
	}
	
	//���[�U�ɓ��͂����邽�߂̕�����\��
	for($i=0; $i<mb_strlen($string); $i++) {
		
	
		//�����͏��Ԃ�����̂ŁA�������ɂ�����x���܂��Ă���B
		$x = (IMAGE_SIZE_X / mb_strlen($string)) * $i + mt_rand(-3,3);
		// �c���́A���S��������Ƀ����_���ɕ\��
		$y = IMAGE_SIZE_Y/2 + mt_rand(-IMAGE_SIZE_Y/4 , IMAGE_SIZE_Y/4);
		// �����̌X��
		$r = mt_rand(-CHAR_ANGLE, CHAR_ANGLE);	
		
		// �P�������o��
		imagettftext(
			$im, 									// �����������摜
			mt_rand(FONT_SIZE_MIN, FONT_SIZE_MAX), 	// �����̃t�H���g�T�C�Y
			$r, 									// �����̊p�x
			$x, $y, 								// �����̍��W
			imagecolorallocate(						// �����̐F(�قڍ������A�킸���ɗh�炬�𔭐������Ă���)
				$im, 
				mt_rand(0,3), 
				mt_rand(0,3), 
				mt_rand(0,3)), 
			$arr_font[mt_rand(0,count($arr_font)-1)], 	//�����̃t�H���g���w��
			mb_substr(mb_convert_encoding($string, "UTF-8"), $i, 1, "UTF-8")	//�����o���������̂���
		);
	}
	
	// ������Ⴍ�����邽�߂ɁA�킸���ɉ摜����]������
	$im = imagerotate($im, mt_rand(-2,2), $white);
	//�摜�`���ɍ��킹�ăw�b�_�o��
	if (IMAGE_TYPE == "jpeg") {
		header('Content-type: image/jpeg');
		imagejpeg($im);
	} else {
		header('Content-type: image/png');
		imagepng($im);
	}
	
	//�Ō�Ƀ��\�[�X�p��
	imagedestroy($im);	
?>


<img src="./create_captcha.php" alt="captcha_image" title="captcha_image" />
<form id="captcha_form" name="captcha_form" method="post" action="ans.php">
 
<input type="text"  id="captcha_text" name="captcha_text">
<button type="button" onclick="location.reload();">�����[�h</button>
<button type="submit" value="���M">���M</button>
 
</form>
 
</body>
</html>