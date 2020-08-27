<?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});

class PDOConnectionFactory implements IfaceFactory {
	
	private static $mainPDO = null;
	
	function __construct()
    {
		
		$servername = AbstractConnectionData::servername;
		$username = AbstractConnectionData::username;
		$password = AbstractConnectionData::password;
		$dbname = AbstractConnectionData::dbname;
		
		if($this::$mainPDO === null){
			try {
				$this::$mainPDO = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			} catch (PDOException $e) {
				die("Unable to connect to " . AbstractConnectionData::servername);				
			}
			$this::$mainPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }
	
	function getProduct(){
		return $this::$mainPDO;
	}
}