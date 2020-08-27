<?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});

require_once("TestsCommon.php");

class TableStatusPDOTest implements IfaceTest {
	
	function run_test() {
		
		$k = gen_rand_vec(Constants::MIN_STATUSNAME_LEN, 'rndlower');
		
		$validtablename = "statustest";
		$validname = new StatusName($k);
		$valid_id = new RowID(1);
				
		$pdo = (new PDOConnectionFactory())->getProduct();
		
		try {
			$worker = new TableStatusPDO($pdo, "");
		} catch (InvalidTablename $e) {}		
		
		$worker = new TableStatusPDO($pdo, $validtablename);

		$worker->create();			
		
		$worker->insert($validname);
		try {
			$worker->insert($validname);
		} catch (NonUniqueStatusName $e) {}		
		
		// sould be ID == 1
		$ret = $worker->getNameById($valid_id);
	
		assert(strcmp($validname->get(), $ret->get()) == 0);
		
		// sould be ID == 1
		$ret = $worker->getIdByName($validname);
	
		assert($valid_id->get() == $ret->get());
		
		$newname = new StatusName("validname");
		
		$worker->setNameById($valid_id, $newname);
		
		// sould be ID == 1
		$ret = $worker->getNameById($valid_id);

		assert(strcmp($newname->get(), $ret->get()) == 0);
		
		// still ID = 1
		$worker->deleteById($valid_id);		
		try {
			$worker->getNameById($valid_id);
		} catch (NotFound $e) {}
		
		$worker->insert($validname);
		
		$worker->deleteByName($validname);
		
		try {
			$worker->getIdByName($validname);
		} catch (NotFound $e) {}
		
		try {
			$worker = new TableStatusPDO($pdo, "@@ASD");
		} catch (NonAlphanumeric $e) {}
		
		return true;
	}

}