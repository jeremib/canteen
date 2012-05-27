<?
header("location: entry.php?action=list");

require_once( 'includes/session_start.php' );



// required connect
SmartyPaginate::connect();
// set items per page
SmartyPaginate::setLimit(25);
SmartyPaginate::setURL('index.php');

$sql  = "SELECT * FROM $_TABLES[campers]";
if ($_SESSION[week_id] != 0){
	$sql .= " WHERE cmpr_week_id = '$_SESSION[week_id]'";
}
$sql .= " ORDER BY cmpr_last ASC, cmpr_first ASC";
$limit = " LIMIT ".SmartyPaginate::getCurrentIndex().",".SmartyPaginate::getLimit();
$result = $mySQL->db_query($sql.$limit);
while($row = $mySQL->db_fetch_assoc($result)){
	$row[cmpr_running_total] = get_cmpr_balance($row[cmpr_id]);
	$row[cmpr_amount_spent] = get_cmpr_trans_amount($row[cmpr_id]);
	$entries[] = $row;
}
#calculate total number of invoices
SmartyPaginate::setTotal($mySQL->db_num_rows($mySQL->db_query($sql)));

SmartyPaginate::assign($smarty);

$i = 0;
$_LINKS[$i][href] = 'index.php';
$_LINKS[$i][title] = 'Go to the main page';
$_LINKS[$i][text] = 'Home';
$i++;

$_LINKS[$i][href] = 'entry.php?action=add';
$_LINKS[$i][title] = 'Add a new camper';
$_LINKS[$i][text] = 'New Camper';
$i++;

$_LINKS[$i][href] = 'entry.php?action=list';
$_LINKS[$i][title] = 'List Campers';
$_LINKS[$i][text] = 'List Campers';
$i++;

$_LINKS[$i][href] = 'entry.php?action=print';
$_LINKS[$i][title] = 'Print current week\'s totals';
$_LINKS[$i][text] = 'Print Totals';
$i++;

$_LINKS[$i][href] = 'login.php?action=logout';
$_LINKS[$i][title] = 'Logout of current user';
$_LINKS[$i][text] = 'Logout';
$i++;

$smarty->assign('_ENTRIES',$entries);
$smarty->assign('_LINKS',$_LINKS);
$smarty->assign('_HELP',$_HELP);
$smarty->display('index.tpl');

?>