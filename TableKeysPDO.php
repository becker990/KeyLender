<?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});

require_once("Constants.php");
require_once("Exceptions.php");

class TableKeysPDO extends AbstractCommonPDO implements IfaceTableKeys {
	
	function create($foreign) : bool{
		
		$sql = "CREATE TABLE IF NOT EXISTS `{$this->TABLENAME}`(			
					id INT PRIMARY KEY,			
					name VARCHAR(" . Constants::MAX_KEYNAME_LEN . ") UNIQUE,
					statusId INT,
					locatant VARCHAR(" . Constants::MAX_LOCATANT_LEN . "),
					
					CONSTRAINT `fk_status` FOREIGN KEY (statusId) REFERENCES {$foreign} (id) ON DELETE SET NULL ON UPDATE CASCADE
				);";
		
		$this->pdo->exec($sql);
		
		return true;	
	}
	
	function getAll() {
		
		$sql = "SELECT * FROM {$this->TABLENAME};";
		
		$stmt = $this->pdo->prepare($sql);
		
		$stmt->execute();
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		
	}
	
	function getCount() {
		
		$sql = "SELECT COUNT(*) AS cont FROM {$this->TABLENAME};";
		
		$stmt = $this->pdo->prepare($sql);
		
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);

	}
	
	function getById(RowID $id){ throw new NotImplemented(); }
	
	function setById(RowID $id, KeyName $kn, RowID $statusid, Locatant $loc){ 
	
		$sql = "INSERT INTO {$this->TABLENAME} 
					(id, name, statusId, locatant) 
				VALUES 
					(:rowid, :kn, :statusid, :locatant) 	
			
				
				ON DUPLICATE KEY UPDATE 
					name = :kn,
					statusId = :statusid,
					locatant = :locatant
				;";
				
		
		
		$stmt = $this->pdo->prepare($sql);
		
		$rowid   = $id->get();
		$keyname = $kn->get();
		$statusid = $statusid->get();
		$locatant = $loc->get();
		
		$stmt->bindParam(":rowid", $rowid);
		$stmt->bindParam(":kn", $keyname);
		$stmt->bindParam(":statusid", $statusid);
		$stmt->bindParam(":locatant", $locatant);		
		
		$stmt->execute();
	
	}
	
	function setStatusById(RowID $id, StatusName $sn){ throw new NotImplemented(); }

	function setStatusByName(KeyName $kn, StatusName $sn){ throw new NotImplemented(); }
	
	function setLocatantById(RowID $id, Locatant $loc){ throw new NotImplemented(); }
	
	function setLocatantByName(KeyName $kn, Locatant $loc){ throw new NotImplemented(); }
	
	function deleteById(RowID $id){ throw new NotImplemented(); }
	
	function deleteByName(KeyName $kn){ throw new NotImplemented(); }	
	
}












