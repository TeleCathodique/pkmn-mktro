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
	<link rel="stylesheet" type="text/css" href="Stats_style.css">
	<link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
	<title>Pokédex MKTRO</title>
	</head>
	<body>

	<header>
		<div class="title">
			POKEMON MKTRO
		</div>
	</header>
	
	<nav>
        <div class="navbar"><a href="../index.php">Accueil</a></div>
        <div class="navbar active"><a href="StatsV2.php">Pokedex</a></div>
        <div class="navbar"><a href="Forum.php">Forum</a></div>
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

	<section id="pokedex_container">
		<center><canvas id="pokedex"></canvas></center>
	</section>


	<section>
		<div class="Stats">
			<?php 
			$nb_combat = $bdd->query('SELECT COUNT(*) FROM combats')->fetch()['COUNT(*)'];
			$liked_pokemon = $bdd->query('SELECT poke, COUNT(*) FROM (SELECT poke_vainqueur AS poke FROM combats UNION ALL (SELECT pokemon_perdant FROM combats)) AS alias GROUP BY poke ORDER BY COUNT(*) DESC')->fetch();
			$most_pokemon = $bdd->query('SELECT poke_vainqueur,COUNT(*) FROM combats GROUP BY poke_vainqueur ORDER BY COUNT(*) DESC')->fetch();
			$least_pokemon = $bdd->query('SELECT pokemon_perdant,COUNT(*) FROM combats GROUP BY pokemon_perdant ORDER BY COUNT(*) DESC')->fetch();

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
					echo "Aucune statistique à afficher";
				}
				?>
			</div>

		</div>
	</section>







	
		<?php include("../footer.php"); ?>

		<div style="display: none;">
		<img id="background" src="../Images/pokedex.png">

		<?php
		$pre_content = $bdd->query('SELECT idImage FROM pokemons');
		while ($pre_line = $pre_content->fetch())
		{

			echo "<img id='".$pre_line['idImage']."' src='../ProtoV11/images/".$pre_line['idImage']."P1.png'>";

		}
		$pre_content->closeCursor();
		?>
		</div>
	
<script type="text/javascript">
	

var cvs = document.getElementById("pokedex");
var ctx = cvs.getContext('2d');
var container = document.getElementById("pokedex_container")

cvs.width=container.clientWidth*0.9;
cvs.height=800;

// position curseur ******************************************************************************************************

var posX=0;
var posY=0;

let screenLog = document.getElementById('screen-log');
document.addEventListener('mousemove', logKey);


var offsetX=cvs.offsetLeft;
var offsetY=cvs.offsetTop;

function majOffset(){
	offsetX=cvs.offsetLeft
	offsetY=cvs.offsetTop
}

function logKey(e) {
	majOffset()
	posX = e.clientX - offsetX + scrollX;
    posY = e.clientY - offsetY + scrollY;
	// screenLog.innerText = `
	// Screen X/Y: ${posX}, ${posY}
	// Client X/Y: ${e.clientX}, ${e.clientY}`;
}
// background ***********************************************************************************************************

var background = document.getElementById("background");

function draw_background(){
	ctx.drawImage(background,0,0,cvs.width,cvs.height) ;
}

// Grille de touches *****************************************************************************************************

class grille{
	constructor(id,x,y,dx,dy){
		this.id = id;
		this.x = x;
		this.y = y;
		this.dx = dx;
		this.dy = dy;
		this.show = false;
	}

	update_survol(){
		if(this.x<=posX && posX<=this.x+this.dx && this.y<=posY && posY<=this.y+this.dy){
			this.show = true;
		}
		else{
			this.show = false;
		}
	}
}

let grid10 = new grille(10,691,388,70,40);
let grid11 = new grille(11,772,388,70,40);
let grid12 = new grille(12,851,388,70,40);
let grid13 = new grille(13,933,388,70,40);
let grid14 = new grille(14,1017,388,70,40);
let grid15 = new grille(15,691,442,70,40);
let grid16 = new grille(16,772,442,70,40);
let grid17 = new grille(17,851,442,70,40);
let grid18 = new grille(18,933,442,70,40);
let grid19 = new grille(19,1017,442,70,40);

li_grid = [grid10,grid11,grid12,grid13,grid14,grid15,grid16,grid17,grid18,grid19];

