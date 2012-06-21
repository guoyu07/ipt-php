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

namespace ipt-php;

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

		//print_r($sql);
		echo "Mod nat 1:1 rules ".$value['ip_pubb']." -> ".$value['ip_priv']."<br />";
	
	}

}
