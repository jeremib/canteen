<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"

"http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>CampAide - {$_GPV.action} Entry</title>

<link rel="stylesheet" type="text/css" href="templates/default/default.css">

</head>

<body>
<div class="content">

  <h1>Current  Week:  
  {$_SESSION.week_name}</h1>
</div>
{if $_GPV.action == "edit"}
<div class="content">
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
<div class="content">

  <h2 class="error">Camper Notes </h2>

  <p>{$_ENTRY.cmpr_notes}</p>

</div>
{/if}
<div class="content">

  <h2>Add Charge</h2>

  <p><table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="46%" align="center">
  <form action="entry.php" method="get" name="entry" id="entry">
    <input type="button" name="Button" value="$0.25" onClick="window.location.href='entry.php?action=addCharge&cmpr_id={$_ENTRY.cmpr_id}&amount=.25'">
    <input type="button" name="Button" value="$0.50" onClick="window.location.href='entry.php?action=addCharge&cmpr_id={$_ENTRY.cmpr_id}&amount=.50'">

      <input type="button" name="Button" value="$0.75" onClick="window.location.href='entry.php?action=addCharge&cmpr_id={$_ENTRY.cmpr_id}&amount=.75'">
      <input type="button" name="Button" value="$1.50" onClick="window.location.href='entry.php?action=addCharge&cmpr_id={$_ENTRY.cmpr_id}&amount=1.50'">
      <br>
      <input type="button" name="Button" value="$2.25" onClick="window.location.href='entry.php?action=addCharge&cmpr_id={$_ENTRY.cmpr_id}&amount=2.25'">
      <input type="button" name="Button" value="$3.00" onClick="window.location.href='entry.php?action=addCharge&cmpr_id={$_ENTRY.cmpr_id}&amount=3'">
      <input type="button" name="Button" value="$3.75" onClick="window.location.href='entry.php?action=addCharge&cmpr_id={$_ENTRY.cmpr_id}&amount=3.75'">
      <input type="button" name="Button" value="$4.50" onClick="window.location.href='entry.php?action=addCharge&cmpr_id={$_ENTRY.cmpr_id}&amount=4.50'">
      <br>
      <input type="button" name="Button" value="$5.25" onClick="window.location.href='entry.php?action=addCharge&cmpr_id={$_ENTRY.cmpr_id}&amount=5.25'">
      <input type="button" name="Button" value="$6.00" onClick="window.location.href='entry.php?action=addCharge&cmpr_id={$_ENTRY.cmpr_id}&amount=6'">
      <input type="button" name="Button" value="$6.75" onClick="window.location.href='entry.php?action=addCharge&cmpr_id={$_ENTRY.cmpr_id}&amount=6.75'">
      <input type="button" name="Button" value="$7.50" onClick="window.location.href='entry.php?action=addCharge&cmpr_id={$_ENTRY.cmpr_id}&amount=7.50'">
      <br>
      or<br>
      <input name="amount" type="text" id="amount" size="7" class="TBLCR">
      &nbsp;
       <input type="submit" name="Submit" value="Other">
      <input name="action" type="hidden" id="action" value="addCharge">
      <input name="cmpr_id" type="hidden" id="cmpr_id" value="{$_ENTRY.cmpr_id}">
      <br>
      To <strong>add money</strong> to an account, enter a <strong>negative number</strong> <br>
      (example -5 will add $5 to the account) 
  </form>

	</td>
    </tr>
</table>
</p>

</div>
<div class="content">
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
	{sectionelse}
    <tr onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='#FFFFFF'">
      <td colspan="4" class="TBLCL">No Transactions Exist </td>
    </tr>
	{/section}
  </table>
</div>
{/if}
<div class="content">

  <h1>{$_GPV.action} Camper </h1>
  {if $_GPV.msg != ""}
  <h2 align="center">{$_GPV.msg}</h2>
  {/if}

  <form action="entry.php?action={$_GPV.action}" method="post" name="entry" id="entry">

    <table width="461"  border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="41%" height="23" class="TBLCR">First Name : </td>

        <td width="59%"><input name="cmpr_first" type="text" id="cmpr_first" value="{$_ENTRY.cmpr_first}"></td>

      </tr>

      <tr>

        <td height="23" class="TBLCR">Last Name: </td>

        <td><input name="cmpr_last" type="text" id="cmpr_last" value="{$_ENTRY.cmpr_last}"></td>

      </tr>
      <tr>
        <td height="23" class="TBLCR">Camper Week : </td>
        <td><select name="cmpr_week_id" id="cmpr_week_id">
            {html_options options=$_WEEKS selected=$_ENTRY.cmpr_week_id}
          </select>
        </td>
      </tr>
	  {if $_GPV.action == "add"}
      <tr>
        <td height="23" class="TBLCR">Beginning Balance : </td>
        <td><input name="cmpr_start_amount" type="text" id="cmpr_start_amount"></td>
      </tr>
	  {/if}
      <tr>

        <td height="23" class="TBLCR">Notes:</td>

        <td><textarea name="cmpr_notes" id="cmpr_notes">{$_ENTRY.cmpr_notes}</textarea></td>

      </tr>

      <tr>

        <td height="23"><input name="step" type="hidden" id="step" value="2">

          <input name="cmpr_id" type="hidden" id="cmpr_id" value="{$_ENTRY.cmpr_id}"></td>

        <td><input type="submit" name="Submit" value="Save Camper">

		{if $_GPV.action == "edit"}

        <input name="Delete" type="button" id="Delete" value="Delete Camper" onClick="window.location.href='entry.php?action=delete&cmpr_id={$_ENTRY.cmpr_id}&step=2'"></td>

		{/if}

      </tr>

    </table>

  </form>

  <p>&nbsp;</p>

</div>

<div class="content"> Powered by CampAide pre-beta </div>

<div id="navAlpha">

  <h2>Links</h2>

  <p>

    {foreach from=$_LINKS item=link}

    <a href="{$link.href}" title="{$link.title}">

    {$link.text}

    </a><br>

    {/foreach}

  </p>
  <form action="entry.php?action=list&search=true" method="post" name="search" id="search">
  <table width="153"  border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="212"><span class="TBLCR">Search:
              <input name="step" type="hidden" id="step" value="2">
              <input name="cmpr_id" type="hidden" id="cmpr_id" value="{$_ENTRY.cmpr_id}">
        </span></td>
      </tr>
      <tr>
        <td><input name="search_term" type="text" id="search_term" value="{$_GPV.search_term}">
      </tr>
      <tr>
        <td><input type="submit" name="Submit" value="Find">      
    </tr>
    </table>
  </form>
    <BR>
Selected Week:
<select name="week_id" id="week_id"  onchange="window.location='index.php?week_id='+this.options[selectedIndex].value">
  <option value="0">All</option>
  {html_options options=$_WEEKS selected=$_SESSION.week_id}
</select>
</div>

<div id="navBeta">

  <h2>Help Section </h2>

  {foreach from=$_HELP item=help_text}

  <p>

    {$help_text}

  </p>

  {/foreach}

</div>

</div>

</body>

</html>