 <?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});
 
interface IfaceTableKeys {
	
	function create(string $foreign);
	
	function getAll();
	
	function getCount();
	
	function getById(RowID $id);
	
	function setById(RowID $id, KeyName $kn, RowID $statusid, Locatant $loc);
	
	function setStatusById(RowID $id, StatusName $sn);

	function setStatusByName(KeyName $kn, StatusName $sn);
	
	function setLocatantById(RowID $id, Locatant $loc);
	
	function setLocatantByName(KeyName $kn, Locatant $loc);
	
	function deleteById(RowID $id);
	
	function deleteByName(KeyName $kn);	

}