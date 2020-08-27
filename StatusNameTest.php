<?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});

require_once("TestsCommon.php");
require_once("Constants.php");

class StatusNameTest implements IfaceTest { 

	function run_test() {
		
		try {
			$test = new StatusName();
		} catch (ArgumentCountError $e) {}
		
		try {
			$test = new StatusName("");
		} catch (NonAlphanumeric $e) {}
	
		try {
			$test = new StatusName("@!@#");
		} catch (NonAlphanumeric $e) {}
	
		try {
			$test = new StatusName(123);
		} catch (NonAlphanumeric $e) {}
		
		$str = "";
		for ($i = 0; $i <= Constants::MAX_STATUSNAME_LEN; $i++) {
			$str .= 'a';
		}
		try {
			$test = new StatusName($str);
		} catch (ValueOutOfBounds $e) {}
							
		try {
			
			$v = "123abc";
			
			$test = new StatusName($v);				
			
			$r = $test->get();
			
			assert(strcmp($v, $r) == 0);
			
			$test = new StatusName("asdas");
			
			$test->set($v);
			$r = $test->get();
			
			assert(strcmp($v, $r) == 0);
			
		} catch (Exception | Error $e) {
			echo "Test failed! ". $e->getMessage();
			return false;
		}
	
		return true;
	}
}