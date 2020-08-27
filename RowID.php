<?php

require_once("Exceptions.php");

final class RowID {
	
	protected const MINVAL = 1;
	
	protected const MAXVAL = Constants::MYMAXINT;

	protected $ID = null;

	function __construct(int $id) {
		$this->set($id);
	}
	
	function set(int $id) {
		
		$this->guard_id($id);
		
		$this->ID = $id;
		
	}
	
	function get() : int {
		return $this->ID;
	}
	
	protected function guard_id(int $id) {
		
		if ($id < $this::MINVAL || $id > $this::MAXVAL) throw new ValueOutOfBounds();
		
	}

}