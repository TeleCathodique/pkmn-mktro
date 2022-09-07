<?php
session_start();
try{
	$bdd = new PDO('mysql:host=localhost;dbname=user7;charset=utf8', 'root', 'Kermit01');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}
?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="../STYLE.css">
	<link rel="stylesheet" type="text/css" href="Profil_style.css">
	<link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
	<title>Profil MKTRO</title>
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
        <div class="navbar active"><a href="Profil.php">Profil</a></div>
       	<?php
       	if(isset($_SESSION['Connected']) && isset($_SESSION['Name']) && isset($_SESSION['Group_id'])){
       		if ($_SESSION['Connected']==1) {
       			echo "<div class='navbar'><a href='Deconnexion.php'>Deconnexion</a></div>";
       		}
       	}
       	else{
	    	echo "<div class='navbar'><a href='Connexion.php'>Connexion</a></div>";
       	}
       		
       	?>
	</nav>

	<section>
		<?php if(isset($_SESSION['Connected'])){if($_SESSION['Connected']==1){ ?>

		<div class="profil">
		<div>

			<strong> <?php echo $_SESSION['Name'] ?> </strong> <br>
			<?php
			switch($_SESSION['Group_id']){
				case 1:
					echo "<i> Admin </i><br>";
					break;
				case 2:
					echo "<i> Equipe Blanche </i><br>";
					break;
				case 3:
					echo "<i> Equipe Jaune </i><br>";
					break;
			}
			?>
			Inscris depuis <?php echo $_SESSION['Inscription'] ?><br>

		</div>

		<div class="Stats">
			<?php 

			$req0 = $bdd->prepare('SELECT COUNT(*) FROM combats WHERE id_joueur_vainqueur=?');
			$req0->execute(array($_SESSION['id']));
			$nb_combat = $req0->fetch()['COUNT(*)'];

			$req1 = $bdd->prepare('SELECT poke, COUNT(*) FROM (SELECT poke_vainqueur AS poke FROM combats WHERE id_joueur_vainqueur = ? UNION ALL (SELECT pokemon_perdant FROM combats WHERE id_joueur_vainqueur = ?)) AS alias GROUP BY poke ORDER BY COUNT(*) DESC');
			$req1->execute(array($_SESSION['id'],$_SESSION['id']));
			$liked_pokemon = $req1->fetch();
			
			$req2 = $bdd->prepare('SELECT poke_vainqueur,COUNT(*) FROM combats WHERE id_joueur_vainqueur = ? GROUP BY poke_vainqueur ORDER BY COUNT(*) DESC');
			$req2->execute(array($_SESSION['id']));
			$most_pokemon = $req2->fetch();

			$req3 = $bdd->prepare('SELECT pokemon_perdant,COUNT(*) FROM combats WHERE id_joueur_vainqueur = ? GROUP BY pokemon_perdant ORDER BY COUNT(*) DESC');
			$req3->execute(array($_SESSION['id']));
			$least_pokemon = $req3->fetch();

			?>
			<strong>Statistiques de combats</strong><br><br>

			<div>
				Nombre de combats joués : <?php echo $nb_combat;?><br>
				<?php 
				if($nb_combat!=0){
				?>
				Pokémon préféré : <?php echo $liked_pokemon['poke'];?> avec <?php echo round($liked_pokemon['COUNT(*)']/$nb_combat*100);?> % de jeux<br>
				Pokémon le plus souvent gagnant : <?php echo $most_pokemon['poke_vainqueur']; ?> avec <?php echo round($most_pokemon['COUNT(*)']/$nb_combat*100,0); ?> % de victoire<br>
				Pokémon le plus souvent perdant : <?php echo $least_pokemon['pokemon_perdant']; ?> avec <?php echo round($least_pokemon['COUNT(*)']/$nb_combat*100,0); ?> % de défaite<br>
				<?php
				}
				else{
					echo "Joue un peu pour avoir tes statistiques !";
				}
				?>
			</div>

		</div>

		<div class="change">
			<div>
				<form method="post" action="Profil_post.php">
					<fieldset>
						<legend>Changer de pseudo</legend>
						<label>Nouveau pseudo</label> <br>
						<input type="text" name="new_pseudo" required="required"> <br>
						<label>Mot de passe</label> <br>
						<input type="password" name="mdp" required="required"> <br>
						<input type="submit" value="Envoyer">

						<?php

						
						if (isset($_SESSION['Existe_mdp'])){if($_SESSION['Existe_mdp']==0) {
							echo "<br>Mauvais mdp";
							unset($_SESSION['Existe_mdp']);
						}}
						if(isset($_SESSION['Done_pseudo'])){if($_SESSION['Done_pseudo']==1){
							echo "<br>Pseudo changé";
							unset($_SESSION['Done_pseudo']);
						}}
						if(isset($_SESSION['Crash'])){if($_SESSION['Crash']==1){
							echo "<br>CRASH";
							unset($_SESSION['Crash']);
						}}
						?>

				</fieldset>
			</form>
			</div>
			<div>
				<form method="post" action="Profil_post.php">
					<fieldset>
						<legend>Changer de mot de passe</legend>
						<label>Ancien mot de passe</label> <br>
						<input type="password" name="old_pass" required="required"> <br>
						<label>Nouveau mot de passe</label> <br>
						<input type="password" name="new_pass1" required="required"> <br>
						<label>Nouveau mot de passe</label> <br>
						<input type="password" name="new_pass2" required="required"> <br>
						<input type="submit" value="Envoyer">

						<?php

						if(isset($_SESSION['Existe_mdp'])){if($_SESSION['Existe_mdp']==0){
							echo "<br>Mauvais mdp";
							unset($_SESSION['Existe_mdp']);
						}}
						if(isset($_SESSION['is_mdp'])){if($_SESSION['is_mdp']==0){
							echo "<br>Tu sais pas recopier un mdp";
							unset($_SESSION['is_mdp']);
						}}
						if(isset($_SESSION['Done_mdp'])){if($_SESSION['Done_mdp']==1){
							echo "<br>Mot de passe changé";
							unset($_SESSION['Done_mdp']);
						}}
						if(isset($_SESSION['Crash'])){if($_SESSION['Crash']==1){
							echo "<br>CRASH";
							unset($_SESSION['Crash']);
						}}

						?>

				</fieldset>
			</form>
			</div>
		</div>
		</div>
	</section>
	<section>

		<?php }else{ ?>

		<div>

			Pour accéder à ton profil, connecte-toi.

		</div>

		<?php }}else{ ?>

		<div>

			Pour accéder à ton profil, connecte-toi.

		</div>

		<?php } ?>

	</section>

<?php include("../footer.php"); ?>

	</body>
</html>