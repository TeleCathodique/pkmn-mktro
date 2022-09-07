<?php

session_start();

$NomJ1=$_GET['NomJ1'];
$NomJ2=$_GET['NomJ2'];

// $NomJ1="Roman";
// $NomJ2="Hamid";

$_SESSION['Mode']=$_GET['Mode'];


try
{
	$bdd = new PDO('mysql:host=localhost;dbname=user7;charset=utf8', 'root', 'Kermit01');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}


$rq1=$bdd->prepare("SELECT * FROM pokemons WHERE Nom = :Nom ");
$rq2=$bdd->prepare("SELECT * FROM pokemons WHERE Nom = :Nom ");

$rq1->execute(array(
'Nom' => $NomJ1
));

$rq2->execute(array(
'Nom' => $NomJ2
));

// $rq1->execute(array(
// 'Nom' => 'Roman'
// ));

// $rq2->execute(array(
// 'Nom' => 'Roman'
// ));

$donneesJ1=$rq1->fetchAll(PDO::FETCH_ASSOC);
$donneesJ2=$rq2->fetchAll(PDO::FETCH_ASSOC);


// J1
$L1[0]=$donneesJ1[0]['idImage'];
$L1[1]=$donneesJ1[0]['Nom'];
$L1[2]=$donneesJ1[0]['Niveau'];
$L1[3]=$donneesJ1[0]['type'];
$L1[4]=$donneesJ1[0]['vieMax'];
$L1[5]=$donneesJ1[0]['Attaque1'];
$L1[6]=$donneesJ1[0]['Attaque2'];
$L1[7]=$donneesJ1[0]['Attaque3'];
$L1[8]=$donneesJ1[0]['Attaque4'];
$L1[9]=$donneesJ1[0]['Vitesse'];
$L1[10]=$donneesJ1[0]['Defense'];
$L1[11]=$donneesJ1[0]['StatAttaque'];

$_SESSION['idImageJ1'] = $L1[0];
$_SESSION['NomJ1'] = $L1[1];
$_SESSION['NiveauJ1'] = $L1[2];
$_SESSION['typeJ1'] = $L1[3];
$_SESSION['vieMaxJ1'] = $L1[4];
$_SESSION['Attaque1J1'] = $L1[5];
$_SESSION['Attaque2J1'] = $L1[6];
$_SESSION['Attaque3J1'] = $L1[7];
$_SESSION['Attaque4J1'] = $L1[8];
$_SESSION['VitesseJ1'] = $L1[9];
$_SESSION['DefenseJ1'] = $L1[10];
$_SESSION['StatAttaqueJ1'] = $L1[11];

$_SESSION['placeJ1'] = 'P1';
$_SESSION['vieCibleJ1'] = $_SESSION['vieMaxJ1'];




$rqAtt=$bdd->prepare("SELECT * FROM attaques WHERE nom = :nom ");

$rqAtt->execute(array(
'nom' => $_SESSION['Attaque1J1']
));

$donneesAtt1J1=$rqAtt->fetchAll(PDO::FETCH_ASSOC);

$LAtt1J1[0]=$donneesAtt1J1[0]['nom'];
$LAtt1J1[1]=$donneesAtt1J1[0]['anim'];
$LAtt1J1[2]=$donneesAtt1J1[0]['animDef'];
$LAtt1J1[3]=$donneesAtt1J1[0]['puissance'];
$LAtt1J1[4]=$donneesAtt1J1[0]['heal'];
$LAtt1J1[5]=$donneesAtt1J1[0]['AttbuffAtt'];
$LAtt1J1[6]=$donneesAtt1J1[0]['AttbuffDef'];
$LAtt1J1[7]=$donneesAtt1J1[0]['AttbuffVitesse'];
$LAtt1J1[8]=$donneesAtt1J1[0]['DefbuffAtt'];
$LAtt1J1[9]=$donneesAtt1J1[0]['DefbuffDef'];
$LAtt1J1[10]=$donneesAtt1J1[0]['DefBuffVitesse'];
$LAtt1J1[11]=$donneesAtt1J1[0]['type'];
$LAtt1J1[12]=$donneesAtt1J1[0]['description'];
$LAtt1J1[13]=$donneesAtt1J1[0]['PP'];

