<?php

namespace App\Libraries;

class Crypt {
	static public function encrypt($plaintext, $public_key)
	{
		$rsa = new \phpseclib\Crypt\RSA();
		$rij = new \phpseclib\Crypt\AES(\phpseclib\Crypt\Rijndael::MODE_CBC);
	
		// Generate Random Symmetric Key
		$sym_key 	= \phpseclib\Crypt\Random::string(32);
		$sym_iv 	= \phpseclib\Crypt\Random::string(32);
		
		// Encrypt Message with new Symmetric Key
		$rij->setKey($sym_key);
		$rij->setIV($sym_iv);
		$ciphertext = $rij->encrypt($plaintext);
		$ciphertext = base64_encode($ciphertext);
		
		// Encrypted the Symmetric Key with the Asymmetric Key
		$rsa->loadKey($public_key);
		$rsa->setEncryptionMode($rsa::ENCRYPTION_PKCS1);
		$sym = $rsa->encrypt(json_encode(['iv' => base64_encode($sym_iv), 'key' => base64_encode($sym_key)]));
		
		// Base 64 encode the symmetric key for transport
		$sym = base64_encode($sym);
		$len = strlen($sym); // Get the length
	
		$len = dechex($len); // The first 3 bytes of the message are the key length
		$len = str_pad($len, 3, '0', STR_PAD_LEFT); // Zero pad to be sure.
	
		// Concatinate the length, the encrypted symmetric key, and the message
		$message = $len.$sym.$ciphertext;
		
		return $message;
	}
	
	static public function decrypt($encrypted, $private_key)
	{
		$rsa = new \phpseclib\Crypt\RSA();
		$rij = new \phpseclib\Crypt\AES(\phpseclib\Crypt\AES::MODE_CBC);
		
		// Extract the Symmetric Key
		$len = substr($encrypted, 0, 3);
		$len = hexdec($len);
		$sym = substr($encrypted, 3, $len);
		
		//Extract the encrypted message
		$encrypted 	= substr($encrypted, 3);
		$ciphertext = substr($encrypted, $len);
		$ciphertext = base64_decode($ciphertext);
		
		$rsa->loadKey($private_key);
		$rsa->setEncryptionMode($rsa::ENCRYPTION_PKCS1);
		$sym = base64_decode($sym);
		// $sym = pack('H*', $sym); // my added
		$sym = $rsa->decrypt($sym);
		
		$sym = json_decode($sym);
		
		if ($sym === null || json_last_error() !== JSON_ERROR_NONE) {
			throw new \Exception('Incorrect data');
		}
		
		$sym_key       = base64_decode($sym->key);
		$sym_iv        = base64_decode($sym->iv);   // iv_base64 from JS
		
		if(strlen($sym_key) != 32) {
			throw new \Exception('Key of size ' . strlen($sym_key) . ' not supported by this algorithm. Only key of size 32 are supported');
		}
		
		if(strlen($sym_iv) != 32) {
			throw new \Exception('IV of size ' . strlen($sym_iv) . ' not supported by this algorithm. Only iv of size 32 are supported');
		}
		
		// Decrypt the message
		$rij->setKey($sym_key);
		$rij->setIV($sym_iv);
		
		$plaintext = $rij->decrypt($ciphertext);
		
		$data = json_decode($plaintext, false, 512, JSON_BIGINT_AS_STRING);
		
		if ($data === null || json_last_error() !== JSON_ERROR_NONE) {
			throw new \Exception('Incorrect data');
		}
		
		return $data;
	}
	
	static public function rsaKeyToSingleLine($key)
	{
		/*
		$key = str_replace(['-----BEGIN RSA PUBLIC KEY-----', '-----END RSA PUBLIC KEY-----'], '', $key);
		$key = str_replace(['-----BEGIN RSA PRIVATE KEY-----', '-----END RSA PRIVATE KEY-----'], '', $key);
		$key = str_replace(["\r", "\n"], '', $key);
		*/
		$key = preg_replace('/-----[\s\S]+?-----|\s/', '', $key);
		return $key;
	}
}