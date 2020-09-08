$servername = "localhost";
$username = "testing";
$password = "3azjQfv1eUGPAuUP";
$dbname = "testing";
 
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  

  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


try {
	
	// begin the transaction
	$conn->beginTransaction();
	
	$sql = "CREATE TABLE IF NOT EXISTS MyGuests (			
			firstname VARCHAR(30),			
			email VARCHAR(50),
			reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)";
	$conn->exec($sql);
		
	$sql = "INSERT INTO `myguests` (`firstname`, `email`, `reg_date`) VALUES ('asdasd', '11112321', current_timestamp())";
	
	$conn->exec($sql);
	
	// commit the transaction
	$conn->commit();
	
	$stmt = $conn->prepare("SELECT * FROM MyGuests");
	$stmt->execute();

	// set the resulting array to associative
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	
	echo "<table style='border: solid 1px black;'>";
	
	while($row = $stmt->fetch()) {
		echo "<tr><td>".$row["firstname"]."</td><td>".$row["email"]."</td><td>".$row["reg_date"]."</td></tr>";
	}

	
} catch(PDOException $e) {
	// roll back the transaction if something failed
	
	$conn->rollback();
	
	echo $sql . "<br>" . $e->getMessage();
}
,