<?php

abstract class Constants {

	const MYMAXINT = 2147483646; // 32 bit max int -1
	
	const MAXTABLENAMESIZE = 64; // comes from mariadb docs
	
	const MAX_KEYNAME_LEN = 255;	
	const MIN_KEYNAME_LEN = 1;	
	
	const MAX_LOCATANT_LEN = 255;	
	const MIN_LOCATANT_LEN = 4;
	
	const MAX_STATUSNAME_LEN = 255;
	const MIN_STATUSNAME_LEN = 1;
	
	const SQLSTATE_CONSTRAINT_VIOLATION = "23000";
	const SQLSTATE_BASETABLEVIEW_NOT_FOUND = "42S02";

}