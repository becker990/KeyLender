<?php

	function d($v) {
		print("<pre>" . print_r($v, 1) . "</pre>");
	}
	
	if (isset($_POST['method'])) {
		$method = $_POST['method'];
	} else {
		die;
	}	
		
	require_once("conn.php");
	
	function sql_return_ordie($query){
		
		$mysqli = new mysqli($GLOBALS['mysql_endereco'], $GLOBALS['mysql_usuario'], $GLOBALS['mysql_senha'], $GLOBALS['mysql_banco']);
		
		$ret = $mysqli->query($query);
		
		if (!$ret){
			echo "Failed SQL: (" . $mysqli->errno . ") " . $mysqli->error;
			echo $mysqli->host_info . "\n";	
			exit;
		}
		
		$mysqli->close();
		return $ret;		
	}
	
	function sql_multi_return_ordie($query){
		
		$mysqli = new mysqli($GLOBALS['mysql_endereco'], $GLOBALS['mysql_usuario'], $GLOBALS['mysql_senha'], $GLOBALS['mysql_banco']);
		
		$ret = $mysqli->multi_query($query);
		
		if (!$ret){
			echo "Failed SQL: (" . $mysqli->errno . ") " . $mysqli->error;
			echo $mysqli->host_info . "\n";	
			exit;
		}
		
		$mysqli->close();		
		return $ret;
	}
		
	function protect() {
		if (!@session_start()) {
			die;
		}

		if (!@isset($_SESSION["auth"])) {
			die;
		}		
	}
	
	function sabi_extract_nome($html) {	
		
		$rgx_ret = preg_match('/jQuery\.cookie\(\"user\", \"(.*)\"\);/', $html, $rgx_arr);
		
		if(!isset($rgx_arr[1])) {
			die("API de login ao SABI via scraper está quebrada.");
		}
		return $rgx_arr[1];
		
	}

	function sabi_do_login($username = "", $password = "") {		

		$url="https://sabi.ufrgs.br/F/?func=file&file_name=login-session"; 

		$info_arr = array(
							"ssl_flag"=>"Y", 
							"func"=>"login-session", 
							"login_source"=>"bor-info", 
							"bor_library"=>"URS50", 
							"bor_id"=>$username, 
							"bor_verification"=>$password
						);// info_arr

		$postinfo = http_build_query($info_arr);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfo);

		$html = curl_exec($ch);
		
		$url="https://sabi.ufrgs.br/F/?func=logout"; 
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_exec($ch);
		
		curl_close($ch);		
		
		// regex match de sinais de login com sucesso		
		$fator1 = preg_match('/jQuery\.cookie\(\"user\", \"/', $html);
		$fator2 = preg_match('/document\.getElementById\(\'nome\'\)\.innerHTML = \"/', $html);
			
		if ($fator1 === 1 and $fator2 === 1)
			return sabi_extract_nome($html);
		
		$fator3 = preg_match("/var msg = \'ID ou senha não conferem com os registros do sistema\';/", $html);
		
		if ($fator3 === 1)
			return false;
		
		die("API de login ao SABI via scraper está quebrada.");		
	}
	
	function api_scraper_login($cartao, $senha) {		
		return sabi_do_login($cartao, $senha);
	}
	
	function get_maxarmarios() {
		
		$query = "SELECT * FROM configs WHERE mykey='maxarmarios';";
			
		$res = sql_return_ordie($query);
		
		if (!$res){
			die("api 14");
		}
			
		$values = $res->fetch_assoc();

		return $values['myvalue'];
	}
	
	function get_prioridade() {
		
		$query = "SELECT * FROM configs WHERE mykey='prioridade';";
			
		$res = sql_return_ordie($query);
		
		if (!$res){
			die("api 100");
		}
			
		$values = $res->fetch_assoc();

		return $values['myvalue'];
	}
	
	if ($method == "aluno_login") {
		
		protect();
		
		if (!isset($_POST['cartao']))
			die("api 50");
		
		if (!isset($_POST['senha']))
			die("api 51");
		
		$cartao = $_POST['cartao'];
		$senha  = $_POST['senha'];
		
		$res = api_scraper_login($cartao, $senha); 
		
		if ($res) {
			echo json_encode($res);
			exit;
		}
		
		echo json_encode("FALSE");
		exit;
	}
	
	if ($method == "ask_chave") {
		
		protect();
		
		$minha = get_prioridade();

		$minha = str_replace(" ", "", $minha);

		$pri = explode(",", $minha);
		
		$query = "SELECT * FROM chaves WHERE status=0;";
		
		$res = sql_return_ordie($query);
		
		if (!$res){			
			die("api 90");
		}
		
		$disp = array();
		
		while($row = $res->fetch_assoc()){
			$disp[] = $row['id_chave'];
		}
		
		foreach ($pri as $k){
			if (in_array($k, $disp)){
				echo json_encode($k);
				exit;
			}
		}
		
		echo json_encode("FULL");
		exit;
	}
	
	if ($method == "devolve_chave") {
		
		protect();
		
		if (!isset($_POST['codbarra']))
			die("api 70");
		
		$codbarra = $_POST['codbarra'];

		$query = "SELECT * FROM chaves WHERE codbarra='$codbarra';";
		
		$res = sql_return_ordie($query);
		
		if (!$res){			
			die("api 73");
		}
		
		$assoc = $res->fetch_assoc();
			
		$id_chave = $assoc['id_chave'];
		$cartao = $assoc['cartao'];
		$status = $assoc['status'];
		
		if ($status == 0){
			echo json_encode("DEV");
			exit;
		}
		
		if ($id_chave == "" || $cartao == ""){
			die("api 74");
		}
				
		$query = "INSERT INTO historico (id_chave, operacao, cartao, data_hora) VALUES ('$id_chave', 0, '$cartao', NOW()); ";
		
		$res = sql_return_ordie($query);
		
		if (!$res){			
			die("api 71");
		}
				
		$query = "UPDATE chaves SET status=0, cartao='', nome='' WHERE codbarra='$codbarra';";
		
		$res = sql_return_ordie($query);
		
		if (!$res){			
			die("api 72");
		}
		
		echo json_encode("OK");
		exit;
	}
	
	if ($method == "get_chave") {
		
		protect();
		
		if (!isset($_POST['id_chave']))
			die("api 60");
		
		if (!isset($_POST['cartao']))
			die("api 61");
		
		if (!isset($_POST['nome']))
			die("api 62");
		
		$id_chave = (int)$_POST['id_chave'];
		$cartao   = $_POST['cartao'];
		$nome     = $_POST['nome'];
		
		if (!is_int($id_chave)){
			echo json_encode("ISNOTINT");
			exit;
		}
		
		$maxarmarios = get_maxarmarios();
	
		if ($id_chave < 1 || $id_chave > $maxarmarios){
			echo json_encode("OUTOFBOUNDS");
			exit;
		}
		
		$query = "SELECT * FROM chaves WHERE id_chave='$id_chave'; ";
		
		$res = sql_return_ordie($query);		
		if (!$res){			
			die("api 73");
		}
		
		$assoc = $res->fetch_assoc();
			
		$status = $assoc['status'];
		
		if ($status != 0){
			echo json_encode("OCCUPIED");
			exit;
		}
		
		$query = "INSERT INTO historico (id_chave, operacao, cartao, data_hora) VALUES ('$id_chave', 1, '$cartao', NOW()); ";
		
		$res = sql_return_ordie($query);
		
		if (!$res){			
			die("api 68");
		}
				
		$query = "UPDATE chaves SET status='1', cartao='$cartao', nome='$nome' WHERE id_chave='$id_chave';";
		
		$res = sql_return_ordie($query);
		
		if (!$res){			
			die("api 69");
		}
		echo json_encode("OK");
		exit;
	}

	if ($method == "get_historico") {
		
		protect();
	
		$query = "SELECT * FROM historico ORDER BY id_transacao DESC;";
			
		$res = sql_return_ordie($query);
		
		if (!$res){
			die("api 30");
		}
			
		$return = array();
		
		while ($row = $res->fetch_assoc()) {
			$return[] = $row;
		}
		
		echo json_encode($return);
		exit;		
	}
		
	if ($method == "set_config_chaves_single") {
		
		protect();
		
		if (!isset($_POST['id_chave']))
			die("api 5");		
		
		if (!isset($_POST['codbarra']))
			die("api 7");
		
		$id_chave = $_POST['id_chave'];		
		$codbarra = $_POST['codbarra'];
		
		$maxarmarios = get_maxarmarios();
		
		if ($id_chave < 1 || $id_chave > $maxarmarios){
			echo json_encode("FALSE");
			exit;
		}
			
		$query = "UPDATE chaves SET codbarra='$codbarra' WHERE id_chave='$id_chave';";
		
		$res = sql_return_ordie($query);
		
		if (!$res){			
			die("api 8");
		}
		
		echo json_encode("OK");
		exit;			
	}
		
	if ($method == "get_chaves_all") {
						
		$return = array();
			
		echo json_encode($return);
		
		exit;
	}
	
	if ($method == "get_configs") {
		
		protect();
		
		$query = "SELECT * FROM configs;";
			
		$res = sql_return_ordie($query);
		
		$return = array();
		
		while ($row = $res->fetch_assoc()) {
			$return[$row['mykey']] = $row['myvalue'];
		}
		
		echo json_encode($return);
		exit;
	}
	
	if ($method == "set_configs") {
		
		protect();
		
		if (!isset($_POST['senha']))
			die("api 10");
		
		if (!isset($_POST['prioridade']))
			die("api 11");
				
		
		$senha       = $_POST['senha'];
		$prioridade  = $_POST['prioridade'];
				
		$query = "";
		$query .= "UPDATE configs SET myvalue='$senha'       WHERE mykey='senhasys'; ";
		$query .= "UPDATE configs SET myvalue='$prioridade'  WHERE mykey='prioridade'; ";
		
		$res = sql_multi_return_ordie($query);
		
		if (!$res){
			die("api 21");
		}
			
		echo json_encode("OK");
		exit;
	}
	
	if ($method == "get_login") {
		
		/*
		
			CUIDAR FORCA BRUTA NESSE METODO
		
		*/
		
		if (!isset($_POST['senha']))
			die("api 13");
		
		$senha = $_POST['senha'];
		
		$query = "SELECT * FROM configs WHERE mykey='senhasys';";
			
		$res = sql_return_ordie($query);
			
		$values = $res->fetch_assoc();	
		
		if ($senha === $values['myvalue']) {
			
			if (!@session_start()){
				echo json_encode("FALSE");
				exit;
			}
			
			$_SESSION['auth'] = true;
			
			echo json_encode("OK");
		} else {
			echo json_encode("FALSE");
		}
		exit;
	}
	
	if ($method == "get_logout") {
		
		protect();
		
		$_SESSION[] = Array();
				
		$sessname = session_name();
		
		if (session_id() != "" || isset($_COOKIE[$sessname])) {
			setcookie($sessname, '', time() - 2592000, '/');
		}
		
		@session_destroy();
		
		echo json_encode("OK");
		exit;
	}


?>