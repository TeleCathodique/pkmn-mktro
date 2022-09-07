<?php
session_start();
try{
	$bdd = new PDO('mysql:host=localhost;dbname=user7;charset=utf8', 'root', 'Kermit01');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}
$_SESSION['connexion'] = 1;
$_SESSION['Inscris'] = 0;
$_SESSION['Connected'] = 0;





if(filter_var($_POST['Mail'], FILTER_VALIDATE_EMAIL)){
	$_SESSION['is_mail'] = 1;

	$verif_mail = $bdd->prepare('SELECT COUNT(1) FROM account WHERE Mail=?');
	$verif_mail->execute(array($_POST['Mail']));
	$existe_mail_data = $verif_mail->fetch()['COUNT(1)'];
	if($existe_mail_data==1){
		$_SESSION['Existe_mail'] = 1;

		$verif_mdp = $bdd->prepare('SELECT * FROM account WHERE Mail=?');
		$verif_mdp->execute(array($_POST['Mail']));
		$data = $verif_mdp->fetch();

		if(password_verify($_POST['mdp1'], $data['Mdp'])){
			$_SESSION['Existe_mdp'] = 1;
					
			$_SESSION['Connected'] = 1;
			$_SESSION['Name'] = $data['Name'];
			$_SESSION['Group_id'] = $data['Group_id'];
			$_SESSION['Inscription'] = $data['Inscription'];

			$_SESSION['id'] = $data['id'];

		}
		else{
			$_SESSION['Existe_mdp'] = 0;
		}
	}	
	else{
		$_SESSION['Existe_mail'] = 0;
	}
}
else{
	$_SESSION['is_mail'] = 0;

}


if($_SESSION['Connected']==1){
	header('Location: ../index.php');
}
else{
	header('Location: Connexion.php');
}

?>