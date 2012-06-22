--
-- Struttura della tabella `ipt_nat`
--

CREATE TABLE IF NOT EXISTS `ipt_nat` (
  `id_nat` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_pubb` varchar(15) NOT NULL,
  `ip_priv` varchar(15) NOT NULL,
  `id_tables` int(4) unsigned NOT NULL,
  PRIMARY KEY (`id_nat`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Tabella Iptables NAT 1:1'  AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `ipt_masq` (
  `id_masq` int(11) NOT NULL AUTO_INCREMENT,
  `masq_interface` varchar(10) NOT NULL,
  `masq_network` varchar(15) DEFAULT NULL,
  `masq_netmask` varchar(15) DEFAULT NULL,
  `masq_network2` varchar(15) DEFAULT NULL,
  `masq_netmask2` varchar(15) DEFAULT NULL,
  `id_tables` int(11) NOT NULL,
  PRIMARY KEY (`id_masq`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabella Iptables Masquarade' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ipt_table` (
  `id_tables` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `chain` varchar(50) NOT NULL,
  `policy` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tables`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabella Iptables Chain' AUTO_INCREMENT=1 ;

INSERT INTO `ipt_table` (`id_tables`, `name`, `chain`, `policy`) VALUES
(1, 'filter', 'INPUT', 'DROP'),
(2, 'filter', 'OUTPUT', 'ACCEPT'),
(3, 'filter', 'FORWARD', 'ACCEPT'),
(4, 'filter', 'LOG', ''),
(5, 'nat', 'PREROUTING', ''),
(6, 'nat', 'POSTROUTING', '');

CREATE TABLE  `ipt_pf` (
`id_pf` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`pf_interface` VARCHAR( 10 ) NOT NULL ,
`pf_protocol` VARCHAR( 10 ) NOT NULL ,
`pf_port` INT( 6 ) UNSIGNED NOT NULL ,
`pf_dnat` VARCHAR( 15 ) NOT NULL ,
`pf_dport` INT( 6 ) UNSIGNED NOT NULL ,
`id_tables` INT( 5 ) NULL
) ENGINE = MYISAM COMMENT =  'Tabella Iptables Port Forwarding';
