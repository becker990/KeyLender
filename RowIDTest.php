<?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});

require_once("TestsCommon.php");
require_once("Constants.php");

class RowIDTest implements IfaceTest { 

	function run_test() {
		
		try {
			$rowid = new RowID();
		} catch (ArgumentCountError $e) {}
			
		try {
			$rowid = new RowID(-1);
		} catch (ValueOutOfBounds $e) {}
		
		try {
			$rowid = new RowID(Constants::MYMAXINT + 1);
		} catch (ValueOutOfBounds $e) {}
		
		
		try {
			
			$val = 42;
			
			$rowid = new RowID($val);
			
			$result = $rowid->get();
			
			assert($val == $result);
			
		} catch (Exception | Error $e) {
			echo "test failed: " . $e->getMessage() ."<br>";		
			return false;
		}
		
		try {
			
			$val = 42;
			
			$rowid = new RowID(1);
			
			$rowid->set($val);
			
			$result = $rowid->get();
			
			assert($val == $result);
			
		} catch (Exception | Error $e) {
			echo "test failed: " . $e->getMessage() ."<br>";		
			return false;
		}
		
		return true;	
	}

}