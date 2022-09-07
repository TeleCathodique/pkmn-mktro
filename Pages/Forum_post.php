<?php
session_start();
try{
	$bdd = new PDO('mysql:host=localhost;dbname=user7;charset=utf8', 'root', 'Kermit01');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}


$req1 = $bdd->prepare('SELECT id FROM account WHERE Name = ?');
$req1-> execute(array($_SESSION['Name']));
$res = $req1->fetch();

$req2 = $bdd->prepare('INSERT INTO forum(Name, Name_id, Data) VALUES(?,?,?)');
$req2->execute(array($_SESSION['Name'], $res['id'], $_POST['Data'])) or die(print_r($req1->errorInfo()));


header('Location: Forum.php');

?>Z