$rqAtt->execute(array(
'nom' => $_SESSION['Attaque2J1']
));

$donneesAtt2J1=$rqAtt->fetchAll(PDO::FETCH_ASSOC);

$LAtt2J1[0]=$donneesAtt2J1[0]['nom'];
$LAtt2J1[1]=$donneesAtt2J1[0]['anim'];
$LAtt2J1[2]=$donneesAtt2J1[0]['animDef'];
$LAtt2J1[3]=$donneesAtt2J1[0]['puissance'];
$LAtt2J1[4]=$donneesAtt2J1[0]['heal'];
$LAtt2J1[5]=$donneesAtt2J1[0]['AttbuffAtt'];
$LAtt2J1[6]=$donneesAtt2J1[0]['AttbuffDef'];
$LAtt2J1[7]=$donneesAtt2J1[0]['AttbuffVitesse'];
$LAtt2J1[8]=$donneesAtt2J1[0]['DefbuffAtt'];
$LAtt2J1[9]=$donneesAtt2J1[0]['DefbuffDef'];
$LAtt2J1[10]=$donneesAtt2J1[0]['DefBuffVitesse'];
$LAtt2J1[11]=$donneesAtt2J1[0]['type'];
$LAtt2J1[12]=$donneesAtt2J1[0]['description'];
$LAtt2J1[13]=$donneesAtt2J1[0]['PP'];

$rqAtt->execute(array(
'nom' => $_SESSION['Attaque3J1']
));

$donneesAtt3J1=$rqAtt->fetchAll(PDO::FETCH_ASSOC);

$LAtt3J1[0]=$donneesAtt3J1[0]['nom'];
$LAtt3J1[1]=$donneesAtt3J1[0]['anim'];
$LAtt3J1[2]=$donneesAtt3J1[0]['animDef'];
$LAtt3J1[3]=$donneesAtt3J1[0]['puissance'];
$LAtt3J1[4]=$donneesAtt3J1[0]['heal'];
$LAtt3J1[5]=$donneesAtt3J1[0]['AttbuffAtt'];
$LAtt3J1[6]=$donneesAtt3J1[0]['AttbuffDef'];
$LAtt3J1[7]=$donneesAtt3J1[0]['AttbuffVitesse'];
$LAtt3J1[8]=$donneesAtt3J1[0]['DefbuffAtt'];
$LAtt3J1[9]=$donneesAtt3J1[0]['DefbuffDef'];
$LAtt3J1[10]=$donneesAtt3J1[0]['DefBuffVitesse'];
$LAtt3J1[11]=$donneesAtt3J1[0]['type'];
$LAtt3J1[12]=$donneesAtt3J1[0]['description'];
$LAtt3J1[13]=$donneesAtt3J1[0]['PP'];

$rqAtt->execute(array(
'nom' => $_SESSION['Attaque4J1']
));

$donneesAtt4J1=$rqAtt->fetchAll(PDO::FETCH_ASSOC);

$LAtt4J1[0]=$donneesAtt4J1[0]['nom'];
$LAtt4J1[1]=$donneesAtt4J1[0]['anim'];
$LAtt4J1[2]=$donneesAtt4J1[0]['animDef'];
$LAtt4J1[3]=$donneesAtt4J1[0]['puissance'];
$LAtt4J1[4]=$donneesAtt4J1[0]['heal'];
$LAtt4J1[5]=$donneesAtt4J1[0]['AttbuffAtt'];
$LAtt4J1[6]=$donneesAtt4J1[0]['AttbuffDef'];
$LAtt4J1[7]=$donneesAtt4J1[0]['AttbuffVitesse'];
$LAtt4J1[8]=$donneesAtt4J1[0]['DefbuffAtt'];
$LAtt4J1[9]=$donneesAtt4J1[0]['DefbuffDef'];
$LAtt4J1[10]=$donneesAtt4J1[0]['DefBuffVitesse'];
$LAtt4J1[11]=$donneesAtt4J1[0]['type'];
$LAtt4J1[12]=$donneesAtt4J1[0]['description'];
$LAtt4J1[13]=$donneesAtt4J1[0]['PP'];







