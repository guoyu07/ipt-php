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

$ipt = new iptables();

switch($_POST['action']){

		case modpf:
			echo "MODIFICA PORT FORWARD WITH ID ".$_POST['value']."<br />";
			break;
		case delpf:
			echo "ELIMINA PORT FORWARD WITH ID ".$_POST['value']."<br />";
			break;	
		case modnat:
			echo "MODIFICA NAT WITH ID ".$_POST['value']."<br />";
			break;
		case delnat:
			echo "ELIMINA NAT WITH ID ".$_POST['value']."<br />";
			break;
	
	}
	
switch($_POST['id']){

	// firewall view
	case firewall:
		echo "Page Firewall <br />";
		break;

	// portforward view
	case portforward:
		echo "Page PortForward<br />";
			$query = "SELECT * FROM `ipt_pf`";
			$result = mysql_query($query);
			if (!$result) {
				echo "problema query ($query) per il DB: " . mysql_error() ."<br />";
				exit;
			}
			if (mysql_num_rows($result) == 0) {
				echo "Nessuan riga<br />";
				exit;
			}
			
		echo "Tabella <b>Port Forward</b><br />";
		echo "<table class='iptTable'>";
		echo "<tr class='iptTable' >";
		echo "<td class='iptTable'>ID Port Forward</td>
						<td class='iptTable'>INTERFACE</td>
						<td class='iptTable'>PROTOCOL</td>
						<td class='iptTable'>PORT</td>
						<td class='iptTable'>DESTINATION</td>
						<td class='iptTable'>DESTINATION PORT</td>
						<td></td>";
		echo "</tr>";
		while ($rsPF = mysql_fetch_assoc($result)) {

				echo "<tr class='iptTable'>";
				echo "<td class='iptTable'>".$rsPF['id_pf']."</td>";
				echo "<td class='iptTable'>".$rsPF['pf_interface']."</td>";
				echo "<td class='iptTable'>".$rsPF['pf_protocol']."</td>";
				echo "<td class='iptTable'>".$rsPF['pf_port']."</td>";
				echo "<td class='iptTable'>".$rsPF['pf_dnat']."</td>";
				echo "<td class='iptTable'>".$rsPF['pf_dport']."</td>";
				echo "<td class='iptTable'>
								<form name=\"mod_pf\" action=\"index.php\" method=\"POST\">
								<input name=\"action\" type=\"image\" src=\"img/flagEdit.png\" alt=\"Modifica Rules\" title=\"Modify Rules ".$rsPF['id_pf']."\" value=\"modpf\">
								<input name=\"value\" type=\"hidden\" value=\"".$rsPF['id_pf']."\">
								</form>
								<form name=\"del_pf\" action=\"index.php\" method=\"POST\">
								<input name=\"action\" type=\"image\" src=\"img/flagRed.png\" alt=\"Cancella Rules\" title=\"Delete Rules ".$rsPF['id_pf']."\" value=\"delpf\">
								<input name=\"value\" type=\"hidden\" value=\"".$rsPF['id_pf']."\">
								</form>
					  </td>";
				echo "</tr>";
				}
				echo "</table>";
		break;

	//nat view
		case nat:
			$query = "SELECT * FROM `ipt_nat`";
			$result = mysql_query($query);
			if (!$result) {
				echo "problema query ($query) per il DB: " . mysql_error();
				exit;
			}
			if (mysql_num_rows($result) == 0) {
				echo "Nessuan riga";
				exit;
			}
			
		echo "Tabella <b>NAT</b><br />";
		echo "<table class='iptTable'>";
		echo "<tr class='iptTable' >";
		echo "<td class='iptTable'>ID NAT</td><td class='iptTable'>IP PUBBLICO</td><td class='iptTable'>IP PRIVATO</td><td class='iptTable'>ID TABLES</td><td></td>";
		echo "</tr>";
		while ($rsNat = mysql_fetch_assoc($result)) {

				echo "<tr class='iptTable'>";
				echo "<td class='iptTable'>".$rsNat['id_nat']."</td>";
				echo "<td class='iptTable'>".$rsNat['ip_pubb']."</td>";
				echo "<td class='iptTable'>".$rsNat['ip_priv']."</td>";
				echo "<td class='iptTable'>".$rsNat['id_tables']."</td>";
				echo "<td class='iptTable'>
						<form name=\"mod_nat\" action=\"index.php\" method=\"POST\">
							<input name=\"action\" type=\"image\" src=\"img/flagEdit.png\" alt=\"Modifica Rules\" title=\"Modify Rules ".$rsNat['id_nat']."\" value=\"modnat\">
							<input name=\"value\" type=\"hidden\" value=\"".$rsNat['id_nat']."\">
						</form>
						<form name=\"del_nat\" action=\"index.php\" method=\"POST\">
							<input name=\"action\" type=\"image\" src=\"img/flagRed.png\" alt=\"Modifica Rules\" title=\"Delete Rules ".$rsNat['id_nat']."\" value=\"delnat\">
							<input name=\"value\" type=\"hidden\" value=\"".$rsNat['id_nat']."\">
						</form>
					</td>";
				echo "</tr>";
				}
				echo "</table>";
			break;	
			// default view
		default:
			echo "Visualizza RULES:<br />";
			echo "<form name=\"form_nat\" action=\"index.php\" method=\"POST\">
								<input name=\"id\" type=\"submit\" value=\"nat\">
								<input name=\"id\" type=\"submit\" value=\"portforward\">
								<input name=\"id\" type=\"submit\" value=\"firewall\">
				  </form>";
		 break;
	}


/*

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
*/
mysql_close($link);
?>
