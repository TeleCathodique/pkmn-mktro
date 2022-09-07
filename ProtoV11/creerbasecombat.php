<?php
// connexion bdd
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=user7;charset=utf8', 'root', 'Kermit01');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}


$bdd->exec("DROP TABLE if exists `combats`");

$bdd->exec("CREATE TABLE if not exists `combats` ( `id` INT NOT NULL AUTO_INCREMENT , `poke_vainqueur` VARCHAR(255) NOT NULL , `pokemon_perdant` VARCHAR(255) NOT NULL , `id_joueur_vainqueur` INT NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");

// $insertcombat = $bdd->prepare("INSERT INTO `combats` (`id`, `poke_vainqueur`, `pokemon_perdant`, `id_joueur_vainqueur`) VALUES (NULL, :poke_vainqueur, :pokemon_perdant, :id_joueur_vainqueur);");

// $insertcombat->execute(array(
// 	'poke_vainqueur' =>'mabite',
// 	'pokemon_perdant' => 'christophe',
// 	'id_joueur_vainqueur' => NULL
// ));


echo 'blablabla';

?>