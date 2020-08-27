<?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});

interface IfaceTableStatus {
	
	function create();

	function insert(StatusName $status) : bool;
	
	function getNameById(RowID $id)  : StatusName;
	
	function getIdByName(StatusName $name) : RowID;
	
	function setNameById(RowID $id, StatusName $name) : bool;

	function deleteById(RowID $id) : bool;
	
	function deleteByName(StatusName $name) : bool;	
	
}
	