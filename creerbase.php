<?php
// connexion bdd
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=main;charset=utf8', 'root', 'root');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}


// suppression des tables
$bdd->exec("DROP TABLE if exists `pokemons`");
$bdd->exec("DROP TABLE if exists `attaques`");

// création table pokemons
$bdd->exec("CREATE TABLE if not exists `pokemons` ( `idImage` VARCHAR(255) NOT NULL , `Nom` VARCHAR(255) NOT NULL , `Niveau` INT NOT NULL , `type` VARCHAR(255) NOT NULL , `vieMax` INT NOT NULL , `Attaque1` VARCHAR(255) NOT NULL , `Attaque2` VARCHAR(255) NOT NULL , `Attaque3` VARCHAR(255) NOT NULL , `Attaque4` VARCHAR(255) NOT NULL , `Vitesse` INT NOT NULL , `Defense` INT NOT NULL , `StatAttaque` INT NOT NULL , PRIMARY KEY (`Nom`)) ENGINE = InnoDB;");



// insertion pokemons
$insertpokemon=$bdd->prepare("INSERT INTO `pokemons` (`idImage`, `Nom`, `Niveau`, `type`, `vieMax`, `Attaque1`, `Attaque2`, `Attaque3`, `Attaque4`, `Vitesse`, `Defense`, `StatAttaque`) VALUES (:idImage, :Nom, :Niveau, :type, :vieMax, :Attaque1, :Attaque2, :Attaque3, :Attaque4, :Vitesse, :Defense, :StatAttaque)");


$insertpokemon->execute(array(
	'idImage' => 'roman',
	'Nom' => 'Roman',
	'Niveau' => 69,
	'type' => 'elec',
	'vieMax' => 150,
	'Attaque1' => 'Trempette',
	'Attaque2' => 'Charge',
	'Attaque3' => 'Trempette',
	'Attaque4' => 'Trempette',
	'Vitesse' => 200,
	'Defense' => 50,
	'StatAttaque' => 150
));

$insertpokemon->execute(array(
	'idImage' => 'hamid',
	'Nom' => 'Hamid',
	'Niveau' => 1000,
	'type' => 'elec',
	'vieMax' => 300,
	'Attaque1' => 'Trempette',
	'Attaque2' => 'Charge',
	'Attaque3' => 'Charge',
	'Attaque4' => 'Pause MKTRO',
	'Vitesse' => 200,
	'Defense' => 50,
	'StatAttaque' => 150
));

$insertpokemon->execute(array(
	'idImage' => 'gardette',
	'Nom' => 'Gardette',
	'Niveau' => 1000,
	'type' => 'acier',
	'vieMax' => 300,
	'Attaque1' => 'Trempette',
	'Attaque2' => 'Charge',
	'Attaque3' => 'Charge',
	'Attaque4' => 'Pause MKTRO',
	'Vitesse' => 200,
	'Defense' => 50,
	'StatAttaque' => 150
));

$insertpokemon->execute(array(
	'idImage' => 'damien',
	'Nom' => 'Damien',
	'Niveau' => 1000,
	'type' => 'elec',
	'vieMax' => 300,
	'Attaque1' => 'Trempette',
	'Attaque2' => 'Charge',
	'Attaque3' => 'Charge',
	'Attaque4' => 'Pause MKTRO',
	'Vitesse' => 200,
	'Defense' => 50,
	'StatAttaque' => 150
));

$insertpokemon->execute(array(
	'idImage' => 'charles',
	'Nom' => 'Charles',
	'Niveau' => 1000,
	'type' => 'elec',
	'vieMax' => 300,
	'Attaque1' => 'Trempette',
	'Attaque2' => 'Charge',
	'Attaque3' => 'Charge',
	'Attaque4' => 'Pause MKTRO',
	'Vitesse' => 200,
	'Defense' => 50,
	'StatAttaque' => 150
));

$insertpokemon->execute(array(
	'idImage' => 'mariecaro',
	'Nom' => 'Marie-Caroline',
	'Niveau' => 1000,
	'type' => 'elec',
	'vieMax' => 300,
	'Attaque1' => 'Trempette',
	'Attaque2' => 'Charge',
	'Attaque3' => 'Charge',
	'Attaque4' => 'Pause MKTRO',
	'Vitesse' => 200,
	'Defense' => 50,
	'StatAttaque' => 150
));


// création table attaques

$bdd->exec("CREATE TABLE if not exists `attaques` ( `nom` VARCHAR(255) NOT NULL , `anim` VARCHAR(255) NOT NULL , `animDef` VARCHAR(255) NOT NULL , `puissance` INT NOT NULL , `heal` INT NOT NULL ,`AttbuffAtt` INT NOT NULL , `AttbuffDef` INT NOT NULL , `AttbuffVitesse` INT NOT NULL , `DefbuffAtt` INT NOT NULL , `DefbuffDef` INT NOT NULL , `DefBuffVitesse` INT NOT NULL, `type` VARCHAR(255) NOT NULL , `description` TEXT NOT NULL , `PP` INT NOT NULL , PRIMARY KEY (`nom`)) ENGINE = InnoDB;");

// insertion des attaques

$insertattaque=$bdd->prepare("INSERT INTO `attaques` (`nom`, `anim`, `animDef`, `puissance`, `heal`,`AttbuffAtt`,`AttbuffDef`,`AttbuffVitesse`,`DefbuffAtt`,`DefbuffDef`,`DefBuffVitesse`, `type`, `description`, `PP`) VALUES (:nom, :anim, :animDef, :puissance, :heal, :AttbuffAtt, :AttbuffDef, :AttbuffVitesse, :DefbuffAtt, :DefbuffDef, :DefBuffVitesse, :type, :description, :PP);");

$insertattaque->execute(array(	
	'nom' => 'Trempette',
	'anim' => 'idlefast',
	'animDef' => 'idle',
	'puissance' => 0,
	'heal' => 0,
	'AttbuffAtt' => 0,
	'AttbuffDef' => 0,
	'AttbuffVitesse' => 0,
	'DefbuffAtt' => 0,
	'DefbuffDef' => 0,
	'DefBuffVitesse' => 0,
	'type' => 'normal',
	'description' => 'Fait trempette',
	'PP' => 10 
));

$insertattaque->execute(array(	
	'nom' => 'Pause MKTRO',
	'anim' => 'idlefast',
	'animDef' => 'idle',
	'puissance' => 0,
	'heal' => 20,
	'AttbuffAtt' => 0,
	'AttbuffDef' => 0,
	'AttbuffVitesse' => 0,
	'DefbuffAtt' => 0,
	'DefbuffDef' => 0,
	'DefBuffVitesse' => 0,
	'type' => 'normal',
	'description' => "Une pause s'impose !",
	'PP' => 10 
));

$insertattaque->execute(array(	
	'nom' => 'Charge',
	'anim' => 'ligne',
	'animDef' => 'animDegat',
	'puissance' => 30,
	'heal' => 0,
	'AttbuffAtt' => 0,
	'AttbuffDef' => 0,
	'AttbuffVitesse' => 0,
	'DefbuffAtt' => 0,
	'DefbuffDef' => 0,
	'DefBuffVitesse' => 0,
	'type' => 'normal',
	'description' => "Charge l'ennemi",
	'PP' => 20
));



echo 'blablabla';

?>