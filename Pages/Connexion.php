<?php
session_start();
?>
<!DOCTYPE html>	
<html>
	<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="../STYLE.css">
	<link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="Connect_style.css">
	<title>Pokémon MKTRO - Connection</title>
	</head>
	<body>

	<header>
		<div class="title">
			POKEMON MKTRO
		</div>
	</header>
	
	<nav>
       	<div class="navbar"><a href="../index.php">Accueil</a></div>
       	<div class="navbar"><a href="StatsV2.php">Pokedex</a></div>
       	<div class="navbar"><a href="Forum.php">Forum</a></div>
        <div class="navbar"><a href="Profil.php">Profil</a></div>
       	<div class="navbar active"><a href="Connexion.php">Connexion</a></div>
	</nav>

	<section>

		

		<div class="Connexion">

			<div class="page_connect" id="welcome">
				<button name="connection" onclick="show_connect()">Connection</button>
				<button name="inscription" onclick="show_signin()">Inscription</button>
			</div>

			<div class="page_connect" id="connect">
				<form method="post" action="Connexion_post.php">
					<fieldset>
						<legend>Informations de Connection</legend>
						<label>E-mail</label> <br>
						<input type="email" name="Mail" required="required"> <br><br>
						<label>Mot de passe</label> <br>
						<input type="password" name="mdp1" required="required"> <br><br>
						<input type="submit" value="Envoyer">
						<input type="reset" value="Reset">

						<?php

						if (isset($_SESSION['connexion'])) {
							echo "<br>";
							if ($_SESSION['is_mail']==0) {
								echo "Ce n'est pas une adresse e-mail petit coquin";
								unset($_SESSION['is_mail']);
							}
							else if ($_SESSION['Existe_mail']==0) {
								echo "Mauvaise adresse mail";
								unset($_SESSION['Existe_mail']);
							}
							else if ($_SESSION['Existe_mdp']==0) {
								echo "Mauvais mdp";
								unset($_SESSION['Existe_mdp']);
							}
							unset($_SESSION['connexion']);
						}

						?>

					</fieldset>
				</form>
				<button name="return1" onclick="go_back()">Retour</button>
			</div>

			<div class="page_connect" id="signin">
				<form method="post" action="Inscription_post.php">
					<fieldset>
						<legend>Information d'Inscription</legend>
						<label>E-mail</label> <br>
						<input type="email" name="Mail" required="required"> <br><br>
						<label>Pseudonyme</label> <br>
						<input type="text" name="Name" required="required"> <br><br>
						<label>Mot de passe</label> <br>
						<input type="password" name="mdp1" required="required" minlength="6"> <br><br>
						<label>Confirmer le mot de passe</label> <br>
						<input type="password" name="mdp2" required="required"> <br><br>
						<label>Ton équipe</label> <br>
						<select name="Group_id" required="required">
							<option value="">Choisis une équipe !</option>
							<option value="2">Blanche</option>
							<option value="3">Jaune</option>
						</select> <br>
						<input type="submit" value="Envoyer">
						<input type="reset" value="Reset">

						<?php

						if (isset($_SESSION['inscription'])) {
							echo "<br>";
							if ($_SESSION['is_mail']==0) {
								echo "Ce n'est pas une adresse e-mail petit coquin";
								unset($_SESSION['is_mail']);
							}
							else if ($_SESSION['is_mdp']==0) {
								echo "Tu sais pas recopier un mot de passe";
								unset($_SESSION['is_mdp']);
							}
							else if ($_SESSION['Existe']==1) {
								echo "Un compte existe déjà avec cettre adresse mail";
								unset($_SESSION['Existe']);
							}
							unset($_SESSION['inscription']);
						}

						?>

					</fieldset>
				</form>
				<button name="return1" onclick="go_back()">Retour</button>
			</div>

		</div>
	</section>

<?php include("../footer.php"); ?>



<script type="text/javascript">

function show_connect(){
	var welcome = document.getElementById("welcome");
	var connect = document.getElementById("connect");
	welcome.style.display = "none";
	connect.style.display = "contents";
}

function show_signin(){
	var welcome = document.getElementById("welcome");
	var signin = document.getElementById("signin");
	welcome.style.display = "none";
	signin.style.display = "contents";
}

function go_back(){
	var welcome = document.getElementById("welcome");
	var connect = document.getElementById("connect");
	var signin = document.getElementById("signin");
	welcome.style.display = "contents";
	connect.style.display = "none";
	signin.style.display = "none";
}


<?php

if (isset($_SESSION['inscription'])) {
	if($_SESSION['inscription']==1){
		echo 'show_signin();';
	}
}
if (isset($_SESSION['connexion'])) {
	if($_SESSION['connexion']==1){
		echo 'show_connect();';
	}
}

?>

</script>


	</body>
</html>