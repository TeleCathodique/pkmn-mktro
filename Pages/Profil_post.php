<?php
session_start();
try{
	$bdd = new PDO('mysql:host=localhost;dbname=user7;charset=utf8', 'root', 'Kermit01');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}
$_SESSION['Crash'] = 0;
$_SESSION['Done_mdp'] = 0;
$_SESSION['Done_pseudo'] = 0;
if(isset($_POST['mdp']) && isset($_POST['new_pseudo'])){
	$verif_mdp = $bdd->prepare('SELECT Mdp FROM account WHERE id=?');
	$verif_mdp->execute(array($_SESSION['id']));
	$data = $verif_mdp->fetch();

	if(password_verify($_POST['mdp'], $data['Mdp'])){
		$_SESSION['Existe_mdp'] = 1;
				
		$_SESSION['Name'] = $_POST['new_pseudo'];
		$req = $bdd->prepare('UPDATE account SET Name = ? WHERE id = ?');
		$req->execute(array($_POST['Name'],$_SESSION['id']));

		$_SESSION['Done_pseudo'] = 1;

		}
		else{
			$_SESSION['Existe_mdp'] = 0;
		}

}
else if(isset($_POST['old_pass']) && isset($_POST['new_pass1']) && isset($_POST['new_pass2'])){

	if ($_POST['new_pass1']==$_POST['new_pass2']) {
		$_SESSION['is_mdp'] = 1;
		$verif_mdp = $bdd->prepare('SELECT Mdp FROM account WHERE id=?');
		$verif_mdp->execute(array($_SESSION['id']));
		$data = $verif_mdp->fetch();

		if(password_verify($_POST['old_pass'], $data['Mdp'])){
			$_SESSION['Existe_mdp'] = 1;
			
			$req = $bdd->prepare('UPDATE account SET Mdp = ? WHERE id = ?');
			$req->execute(array(password_hash($_POST['new_pass1'], PASSWORD_DEFAULT),$_SESSION['id']));
			$_SESSION['Done_mdp'] = 1;

		}
		else{
			$_SESSION['Existe_mdp'] = 0;
		}
	}
	else{
		$_SESSION['is_mdp'] = 0;
	}

}
else{
	$_SESSION['Crash'] = 1;
}


header('Location: Profil.php');
?>