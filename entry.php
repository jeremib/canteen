<?
require_once( 'includes/session_start.php' );

/************* Add *********************
*
* Purpose:	This action displays and processes the adding
*			of a new timelog entry.
* Passed:	N/A
* Returns:	N/A
* Actions:	After first displaying the form for the user to
*			add the details, step 2 is called, which actually
*			adds the entry to the database.  The user is then
*			directed to the timelog listing
* Template:	add_entry.tpl
*******************************************/
if ($_GPV[action] == "addCharge" && $_GPV[cmpr_id]){
	if (is_numeric($_GPV[amount])){
		$_INSERT[trans_cmpr_id] = $_GPV[cmpr_id];
		$_INSERT[trans_dts] 	= date("Y-m-d H:i:s");
		$_INSERT[trans_amount] 	= -$_GPV[amount];
		$_INSERT[trans_admin_name] = $_SESSION[admin_name];
		$mySQL->db_insert_by_array($_TABLES[transactions],$_INSERT);
	}
	header("location: entry.php?action=edit&cmpr_id=$_GPV[cmpr_id]");
}

/************* Add *********************
*
* Purpose:	This action displays and processes the adding
*			of a new timelog entry.
* Passed:	N/A
* Returns:	N/A
* Actions:	After first displaying the form for the user to
*			add the details, step 2 is called, which actually
*			adds the entry to the database.  The user is then
*			directed to the timelog listing
* Template:	add_entry.tpl
*******************************************/
if ($_GPV[action] == "add") {
	if ($_GPV[step] == 2) {

		$_INSERT[cmpr_first] = $_GPV[cmpr_first];
		$_INSERT[cmpr_last] = $_GPV[cmpr_last];
		$_INSERT[cmpr_start_amount] = $_GPV[cmpr_start_amount];
		$_INSERT[cmpr_notes] = $_GPV[cmpr_notes];
		$_INSERT[cmpr_week_id] = $_GPV[cmpr_week_id];
		$mySQL->db_insert_by_array($_TABLES[campers], $_INSERT);

		header("location: entry.php?action=add&msg=Camper added.");
	} else {

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
		
		$_HELP[0] = 'If you select STAFF as the camp week, the user will show up no matter what week is selected.';
		$smarty->assign('_HELP',$_HELP);
		$smarty->assign('_LINKS',$_LINKS);
		$smarty->display('add_entry.tpl');
	}
}


/************* LIST *********************
*
* Purpose:	This action displays a list of timelog entries
* Passed:	$_GPV[time_clockin_date]* : Date to start listing at
*			$_GPV[time_clockout_date]* : Date to stop listing at
*			$_GPV[client_id]* : Client id to show for
*			$_GPV[project_id]* : Project id to show for
* Returns:	N/A
* Actions:	List is displayed based on the variables passed
* Template:	list_entry.tpl
*******************************************/
elseif ($_GPV[action] == "list"){
	// required connect
	SmartyPaginate::connect();
	// set items per page
	SmartyPaginate::setLimit(25);
	SmartyPaginate::setURL("entry.php?action=list&search_term=$_GPV[search_term]");

	$sql  = "SELECT * FROM $_TABLES[campers]";
	if ($_SESSION[week_id] != 0){
		$sql .= " WHERE cmpr_week_id = '$_SESSION[week_id]' OR cmpr_week_id = 1";
	}
	if ($_GPV[search]){
		if ($_SESSION[week_id] != 0){
			$sql .= " AND";
		} else {
			$sql .= " WHERE";
		}
		$sql .= " cmpr_first LIKE '%$_GPV[search_term]%' OR cmpr_last LIKE '%$_GPV[search_term]%'";
	}
	$sql .= " ORDER BY cmpr_last ASC, cmpr_first ASC";
	$limit = " LIMIT ".SmartyPaginate::getCurrentIndex().",".SmartyPaginate::getLimit();
	$result = $mySQL->db_query($sql.$limit);
	if ($_GPV[search] && ($mySQL->db_num_rows($result) == 1)){
		$row = $mySQL->db_fetch_assoc($result);
		header("Location: entry.php?action=edit&cmpr_id=$row[cmpr_id]");
	}
	while($row = $mySQL->db_fetch_assoc($result)){
		$row[cmpr_running_total] = get_cmpr_balance($row[cmpr_id]);
		$row[cmpr_amount_spent] = get_cmpr_trans_amount($row[cmpr_id]);
		$row[cmpr_week_name] = get_week_name($row[cmpr_week_id]);
		$entries[] = $row;
	}
	#calculate total number of invoices
	SmartyPaginate::setTotal($mySQL->db_num_rows($mySQL->db_query($sql)));

	SmartyPaginate::assign($smarty);
	$i=0;
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
	
	$_HELP[] = "This is a list of the campers in this specific week, plus those in the STAFF week.";
	$_HELP[] = "To add a charge to a specific camper, click on their name.";
	$_HELP[] = "You can use the search feature to search by the first or last name";

	$smarty->assign('_ENTRIES',$entries);
	$smarty->assign('_LINKS',$_LINKS);
	$smarty->assign('_HELP',$_HELP);
	$smarty->display('list_entry.tpl');
	SmartyPaginate::disconnect();
}

