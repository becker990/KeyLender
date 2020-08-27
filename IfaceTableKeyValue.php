 <?php

spl_autoload_register(function ($class_name) {
    require_once($class_name . '.php');
});
 
interface IfaceTableKeyValue {
	
	function create();

	function get_all() : array;

	function get_assoc(string $key) : array;

	function get(string $key) : string;
	
	function set(string $key, string $value) : bool;	
	
}