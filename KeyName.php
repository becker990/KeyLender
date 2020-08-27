<?php

final class KeyName {
	
	protected $KEYNAME = null;	
	
	function __construct(string $keyname) {
		$this->set($keyname);		
	}
	
	function set($keyname) {
		
		$this->guard_keyname($keyname);
		
		$this->KEYNAME = $keyname;
	}
	
	function get() {
		return $this->KEYNAME;
	}
	
	protected function guard_keyname(string $keyname) {
		
		if (!ctype_alnum($keyname)) throw new NonAlphanumeric();

		if (strlen($keyname) < Constants::MIN_KEYNAME_LEN) throw new ValueOutOfBounds("Keyname smaller than " . Constants::MAX_KEYNAME_LEN);

		if (strlen($keyname) > Constants::MAX_KEYNAME_LEN) throw new ValueOutOfBounds("Keyname bigger than " . Constants::MAX_KEYNAME_LEN);
		
	}

}