function draw_grid(){

	ctx.fillStyle = 'rgba(204, 209, 219, 0.5)';
	for (i=0; i<li_grid.length; i++){
		temp = li_grid[i];
		temp.update_survol();
		if (temp.show){
			ctx.fillRect(temp.x,temp.y,temp.dx,temp.dy);
		}
	}
}

// Lumière *************************************************************************************************************

class Light{
	constructor(id,x,y,r,rgba,showstat){
		this.id = id;
		this.x = x;
		this.y = y;
		this.r = r;
		this.rgba = rgba;
		this.showstat = showstat;
		this.show = this.showstat

	}
	update_phase(){
		if (Statique){
			this.show = this.showstat;
		}
		else if (!Statique){
			this.show = !this.showstat;
		}
	}
}

let light_y = new Light(0,274,53,20,"rgba(240,255,255,0.5)",false);
let light_g = new Light(1,318,53,20,"rgba(240,255,240,0.5)",true);

li_Lights = [light_y, light_g];

// Cross ****************************************************************************************************************


let grid_up = new grille(1,393,590,33,28);
let grid_right = new grille(2,435,626,28,33);
let grid_down = new grille(3,393,667,33,28);
let grid_left = new grille(4,356,626,28,33);

li_cross = [grid_up, grid_right, grid_down, grid_left];

function draw_cross(){
	ctx.fillStyle = 'rgba(204, 209, 219, 0.5)';
	for (i=0; i<li_cross.length; i++){
		temp = li_cross[i];
		temp.update_survol();
		if (temp.show){
			ctx.fillRect(temp.x,temp.y,temp.dx,temp.dy);
		}
	}
}

// Selecteur Stats *****************************************************************************************************

let grid_Stats = new grille(5,697,534,806-697,558-534);
let grid_Desc = new grille(6,835,534,943-835,558-534);

li_select = [grid_Stats,grid_Desc];
li_select_print = ["Desc","Stats"]

function draw_selecteur(){
	for (i=0; i<li_select.length; i++){
		temp = li_select[i];
		temp.update_survol();
		ctx.font = "16px Staatliches";
		ctx.fillStyle = "rgba(0,0,0,1.0)";
		ctx.fillText(li_select_print[i],temp.x,temp.y+0.8*temp.dy);
		if (temp.show){
			ctx.fillStyle = 'rgba(204, 209, 219, 0.35)';
			ctx.fillRect(temp.x,temp.y,temp.dx,temp.dy);
		}
	}
}


// Animations **********************************************************************************************************

class Animation{
	constructor(Xt,Yt,duree=1000,angle=function no_rotate(t){return 0}){
		this.Xt=Xt;
		this.Yt=Yt;
		this.duree=duree;
		this.angle=angle;
	}
}

function IdleX(t){return(0)}
function IdleY(t){return(0)}

let Idle = new Animation(IdleX,IdleY);

function OutLeftX(t){return(-1*t)}
function OutLeftY(t){return(0)}

let OutLeft = new Animation(OutLeftX,OutLeftY,140);

function OutRightX(t){return(1*t)}
function OutRightY(t){return(0)}

let OutRight = new Animation(OutRightX,OutRightY,140);

function InLeftX(t){return(-140+1*t)}
function InLeftY(t){return(0)}

let InLeft = new Animation(InLeftX,InLeftY,140);

function InRightX(t){return(+140-1*t)}
function InRightY(t){return(0)}

let InRight = new Animation(InRightX,InRightY,140);

function EasterEggX(t){return(0)}
function EasterEggY(t){return(0)}
function EasterEggT(t){return(0.36*t*2)}

let EasterEgg = new Animation(EasterEggX,EasterEggY,1000,EasterEggT);



// Pokemons ************************************************************************************************************

class pokemon{
	constructor(id,Name,Atk,Def,Speed,Type,PV,lvl,Li_Atk){
		this.id = id;
		this.Name = Name;
		this.Atk = Atk;
		this.Def = Def;
		this.Speed = Speed;
		this.Type = Type;
		this.PV = PV;
		this.lvl = lvl;
		this.Li_Atk = Li_Atk;
		this.anim = Idle;
	}
}

class Attack{
	constructor(Name,Dmg,Heal,Type,Pp,Txt){
		this.Name = Name;
		this.Dmg = Dmg;
		this.Heal = Heal;
		this.Type = Type;
		this.Pp = Pp;
		this.Txt = Txt;
	}
}


