<?
/****************************************************************************************
*   Class   :   firewall
*   Ver.    :   1.0
*   Author  :   Andrea Salvatore Crisafulli  a.k.a. Xanio <xanio@nemesilabs.org>
*   Date    :   201206
*   License :   GPL License
*/
include ('class/iptables.php');
include ('inc/config.php');

$link = mysql_connect($CFG['dbhost'], $CFG['dbuser'], $CFG['dbpass']);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db($CFG['db']); 

$ipt = new iptables();

$output = $ipt->genIpt();
print_r($output);
mysql_close($link);
?>
