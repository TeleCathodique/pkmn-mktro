<?php

session_start();



$Num=$_GET['Num'];

if(($Num!='1')&&($Num!='2')&&($Num!='3')&&($Num!='4')){
	$Num='1';
}

// $Num='2';

$Patt=$_SESSION['joueurActuel'];
$Pdef=$_SESSION['autreJoueur'];

$Rate='non';
$Crit='non';

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=user7;charset=utf8', 'root', 'Kermit01');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

$rqAtt=$bdd->prepare("SELECT * FROM attaques WHERE nom = :nom ");


$rqAtt->execute(array(
'nom' => $_SESSION['Attaque'.strval($Num).$Patt]
));

$donneesAtt=$rqAtt->fetchAll(PDO::FETCH_ASSOC);


$LAtt['nom']=$donneesAtt[0]['nom'];
$LAtt['anim']=$donneesAtt[0]['anim'];
$LAtt['animDef']=$donneesAtt[0]['animDef'];
$LAtt['puissance']=$donneesAtt[0]['puissance'];
$LAtt['heal']=$donneesAtt[0]['heal'];
$LAtt['AttbuffAtt']=$donneesAtt[0]['AttbuffAtt'];
$LAtt['AttbuffDef']=$donneesAtt[0]['AttbuffDef'];
$LAtt['AttbuffVitesse']=$donneesAtt[0]['AttbuffVitesse'];
$LAtt['DefbuffAtt']=$donneesAtt[0]['DefbuffAtt'];
$LAtt['DefbuffDef']=$donneesAtt[0]['DefbuffDef'];
$LAtt['DefBuffVitesse']=$donneesAtt[0]['DefBuffVitesse'];
$LAtt['type']=$donneesAtt[0]['type'];
$LAtt['description']=$donneesAtt[0]['description'];



function probaCrit($Patt,$Pdef){
	// return (0.03+0.05*(Patt.Vitesse-Pdef.Vitesse)/Pdef.Vitesse)
	return (0.03+0.05*($_SESSION['Vitesse'.$Patt]-$_SESSION['Vitesse'.$Pdef])/$_SESSION['Vitesse'.$Pdef]);
};

function probaRater($Patt,$Pdef){
	return(0.05-0.05*($_SESSION['Vitesse'.$Patt]-$_SESSION['Vitesse'.$Pdef])/$_SESSION['Vitesse'.$Pdef]);
};

function calcDegats($Patt,$Pdef,$LAtt){

	$Crit="non";
	$Rate="non";

	$Degats=($_SESSION['StatAttaque'.$Patt]/$_SESSION['Defense'.$Pdef])*$LAtt['puissance'];

	// echo ($_SESSION['StatAttaque'.$Patt]/$_SESSION['Defense'.$Pdef])*$LAtt['puissance'];
	// echo ' formule1!<br />';

	// echo $_SESSION['StatAttaque'.$Patt];
	// echo ' StatAttaque!<br />';
	// echo $_SESSION['Defense'.$Pdef];
	// echo ' Defense!<br />';	
	// echo $LAtt['puissance'];
	// echo ' puissance!<br />';

	// echo $LAtt;
	// echo ' mabitevolcanique!<br />';


	// echo $Degats;
	// echo ' !<br />';

	$rollCrit=rand(0,100)/100;

	// echo $rollCrit ;
	// echo ' !<br />';

	$rollRater=rand(0,100)/100;

	// echo $rollRater;
	// echo ' !<br />';

	if($rollRater<=probaRater($Patt,$Pdef)){
		$Degats=0;
		$Rate="oui";
	}
	elseif($rollCrit<=probaCrit($Patt,$Pdef)){
		$Degats=2*$Degats;
		$Crit="oui";
	};

	return(floor($Degats));
};



$PPsuffisants='non';

// echo $LAtt['puissance'];
// 	echo ' puissance3!<br />';

if ($_SESSION['PP'.strval($Num).$Patt]>0){ //si on a des PP
	$PPsuffisants='oui';
	
	$_SESSION['Phase'] = "Text1";
	$derniereAttaque  = $LAtt['nom'];

	$_SESSION['PP'.strval($Num).$Patt]=$_SESSION['PP'.strval($Num).$Patt]-1;//descendre PP

	$Degats=calcDegats($Patt,$Pdef,$LAtt);

	// echo $_SESSION['StatAttaque'.$Patt];
	// echo ' !<br />';
	// echo $_SESSION['Defense'.$Pdef];
	// echo ' !<br />';
	// echo $LAtt['puissance'];
	// echo ' puissance2!<br />';
	// echo '  sdfsdf  ';
	// echo $Degats;
	// echo ' !<br />';

	// echo '  sdfsdf  ';
	// echo ($_SESSION['StatAttaque'.$Patt]/$_SESSION['Defense'.$Pdef])*$LAtt['puissance'];
	// echo ' formule2 !<br />';

	// echo $Rate;
	// echo ' !<br />';
	// echo $Crit;

	// Patt.anim=Att.anim

	if($Rate=="non"){
			// Pdef.anim=Att.animDef
			$_SESSION['StatAttaque'.$Patt]+=$LAtt['AttbuffAtt'];
			$_SESSION['Defense'.$Patt]+=$LAtt['AttbuffDef'];
			$_SESSION['Vitesse'.$Patt]+=$LAtt['AttbuffVitesse'];
			$_SESSION['StatAttaque'.$Pdef]+=$LAtt['DefbuffAtt'];
			$_SESSION['Defense'.$Pdef]+=$LAtt['DefbuffDef'];
			$_SESSION['Vitesse'.$Pdef]+=$LAtt['DefBuffVitesse'];
			$_SESSION['vieCible'.$Patt]+=$LAtt['heal'];
			}

	$_SESSION['vieCible'.$Pdef]-=$Degats;


};

$Lecho['PPsuffisants']=$PPsuffisants;
$Lecho['derniereAttaque']=$derniereAttaque;
$Lecho['Rate']=$Rate;
$Lecho['Crit']=$Crit;

echo json_encode($Lecho);

?>