<?php
$content = $bdd->query('SELECT * FROM attaques');
while ($line = $content->fetch())
{

	echo 'let '.str_replace(" ", "", $line['nom']).' = new Attack("'.$line['nom'].'", '.$line['puissance'].', '.$line['heal'].', "'.$line['type'].'", '.$line['PP'].', "'.str_replace("'","\'",$line['description']).'");';

}
$content->closeCursor();
?>


Li_pokemon = [];

<?php
$content = $bdd->query('SELECT * FROM pokemons');
while ($line = $content->fetch())
{

	echo "let ".$line['idImage']." = new pokemon('".$line['idImage']."', '".$line['Nom']."', ".$line['StatAttaque'].", ".$line['Defense'].", ".$line['Vitesse'].", '".$line['type']."', ".$line['vieMax'].", ".$line['Niveau'].", [".str_replace(" ", "", $line['Attaque1']).",".str_replace(" ", "", $line['Attaque2']).",".str_replace(" ", "", $line['Attaque3']).",".str_replace(" ", "", $line['Attaque4'])."]);";
	echo "Li_pokemon.push(".$line['idImage'].");";

}
$content->closeCursor();
?>


// Selection Pokemon ***************************************************************************************************

Sel_max = Li_pokemon.length-1;
Select = 0;

function click_cross(e){
	if (li_cross[2].show || li_cross[1].show){
		if (Select<Sel_max){
			Change_Right_P1();
		}
		else{

		}
	}
	if (li_cross[0].show || li_cross[3].show){
		if (Select>0){
			Change_Left_P1();
		}
		else{

		}
	}
}


function Change_Right_P1(){
	Statique = false;
	Li_pokemon[Select].anim = OutLeft;
	var timestamp = new Date();
	t0 = (1000*60*timestamp.getMinutes()+1000*timestamp.getSeconds()+timestamp.getMilliseconds());
	setTimeout(Change_Right_P2,Li_pokemon[Select].anim.duree)
}

function Change_Right_P2(){
	Li_pokemon[Select].anim = Idle;
	Select+=1;
	Li_pokemon[Select].anim = InRight;
	var timestamp = new Date();
	t0 = (1000*60*timestamp.getMinutes()+1000*timestamp.getSeconds()+timestamp.getMilliseconds());
	setTimeout(Change_Right_P3,Li_pokemon[Select].anim.duree)
}

function Change_Right_P3(){
	Li_pokemon[Select].anim = Idle;
	Statique = true;
}

function Change_Left_P1(){
	Statique = false;
	Li_pokemon[Select].anim = OutRight;
	var timestamp = new Date();
	t0 = (1000*60*timestamp.getMinutes()+1000*timestamp.getSeconds()+timestamp.getMilliseconds());
	setTimeout(Change_Left_P2,Li_pokemon[Select].anim.duree)
}

function Change_Left_P2(){
	Li_pokemon[Select].anim = Idle;
	Select-=1;
	Li_pokemon[Select].anim = InLeft;
	var timestamp = new Date();
	t0 = (1000*60*timestamp.getMinutes()+1000*timestamp.getSeconds()+timestamp.getMilliseconds());
	setTimeout(Change_Left_P3,Li_pokemon[Select].anim.duree)
}

function Change_Left_P3(){
	Li_pokemon[Select].anim = Idle;
	Statique = true;
}


function reset_anim(){Li_pokemon[Select].anim = Idle;Statique = true;};

// Image Pokemon *******************************************************************************************************

function import_pokemon(fig,X,Y,width,height,angle){
	ctx.translate(X+0.5*width,Y+0.5*height);
	ctx.rotate(Math.PI/180*angle);
	ctx.translate(-X-0.5*width,-Y-0.5*height);
	ctx.drawImage(fig,X,Y,width,height);
	ctx.translate(X+0.5*width,Y+0.5*height);
	ctx.rotate(Math.PI/180*(-angle));
	ctx.translate(-X-0.5*width,-Y-0.5*height);
}

Statique = true

function draw_pokemon(t){
	temp = Li_pokemon[Select];
	fig = document.getElementById(temp.id);
	ratio = fig.width/fig.height;
	height = 248;
	width = height*ratio
	X = 100+(488-100)/2-width/2;
	Y = 248;
	import_pokemon(fig,X+temp.anim.Xt(t),Y+temp.anim.Yt(t),width,height,temp.anim.angle(t));
}

function draw_lights(){
	for (i=0; i<li_Lights.length; i++){
		temp = li_Lights[i];
		temp.update_phase();
		if (temp.show){
			ctx.arc(temp.x,temp.y,temp.r,0,2*Math.PI,true);
			ctx.fillStyle = temp.rgba;
		}
	}
	ctx.fill();
}

