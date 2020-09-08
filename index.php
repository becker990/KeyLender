
<a href="RunTests.php">run all tests</a>

<a href="home.php">home</a>



<?php

//require_once("RunTests.php");






/*





function myhandl(int $errno , string $errstr , string $errfile , int $errline , array $errcontext ) {
	$cx = print_r($errcontext, true);	
	$s = <<<MYERR
	
			<ol>
				<li>errno  : {$errno}</li>
				<li>erstr  : {$errstr}</li>
				<li>errfile: {$errfile}</li>
				<li>line   : {$errline}</li>					
				<li>ctx    : {$cx}</li>
			</ol>	
MYERR;
	echo $s;
}	

set_error_handler("myhandl");

$a = 0;

$b = array(1, 2, 3);


$c = $b[3];	






$worker1 = new PDOConnectionFactory();

$worker2 = new PDOConnectionFactory();

$p1 = $worker1->getProduct();
$p2 = $worker2->getProduct();

if($p1 === $p2)
	echo "yes";
else
	echo "no";


$pdo = (new PDOConnectionFactory())->getProduct();

$worker = new TableKeysPDO($pdo);

echo $worker->create() . " create";

$id = new KeysID();
$name = new KeysName();
$status = new KeysStatus();
$currentUser = new KeysUser();

echo $worker->insert($id, $name, $status, $currentUser) . " insert";


$pdo = (new PDOConnectionFactory())->getProduct();

$worker = new TableStatusPDO($pdo);


echo $worker->drop() . " drop".PHP_EOL;
echo $worker->create() . " create".PHP_EOL;
*/















