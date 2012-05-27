<?
session_start();
# make sure we're logged in
if (!$_SESSION[admin_id] && !$_GET['do_login'] && !$_GET['check_login']) {
	header("Location: login.php?do_login=1");
}

require_once( 'config.php' );
require_once( 'core.php' );
require_once( 'includes/smarty/Smarty.class.php' );
require_once( 'includes/smarty/SmartyPaginate.class.php' );
require_once( 'classes/mySQL.class.php' );

$mySQL 	= new MySQL($dbName, $dbUser, $dbPass, $dbHost);
$smarty = new Smarty();

$smarty->template_dir = "$packagePath/templates/$template";
$smarty->compile_dir = "$packagePath/templates_c";
$smarty->cache_dir = "$packagePath/cache";
$smarty->config_dir = "$packagePath/configs";

$_GPV = array_merge($_GET,$_POST);

# Figure current week and set session
if ($_SESSION[week_id]==""){
	$sql  = "SELECT week_id,week_name FROM $_TABLES[weeks] WHERE '".date("Y-m-d")."' BETWEEN ";
	$sql .= "week_start_date AND week_end_date ORDER BY week_name ASC";
	$result = $mySQL->db_query($sql);
	$row = $mySQL->db_fetch_assoc($result);
	$_SESSION[week_id] = $row[week_id];
}
if ($_GPV[week_id] != ""){
	$_SESSION[week_id] = $_GPV[week_id];
}

# Get week name
if ($_SESSION[week_id] == 0){
	$_SESSION[week_name] = "All Weeks";
} else {
	$_SESSION[week_name] = get_week_name($_SESSION[week_id]);
}

# Load Week Information
$sql = "SELECT * FROM $_TABLES[weeks]";
$result = $mySQL->db_query($sql);
while($tmp = $mySQL->db_fetch_assoc($result)){
	$_WEEKS[$tmp[week_id]] = $tmp[week_name];
}
$smarty->assign('_WEEKS',$_WEEKS);

# Load User Information
$sql = "SELECT * FROM $_TABLES[users] WHERE admin_id = '$_SESSION[admin_id]'";
$result = $mySQL->db_query($sql);
$_USER = $mySQL->db_fetch_assoc($result);
$smarty->assign('_SESSION',$_SESSION);
$smarty->assign('_ADMIN',$_USER);
$smarty->assign('_GPV',$_GPV);
$smarty->assign('_SERVER',$_SERVER);

//print_r($_SERVER);

?>