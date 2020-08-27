<?php

final class Locatant {
	
	protected $LOCATANT = null;
	
	function __construct(string $l) {
		$this->set($l);
	}

	function set($l) {
		
		$this->guard_locatant($l);
		
		$this->LOCATANT = $l;
		
	}

	function get() : string {
		return $this->LOCATANT;
	}
	
	protected function guard_locatant($l) {
		
		$len = strlen($l);
		
		if ($len < Constants::MIN_LOCATANT_LEN || $len > Constants::MAX_LOCATANT_LEN) throw new ValueOutOfBounds();
		
	}

}