<?
function do_addslashes($string){
	if (get_magic_quotes_gpc()){
		return $string;
	} else {
		return addslashes($string);
	}
}

function get_cmpr_trans_amount($cmpr_id){
	global $_TABLES, $mySQL;
	$total = 0;
	$sql = "SELECT trans_amount FROM $_TABLES[transactions] WHERE trans_cmpr_id = '$cmpr_id'";
	$result = $mySQL->db_query($sql);
	while($row = $mySQL->db_fetch_assoc($result)){
		$total += $row[trans_amount];
	}
	return $total;
}
function get_cmpr_balance($cmpr_id) {
	global $_TABLES, $mySQL;
	$sql = "SELECT cmpr_start_amount FROM $_TABLES[campers] WHERE cmpr_id = '$cmpr_id'";
	$result = $mySQL->db_query($sql);
	$row = $mySQL->db_fetch_assoc($result);
	return $row[cmpr_start_amount] + get_cmpr_trans_amount($cmpr_id);
}
function get_week_name($week_id){
	global $_TABLES,$mySQL;
	$sql = "SELECT week_name FROM $_TABLES[weeks] WHERE week_id = '$week_id'";
	$result = $mySQL->db_query($sql);
	$row = $mySQL->db_fetch_assoc($result);
	return $row[week_name];

}

?>