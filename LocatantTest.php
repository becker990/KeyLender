<?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});

require_once("TestsCommon.php");
require_once("Constants.php");

class LocatantTest implements IfaceTest { 

	function run_test() {
		
		try {
			$test = new Locatant();
		} catch (ArgumentCountError $e) {}

		try {
			$test = new Locatant("");
		} catch (ValueOutOfBounds $e) {}
		
		try {
			$test = new Locatant("123");
		} catch (ValueOutOfBounds $e) {}
		
		$str = "";
		for ($i = 0; $i <= Constants::MAX_LOCATANT_LEN; $i++) {
			$str .= 'a';
		}
		try {
			$test = new Locatant($str);
		} catch (ValueOutOfBounds $e) {}
							
		try {
			
			$v = "123 abc";
			
			$test = new Locatant($v);				
			
			$r = $test->get();
			
			assert(strcmp($v, $r) == 0);
			
			$test = new Locatant("asdas");
			
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