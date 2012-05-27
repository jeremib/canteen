<?
require("classes/mySQL.class.php");

echo "Installing ...<BR>";

$mysql = new mySQL();

$mysql->connect(null,'root','11111111','localhost');
echo $mysql->db_run_sql_file('CampAide.sql',null,true);

echo "<BR><B>Installed</B>";
?>