$_SESSION['PP1J1'] = $donneesAtt1J1[0]['PP'];
$_SESSION['PP2J1'] = $donneesAtt2J1[0]['PP'];
$_SESSION['PP3J1'] = $donneesAtt3J1[0]['PP'];
$_SESSION['PP4J1'] = $donneesAtt4J1[0]['PP'];












// J2
$L2[0]=$donneesJ2[0]['idImage'];
$L2[1]=$donneesJ2[0]['Nom'];
$L2[2]=$donneesJ2[0]['Niveau'];
$L2[3]=$donneesJ2[0]['type'];
$L2[4]=$donneesJ2[0]['vieMax'];
$L2[5]=$donneesJ2[0]['Attaque1'];
$L2[6]=$donneesJ2[0]['Attaque2'];
$L2[7]=$donneesJ2[0]['Attaque3'];
$L2[8]=$donneesJ2[0]['Attaque4'];
$L2[9]=$donneesJ2[0]['Vitesse'];
$L2[10]=$donneesJ2[0]['Defense'];
$L2[11]=$donneesJ2[0]['StatAttaque'];

$_SESSION['idImageJ2'] = $L2[0];
$_SESSION['NomJ2'] = $L2[1];
$_SESSION['NiveauJ2'] = $L2[2];
$_SESSION['typeJ2'] = $L2[3];
$_SESSION['vieMaxJ2'] = $L2[4];
$_SESSION['Attaque1J2'] = $L2[5];
$_SESSION['Attaque2J2'] = $L2[6];
$_SESSION['Attaque3J2'] = $L2[7];
$_SESSION['Attaque4J2'] = $L2[8];
$_SESSION['VitesseJ2'] = $L2[9];
$_SESSION['DefenseJ2'] = $L2[10];
$_SESSION['StatAttaqueJ2'] = $L2[11];


$_SESSION['placeJ2'] = 'P2';
$_SESSION['vieCibleJ2'] = $_SESSION['vieMaxJ2'];




$rqAtt=$bdd->prepare("SELECT * FROM attaques WHERE nom = :nom ");

$rqAtt->execute(array(
'nom' => $_SESSION['Attaque1J2']
));

$donneesAtt1J2=$rqAtt->fetchAll(PDO::FETCH_ASSOC);

$LAtt1J2[0]=$donneesAtt1J2[0]['nom'];
$LAtt1J2[1]=$donneesAtt1J2[0]['anim'];
$LAtt1J2[2]=$donneesAtt1J2[0]['animDef'];
$LAtt1J2[3]=$donneesAtt1J2[0]['puissance'];
$LAtt1J2[4]=$donneesAtt1J2[0]['heal'];
$LAtt1J2[5]=$donneesAtt1J2[0]['AttbuffAtt'];
$LAtt1J2[6]=$donneesAtt1J2[0]['AttbuffDef'];
$LAtt1J2[7]=$donneesAtt1J2[0]['AttbuffVitesse'];
$LAtt1J2[8]=$donneesAtt1J2[0]['DefbuffAtt'];
$LAtt1J2[9]=$donneesAtt1J2[0]['DefbuffDef'];
$LAtt1J2[10]=$donneesAtt1J2[0]['DefBuffVitesse'];
$LAtt1J2[11]=$donneesAtt1J2[0]['type'];
$LAtt1J2[12]=$donneesAtt1J2[0]['description'];
$LAtt1J2[13]=$donneesAtt1J2[0]['PP'];

$rqAtt->execute(array(
'nom' => $_SESSION['Attaque2J2']
));

