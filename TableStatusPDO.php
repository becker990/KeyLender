<?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});

require_once("Constants.php");

class TableStatusPDO extends AbstractCommonPDO implements IfaceTableStatus { 

	function create()  : bool { 
	
		$this->guard_pdo();

		$this->guard_tablename();
		
		$sql = "CREATE TABLE IF NOT EXISTS `{$this->TABLENAME}`(			
					id INT AUTO_INCREMENT PRIMARY KEY,			
					status VARCHAR(" . Constants::MAX_STATUSNAME_LEN . ") UNIQUE NOT NULL
				)";
		
		$this->pdo->exec($sql);
		
		return true;	
	}
	
	function insert(StatusName $status) : bool {

		$this->guard_pdo();

		$this->guard_tablename();
		
		$sql = "INSERT INTO `{$this->TABLENAME}` (status) VALUES (:status)";
		
		$stmt = $this->pdo->prepare($sql);
		
		$val = $status->get();
		$stmt->bindParam(":status", $val);
		
		try {
			$stmt->execute();
		} catch (PDOException $e) {
			
			if (strcmp($e->getCode(), Constants::SQLSTATE_CONSTRAINT_VIOLATION) == 0) {
				throw new NonUniqueStatusName();
			}			
		}
		
		return true;		
		
	}
	
	function getNameById(RowID $id) : StatusName{
	
		$searchid = $id->get();
	
		$sql = "SELECT status FROM {$this->TABLENAME} WHERE id = :searchid";
		
		$stmt = $this->pdo->prepare($sql);
		
		$stmt->bindParam(":searchid", $searchid);
		
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if(!$result) {
			throw new NotFound("id: <{$searchid}> not found on table <{$this->TABLENAME}>");
		}
			
		return new StatusName($result['status']);
	
	}
	
	function getIdByName(StatusName $name) : RowID {
		
		$search = $name->get();
	
		$sql = "SELECT id FROM {$this->TABLENAME} WHERE status = :search";
		
		$stmt = $this->pdo->prepare($sql);
		
		$stmt->bindParam(":search", $search);
		
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if(!$result) {
			throw new NotFound("status: <{$search}> not found on table <{$this->TABLENAME}>");
		}
		
		return new RowID($result['id']);
	}
	
	function setNameById(RowID $id, StatusName $name) : bool {
		
		$setid = $id->get();
		
		$new = $name->get();
		
		$sql = "UPDATE {$this->TABLENAME} SET status = :new WHERE id = :id";
		
		$stmt = $this->pdo->prepare($sql);
		
		$stmt->bindParam(":new", $new);
		$stmt->bindParam(":id", $setid);
		
		$stmt->execute();
		
		return true;
	}

	function deleteById(RowID $id) : bool{
		
		$param = $id->get();
		
		$sql = "DELETE FROM {$this->TABLENAME} WHERE id = :param";
		
		$stmt = $this->pdo->prepare($sql);
		
		$stmt->bindParam(":param", $param);
		
		$stmt->execute();
		
		return true;
	}
	
	function deleteByName(StatusName $name) :bool {
		
		$param = $name->get();
		
		$sql = "DELETE FROM {$this->TABLENAME} WHERE status = :param";
		
		$stmt = $this->pdo->prepare($sql);
		
		$stmt->bindParam(":param", $param);
		
		$stmt->execute();
		
		return true;
	}
}