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
	<link rel="stylesheet" type="text/css" href="Forum_style.css">
	<link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
	<title>Forum MKTRO</title>
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
        <div class="navbar active"><a href="Forum.php">Forum</a></div>
        <div class="navbar"><a href="Profil.php">Profil</a></div>
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
		<div class="forum">
		
			<?php
			$content = $bdd->query('SELECT * FROM forum ORDER BY ID DESC');
			while ($line = $content->fetch())
			{

			?>


			<div <?php if(isset($_SESSION['Connected'])){if($_SESSION['Connected']==1 && $_SESSION['id']==$line['Name_id']){echo "class='message user'";}else{echo "class='message not_user'";}}else{echo "class='message not_user'";}  ?>>
				<strong>Utilisateur : <?php echo htmlspecialchars($line['Name']);?></strong><br>
				<p>
					<?php echo htmlspecialchars($line['Data']);?><br>
				</p>
				<?php echo $line['time'];?>
			</div>

			<?php
			}
			$content->closeCursor();
			?>


	</div>
	</section>


	<section class="submit_message">
		<form method="post" action="Forum_post.php">

			<?php if(isset($_SESSION['Connected'])){if($_SESSION['Connected']==1){ ?>
			
			<p>
				Message<br>
				<textarea name="Data" rows="5" cols="50"></textarea>
				<input type="submit" name="Submit">
			</p>

			<?php }}else{ ?>

			<p>
				Pour envoyer un message, connecte-toi.
			</p>

			<?php } ?>

		</form>
	</section>

<?php include("../footer.php"); ?>

	</body>
</html>