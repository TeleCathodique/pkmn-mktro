<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="../STYLE.css">
	<link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
	<title>Pokémon MKTRO - Deconnection</title>
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
       	<div class="navbar"><a href="Connexion.php">Connexion</a></div>
	</nav>

	<section>
		

		<?php
		if (1) {
			session_destroy();
			echo "Tu es déconnecté";
		}
		else{
			echo "Tu n'étais pas connecté";
		}
		?>

	</section>

<?php include("../footer.php"); ?>

	</body>
</html>