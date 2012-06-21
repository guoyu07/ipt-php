<?php
/*
 *      iptables.php
 *      
 *      Copyright 2012 Andrea Crisafulli <xanio@grayhats.org>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 *      
 *      
 */

class iptables
{

	/**
	 * Constructor of class iptables.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// ...
	}

	// Gestione nat 1:1
	public function addNat($value) {
		$sql="INSERT INTO ipt_nat (id_tables, ip_pubb, ip_priv)
				VALUES
				('".$value['id_tables']."','".$value['ip_pubb']."','".$value['ip_priv']."')";


			if (!mysql_query($sql))
				  {
			  die('Error: ' . mysql_error());
		  }

		//print_r($sql);
		echo "Added new nat 1:1 rules ".$value['ip_pubb']." -> ".$value['ip_priv']."<br />";
		
	}
	
	public function remNat($id){
		$sql="DELETE FROM ipt_nat where id_nat =  '".$id."'";
				//die(print_r($sql));

			if (!mysql_query($sql))
			  {
			  die('Error: ' . mysql_error());
			  }

		//print_r($sql);
		echo "Remove nat 1:1 with id ".$id."";
	
	}
	
	public function modNat($id,$value){
		$sql="update ipt_nat set ip_pubb = '".$value['ip_pubb']."', ip_priv = '".$value['ip_priv']."' where id_nat =  '".$id."'";
				//die(print_r($sql));

			if (!mysql_query($sql))
			  {
			  die('Error: ' . mysql_error());
			  }

		echo "Mod nat 1:1 rules ".$value['ip_pubb']." -> ".$value['ip_priv']."<br />";
	
	}
	
	public function addMasq($value){
/*
		il masquarade viene applicato sulla catena di POSTROUTING e si ha la possibilità di impostarlo su una interfaccia di output
		oppure dedicere di applicarlo ad una determinata source nat e farla mascherare con altra network
		RICORDA la netmask associata al comenaod deve essere in notazione CDIR
*/
		
		//prelievo l'id della chain corretta:
		$sql_chain = "SELECT id_tables from ipt_table WHERE name = 'nat' AND chain = 'POSTROUTING'";
		$value['id_tables'] = mysql_query($sql_chain);
		
		if(isset($value['masq_network']) && isset($value['masq_netmask']) && isset($value['masq_network2']) && isset($value['masq_network2']))
		{
			$sql="INSERT INTO ipt_masq (masq_interface,masq_network,masq_netmask,masq_network2,masq_netmask2,id_tables)
					VALUES
					('".$value['masq_interface']."','".$value['masq_network']."','".$value['masq_netmask']."','".$value['masq_network2']."','".$value['masq_netmask2']."','".$value['id_tables']."')";

		} else {
			$sql="INSERT INTO ipt_masq (masq_interface,id_tables) VALUES ('".$value['masq_interface']."','".$value['id_tables']."')";
			
			}

			if (!mysql_query($sql))
				  {
			  die('Error: ' . mysql_error());
		  }

		//print_r($sql);
		echo "Added new masquarade rules ".$value['masq_interface']."<br />";
		}
	
	public function modMasq($id,$value){
		if(isset($value['masq_network']) && isset($value['masq_netmask']) && isset($value['masq_network2']) && isset($value['masq_network2']))
		{
		$sql="UPDATE ipt_masq set masq_interface = '".$value['masq_interface']."',
									masq_network = '".$value['masq_network']."',
									masq_netmask = '".$value['masq_netmask']."',
									masq_network2 = '".$value['masq_network2']."',
									masq_netmask2 = '".$value['masq_netmask2']."',
									id_tables = '".$value['id_tables']."'
									WHERE id_masq='".$id."')";
			} else {
			$sql="UPDATE ipt_masq set masq_interface = '".$value['masq_interface']."',
									id_tables = '".$value['id_tables']."'
									WHERE id_masq='".$id."')";
			
			}

			if (!mysql_query($sql))
				  {
			  die('Error: ' . mysql_error());
		  }

		//print_r($sql);
		echo "MOD masquarade rules with id ".$id."<br />";
		}
		
	public function remMasq($id){
		$sql="DELETE FROM ipt_masq where id_nat =  '".$id."'";
				//die(print_r($sql));

		if (!mysql_query($sql))
		  {
			die('Error: ' . mysql_error());
		  }

		//print_r($sql);
		echo "Remove masquarade rules with id ".$id."";
		}

}
