<?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});

require_once("TestsCommon.php");


	$k = gen_rand_vec(Constants::MIN_STATUSNAME_LEN, 'rndlower');
		
	$validtablename = "keystest";
	$validname = new StatusName($k);
	$valid_id = new RowID(1);
		
		
	$pdo = (new PDOConnectionFactory())->getProduct();
		
	$worker = new TableKeysPDO($pdo, $validtablename);
	$worker->create("statustest");
	
	
	//echo json_encode($worker->get_count()); die();
	echo json_encode($worker->get_all()); die();
	
	$arr = array();

	for ($i = 0; $i<40;  $i++ ){
		
		$arr[] = array( "cartao" => "123",
						"codbarra" => "32131",
						"id_chave" => strval($i),
						"nome" => "nome",
						"status" => "1"
						);
		
	}

	echo json_encode($arr);