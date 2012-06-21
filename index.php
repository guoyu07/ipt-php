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

switch($_POST['action']){
	
	
	}
	
switch($_POST['id']){
	
	}


$ipt = new iptables();

$var['id_tables'] = '1';
$var['ip_priv'] = '192.168.1.1';
$var['ip_pubb'] = '1.1.1.1';

echo "aggiungo una rules<br />";
$ipt->addNat($var);
$sql = "select * from ipt_nat";
$result=mysql_query($sql);
while ($rsNat = mysql_fetch_assoc($result)) {
	print_r($rsNat);
}
echo "modifico una rules<br />";
$ipt->modNat("1",$var);
$sql = "select * from ipt_nat";
$result=mysql_query($sql);
while ($rsNat = mysql_fetch_assoc($result)) {
	print_r($rsNat);
}
echo "elimino una rules<br />";
$ipt->remNat("2");
$sql = "select * from ipt_nat";
$result=mysql_query($sql);
while ($rsNat = mysql_fetch_assoc($result)) {
	print_r($rsNat);
}

$var2['masq_interface'] = 'eth1';
$var2['masq_network'] = '192.168.1.0';
$var2['masq_netmask'] = '24';
$var2['masq_network2'] = '10.0.0.0';
$var2['masq_netmask2'] = '24';

echo "Aggiungo una regola di masquarade<br />";
$ipt->addMasq($var2);
$sql = "select * from ipt_masq";
$result=mysql_query($sql);
while ($rsMasq = mysql_fetch_assoc($result)) {
	print_r($rsMasq);
}
echo "Aggiungo una regola di masquarade tradizionale <br />";
$var3['masq_interface'] = 'eth0';
$ipt->addMasq($var3);
$sql = "select * from ipt_masq";
$result=mysql_query($sql);
while ($rsMasq = mysql_fetch_assoc($result)) {
	print_r($rsMasq);
}
echo "Modifico la regola di nat modificando la prima con i parametri dell'ultima rules<br />";
$var4['masq_interface'] = 'eth1';
$var4['masq_network'] = '192.168.2.0';
$var4['masq_netmask'] = '24';
$var4['masq_network2'] = '10.0.0.0';
$var4['masq_netmask2'] = '24';
$ipt->modMasq('1',$var4);
$sql = "select * from ipt_masq";
$result=mysql_query($sql);
while ($rsMasq = mysql_fetch_assoc($result)) {
	print_r($rsMasq);
}
echo "Elimino la rules ultima inserita<br />";
$ipt->remMasq('1');
$sql = "select * from ipt_masq";
$result=mysql_query($sql);
while ($rsMasq = mysql_fetch_assoc($result)) {
	print_r($rsMasq);
}
mysql_close($link);
?>
