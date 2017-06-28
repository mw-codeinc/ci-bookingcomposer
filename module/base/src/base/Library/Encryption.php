<?php
namespace base\Library;

class Encryption {
	
	public static function encrypt($value) {
		$options = array(
			'cost' => 11,
			'salt' => mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_RAND)
		);
		
		return password_hash($value, PASSWORD_BCRYPT, $options);
	}
}