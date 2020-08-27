<?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});

require_once("TestsCommon.php");
require_once("Constants.php");

class KeyNameTest implements IfaceTest { 

	function run_test() {
		
		try {
			$test = new KeyName();
		} catch (ArgumentCountError $e) {}
		
		try {
			$test = new KeyName("");
		} catch (NonAlphanumeric $e) {}
	
		try {
			$test = new KeyName("@!@#");
		} catch (NonAlphanumeric $e) {}
	
		try {
			$test = new KeyName(123);
		} catch (NonAlphanumeric $e) {}
		
		$str = "";
		for ($i = 0; $i <= Constants::MAX_KEYNAME_LEN; $i++) {
			$str .= 'a';
		}
		try {
			$test = new KeyName($str);
		} catch (ValueOutOfBounds $e) {}
							
		try {
			
			$v = "123abc";
			
			$test = new KeyName($v);				
			
			$r = $test->get();
			
			assert(strcmp($v, $r) == 0);
			
			$test = new KeyName("asdas");
			
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