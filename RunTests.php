<?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});

final class TestWorker{
	
	public $passed = 0;
	
	public $fails = 0;
	
	private $tests = null;
	
	function __construct() {
		
		$this->tests = array();
		
	}
	
	function add_test(IfaceTest $t) {
		
		$this->tests[] = $t;
	
	}
	
	function run_all() {
			
		foreach($this->tests as $test) {
		
			if(!$test->run_test()) {
				$this->fails++;
			} else {
				$this->passed++;
			}
		
		}
		
		if ($this->fails > 0) {
			return false;
		}
	
		return true;
	
	}
}

$testworker = new TestWorker();

$testworker->add_test(new RowIDTest());

$testworker->add_test(new KeyNameTest());

$testworker->add_test(new StatusNameTest());

$testworker->add_test(new LocatantTest());

$testworker->add_test(new KeyValuePDOTest());

$testworker->add_test(new TableStatusPDOTest());

$testworker->add_test(new TableKeysPDOTest());

$testworker->run_all();

echo "<br><h2>total {$testworker->passed} tests passed!<h2>";

echo "<br><h2>total {$testworker->fails} tests failed!<h2>";

	