<?
class MySQL{
	var $start_time;
	var $timestamps = array();
	var $actions = array();
	var $result;
	var $row;

	function MySQL($dbname='', $dbuser='', $dbpass='', $dbhost='localhost'){
		$this->start_time = microtime();
		if (isset($dbhost)&&isset($dbuser)&&isset($dbpass)){
			$this->connect($dbname,$dbuser,$dbpass,$dbhost);
		}
	}

	function connect($dbname, $dbuser, $dbpass, $dbhost='localhost'){
		@mysql_connect($dbhost,$dbuser,$dbpass) or die($this->show_error($query,mysql_errno(),mysql_error()));
		if ($dbname != null){
			@mysql_select_db($dbname) or die($this->show_error($query,mysql_errno(),mysql_error()));
		}
		$this->log_action('database connection made');
	}
	function db_query($query){
		$this->log_action("SQL Query: $query");
		$tmp = mysql_query($query) or die($this->show_error($query,mysql_errno(),mysql_error()));
		$this->result = $tmp;
		return $this->result;
	}
	function db_num_rows($result = null){
		if ($result == null) { $result = $this->result; }
		return mysql_num_rows($result);
	}

	function db_fetch_assoc($result = null){
		if ($result == null) { $result = $this->result; }
		return mysql_fetch_assoc($result);
	}
	function db_insert_id() {
		return mysql_insert_id();
	}
	function db_fetch_next($result = null){
		if ($result == null) { $result = $this->result; }
		$this->row = $this->db_fetch_assoc($result);
		return $this->row;
	}
	function db_update_by_array($tblName, $keyName, $array){
		$max = count($array);
		$cnt = 1;
		$sql = "UPDATE $tblName SET";
		foreach($array as $fieldName => $value){
			$sql .= " $fieldName = '$value'";
			if ($cnt < $max) { $sql .= ","; }
			$cnt++;
		}
		$sql .= " WHERE $keyName = '$array[$keyName]'";
		$this->db_query($sql);
	}
	function db_insert_by_array($tblName, $array){
		$max = count($array);
		$cnt = 1;
		$sql = "INSERT INTO $tblName (";
		foreach($array as $fieldName => $value){
			$sql .= "$fieldName";
			if ($cnt < $max) { $sql .= ", "; }
			$cnt++;
		}
		$sql .= ") VALUES (";
		$cnt = 1;
		foreach($array as $fieldName => $value){
			$sql .= "'$value'";
			if ($cnt < $max) { $sql .= ", "; }
			$cnt++;
		}
		$sql .= ")";
		$this->db_query($sql);
	}
	function db_query_to_array($sql){
		$result = $this->db_query($sql);
		if ($this->db_num_rows($result) > 1){
			while($row = $this->db_fetch_assoc($result)){
				$tmp[] = $row;
			}
		} else {
			$tmp = $this->db_fetch_assoc($result);
		}

		return $tmp;
	}
	function db_run_sql_file($file_path, $replace = null, $ret_output = false) {
		$replace = explode(" ",$replace);
		foreach($replace as $k => $v){
			$to_replace[] = explode("=",$v);
		}
		if (file_exists($file_path)){
			$handle = fopen("$file_path", "rb");
			$contents = '';
			while (!feof($handle)) {
				$contents .= fread($handle, 8192);
			}
			$sql = explode(';',$contents);
			foreach($sql as $sql_statement) {
				if (trim($sql_statement) == "") { continue; }
				foreach($to_replace as $replace){
					$sql_statement = str_replace($replace[0],$replace[1],$sql_statement);
				}
				$sql_statement = "$sql_statement;";

				$this->db_query($sql_statement);
				$output .= "$sql_statement<BR>";
			}
			fclose($handle);
		} else {
			$this->show_error("db_run_sql_file",999,"File does not exist:  $file_path");
		}
		if ($ret_output) { return $output; }
	}

	function show_error($query, $mysql_errno, $mysql_error){
		$_FATAL[] = "<b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . $mysql_errno . ") " . htmlspecialchars($mysql_error);
		$this->output_errors($_FATAL);

	}

	function log_action($log_line){
		array_push($this->timestamps,$this->getmicrotime());
		array_push($this->actions,$log_line);
	}
	function getmicrotime() // Gets the microsecond time
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	function stats(){

		$count = count($this->timestamps);
		$start = $this->timestamps[0];
		$finish = $this->timestamps[$count-1];

		echo '<center><span style="font-size: smaller;">Executed '.$count.' queries in about ' .
		round(($finish - $start),4) . ' seconds.</span></center>';


		for($i=0; $i<$count; $i++){
			echo array_pop($this->timestamps)." ".array_pop($this->actions)."<br>";
		}


	}
	function output_errors($_FATAL) {
		// print out errors if some and quit
		if ($_FATAL){
			echo "<style type=\"text/css\">
							<!--
							.errorHeader {
								font-weight: bold;
								color: #FFFFFF;
								background-color: #CCCCCC;
								border-top-width: 1px;
								border-right-width: 1px;
								border-bottom-width: 1px;
								border-left-width: 1px;
								border-top-style: solid;
								border-right-style: solid;
								border-bottom-style: solid;
								border-left-style: solid;
								border-top-color: #000000;
								border-right-color: #000000;
								border-bottom-color: #000000;
								border-left-color: #000000;
								width: 600px;
								padding-left: 5px;
								font-family: Geneva, Arial, Helvetica, sans-serif;
							}
							.errorBody {
								font-weight: normal;
								color: #FF0000;
								background-color: #FFFFFF;
								border-top-width: 1px;
								border-right-width: 1px;
								border-bottom-width: 1px;
								border-left-width: 1px;
								border-top-style: none;
								border-right-style: solid;
								border-bottom-style: solid;
								border-left-style: solid;
								border-top-color: #000000;
								border-right-color: #000000;
								border-bottom-color: #000000;
								border-left-color: #000000;
								width: 595px;
								padding-left: 10px;
								font-family: Geneva, Arial, Helvetica, sans-serif;
								font-size: 11px;
							}
							-->
							</style>";
			echo "<div class=\"errorHeader\">mySQL Fatal Error </div>";
			foreach($_FATAL as $error){
				echo "<div class=\"errorBody\">$error</div>";
			}
			exit;
		}
	}
}
?>