/************* PRINT *********************
*
* Purpose:	This action displays a list of timelog entries
* Passed:	$_GPV[time_clockin_date]* : Date to start listing at
*			$_GPV[time_clockout_date]* : Date to stop listing at
*			$_GPV[client_id]* : Client id to show for
*			$_GPV[project_id]* : Project id to show for
* Returns:	N/A
* Actions:	List is displayed based on the variables passed
* Template:	list_entry.tpl
*******************************************/
elseif ($_GPV[action] == "print"){

	$sql  = "SELECT * FROM $_TABLES[campers]";
	if ($_SESSION[week_id] != 0){
		$sql .= " WHERE cmpr_week_id = '$_SESSION[week_id]' OR cmpr_week_id = 1";
	}
	$sql .= " ORDER BY cmpr_last ASC, cmpr_first ASC";
	$result = $mySQL->db_query($sql);
	while($row = $mySQL->db_fetch_assoc($result)){
		$row[cmpr_running_total] = get_cmpr_balance($row[cmpr_id]);
		$row[cmpr_amount_spent] = get_cmpr_trans_amount($row[cmpr_id]);
		$entries[] = $row;
	}


	$smarty->assign('_ENTRIES',$entries);
	$smarty->display('list_print.tpl');
}



/************* EDIT *********************
*
* Purpose:	This action displays and processes the editing
*			of a specific timelog entry.
* Passed:	$_GPV[time_id] : Key id of the entry to delete
* Returns:	N/A
* Actions:	After first displaying the form for the user to
*			make changes, step 2 is called, which actually
*			makes the database changes.  The user is then
*			directed to the timelog listing
* Template:	add_entry.tpl
*******************************************/
elseif ($_GPV[action] == "edit") {
	if ($_GPV[step] == 2) {
		$_UPDATE[cmpr_first] = $_GPV[cmpr_first];
		$_UPDATE[cmpr_last] = $_GPV[cmpr_last];
		//$_UPDATE[cmpr_start_amount] = $_GPV[cmpr_start_amount];
		//$_UPDATE[cmpr_running_total] =$_GPV[cmpr_running_total];
		$_UPDATE[cmpr_notes] = $_GPV[cmpr_notes];
		$_UPDATE[cmpr_id] = $_GPV[cmpr_id];
		$_UPDATE[cmpr_week_id] = $_GPV[cmpr_week_id];
		$mySQL->db_update_by_array($_TABLES[campers], 'cmpr_id', $_UPDATE);
		header("location: entry.php?action=edit&cmpr_id=$_GPV[cmpr_id]");
	} else {
		$sql  = "SELECT * FROM $_TABLES[campers] WHERE cmpr_id = '$_GPV[cmpr_id]'";
		//$sql .= " AND cmpr_week_id = '$_SESSION[week_id]'";
		$result = $mySQL->db_query($sql);
		$entry = $mySQL->db_fetch_assoc($result);
		$entry[cmpr_running_total] = get_cmpr_balance($entry[cmpr_id]);
		$entry[cmpr_amount_spent] = get_cmpr_trans_amount($entry[cmpr_id]);

		$sql = "SELECT * FROM $_TABLES[transactions] WHERE trans_cmpr_id = '$_GPV[cmpr_id]' ORDER BY trans_dts DESC";
		$result = $mySQL->db_query($sql);
		while($row = $mySQL->db_fetch_assoc($result)){
			$transactions[] = $row;
		}
		$max = count($transactions);
		if (((time()-strtotime($transactions[$max-1][trans_dts]))/60) <= 120){
			$error = "Alert!  Time of last transaction was less than 2 hours ago<BR>";
		}

		if ($entry[cmpr_running_total] < 0){
			$error .= "Alert! Camper has a balance less than zero!<BR>";
		} elseif ($entry[cmpr_running_total] == 0) {
			$error .= "Alert! Camper has a balance of zero!<BR>";
		}

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

		$_LINKS[$i][href] = "entry.php?action=printEntry&cmpr_id=$_GPV[cmpr_id]";
		$_LINKS[$i][title] = 'Print current camper\'s totals';
		$_LINKS[$i][text] = 'Print Camper';
		$i++;

		$_LINKS[$i][href] = 'login.php?action=logout';
		$_LINKS[$i][title] = 'Logout of current user';
		$_LINKS[$i][text] = 'Logout';
		$i++;

		$_HELP[0] = 'If you select STAFF as the camp week, the user will show up no matter what week is selected.';
		$smarty->assign('_HELP',$_HELP);
		$smarty->assign('error',$error);
		$smarty->assign('_TRANSACTIONS',$transactions);
		$smarty->assign('_ENTRY',$entry);
		$smarty->assign('_LINKS',$_LINKS);
		$smarty->display('add_entry.tpl');
	}
}

