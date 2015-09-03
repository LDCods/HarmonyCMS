<?php 
// MEMBRES
$dbh->exec("CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `session` varchar(255) NOT NULL,
  `rang` int(1) NOT NULL DEFAULT '1',
  `pseudo` varchar(255) NOT NULL,
  `passe` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rubis` text NOT NULL,
  `nbr_vote` text NOT NULL,
  `heurevote` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;"); 
// NEWS
$dbh->exec("CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `contenu` text NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `auteur` text NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;");
// SLIDER
$dbh->exec("CREATE TABLE IF NOT EXISTS `slider` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `image` text NOT NULL,
  `titre` text NOT NULL,
  `contenu` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;");
// VOTE
$dbh->exec("CREATE TABLE IF NOT EXISTS `vote` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `contenu` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;");
// COMMENT
$dbh->exec("CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `titre` text NOT NULL,
  `contenu` text NOT NULL,
  `auteur` text NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `news` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;");
// BOUTIQUE_CAT
$dbh->exec("CREATE TABLE IF NOT EXISTS `boutique_cat` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;");
// BOUTIQUE_ARTICLE
$dbh->exec("CREATE TABLE IF NOT EXISTS `boutique_article` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `description` text NOT NULL,
  `prix` text NOT NULL,
  `image` text NOT NULL,
  `categorie` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;");
// BOUTIQUE_ARTICLE_COMMANDE
$dbh->exec("CREATE TABLE IF NOT EXISTS `boutique_article_commande` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `id_article` int(20) NOT NULL,
  `commande` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;");

// ETAPE INSTALLATION
$dbh->exec("CREATE TABLE IF NOT EXISTS `installation` (
  `etape_actuelle` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;");

// AJOUT TABLE VISITES
$dbh->exec("CREATE TABLE IF NOT EXISTS `visites` (
  `ip` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;");

// AJOUT SUPPORT
$dbh->exec("CREATE TABLE IF NOT EXISTS `support` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `titre` text NOT NULL,
  `contenu` text NOT NULL,
  `auteur` text NOT NULL,
  `etat` int(20) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;");

// REPONSE_SUPPORT
$dbh->exec("CREATE TABLE IF NOT EXISTS `reponse_support` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `id_ticket` text NOT NULL,
  `reponse` text NOT NULL,
  `auteur` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;");

// PAGES
$dbh->exec("CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `titre` text NOT NULL,
  `url` text NOT NULL,
  `url_unlink` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;");

// WIDGETS
$dbh->exec("CREATE TABLE IF NOT EXISTS `widgets` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `contenu` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;");

// NAVBAR
$dbh->exec("CREATE TABLE IF NOT EXISTS `navbar` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ordre` text NOT NULL,
  `nom` text NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;");


// AJOUT 1re NEWS
$dbh->exec("INSERT INTO news VALUES('', 'Merci !', 'Merci d\'avoir télégarger le CMS LapisCraft ! Vous ne serez pas decu.', 'Merci d\'avoir t&eacutel&eacutegarger le CMS LapisCraft ! Vous ne serez pas decu. Vous pouvez obtenir plus d\'infos sur Eywek.fr concernant le CMS ainsi que son utilisation.', '0', 'Eywek', '')");
// AJOUT SLIDER
$dbh->exec("INSERT INTO slider VALUES('', 'images/slider/01.jpg', 'Merci !', 'Merci d\'avoir t&eacutel&eacutegarger le CMS LapisCraft. Pour plus d\'info rendez\-vous sur http:\/\/eywek\.fr\/cms\.php')");
?>