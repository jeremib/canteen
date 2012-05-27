

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"

"http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

	<title>CampAide - Login</title>

<link rel="stylesheet" type="text/css" href="templates/default/default.css">

	

</head>



<body>

<div class="content">

	<h1>Camp Canteen </h1>



	<p>

	{foreach from=$_MESSAGE item=message}

		<center>{$message}</center><br>

	{/foreach}

<form action="login.php?check_login=1" method="post" name="login" id="login">

<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td width="150" class="TBLCR">Username:</td>

    <td width="187" class="TBLCL"><input name="user_username" type="text" id="user_username" value="{$user_username}"></td>

  </tr>

  <tr>

    <td class="TBLCR">Password:</td>

    <td class="TBLCL"><input name="user_password" type="password" id="user_password"></td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td class="TBLCL"><input type="submit" name="Submit" value="Login"></td>

  </tr>

</table>

</form>



</div>

<div class="content">

	Powered by CampAide pre-beta

</div>



<div id="navAlpha">

	<h2>Links</h2>



	<p>

	{foreach from=$_LINKS item=link}

		<a href="{$link.href}" title="{$link.title}">{$link.text} </a><br>

	{/foreach}

  </p>

</div>



<div id="navBeta">



	<h2>Help Section </h2>

	{foreach from=$_HELP item=help_text}

		<p>{$help_text}</p>

	{/foreach}

	

</div>

</body>

</html>