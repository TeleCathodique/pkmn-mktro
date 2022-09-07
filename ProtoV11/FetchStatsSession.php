<?php

session_start();

// $L1[0] = $_SESSION['idImageJ1'];
// $L1[1] = $_SESSION['NomJ1'];
// $L1[2] = $_SESSION['NiveauJ1'];
// $L1[3] = $_SESSION['typeJ1'];
// $L1[4] = $_SESSION['vieMaxJ1'];
// $L1[5] = $_SESSION['Attaque1J1'];
// $L1[6] = $_SESSION['Attaque2J1'];
// $L1[7] = $_SESSION['Attaque3J1'];
// $L1[8] = $_SESSION['Attaque4J1'];
// $L1[9] = $_SESSION['VitesseJ1'];
// $L1[10] = $_SESSION['DefenseJ1'];
// $L1[11] = $_SESSION['StatAttaqueJ1'];

// $L2[0] = $_SESSION['idImageJ2'];
// $L2[1] = $_SESSION['NomJ2'];
// $L2[2] = $_SESSION['NiveauJ2'];
// $L2[3] = $_SESSION['typeJ2'];
// $L2[4] = $_SESSION['vieMaxJ2'];
// $L2[5] = $_SESSION['Attaque1J2'];
// $L2[6] = $_SESSION['Attaque2J2'];
// $L2[7] = $_SESSION['Attaque3J2'];
// $L2[8] = $_SESSION['Attaque4J2'];
// $L2[9] = $_SESSION['VitesseJ2'];
// $L2[10] = $_SESSION['DefenseJ2'];
// $L2[11] = $_SESSION['StatAttaqueJ2'];


// J1
$L['idImageJ1'] = $_SESSION['idImageJ1'];
$L['NomJ1'] = $_SESSION['NomJ1'];
$L['NiveauJ1'] = $_SESSION['NiveauJ1'];
$L['typeJ1'] = $_SESSION['typeJ1'];
$L['vieMaxJ1'] = $_SESSION['vieMaxJ1'];
$L['Attaque1J1'] = $_SESSION['Attaque1J1'];
$L['Attaque2J1'] = $_SESSION['Attaque2J1'];
$L['Attaque3J1'] = $_SESSION['Attaque3J1'];
$L['Attaque4J1'] = $_SESSION['Attaque4J1'];
$L['VitesseJ1'] = $_SESSION['VitesseJ1'];
$L['DefenseJ1'] = $_SESSION['DefenseJ1'];
$L['StatAttaqueJ1'] = $_SESSION['StatAttaqueJ1'];

$L['placeJ1'] = $_SESSION['placeJ1'];
$L['vieCibleJ1'] = $_SESSION['vieCibleJ1'];

$L['PP1J1'] = $_SESSION['PP1J1'];
$L['PP2J1'] = $_SESSION['PP2J1'];
$L['PP3J1'] = $_SESSION['PP3J1'];
$L['PP4J1'] = $_SESSION['PP4J1'];


// J2
$L['idImageJ2'] = $_SESSION['idImageJ2'];
$L['NomJ2'] = $_SESSION['NomJ2'];
$L['NiveauJ2'] = $_SESSION['NiveauJ2'];
$L['typeJ2'] = $_SESSION['typeJ2'];
$L['vieMaxJ2'] = $_SESSION['vieMaxJ2'];
$L['Attaque1J2'] = $_SESSION['Attaque1J2'];
$L['Attaque2J2'] = $_SESSION['Attaque2J2'];
$L['Attaque3J2'] = $_SESSION['Attaque3J2'];
$L['Attaque4J2'] = $_SESSION['Attaque4J2'];
$L['VitesseJ2'] = $_SESSION['VitesseJ2'];
$L['DefenseJ2'] = $_SESSION['DefenseJ2'];
$L['StatAttaqueJ2'] = $_SESSION['StatAttaqueJ2'];

$L['placeJ2'] = $_SESSION['placeJ2'];
$L['vieCibleJ2'] = $_SESSION['vieCibleJ2'];

$L['PP1J2'] = $_SESSION['PP1J2'];
$L['PP2J2'] = $_SESSION['PP2J2'];
$L['PP3J2'] = $_SESSION['PP3J2'];
$L['PP4J2'] = $_SESSION['PP4J2'];


// $L['started']=$_SESSION['started']


// echo json_encode($L1);
// echo json_encode($L2);

// echo json_encode(array_merge($L1,$L2));
echo json_encode($L);

?>