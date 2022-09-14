<?php
function miyu($num){
	if($num=='dw'){
		$miyu = ['🐱','🐶','🐷','🐍'];
	}elseif($num=='my'){
		$miyu = ['喵','咪','呜','～'];
	}elseif($num=='sy'){
		$miyu = ['嗷','呜','啊','～'];
	}elseif($num=='gy'){
		$miyu = ['旺','汪','呜','～'];
	}elseif($num=='fh'){
		$miyu = ['·','～','-','`'];
	}elseif($num=='sz'){
		$miyu = ['6','9','8','5'];
	}elseif($num=='zm'){
		$miyu = ['a','b','c','d'];
	}elseif($num=='ay'){
		$miyu = ['我','爱','你','～'];
	}elseif($num=='sg'){
		$miyu = ['🍎','🍑','🍉','🍌'];
	}elseif($num=='bq'){
		$miyu = ['😎','😄','😍','😝'];
	}elseif($num=='ss'){
		$miyu = ['👋','👍','👌','🙏'];
	}
	return $miyu;
}


function encode($str,$miyu){
	$code = null;
	$hexArray = str_split_unicode(bin2hex($str));
	foreach ($hexArray as $k => $v) {
		$x = base_convert($v, 16, 10) + $k % 16;
		if ($x >= 16) {
			$x -= 16;
		}
		$code .= $miyu[($x / 4)] . $miyu[$x % 4];
	}
	return $code;
}

function decode($str){
	if(strstr($str,'🐱')){
		$miyu = miyu('dw');
	}elseif(strstr($str,'喵')){
		$miyu = miyu('my');
	}elseif(strstr($str,'嗷')){
		$miyu = miyu('sy');
	}elseif(strstr($str,'旺')){
		$miyu = miyu('gy');
	}elseif(strstr($str,'·')){
		$miyu = miyu('fh');
	}elseif(strstr($str,'6')){
		$miyu = miyu('sz');
	}elseif(strstr($str,'a')){
		$miyu = miyu('zm');
	}elseif(strstr($str,'我')){
		$miyu = miyu('ay');
	}elseif(strstr($str,'🍎')){
		$miyu = miyu('sg');
	}elseif(strstr($str,'😎')){
		$miyu = miyu('bq');
	}elseif(strstr($str,'👋')){
		$miyu = miyu('ss');
	}
	$code = null;
	$hexArray = str_split_unicode($str);
	$n = count($hexArray);
	for ($i = 0; $i < $n; $i++) {
		if ($i % 2 == 0) {
			if (empty($hexArray[$i + 1])) {
				break;
			}
			$A = array_search($hexArray[$i], $miyu);
			$B = array_search($hexArray[$i + 1], $miyu);
			$x = (($A * 4) + $B) - (($i / 2) % 16);
			if ($x < 0) {
				$x += 16;
			}
			$code .= dechex($x);
		}
	}
	return pack("H*", $code);
}

function str_split_unicode($str, $l = 0){
	if ($l > 0) {
		$ret = array();
		$len = mb_strlen($str, "UTF-8");
		for ($i = 0; $i < $len; $i += $l) {
			$ret[] = mb_substr($str, $i, $l, "UTF-8");
		}
		return $ret;
	}
	return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}

function daddslashes($string, $force = 0, $strip = FALSE) {
        !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
        if(!MAGIC_QUOTES_GPC || $force) {
            if(is_array($string)) {
                foreach($string as $key => $val) {
                    $string[$key] = daddslashes($val, $force, $strip);
                }
            } else {
                $string = addslashes($strip ? stripslashes($string) : $string);
            }
        }
        return $string;
    }
?>