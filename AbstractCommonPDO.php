<?php

require_once('Exceptions.php');

abstract class AbstractCommonPDO {

	protected $pdo = null;
	
	protected $TABLENAME = "";
	
	function __construct(PDO $pdo, string $tablename){

		$this->pdo = $pdo;

		$this->TABLENAME = $tablename;
		
		$this->guard_pdo();
		
		$this->guard_tablename();	
	}

	function guard_pdo() {
		
		if (!($this->pdo instanceof PDO)) throw new InvalidPDO();
		
	}
	
	function guard_tablename () {
		
		if ($this->TABLENAME == null ||
			$this->TABLENAME == ""   ||
			strlen($this->TABLENAME) > Constants::MAXTABLENAMESIZE){
			throw new InvalidTablename();
		}
		
		// executive implementation decision
		if (!ctype_alnum($this->TABLENAME)) throw new NonAlphanumeric("Non alphanumeric tablename");
		
	}
}