$donneesAtt2J2=$rqAtt->fetchAll(PDO::FETCH_ASSOC);

$LAtt2J2[0]=$donneesAtt2J2[0]['nom'];
$LAtt2J2[1]=$donneesAtt2J2[0]['anim'];
$LAtt2J2[2]=$donneesAtt2J2[0]['animDef'];
$LAtt2J2[3]=$donneesAtt2J2[0]['puissance'];
$LAtt2J2[4]=$donneesAtt2J2[0]['heal'];
$LAtt2J2[5]=$donneesAtt2J2[0]['AttbuffAtt'];
$LAtt2J2[6]=$donneesAtt2J2[0]['AttbuffDef'];
$LAtt2J2[7]=$donneesAtt2J2[0]['AttbuffVitesse'];
$LAtt2J2[8]=$donneesAtt2J2[0]['DefbuffAtt'];
$LAtt2J2[9]=$donneesAtt2J2[0]['DefbuffDef'];
$LAtt2J2[10]=$donneesAtt2J2[0]['DefBuffVitesse'];
$LAtt2J2[11]=$donneesAtt2J2[0]['type'];
$LAtt2J2[12]=$donneesAtt2J2[0]['description'];
$LAtt2J2[13]=$donneesAtt2J2[0]['PP'];

$rqAtt->execute(array(
'nom' => $_SESSION['Attaque3J2']
));

$donneesAtt3J2=$rqAtt->fetchAll(PDO::FETCH_ASSOC);

$LAtt3J2[0]=$donneesAtt3J2[0]['nom'];
$LAtt3J2[1]=$donneesAtt3J2[0]['anim'];
$LAtt3J2[2]=$donneesAtt3J2[0]['animDef'];
$LAtt3J2[3]=$donneesAtt3J2[0]['puissance'];
$LAtt3J2[4]=$donneesAtt3J2[0]['heal'];
$LAtt3J2[5]=$donneesAtt3J2[0]['AttbuffAtt'];
$LAtt3J2[6]=$donneesAtt3J2[0]['AttbuffDef'];
$LAtt3J2[7]=$donneesAtt3J2[0]['AttbuffVitesse'];
$LAtt3J2[8]=$donneesAtt3J2[0]['DefbuffAtt'];
$LAtt3J2[9]=$donneesAtt3J2[0]['DefbuffDef'];
$LAtt3J2[10]=$donneesAtt3J2[0]['DefBuffVitesse'];
$LAtt3J2[11]=$donneesAtt3J2[0]['type'];
$LAtt3J2[12]=$donneesAtt3J2[0]['description'];
$LAtt3J2[13]=$donneesAtt3J2[0]['PP'];

$rqAtt->execute(array(
'nom' => $_SESSION['Attaque4J2']
));

$donneesAtt4J2=$rqAtt->fetchAll(PDO::FETCH_ASSOC);

$LAtt4J2[0]=$donneesAtt4J2[0]['nom'];
$LAtt4J2[1]=$donneesAtt4J2[0]['anim'];
$LAtt4J2[2]=$donneesAtt4J2[0]['animDef'];
$LAtt4J2[3]=$donneesAtt4J2[0]['puissance'];
$LAtt4J2[4]=$donneesAtt4J2[0]['heal'];
$LAtt4J2[5]=$donneesAtt4J2[0]['AttbuffAtt'];
$LAtt4J2[6]=$donneesAtt4J2[0]['AttbuffDef'];
$LAtt4J2[7]=$donneesAtt4J2[0]['AttbuffVitesse'];
$LAtt4J2[8]=$donneesAtt4J2[0]['DefbuffAtt'];
$LAtt4J2[9]=$donneesAtt4J2[0]['DefbuffDef'];
$LAtt4J2[10]=$donneesAtt4J2[0]['DefBuffVitesse'];
$LAtt4J2[11]=$donneesAtt4J2[0]['type'];
$LAtt4J2[12]=$donneesAtt4J2[0]['description'];
$LAtt4J2[13]=$donneesAtt4J2[0]['PP'];







