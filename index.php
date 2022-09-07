<?php
session_start();
?>
<!DOCTYPE html>	
<html>
	<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="STYLE.css">
	<link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">	
	<title>Pokémon MKTRO</title>
	</head>
	<body>

	<header>
		<div class="title">
			POKEMON MKTRO
		</div>
	</header>
	
	<nav>
       	<div class="navbar active"><a href="index.php">Accueil</a></div>
       	<div class="navbar"><a href="Pages/StatsV2.php">Pokedex</a></div>
       	<div class="navbar"><a href="Pages/Forum.php">Forum</a></div>
        <div class="navbar"><a href="Pages/Profil.php">Profil</a></div>
       	<?php
       	if(isset($_SESSION['Connected']) && isset($_SESSION['Name']) && isset($_SESSION['Group_id'])){
       		if ($_SESSION['Connected']==1) {
       			echo "<div class='navbar'><a href='Pages/Deconnexion.php'>Deconnexion</a></div>";
       		}
       		else{
	    	echo "<div class='navbar'><a href='Pages/Connexion.php'>Connexion</a></div>";
       		}
       	}
       	else{
	    echo "<div class='navbar'><a href='Pages/Connexion.php'>Connexion</a></div>";
       	}
       		
       	?>
	</nav>


	<section class="index" onmouseover="fctout();">
		<aside class="index">
			<a href="http://kappa.ensr.local/user9">
				<img src="Pubs/Pub_echec.png" title="Jouer aux échecs RPG">
			</a>
		</aside>
		<div class="index">
			On vous propose ici de faire combatre les différents profs de mktro ! Devenez le meilleur dresseur !<br>
			Incarnez vos profs favoris, et amenez les au combat. Faites de votre mieux pour aller le plus loin possible, et vous aurez peut-être la chance de combattre le boss final de l'ENS :<br><br>
			<em>HAMID BEN AHMED</em><br>
			<br>
			Aurez vous le courage de mener à la victoire vos profs ?<br>
			Lancez-vous dans une aventure palpitante !<br>
			<br>
			Mais pour commencer, il faut que tu te connectes ;)<br>
			<br>
			<br>
		</div>
		<aside class="index">
			<img src="Pubs/Pub_Cookie.jpg" title="Contactez Adrien Gaggioli">
		</aside>
	</section>

	<?php
	$if_connected = "<section id='combat'>
		<div id='button' onclick='fctin();'>
			COMBATTRE
		</div>
		<div id='selection'>
			<div>
				<a href='ProtoV11/Combat_MultiPhp.php'>2 Joueurs</a>
			</div>
			<div>
				<a href='ProtoV11/Combat_SoloPhp.php'>Contre l'ordi</a>
			</div>
		</div>
	</section>";
	$if_not_connected = "<section id='combat'>
		<div id='button'>
			Connecte-toi
		</div>
	</section>";

	if(isset($_SESSION['Connected']) && isset($_SESSION['Name']) && isset($_SESSION['Group_id'])){
       		if ($_SESSION['Connected']==1) {echo $if_connected;}else{echo $if_not_connected;}}else{echo $if_not_connected;}
	?>


<?php include("footer.php"); ?>



<script type="text/javascript">



function fctin(){	
	var button = document.getElementById("button");
	var select = document.getElementById("selection");
	var combat = document.getElementById("combat");
	button.style.visibility = "hidden";
	select.style.visibility = "visible";
	select.style.padding = "40px"
	combat.style.height = "350px";
}
function fctout(){	
	var button = document.getElementById("button");
	var select = document.getElementById("selection");
	var combat = document.getElementById("combat");
	button.style.visibility = "visible";
	select.style.visibility = "hidden";
	select.style.padding = "10px"
	combat.style.height = "100px";
}


</script>


	</body>
</html>