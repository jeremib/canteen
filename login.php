<?
require_once( 'includes/session_start.php' );


if ($_GPV[check_login]) {
	$sql = "SELECT admin_id,admin_name FROM $_TABLES[users] WHERE admin_username = '$_GPV[user_username]'
												AND admin_password = '$_GPV[user_password]'";
	$result = $mySQL->db_query($sql);
	if ($mySQL->db_num_rows($result) == 0) {
		$_MESSAGE[] = 'Invalid Username or Password';
	} else {
		$user = $mySQL->db_fetch_assoc($result);
		$_SESSION[admin_id] = $user[admin_id];
		$_SESSION[admin_name] = $user[admin_name];
		header("Location: index.php");
	}
}
if ($_GPV[action] == "logout"){
	foreach($_SESSION as $k => $v){
		unset($_SESSION[$k]);
	}
	$_MESSAGE[] = 'Successfully Logged Out';
}

$linkIndex = 0;
if ($_SESSION[admin_id]) {
	$_LINKS[$linkIndex][href] = 'index.php';
	$_LINKS[$linkIndex][title] = 'Goto your timesheet';
	$_LINKS[$linkIndex][text] = 'My Timesheet';
	$linkIndex++;
}

$_LINKS[$linkIndex][href] = 'login.php?action=forgotPassword';
$_LINKS[$linkIndex][title] = 'Reset your password';
$_LINKS[$linkIndex][text] = 'Forgot Password';
$linkIndex++;

$_HELP[0] = 'Login to CampAide to keep canteen monies, generate reports, etc.';

$smarty->assign('_MESSAGE',$_MESSAGE);
$smarty->assign('_LINKS',$_LINKS);
$smarty->assign('_HELP',$_HELP);

$smarty->display('login.tpl');
?>