if ($_GPV[action] == "printEntry"){
	$sql  = "SELECT * FROM $_TABLES[campers] WHERE cmpr_id = '$_GPV[cmpr_id]'";
	//$sql .= " AND cmpr_week_id = '$_SESSION[week_id]'";
	$result = $mySQL->db_query($sql);
	$entry = $mySQL->db_fetch_assoc($result);
	$entry[cmpr_running_total] = get_cmpr_balance($entry[cmpr_id]);
	$entry[cmpr_amount_spent] = get_cmpr_trans_amount($entry[cmpr_id]);

	$sql = "SELECT * FROM $_TABLES[transactions] WHERE trans_cmpr_id = '$_GPV[cmpr_id]' ORDER BY trans_dts DESC";
	$result = $mySQL->db_query($sql);
	while($row = $mySQL->db_fetch_assoc($result)){
		$transactions[] = $row;
	}
	$max = count($transactions);
	if (((time()-strtotime($transactions[$max-1][trans_dts]))/60) <= 120){
		$error = "Alert!  Time of last transaction was less than 2 hours ago<BR>";
	}

	if ($entry[cmpr_running_total] < 0){
		$error .= "Alert! Camper has a balance less than zero!<BR>";
	} elseif ($entry[cmpr_running_total] == 0) {
		$error .= "Alert! Camper has a balance of zero!<BR>";
	}
	$smarty->assign('error',$error);
	$smarty->assign('_TRANSACTIONS',$transactions);
	$smarty->assign('_ENTRY',$entry);
	$smarty->display('entry_print.tpl');
}

/************* DELETE *********************
*
* Purpose:	This action deletes a given
* 			timelog entry from the database.
* Passed:	$_GPV[time_id] : Key id of the entry to delete
* Returns:	N/A
* Actions:	After deletion the user is directed to the listing
*			entries.
* Template:	N/A
*******************************************/
elseif ($_GPV[action] == "delete") {
	if ($_GPV[step] == 2) {
		$sql = "DELETE FROM $_TABLES[campers] WHERE cmpr_id = '$_GPV[cmpr_id]'";
		$mySQL->db_query($sql);
		header("location: entry.php?action=list");
	}
}
?>