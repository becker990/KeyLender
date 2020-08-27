<?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});

require_once('Exceptions.php');

class KeyValuePDO extends AbstractCommonPDO implements IfaceTableKeyValue {
	
	protected const MAXKEYSIZE = 255;
	
	protected const MAXVALSIZE = 65534;
	
	function create() : bool {

		$this->guard_pdo();

		$this->guard_tablename();
	
		$sql = "CREATE TABLE IF NOT EXISTS `" . $this->TABLENAME . "`(			
					pkey VARCHAR(" . self::MAXKEYSIZE . ") PRIMARY KEY NOT NULL,
					myvalue BLOB
				)";
		
		$this->pdo->exec($sql);
	
		return true; 
	}
	
	function get_all() : array {
		
		$this->guard_pdo();
		
		$this->guard_tablename();
		
		$sql = "SELECT * FROM " . $this->TABLENAME;				
		
		$stmt = $this->pdo->prepare($sql);
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
				
		$stmt->execute();		
		
		return $stmt->fetchAll();
	}
	
	function get_assoc(string $key)  : array{
		
		$this->guard_pdo();
		
		$this->guard_tablename();
		
		$this->guard_key($key);	
		
		$sql = "SELECT * FROM " . $this->TABLENAME . " WHERE pkey = :pkey";				
		
		$stmt = $this->pdo->prepare($sql);
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		$stmt->bindParam(':pkey', $key);
		
		$stmt->execute();		
		
		$result = $stmt->fetch();

		return $result;
	}
	
	function get(string $key) : string {
		
		$this->guard_pdo();
		
		$this->guard_tablename();		
		
		$this->guard_key($key);
			
		$result = $this->get_assoc($key);
		
		if(!$result)
			return false;
		
		return $result['myvalue'];
	}
	
	function set(string $key, string $value) : bool{
		
		$this->guard_pdo();
		
		$this->guard_tablename();

		$this->guard_key($key);
	
		$this->guard_value($value);		
				
		$sql = "INSERT INTO " . $this->TABLENAME . " (pkey, myvalue) VALUES (:pkey, :value) ON DUPLICATE KEY UPDATE myvalue= :value";
		
		$stmt = $this->pdo->prepare($sql);
				
		$stmt->bindParam(':pkey', $key);
		$stmt->bindParam(':value', $value);
		
		$stmt->execute();		
	
		return true; 
	
	}
	
	protected function guard_key(string $key) {
		
		if (!ctype_alnum($key)) throw new NonAlphanumeric("Non alphanumeric key");		
	
		if (strlen($key) > self::MAXKEYSIZE) throw new ValueOutOfBounds("Key bigger than " . self::MAXKEYSIZE . " bytes");
	
	}
	
	protected function guard_value(string $value) {
		
		if(strlen($value) > self::MAXVALSIZE) throw new ValueOutOfBounds("Value bigger than " . self::MAXVALSIZE . " bytes");
		
	}	
}