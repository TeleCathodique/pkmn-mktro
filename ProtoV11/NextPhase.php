<?php

session_start();

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=user7;charset=utf8', 'root', 'Kermit01');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

$insertcombat = $bdd->prepare("INSERT INTO `combats` (`id`, `poke_vainqueur`, `pokemon_perdant`, `id_joueur_vainqueur`) VALUES (NULL, :poke_vainqueur, :pokemon_perdant, :id_joueur_vainqueur);");

// $insertcombat->execute(array(
// 				'poke_vainqueur' => $_SESSION['NomJ2'],
// 				'pokemon_perdant' => $_SESSION['NomJ1'],
// 				'id_joueur_vainqueur' => 0
// 				));


if(intval($_SESSION['vieCibleJ1'])>0 && intval($_SESSION['vieCibleJ2'])>0){
	if($_SESSION['Mode']=='multi'){
		// L=J1
		$L['idImage'] = $_SESSION['idImageJ1'];
		$L['Nom'] = $_SESSION['NomJ1'];
		$L['Niveau'] = $_SESSION['NiveauJ1'];
		$L['type'] = $_SESSION['typeJ1'];
		$L['vieMax'] = $_SESSION['vieMaxJ1'];
		$L['Attaque1'] = $_SESSION['Attaque1J1'];
		$L['Attaque2'] = $_SESSION['Attaque2J1'];
		$L['Attaque3'] = $_SESSION['Attaque3J1'];
		$L['Attaque4'] = $_SESSION['Attaque4J1'];
		$L['Vitesse'] = $_SESSION['VitesseJ1'];
		$L['Defense'] = $_SESSION['DefenseJ1'];
		$L['StatAttaque'] = $_SESSION['StatAttaqueJ1'];

		$L['place'] = $_SESSION['placeJ1'];
		$L['vieCible'] = $_SESSION['vieCibleJ1'];

		$L['PP1'] = $_SESSION['PP1J1'];
		$L['PP2'] = $_SESSION['PP2J1'];
		$L['PP3'] = $_SESSION['PP3J1'];
		$L['PP4'] = $_SESSION['PP4J1'];

		// J1=J2

		$_SESSION['idImageJ1'] = $_SESSION['idImageJ2'];
		$_SESSION['NomJ1'] = $_SESSION['NomJ2'];
		$_SESSION['NiveauJ1'] = $_SESSION['NiveauJ2'];
		$_SESSION['typeJ1'] = $_SESSION['typeJ2'];
		$_SESSION['vieMaxJ1'] = $_SESSION['vieMaxJ2'];
		$_SESSION['Attaque1J1'] = $_SESSION['Attaque1J2'];
		$_SESSION['Attaque2J1'] = $_SESSION['Attaque2J2'];
		$_SESSION['Attaque3J1'] = $_SESSION['Attaque3J2'];
		$_SESSION['Attaque4J1'] = $_SESSION['Attaque4J2'];
		$_SESSION['VitesseJ1'] = $_SESSION['Attaque4J2'];
		$_SESSION['DefenseJ1'] = $_SESSION['DefenseJ2'];
		$_SESSION['StatAttaqueJ1'] = $_SESSION['StatAttaqueJ2'];

		$_SESSION['placeJ1'] = $_SESSION['placeJ2'];
		$_SESSION['vieCibleJ1'] = $_SESSION['vieCibleJ2'];

		$_SESSION['PP1J1'] = $_SESSION['PP1J2'];
		$_SESSION['PP2J1'] = $_SESSION['PP2J2'];
		$_SESSION['PP3J1'] = $_SESSION['PP3J2'];
		$_SESSION['PP4J1'] = $_SESSION['PP4J2'];

		// J2=L

		$_SESSION['idImageJ2'] = $L['idImage'];
		$_SESSION['NomJ2'] = $L['Nom'];
		$_SESSION['NiveauJ2'] = $L['Niveau'];
		$_SESSION['typeJ2'] = $L['type'];
		$_SESSION['vieMaxJ2'] = $L['vieMax'];
		$_SESSION['Attaque1J2'] = $L['Attaque1'];
		$_SESSION['Attaque2J2'] = $L['Attaque2'];
		$_SESSION['Attaque3J2'] = $L['Attaque3'];
		$_SESSION['Attaque4J2'] = $L['Attaque4'];
		$_SESSION['VitesseJ2'] = $L['Vitesse'];
		$_SESSION['DefenseJ2'] = $L['Defense'];
		$_SESSION['StatAttaqueJ2'] = $L['StatAttaque'];

		$_SESSION['placeJ2'] = $L['place'];
		$_SESSION['vieCibleJ2'] = $L['vieCible'];

		$_SESSION['PP1J2'] = $L['PP1'];
		$_SESSION['PP2J2'] = $L['PP2'];
		$_SESSION['PP3J2'] = $L['PP3'];
		$_SESSION['PP4J2'] = $L['PP4'];
	}
	elseif($_SESSION['Mode']=='solo'){
		$Tempo=$_SESSION['joueurActuel'];
		$_SESSION['joueurActuel']=$_SESSION['autreJoueur'];
		$_SESSION['autreJoueur']=$Tempo;

		$Tempo=$_SESSION['placeJ1'];
		$_SESSION['placeJ1'] = $_SESSION['placeJ2'];
		$_SESSION['placeJ2'] = $Tempo;


	}
}
else{ // fin
	//ajout ligne table combat
	if($_SESSION['Mode']=='multi'){
		if(intval($_SESSION['vieCibleJ1'])<=0){//J2 gagne
			$insertcombat->execute(array(
				'poke_vainqueur' => $_SESSION['NomJ2'],
				'pokemon_perdant' => $_SESSION['NomJ1'],
				'id_joueur_vainqueur' => NULL
				));

		}
		else{//J1 gagne
			$insertcombat->execute(array(
				'poke_vainqueur' => $_SESSION['NomJ1'],
				'pokemon_perdant' => $_SESSION['NomJ2'],
				'id_joueur_vainqueur' => NULL
				));

		};
	}
	elseif($_SESSION['Mode']=='solo'){
		if(intval($_SESSION['vieCibleJ1'])<=0){//J2 (IA) gagne
			$insertcombat->execute(array(
				'poke_vainqueur' => $_SESSION['NomJ2'],
				'pokemon_perdant' => $_SESSION['NomJ1'],
				'id_joueur_vainqueur' => 0
				));

		}
		else{//J1 (joueur) gagne
			$insertcombat->execute(array(
				'poke_vainqueur' => $_SESSION['NomJ1'],
				'pokemon_perdant' => $_SESSION['NomJ2'],
				'id_joueur_vainqueur' => $_SESSION['id']
				));

		};

	}

}


$Ldata['Mode']=$_SESSION['Mode'];
$Ldata['joueurActuel']=$_SESSION['joueurActuel'];

echo json_encode($Ldata)

?>