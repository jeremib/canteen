<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"

"http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>CampAide - Print Entries</title>

<link rel="stylesheet" type="text/css" href="templates/default/default.css">
<script language="javascript">
window.print(); 
</script>

</head>

<body>

<div class="contentPrint">
  <h1>Camper List : {$_SESSION.week_name}</h1>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="TBLCL"><strong>Camper</strong></td>
      <td class="TBLCL"><strong>Camp Week </strong></td>
      <td class="TBLCR"><strong>Beginning Balance </strong></td>
      <td class="TBLCR"><strong>Amount Spent </strong></td>
      <td class="TBLCR"><strong>Current Balance </strong></td>
    </tr>
    {section name=entry loop=$_ENTRIES}
    <tr style="background-color: {cycle values="#eee,#fff"};">
      <td class="TBLCL">{$_ENTRIES[entry].cmpr_last}
      ,
        {$_ENTRIES[entry].cmpr_first}
      </td>
      <td class="TBLCL">{$_ENTRIES[entry].cmpr_week_name}</td>
      <td class="TBLCR">$
          {$_ENTRIES[entry].cmpr_start_amount|number_format:"2"}</td>
      <td class="TBLCR">$
          {$_ENTRIES[entry].cmpr_amount_spent|number_format:"2"}</td>
      <td class="TBLCR" {if $_ENTRIES[entry].cmpr_running_total < 0}style="color:#FF0000"{/if}>$
          {$_ENTRIES[entry].cmpr_running_total|number_format:"2"}</td>
    </tr>
    {sectionelse}
    <tr>
      <td colspan="5">No entries to display.</td>
    </tr>
    {/section}
  </table>
</div>
</div>
<div class="contentPrint"> Powered by CampAide pre-beta
</div>
</body>

</html>