// Stats Pokemon *******************************************************************************************************

function write_stats(){
	temp = Li_pokemon[Select];
	ctx.font = "20px Staatliches";
	ctx.fillStyle = "rgba(255,255,255,1.0)";
	ctx.fillText("PV: "+temp.PV.toString(),750,655);
	ctx.fillText("ATK: "+temp.Atk.toString(),915,645);
	ctx.fillText("DEF: "+temp.Def.toString(),1005,645);
	ctx.fillText("VIT: "+temp.Speed.toString(),960,670);
	ctx.font = "25px Staatliches";
	ctx.fillStyle = "rgba(10,10,10,.6)";
	ctx.fillText(temp.Name.toString(),100,690,175,30);
}


// Stats ou Description ***********************************************************************************************

Select_display = 0;

function click_select(e){
	if (li_select[0].show){
		Select_display = 0;
	}
	if (li_select[1].show){
		Select_display = 1;
	}		
}


// Attaques Pokemon Grille **********************************************************************************************

function write_attacks(){
	temp_li_atk = Li_pokemon[Select].Li_Atk;
	ctx.font = "18px Staatliches";
	ctx.fillStyle = "rgba(255,255,255,1.0)";
	for (i=0; i<temp_li_atk.length; i++){
		temp = li_grid[i];
		ctx.fillText(temp_li_atk[i].Name.toString(),temp.x,temp.y+0.5*temp.dy+9,temp.dx,temp.dy)
	}
}

// Select attaque ******************************************************************************************************

Select_atk = 0;
Sel_atk_max = Li_pokemon[Select].Li_Atk.length-1;

function click_attack(e){
	for (i=0; i<Sel_atk_max+1; i++){
		if (li_grid[i].show){
			Select_atk = i;
		}
	}
}

// Display Attaque + Description

function write_data(){
	temp = Li_pokemon[Select].Li_Atk[Select_atk];
	ctx.font = "30px Staatliches";
	ctx.fillStyle = "rgba(255,255,255,1.0)";
	ctx.fillText(temp.Name,700,310);
	if (Select_display==0){
		ctx.font = "20px Staatliches";
		ctx.fillStyle = "rgba(255,255,255,1.0)";
		ctx.fillText(temp.Txt,700,350);
	}
	else if (Select_display==1){
		ctx.font = "20px Staatliches";
		ctx.fillStyle = "rgba(255,255,255,1.0)";
		ctx.fillText("TYPE: "+temp.Type.toString(),700,350);
		if(temp.Dmg!=0){
			ctx.fillText("DMG: "+temp.Dmg.toString(),850,350);
		}
		else{
			if(temp.Heal!=0){
				ctx.fillText("HEAL: "+temp.Heal.toString(),850,350);
			}
		}
		ctx.fillText("PP: "+temp.Pp.toString(),1000,350);
	}
}

// EASTER_EGG **********************************************************************************************************

let button_easter = new grille(7,1064,544,20,20);

function draw_easter(){

	ctx.fillStyle = 'rgba(204, 209, 219, 0.5)';
	temp = button_easter;
	temp.update_survol();
	if (temp.show){
		ctx.fillRect(temp.x,temp.y,temp.dx,temp.dy);
	}
}

function click_easter(e){
	if (button_easter.show){
		Li_pokemon[Select].anim = EasterEgg;
		var timestamp = new Date();
		Statique = false;
		t0 = (1000*60*timestamp.getMinutes()+1000*timestamp.getSeconds()+timestamp.getMilliseconds());
		setTimeout(reset_anim,EasterEgg.duree);
	}
}

// MAIN *****************************************************************************************************************

document.addEventListener('mousedown',click);

function click(){
	click_cross();
	click_select();
	click_attack();
	click_easter();
}

function draw_all(t){
	draw_pokemon(t);
	draw_background();
	draw_grid();
	draw_easter();
	draw_cross();
	draw_selecteur();
	draw_lights();
	write_stats();
	write_attacks();
	write_data()
}


function main(){
	
	cvs.width = cvs.width;

	var time = new Date();
	t=(1000*60*time.getMinutes()+1000*time.getSeconds()+time.getMilliseconds())-t0


	draw_all(t);

	setTimeout(main,15);
}

t0=0


main();

</script>

	</body>
</html>