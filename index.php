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
echo 'Connected successfully';

mysql_select_db($CFG['db']); 

$ipt = new firewall();

$var['id_tables'] = '1';
$var['ip_priv'] = '192.168.1.1';
$var['ip_pubb'] = '1.1.1.1';

echo "aggiungo una rules<br />";
$ipt->addNat($var);
echo "modifico una rules<br />";
$ipt->modNat("1",$var);
echo "elimino una rules<br />";
$ipt->remNat("2");
echo "stampo xml";
$ipt->xmlNat("PREROUTING");

mysql_close($link);
?>
