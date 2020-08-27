<?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});

require_once("TestsCommon.php");

class KeyValuePDOTest implements IfaceTest {

	function run_test() {
			
		$pdo = "";
		
		try {
			$worker = new KeyValuePDO($pdo, "keyvaluepdotest");
		} catch (TypeError $e) {}

		$pdo = (new PDOConnectionFactory())->getProduct();
		
		try {
			$worker = new KeyValuePDO($pdo, "@@ASD");
		} catch (NonAlphanumeric $e) {}

		$worker = new KeyValuePDO($pdo, "keyvaluetest");
		
		$worker->create();
		
		$k = gen_rand_vec(256, 'rndlower');		
		
		try {
			$worker->set($k, "");
		} catch (ValueOutOfBounds $e) {}

		
		$v = gen_rand_vec(65535, 'rndbyte');
		
		try {
			$worker->set("kk", $v);
		} catch (ValueOutOfBounds $e) {}
		
		for ($i = 0; $i < 10; $i++) {
			
			$k = gen_rand_vec(255, 'rndlower');
			
			$v = gen_rand_vec(65534, 'rndbyte');
			
			$worker->set($k, $v);
			$ret = $worker->get($k);
			
			assert(strcmp($ret, $v) == 0);

		}	

		
		return true;
	}
}
