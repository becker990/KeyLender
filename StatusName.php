<?php

final class StatusName {
	
	protected $STATUSNAME = null;	
	
	function __construct(string $s) {
		$this->set($s);		
	}
	
	function set($s) {
		
		$this->guard_status_name($s);
		
		$this->STATUSNAME = $s;
	}
	
	function get() {
		return $this->STATUSNAME;
	}
	
	protected function guard_status_name(string $s) {
		
		if (!ctype_alnum($s)) throw new NonAlphanumeric();
		
		$len = strlen($s);

		if ($len < Constants::MIN_STATUSNAME_LEN) throw new ValueOutOfBounds("StatusName smaller than " . Constants::MAX_STATUSNAME_LEN);

		if ($len > Constants::MAX_STATUSNAME_LEN) throw new ValueOutOfBounds("StatusName bigger than " . Constants::MAX_STATUSNAME_LEN);
		
	}

}