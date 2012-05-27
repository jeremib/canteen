<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"

"http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>CampAide - {$_GPV.action} Entry</title>

<link rel="stylesheet" type="text/css" href="templates/default/default.css">

</head>

<body>
<div class="contentPrint">
  <h1>{$_ENTRY.cmpr_last}, {$_ENTRY.cmpr_first}</h1>
  {if $error != ""}
  <div class="error">{$error}</div>
  {/if}
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="TBLCL"><strong>Camper</strong></td>
      <td class="TBLCR"><strong>Beginning Balance </strong></td>
      <td class="TBLCR"><strong>Amount Spent </strong></td>
      <td class="TBLCR"><strong>Current Balance </strong></td>
    </tr>
    <tr>
      <td class="TBLCL">{$_ENTRY.cmpr_last}
      ,
        {$_ENTRY.cmpr_first}
      </td>
      <td class="TBLCR">$
          {$_ENTRY.cmpr_start_amount|number_format:"2"}</td>
      <td class="TBLCR">$
          {$_ENTRY.cmpr_amount_spent|number_format:"2"}</td>
      <td class="TBLCR" {if $_ENTRIES[entry].cmpr_running_total < 0}style="color:#FF0000"{/if}>$
          {$_ENTRY.cmpr_running_total|number_format:"2"}</td>
    </tr>
  </table>
</div>
{if $_ENTRY.cmpr_notes != ""}
<div class="contentPrint">

  <h2>Camper Notes </h2>

  <p><h2>{$_ENTRY.cmpr_notes}</h2></p>

</div>
{/if}
<div class="contentPrint">
  <h2>Past Charges/Credits </h2>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="TBLCL"><strong>Charged By </strong></td>
      <td class="TBLCL"><strong>Date</strong></td>
      <td class="TBLCR"><strong>Time</strong></td>
      <td class="TBLCR"><strong>Amount</strong></td>
    </tr>
	{section name=trans loop=$_TRANSACTIONS}
    <tr onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='#FFFFFF'">
      <td class="TBLCL">{$_TRANSACTIONS[trans].trans_admin_name}</td>
      <td class="TBLCL">{$_TRANSACTIONS[trans].trans_dts|date_format:"%A, %B %e %Y"}</td>
      <td class="TBLCR">{$_TRANSACTIONS[trans].trans_dts|date_format:"%I:%M %p"}</td>
      <td class="TBLCR">${$_TRANSACTIONS[trans].trans_amount|number_format:"2"}</td>
    </tr>
	{/section}
  </table>
</div>
<div class="contentPrint"> Powered by CampAide pre-beta
</div>
</div>

</body>

</html>