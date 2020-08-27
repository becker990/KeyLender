<?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});

interface IfaceTableHistory {
	
	function create();

	function insert(RowID $keyid, RowID $statusid, Locatant $loc) : bool;
	
	function getAll() : array;
	
	function getCount() : int;

}