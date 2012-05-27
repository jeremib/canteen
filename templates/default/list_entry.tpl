<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"

"http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>CampAide - List Entries</title>

<link rel="stylesheet" type="text/css" href="templates/default/default.css">


</head>

<body>
<div class="content">

  <h1>Current  Week:  
  {$_SESSION.week_name}</h1>
</div>
<div class="content">
  <h1>Camper List</h1>
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="26%">{* display pagination header *}
        Items
          {$paginate.first}
        -
        {$paginate.last}
        out of
        {$paginate.total}
        displayed.</td>
      <td width="74%" align="center">{* display pagination info *}
          {paginate_prev}
          {paginate_middle}
          {paginate_next}</td>
    </tr>
  </table>
  <BR>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="TBLCL"><strong>Camper</strong></td>
      <td class="TBLCL"><strong>Camp Week </strong></td>
      <td class="TBLCR"><strong>Beginning Balance </strong></td>
      <td class="TBLCR"><strong>Amount Spent </strong></td>
      <td class="TBLCR"><strong>Current Balance </strong></td>
    </tr>
    {section name=entry loop=$_ENTRIES}
    <tr onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='#FFFFFF'" style="cursor: pointer" onClick=" document.location.href='entry.php?action=edit&cmpr_id={$_ENTRIES[entry].cmpr_id}'" title="Click to edit this entry">
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

