<?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});

require_once("TestsCommon.php");

class TableKeysPDOTest implements IfaceTest {
	
	function run_test() {
		
		$validtablename = "keystest";
		
		// set up parent table
		$parentname = "statustest";
		
		$pdo = (new PDOConnectionFactory())->getProduct();
		
		$worker = new TableKeysPDO($pdo, $validtablename);
		$worker->deleteit();
		
		$parent = new TableStatusPDO($pdo, $parentname);
			
		$worker->create($parentname);
		
		$validstatusname1 = new StatusName("status1");
		$validstatusname2 = new StatusName("status2");
		
		$parent->insert($validstatusname1);
		$parent->insert($validstatusname2);
		
		// actually testing		
				
		$validkeyname = new KeyName("keyname1");
		
		$validloca1 = new Locatant("locatant1");
		$validloca2 = new Locatant("locatant2");
		
		$valid_status_id1 = $parent->getIdByName($validstatusname1);
		$valid_status_id2 = $parent->getIdByName($validstatusname2);
			
		$validrowid = new RowID(3);
				
		$worker->setByID($validrowid, $validkeyname, $valid_status_id1, $validloca1);	
			
		
		$worker->setStatusById($valid_id,$valid_status_id2);	
		
		/*
		try {
			$worker = new TableKeysPDO($pdo, "");
		} catch (InvalidTablename $e) {}
				
		$worker = new TableKeysPDO($pdo, $validtablename);
			
		*/
		return true;
	}

}

/*

	$k = gen_rand_vec(Constants::MIN_STATUSNAME_LEN, 'rndlower');
		
		$validtablename = "statustest";
		$validname = new StatusName($k);
		$valid_id = new RowID(1);
		
		
		$pdo = (new PDOConnectionFactory())->getProduct();
		
		try {
			$worker = new TableStatusPDO($pdo, "");
		} catch (InvalidTablename $e) {}		
		
		$worker = new TableStatusPDO($pdo, $validtablename);
		
		$worker->deleteit();
		$worker->create();
			
		$worker->clear();
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
		} catch (NonAlphanumeric $e) {}*/