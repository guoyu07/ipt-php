--
-- Struttura della tabella `ipt_nat`
--

CREATE TABLE IF NOT EXISTS `ipt_nat` (
  `id_nat` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_pubb` varchar(15) NOT NULL,
  `ip_priv` varchar(15) NOT NULL,
  `id_tables` int(4) unsigned NOT NULL,
  PRIMARY KEY (`id_nat`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Tabella Iptables NAT 1:1';