$_SESSION['PP1J2'] = $donneesAtt1J2[0]['PP'];
$_SESSION['PP2J2'] = $donneesAtt2J2[0]['PP'];
$_SESSION['PP3J2'] = $donneesAtt3J2[0]['PP'];
$_SESSION['PP4J2'] = $donneesAtt4J2[0]['PP'];



$LAttConcat=array_merge($LAtt1J1,$LAtt2J1,$LAtt3J1,$LAtt4J1,$LAtt1J2,$LAtt2J2,$LAtt3J2,$LAtt4J2);

for ($joueur = 1; $joueur <= 2; $joueur++){
	for ($i = 1; $i <= 4; $i++){
		$LAtt['nom'.'Att'.strval($i).'P'.strval($joueur)]=$LAttConcat[(4*($joueur-1)+$i-1)*14+0];
		$LAtt['anim'.'Att'.strval($i).'P'.strval($joueur)]=$LAttConcat[(4*($joueur-1)+$i-1)*14+1];
		$LAtt['animDef'.'Att'.strval($i).'P'.strval($joueur)]=$LAttConcat[(4*($joueur-1)+$i-1)*14+2];
		$LAtt['puissance'.'Att'.strval($i).'P'.strval($joueur)]=$LAttConcat[(4*($joueur-1)+$i-1)*14+3];
		$LAtt['heal'.'Att'.strval($i).'P'.strval($joueur)]=$LAttConcat[(4*($joueur-1)+$i-1)*14+4];
		$LAtt['AttbuffAtt'.'Att'.strval($i).'P'.strval($joueur)]=$LAttConcat[(4*($joueur-1)+$i-1)*14+5];
		$LAtt['AttbuffDef'.'Att'.strval($i).'P'.strval($joueur)]=$LAttConcat[(4*($joueur-1)+$i-1)*14+6];
		$LAtt['AttbuffVitesse'.'Att'.strval($i).'P'.strval($joueur)]=$LAttConcat[(4*($joueur-1)+$i-1)*14+7];
		$LAtt['DefbuffAtt'.'Att'.strval($i).'P'.strval($joueur)]=$LAttConcat[(4*($joueur-1)+$i-1)*14+8];
		$LAtt['DefbuffDef'.'Att'.strval($i).'P'.strval($joueur)]=$LAttConcat[(4*($joueur-1)+$i-1)*14+9];
		$LAtt['DefBuffVitesse'.'Att'.strval($i).'P'.strval($joueur)]=$LAttConcat[(4*($joueur-1)+$i-1)*14+10];
		$LAtt['type'.'Att'.strval($i).'P'.strval($joueur)]=$LAttConcat[(4*($joueur-1)+$i-1)*14+11];
		$LAtt['description'.'Att'.strval($i).'P'.strval($joueur)]=$LAttConcat[(4*($joueur-1)+$i-1)*14+12];
		$LAtt['PP'.'Att'.strval($i).'P'.strval($joueur)]=$LAttConcat[(4*($joueur-1)+$i-1)*14+13];
	}
}

$_SESSION['joueurActuel']='J1';
$_SESSION['autreJoueur']='J2';

$_SESSION['Phase'] = 'Choix';

// $_SESSION['started'] = 'non';




// echo json_encode($L1);
// echo json_encode($L2);
// echo json_encode(array_merge($LAtt1J1,$LAtt2J1,$LAtt3J1,$LAtt4J1,$LAtt1J2,$LAtt2J2,$LAtt3J2,$LAtt4J2));

echo json_encode($LAtt);

// echo json_encode($LAttConcat);

// echo json_encode($LAtt1J1);
// echo json_encode($LAtt2J1);
// echo json_encode($LAtt3J1);
// echo json_encode($LAtt4J1);
// echo json_encode($LAtt1J2);
// echo json_encode($LAtt2J2);
// echo json_encode($LAtt3J2);
// echo json_encode($LAtt4J2);


// echo($_SESSION['vieMaxJ1']);

?>