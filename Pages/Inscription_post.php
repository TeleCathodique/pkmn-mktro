<?php
session_start();
try{
	$bdd = new PDO('mysql:host=localhost;dbname=user7;charset=utf8', 'root', 'Kermit01');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}
$_SESSION['inscription'] = 1;
$_SESSION['Inscris'] = 0;
$_SESSION['Connected'] = 0;


if ($_POST['Group_id']!="") {
	$_SESSION['team'] = $_POST['Group_id'];

	if(filter_var($_POST['Mail'], FILTER_VALIDATE_EMAIL)){
		$_SESSION['is_mail'] = 1;

		if($_POST['mdp1']==$_POST['mdp2']){

			$_SESSION['is_mdp'] = 1;
			$mdp_hache = password_hash($_POST['mdp1'], PASSWORD_DEFAULT);

			$verif = $bdd->prepare('SELECT COUNT(1) FROM account WHERE Mail=?');
			$verif->execute(array($_POST['Mail']));
			$existe = $verif->fetch()['COUNT(1)'];

			if($existe==0){


				$_SESSION['Existe'] = 0;
				$req = $bdd->prepare('INSERT INTO account(Name, Mail, Mdp, Group_id) VALUES(?,?,?,?)');
				$req->execute(array($_POST['Name'], $_POST['Mail'], $mdp_hache, $_POST['Group_id']));
				$_SESSION['Inscris'] = 1;
				
				$_SESSION['Connected'] = 1;
				$_SESSION['Name'] = $_POST['Name'];
				$_SESSION['Group_id'] = $_POST['Group_id'];

				$req1 = $bdd->prepare('SELECT id,Inscription FROM account WHERE Name = ?');
				$req1-> execute(array($_SESSION['Name']));
				$res = $req1->fetch();

				$_SESSION['Inscription'] = $data['Inscription'];
				$_SESSION['id'] = $res['id'];


			}
			else{
				$_SESSION['Existe'] = 1;
			}
		}
		else{
			$_SESSION['is_mdp'] = 0;
		}
	}
	else{
		$_SESSION['is_mail'] = 0;
	}
}
else{
	$_SESSION['team'] = 0;
}

if($_SESSION['Inscris']==1){
	header('Location: ../index.php');
}
else{
	header('Location: Connexion.php');
}

?>