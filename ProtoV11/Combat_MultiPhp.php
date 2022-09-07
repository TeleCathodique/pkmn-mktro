
<?php
session_start();
?>

<html>

<title>Baston</title>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="StyleCombat.css">
	<link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>



<!-- <center>
<h1 style="font-size:240%">Mega baston</h1>

</center> -->


<div id="conteneur">
	<div id="zonedessin">
		<center>
		<canvas id=c></canvas>
		</center>

		<center>
		<canvas id=cvtxt></canvas>
		</center>

	</div>

	<div id="selecteurs">
		<p id="select" style="display:none;">
		<label for="selectMode">sélectionner mode de jeu</label><br />
		<select name="selectMode" id="selectMode">
		           <option value="multi">Multi</option>
		           <option value="solo">Solo</option>
		</select>
		</p>

		<p id="select">
		<label for="selectJoueur1">sélectionner Pokémon 1</label><br />
		<select name="Joueur1" id="selectJoueur1">
		           <option value="Gardette">Gardette</option>
		           <option value="Hamid">Hamid</option>
		           <option value="Damien">Damien</option>
		           <option value="Roman">Roman</option>
		           <option value="Charles">Charles</option>
		           <option value="Marie-Caroline">Marie-Caroline</option>
		</select>
		</p>

		<p id="select">
		<label for="selectJoueur2">sélectionner Pokémon 2</label><br />
		<select name="Joueur2" id="selectJoueur2">
		           <option value="Gardette">Gardette</option>
		           <option value="Hamid">Hamid</option>
		           <option value="Damien">Damien</option>
		           <option value="Roman">Roman</option>
		           <option value="Charles">Charles</option>
		           <option value="Marie-Caroline">Marie-Caroline</option>
		</select>
		</p>

		<center>
		<canvas id="canvasMute" onclick=MuteUnmute()></canvas>
		</center>

		<!-- <center> -->
		<p id="grosBouton" , onclick=Start()>COMMENCER</p>
		<p id="grosBoutonOut"><a href="../index.php">RETOUR</a></p>
		<!-- </center> -->

	</div>
</div>


<audio id="musique1" src="images/musique1.mp3"></audio>
<audio id="musiquefin" src="images/musiquefin.mp3"></audio>



<div style="display:none;">
<img id="backfight" src="images/backfight.png">
<img id="gardetteP1" src="images/gardetteP1.png">
<img id="gardetteP2" src="images/gardetteP2.png">
<img id="hamidP1" src="images/hamidP1.png">
<img id="hamidP2" src="images/hamidP2.png">
<img id="damienP1" src="images/damienP1.png">
<img id="damienP2" src="images/damienP2.png">
<img id="romanP1" src="images/romanP1.png">
<img id="romanP2" src="images/romanP2.png">
<img id="charlesP1" src="images/charlesP1.png">
<img id="charlesP2" src="images/charlesP2.png">
<img id="mariecaroP1" src="images/mariecaroP1.png">
<img id="mariecaroP2" src="images/mariecaroP2.png">

<img id="logo" src="images/logo.png">
<img id="imagefin" src="images/plaine.jpg">

<img id="imagemute" src="images/mute.png">
<img id="imageunmute" src="images/unmute.png">

</div>

<p id="screen-log"></p>


<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=user7;charset=utf8', 'root', 'Kermit01');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}


?>


<script>

musique1=document.getElementById('musique1')
musiquefin=document.getElementById('musiquefin')

var Laudios=[]

Laudios.push(musique1)
Laudios.push(musiquefin)

var Mute="non"

var K=0.8

var started="non"

var t0=0

var Phase="choix"
//var Phase="fin"
var derniereAttaque=''

//var Mode="multi"
var Mode="solo"

var Crit="non"

var Rate="non"


// musique=document.getElementById("musique")
// musique.play()


// **********************************************************************


function MuteUnmute(){
	if(Mute=="non"){
		for(i = 0; i < Laudios.length; i++){
			Laudios[i].muted=true
		}
		Mute="oui"
	}
	else{
		for(i = 0; i < Laudios.length; i++){
			Laudios[i].muted=false
		}
		Mute="non"
	}
}





// création des animations **********************************************************************

class Animation{
	constructor(Nom,Xt,Yt,duree=1000){
		this.Nom = Nom;
		this.Xt=Xt;
		this.Yt=Yt;
		this.duree=duree;
	}
}

function idleX(t){return (0)}
function idleY(t){return (5*Math.sin(2*Math.PI*0.5*0.001*t))}
let idle = new Animation('idle',idleX,idleY)

function idlefastX(t){return (0)}
function idlefastY(t){return (5*Math.sin(2*Math.PI*5*0.001*t))}
let idlefast = new Animation('idlefast',idlefastX,idlefastY,1000)

function animDegatX(t){return (15*Math.sin(2*Math.PI*10*0.001*t))}
function animDegatY(t){return (15*Math.sin(2*Math.PI*15*0.001*t))}
let animDegat = new Animation('animDegat',animDegatX,animDegatY,500)

function ligneX(t){return (0.5*t)}
function ligneY(t){return (-0.4*t)}
let ligne = new Animation('ligne',ligneX,ligneY,250);


Lanim=[];

Lanim.push(idle);
Lanim.push(idlefast);
Lanim.push(animDegat);
Lanim.push(ligne);

//***************************


// création des attaques ************************************************************************

class Attaque{
	constructor(nom,anim,animDef,puissance,heal,AttbuffAtt,AttbuffDef,AttbuffVitesse,DefbuffAtt,DefbuffDef,DefBuffVitesse,type,description="une attaque",PP=10){
		this.nom=nom
		this.anim=anim
		this.animDef=animDef
		this.puissance=puissance
		this.heal=heal
		this.AttbuffAtt=AttbuffAtt
		this.AttbuffDef=AttbuffDef
		this.AttbuffVitesse=AttbuffVitesse
		this.DefbuffAtt=DefbuffAtt
		this.DefbuffDef=DefbuffDef
		this.DefBuffVitesse=DefBuffVitesse
		this.type=type
		this.description=description
		this.PP=PP
	}
}


//***********************************************************************************************


// Création des joueurs ************************************************************************

//Charge,Sieste,Trempette,Trempette

class Player{
	constructor(idImage,Nom,Niveau,type,vieMax=100,Attaques=[],Vitesse=100,Defense=100,StatAttaque=100,place="indefini"){
		this.place=place;
		this.idImage=idImage;
		this.idImageP1=idImage+"P1";
		this.idImageP2=idImage+"P2";
		this.Nom=Nom;
		this.Niveau=Niveau;
		this.vie=vieMax;
		this.vieCible=vieMax;
		this.vieMax=vieMax;
		this.type=type;
		this.Attaques=Attaques;
		this.PPs=[10,10,10,10]
		this.anim=idle;
		this.Vitesse=Vitesse
		this.Defense=Defense
		this.StatAttaque=StatAttaque

	}

	setPPs(){
		this.PPs[0]=this.Attaques[0].PP
		this.PPs[1]=this.Attaques[1].PP
		this.PPs[2]=this.Attaques[2].PP
		this.PPs[3]=this.Attaques[3].PP		
	}
	resetanim(){this.anim=idle};
	majvie(){
		if(this.vieCible>this.vieMax){this.vieCible=this.vieMax}
		if(this.vie>this.vieCible){this.vie=this.vie-1;};
		if(this.vie<this.vieCible){this.vie=this.vie+1;};
	}

}

function copyPlayer(Destination,Player){
	Destination.place=Player.place;
	Destination.idImage=Player.idImage;
	Destination.idImageP1=Player.idImageP1;
	Destination.idImageP2=Player.idImageP2;
	Destination.Nom=Player.Nom;
	Destination.Niveau=Player.Niveau;
	Destination.type=Player.type;
	Destination.vie=Player.vie;
	Destination.vieCible=Player.vieCible;
	Destination.vieMax=Player.vieMax;
	Destination.Attaques=Player.Attaques;
	Destination.PPs=Player.PPs;
	Destination.anim=Player.anim;
	Destination.Vitesse=Player.Vitesse;
	Destination.Defense=Player.Defense;
	Destination.StatAttaque=Player.StatAttaque;
}




var NomP1=''
var NomP2=''





let Att1P1 = new Attaque();
let Att2P1 = new Attaque();
let Att3P1 = new Attaque();
let Att4P1 = new Attaque();
let Att1P2 = new Attaque();
let Att2P2 = new Attaque();
let Att3P2 = new Attaque();
let Att4P2 = new Attaque();

let ListeAtt=[];

ListeAtt.push(Att1P1);
ListeAtt.push(Att2P1);
ListeAtt.push(Att3P1);
ListeAtt.push(Att4P1);
ListeAtt.push(Att1P2);
ListeAtt.push(Att2P2);
ListeAtt.push(Att3P2);
ListeAtt.push(Att4P2);

let P1 = new Player()
let P2 = new Player()
let P3 = new Player()


function affecterJoueursPhp(){
	return new Promise(resolve =>{
	NomP1=document.getElementById("selectJoueur1").value
	NomP2=document.getElementById("selectJoueur2").value
	Mode=document.getElementById("selectMode").value

	$.getJSON("affectationJoueurs.php",{NomJ1:NomP1, NomJ2:NomP2,Mode:Mode}, function(data){
    	LdataAtt=data;

    	// création des classes attaques



    	for (var i = ListeAtt.length - 1; i >= 0; i--) {




    		ListeAtt[i].nom=LdataAtt['nom'+'Att'+(i%4+1).toString()+'P'+Math.floor(i/4+1).toString()];
			ListeAtt[i].anim=LdataAtt['anim'+'Att'+(i%4+1).toString()+'P'+Math.floor(i/4+1).toString()];
			ListeAtt[i].animDef=LdataAtt['animDef'+'Att'+(i%4+1).toString()+'P'+Math.floor(i/4+1).toString()];
			ListeAtt[i].puissance=parseInt(LdataAtt['puissance'+'Att'+(i%4+1).toString()+'P'+Math.floor(i/4+1).toString()]);
			ListeAtt[i].heal=parseInt(LdataAtt['heal'+'Att'+(i%4+1).toString()+'P'+Math.floor(i/4+1).toString()]);
			ListeAtt[i].AttbuffAtt=parseInt(LdataAtt['AttbuffAtt'+'Att'+(i%4+1).toString()+'P'+Math.floor(i/4+1).toString()]);
			ListeAtt[i].AttbuffDef=parseInt(LdataAtt['AttbuffDef'+'Att'+(i%4+1).toString()+'P'+Math.floor(i/4+1).toString()]);
			ListeAtt[i].AttbuffVitesse=parseInt(LdataAtt['AttbuffVitesse'+'Att'+(i%4+1).toString()+'P'+Math.floor(i/4+1).toString()]);
			ListeAtt[i].DefbuffAtt=parseInt(LdataAtt['DefbuffAtt'+'Att'+(i%4+1).toString()+'P'+Math.floor(i/4+1).toString()]);
			ListeAtt[i].DefbuffDef=parseInt(LdataAtt['DefbuffDef'+'Att'+(i%4+1).toString()+'P'+Math.floor(i/4+1).toString()]);
			ListeAtt[i].DefBuffVitesse=parseInt(LdataAtt['DefBuffVitesse'+'Att'+(i%4+1).toString()+'P'+Math.floor(i/4+1).toString()]);
			ListeAtt[i].type=LdataAtt['type'+'Att'+(i%4+1).toString()+'P'+Math.floor(i/4+1).toString()];
			ListeAtt[i].description=LdataAtt['description'+'Att'+(i%4+1).toString()+'P'+Math.floor(i/4+1).toString()];
			ListeAtt[i].PP=parseInt(LdataAtt['PP'+'Att'+(i%4+1).toString()+'P'+Math.floor(i/4+1).toString()]);

			for (var j = Lanim.length - 1; j >= 0; j--) {
                if (Lanim[j].Nom == ListeAtt[i].anim){ListeAtt[i].anim=Lanim[j]}
                if (Lanim[j].Nom == ListeAtt[i].animDef){ListeAtt[i].animDef=Lanim[j]}
            }

        }



    	$.getJSON("FetchStatsSession.php", function(data2){

    		// création des joueurs

    		LdataSession=data2;

    		P1.place=LdataSession['placeJ1'];
			P1.idImage=LdataSession['idImageJ1'];
			P1.idImageP1=LdataSession['idImageJ1']+"P1";
			P1.idImageP2=LdataSession['idImageJ1']+"P2";
			P1.Nom=LdataSession['NomJ1'];
			P1.Niveau=LdataSession['NiveauJ1'];
			P1.vie=LdataSession['vieMaxJ1'];
			P1.vieCible=LdataSession['vieMaxJ1'];
			P1.vieMax=LdataSession['vieMaxJ1'];
			P1.type=LdataSession['typeJ1'];
			P1.Attaques=[Att1P1,Att2P1,Att3P1,Att4P1];
			P1.PPs=[10,10,10,10]
			P1.anim=idle;
			P1.Vitesse=LdataSession['VitesseJ1']
			P1.Defense=LdataSession['DefenseJ1']
			P1.StatAttaque=LdataSession['StatAttaqueJ1']

			P1.setPPs()

			P2.place=LdataSession['placeJ2'];
			P2.idImage=LdataSession['idImageJ2'];
			P2.idImageP1=LdataSession['idImageJ2']+"P1";
			P2.idImageP2=LdataSession['idImageJ2']+"P2";
			P2.Nom=LdataSession['NomJ2'];
			P2.Niveau=LdataSession['NiveauJ2'];
			P2.vie=LdataSession['vieMaxJ2'];
			P2.vieCible=LdataSession['vieMaxJ2'];
			P2.vieMax=LdataSession['vieMaxJ2'];
			P2.type=LdataSession['typeJ2'];
			P2.Attaques=[Att1P2,Att2P2,Att3P2,Att4P2];
			P2.PPs=[10,10,10,10]
			P2.anim=idle;
			P2.Vitesse=LdataSession['VitesseJ2']
			P2.Defense=LdataSession['DefenseJ2']
			P2.StatAttaque=LdataSession['StatAttaqueJ2']

			P2.setPPs()

			// started=LdataSession['started']

			joueurActuel=P1;
			autreJoueur=P2

			resolve("true")

    
    });

});
})
}

function MajJoueursPhp(){
	return new Promise(resolve =>{

    	$.getJSON("FetchStatsSession.php", function(data2){

    		// création des joueurs

    		LdataSession=data2;

    		P1.place=LdataSession['placeJ1'];
			P1.vieCible=LdataSession['vieCibleJ1'];
			P1.PPs=[LdataSession['PP1J1'],LdataSession['PP2J1'],LdataSession['PP3J1'],LdataSession['PP4J1']]
			P1.Vitesse=LdataSession['VitesseJ1']
			P1.Defense=LdataSession['DefenseJ1']
			P1.StatAttaque=LdataSession['StatAttaqueJ1']

			P2.place=LdataSession['placeJ2'];
			P2.vieCible=LdataSession['vieCibleJ2'];
			P2.PPs=[LdataSession['PP1J2'],LdataSession['PP2J2'],LdataSession['PP3J2'],LdataSession['PP4J2']]
			P2.Vitesse=LdataSession['VitesseJ2']
			P2.Defense=LdataSession['DefenseJ2']
			P2.StatAttaque=LdataSession['StatAttaqueJ2']

			resolve("true")


    
    });

});
}




//***********************************************************************************************

// fonctions de dessin **************************************************************************

function dessiner(id, canvas, dx,dy,W,H){
canvas.drawImage(document.getElementById(id),0,0,document.getElementById(id).width,document.getElementById(id).height,dx,dy,W,H)
}

function couleurVie(P){
	if(P.vie>0.50*P.vieMax){return('rgb(0,230,0)')}
	else if(P.vie>0.20*P.vieMax && P.vie<=0.50*P.vieMax){return('rgb(230,150,0)')}
	else if (P.vie<=0.20*P.vieMax){return('rgb(230,0,0)')}
	else {return('rgb(0,0,0)')}
}


function dessinerArene(ctx){

	ctx.font=1.2*tailleDeBasePolice.toString()+"px Staatliches";
	// Arrière plan

	dessiner("backfight",ctx,0,0,W,H+1);

	// Rectangles

	Wrec=0.70*H;
	Hrec=0.2*H;

	X0recP2=0.1*H;
	Y0recP2=0.07*H;

	X0recP1=W-X0recP2-Wrec;
	Y0recP1=H-Y0recP2-Hrec;

	d=0.03*Hrec
	d2=0.3*Hrec

	ctx.fillStyle='rgb(32,56,0)'
	ctx.fillRect(X0recP2-d,Y0recP2-d,Wrec+2*d,Hrec+2*d)
	// ctx.strokeRect(X0recP2,Y0recP2,Wrec,Hrec)
	ctx.fillRect(X0recP1-d,Y0recP1-d,Wrec+2*d,Hrec+2*d)
	// ctx.strokeRect(X0recP1,Y0recP1,Wrec,Hrec)
	
	ctx.fillStyle='rgb(248,248,216)'
	ctx.fillRect(X0recP2,Y0recP2,Wrec,Hrec)
	ctx.strokeRect(X0recP2,Y0recP2,Wrec,Hrec)
	ctx.fillRect(X0recP1,Y0recP1,Wrec,Hrec)
	ctx.strokeRect(X0recP1,Y0recP1,Wrec,Hrec)

	// Barres de vie

	Lbarrevie=0.6*Wrec
	Hbarrevie=0.05*Hrec
	DXbarrevie=0.3*Wrec
	DYbarrevie=0.5*Hrec

	

	ctx.fillStyle='rgb(0,0,0)'
	ctx.fillRect(X0recP2+DXbarrevie-d2-2*d,Y0recP2+DYbarrevie-2*d,Lbarrevie+4*d+d2,Hbarrevie+4*d);
	ctx.fillRect(X0recP1+DXbarrevie-d2-2*d,Y0recP1+DYbarrevie-2*d,Lbarrevie+4*d+d2,Hbarrevie+4*d);

	ctx.fillStyle='rgb(255,255,255)'
	ctx.fillRect(X0recP2+DXbarrevie-d,Y0recP2+DYbarrevie-d,Lbarrevie+2*d,Hbarrevie+2*d);
	ctx.fillRect(X0recP1+DXbarrevie-d,Y0recP1+DYbarrevie-d,Lbarrevie+2*d,Hbarrevie+2*d);

	ctx.fillStyle='rgb(0,0,0)'
	ctx.fillRect(X0recP2+DXbarrevie,Y0recP2+DYbarrevie,Lbarrevie,Hbarrevie);
	ctx.fillRect(X0recP1+DXbarrevie,Y0recP1+DYbarrevie,Lbarrevie,Hbarrevie);


	ctx.fillStyle='rgb(248,176,64)'
	ctx.font=0.85*tailleDeBasePolice.toString()+"px Staatliches";
	ctx.fillText('PV',X0recP2+DXbarrevie-d2+d,Y0recP2+DYbarrevie+Hbarrevie+d)
	ctx.fillText('PV',X0recP1+DXbarrevie-d2+d,Y0recP1+DYbarrevie+Hbarrevie+d)

	ctx.font=1.2*tailleDeBasePolice.toString()+"px Staatliches";


	ctx.fillStyle=couleurVie(P2)//couleur
	if(P2.vie>0){ctx.fillRect(X0recP2+DXbarrevie,Y0recP2+DYbarrevie,P2.vie/P2.vieMax*Lbarrevie,Hbarrevie)};
	ctx.fillStyle=couleurVie(P1)
	if(P1.vie>0){ctx.fillRect(X0recP1+DXbarrevie,Y0recP1+DYbarrevie,P1.vie/P1.vieMax*Lbarrevie,Hbarrevie)};

	// PV/PVmax

	ctx.fillStyle='rgb(0,0,0)'
	ctx.textAlign="center"

	DXPV=Lbarrevie*0.85+DXbarrevie
	DYPV=DYbarrevie*1.75

	if(P2.vie>0){ctx.fillText(P2.vie.toString()+"/"+P2.vieMax.toString(),X0recP2+DXPV,Y0recP2+DYPV)};
	if(P2.vie<=0){ctx.fillText("0"+"/"+P2.vieMax.toString(),X0recP2+DXPV,Y0recP2+DYPV)};
	if(P1.vie>0){ctx.fillText(P1.vie.toString()+"/"+P1.vieMax.toString(),X0recP1+DXPV,Y0recP1+DYPV)};
	if(P1.vie<=0){ctx.fillText("0"+"/"+P1.vieMax.toString(),X0recP1+DXPV,Y0recP1+DYPV)};

	// Nom

	DXNom=0.2*DXbarrevie
	DYNom=0.6*DYbarrevie

	ctx.textAlign="start"

	ctx.fillStyle='rgb(0,0,0)'
	ctx.fillText(P2.Nom,X0recP2+DXNom,Y0recP2+DYNom)
	ctx.fillText(P1.Nom,X0recP1+DXNom,Y0recP1+DYNom)

	// Niveau

	DXNiveau=DXPV
	DYNiveau=DYNom

	ctx.fillText("N."+P2.Niveau.toString(),X0recP2+DXNiveau,Y0recP2+DYNiveau)
	ctx.fillText("N."+P1.Niveau.toString(),X0recP1+DXNiveau,Y0recP1+DYNiveau)

}

// récupération des canvas ***********************************************************************************************

//canvas arene

cvs=document.getElementById("c");
ctx=cvs.getContext('2d');
cvs.width=Math.min(window.innerWidth,window.innerHeight)*K;
cvs.height=cvs.width*9/16;



var W=cvs.width;
var H=cvs.height;

// canvas texte

var Wtxt=W;
var Htxt=H/3;

cvstxt=document.getElementById("cvtxt");
ctxtxt=cvstxt.getContext('2d');
cvstxt.width=W;
cvstxt.height=H/3;

tailleDeBasePolice=Math.floor(0.04*H)+1

ctx.font=tailleDeBasePolice.toString()+"px Staatliches";
//ctx.font="italic 22px Arial";
ctxtxt.font=tailleDeBasePolice.toString()+"px Staatliches";


cvsmute=document.getElementById("canvasMute")
ctxmute=cvsmute.getContext('2d')

Hmute=2*tailleDeBasePolice
Wmute=Hmute

cvsmute.height=Hmute
cvsmute.width=Wmute

ctxmute.fillStyle='rgb(0,120,200)'
ctxmute.fillRect(0,0,Wmute,Hmute)
//************************************************************************************************************************

function dessinerCanvasMute(){
	if(Mute=="non"){dessiner('imageunmute',ctxmute,0,0,Wmute,Hmute);}
	else{dessiner('imagemute',ctxmute,0,0,Wmute,Hmute);}

}



// position curseur ******************************************************************************************************

var posX=0;
var posY=0;

let screenLog = document.getElementById('screen-log')
document.addEventListener('mousemove', logKey);


var offsetX=cvstxt.offsetLeft
var offsetY=cvstxt.offsetTop

function majOffset(){
	offsetX=cvstxt.offsetLeft
	offsetY=cvstxt.offsetTop
}

function logKey(e) {
	majOffset()
	posX = e.clientX - offsetX;
    posY = e.clientY - offsetY;

  // screenLog.innerText = `
  //   Screen X/Y: ${posX}, ${posY}
  //   Client X/Y: ${e.clientX}, ${e.clientY}`;
    
}

//************************************************************************************************************************



DXboutonBord=0.1*Htxt
DYboutonBord=0.1*Htxt
DXentreBoutons=20
Wbouton=Wtxt*0.3
Hbouton=0.35*Htxt

class boutonAttaque{
	constructor(Num,Ox,Oy,W,H){
		this.Num=Num
		this.Ox=Ox;
		this.Oy=Oy;
		this.W=W;
		this.H=H;
		this.survol="non"
	}
	updatesurvol(){
		if(posX>=this.Ox && posX<=(this.Ox+this.W) && posY>=this.Oy && posY<=(this.Oy+this.H)){
			this.survol="oui"
		}
		else{this.survol="non"}
	}
	resetsurvol(){this.survol="non"}
}



let bouton1 = new boutonAttaque(1,DXboutonBord,DYboutonBord,Wbouton,Hbouton)
let bouton2 = new boutonAttaque(2,DXboutonBord+bouton1.W+DXentreBoutons,bouton1.Oy,Wbouton,Hbouton)
let bouton3 = new boutonAttaque(3,bouton1.Ox,Htxt-DYboutonBord-Hbouton,Wbouton,Hbouton)
let bouton4 = new boutonAttaque(4,bouton2.Ox,bouton3.Oy,Wbouton,Hbouton)

Lboutons=[]
Lboutons.push(bouton1)
Lboutons.push(bouton2)
Lboutons.push(bouton3)
Lboutons.push(bouton4)

function resetboutons(){
	for(i = 0; i < Lboutons.length; i++){Lboutons[i].resetsurvol()}
}

// function updateboutons(){
// 	for(i = 0; i < Lboutons.length; i++){Lboutons[i].updatesurvol()}
// }

// function dessinerFillRectangle(rect,ct=ctxtxt) {
//     ct.fillRect(rect.points[0].x,rect.points[0].y,rect.points[1].x-rect.points[0].x,rect.points[2].y-rect.points[0].y)
// }

// function dessinerStrokeRectangle(rect,ct=ctxtxt) {
//     ct.strokeRect(rect.points[0].x,rect.points[0].y,rect.points[1].x-rect.points[0].x,rect.points[2].y-rect.points[0].y)
// }



function dessinerbouton(bouton,Player,ct=ctxtxt) {
	bouton.updatesurvol()
    ct.strokeRect(bouton.Ox,bouton.Oy,bouton.W,bouton.H)
    if(bouton.survol=="oui"){
    	ct.fillStyle="rgb(200,200,200)"
    	ct.fillRect(bouton.Ox,bouton.Oy,bouton.W,bouton.H)


    	OxDesc=0.685*Wtxt
		OyDesc=0.2*Htxt

    	// description
    	ct.fillStyle="rgb(0,0,0)"
    	ct.textAlign='start'
    	ct.fillText(Player.Attaques[i].description,OxDesc,OyDesc)
    }
    else{
    	ct.fillStyle="rgb(255,255,255)"
    	ct.fillRect(bouton.Ox,bouton.Oy,bouton.W,bouton.H)
    }
	
	
	ct.fillStyle="rgb(0,0,0)"
	ct.textAlign="start"
	
	DxNomAttaque=0.1*Wbouton
	DyNomAttaque=0.5*Hbouton
	DxPP=0.55*Wbouton
	DyPP=0.75*Hbouton

	ct.font=tailleDeBasePolice.toString()+"px Staatliches";

	ct.fillText(Player.Attaques[bouton.Num-1].nom,bouton.Ox+DxNomAttaque,bouton.Oy+DyNomAttaque)
	ct.fillText("PP "+Player.PPs[bouton.Num-1].toString()+"/"+Player.Attaques[bouton.Num-1].PP,bouton.Ox+DxPP,bouton.Oy+DyPP)
}


//dessiner deuxième canvas************************************************************************************************


function dessinerCanvasTxt(){
	d=0.01*H
	Dxseparation=bouton2.Ox+Wbouton+bouton1.Ox
	if(Phase=="choix"){
		ctxtxt.fillStyle='rgb(40,48,48)'
		ctxtxt.fillRect(0,0,Dxseparation,Htxt)

		ctxtxt.fillStyle='rgb(200,168,72)'
		ctxtxt.fillRect(d,d,Dxseparation-2*d,Htxt-2*d)

		ctxtxt.fillStyle='rgb(255,255,255)'
		ctxtxt.fillRect(2.5*d,2.5*d,Dxseparation-5*d,Htxt-5*d)

		ctxtxt.fillStyle='rgb(40,80,104)'
		ctxtxt.fillRect(3*d,3*d,Dxseparation-6*d,Htxt-6*d)


		// ctxtxt.fillStyle='rgb(0,0,0)'
		// ctxtxt.fillRect(Dxseparation,0,3,Htxt)

		ctxtxt.fillStyle='rgb(40,48,48)'
		ctxtxt.fillRect(Dxseparation,0,Wtxt-Dxseparation,Htxt)
		ctxtxt.fillStyle='rgb(32,104,208)'
		ctxtxt.fillRect(Dxseparation+d,d,Wtxt-Dxseparation-2*d,Htxt-2*d)
		ctxtxt.fillStyle='rgb(255,255,255)'
		ctxtxt.fillRect(Dxseparation+2.5*d,2.5*d,Wtxt-Dxseparation-5*d,Htxt-5*d)

		for(i = 0; i < Lboutons.length; i++){dessinerbouton(Lboutons[i],joueurActuel,ctxtxt)}
	}
	else if(Phase=="Text1"){
		resetboutons()
		ctxtxt.fillStyle='rgb(40,48,48)'
		ctxtxt.fillRect(0,0,Wtxt,Htxt)

		ctxtxt.fillStyle='rgb(200,168,72)'
		ctxtxt.fillRect(d,d,Wtxt-2*d,Htxt-2*d)

		ctxtxt.fillStyle='rgb(255,255,255)'
		ctxtxt.fillRect(2.5*d,2.5*d,Wtxt-5*d,Htxt-5*d)

		ctxtxt.fillStyle='rgb(40,80,104)'
		ctxtxt.fillRect(3*d,3*d,Wtxt-6*d,Htxt-6*d)

		ctx.textAlign='start'

		ctxtxt.font=1.5*tailleDeBasePolice.toString()+"px Staatliches";
		ctxtxt.fillStyle='rgb(255,255,255)'
		ctxtxt.fillText(joueurActuel.Nom+" utilise "+derniereAttaque+" !",5*d,0.3*Htxt)

		if(Rate=="oui"){ctxtxt.fillText(joueurActuel.Nom+" rate son attaque !",5*d,0.3*Htxt+1.2*1.5*tailleDeBasePolice)}
		else if(Crit=="oui"){
			ctxtxt.fillText("Coup critique !",5*d,0.3*Htxt+1.2*1.5*tailleDeBasePolice);
		}

		// ctxtxt.font=1.5*tailleDeBasePolice.toString()+"px Staatliches";
		// ctxtxt.fillStyle='rgb(0,0,0)'
		// ctxtxt.strokeText(joueurActuel.Nom+" utilise "+derniereAttaque+" !",5*d,0.3*Htxt)

	}

}



function dessinerPageInit(){
	// ctx.fillStyle='rgb(255,255,255)'
	// ctx.fillRect(0,0,W,H)
	dessiner("logo",ctx,0,0,W,H)

	d=0.01*H

	ctxtxt.fillStyle='rgb(40,48,48)'
	ctxtxt.fillRect(0,0,Wtxt,Htxt)

	ctxtxt.fillStyle='rgb(200,168,72)'
	ctxtxt.fillRect(d,d,Wtxt-2*d,Htxt-2*d)

	ctxtxt.fillStyle='rgb(255,255,255)'
	ctxtxt.fillRect(2.5*d,2.5*d,Wtxt-5*d,Htxt-5*d)

	ctxtxt.fillStyle='rgb(40,80,104)'
	ctxtxt.fillRect(3*d,3*d,Wtxt-6*d,Htxt-6*d)

	ctxtxt.textAlign='start'

	ctxtxt.font=1.5*tailleDeBasePolice.toString()+"px Staatliches";
	ctxtxt.fillStyle='rgb(255,255,255)'
	ctxtxt.fillText("Bienvenue dans Pokémon MKTRO !",5*d,0.3*Htxt)
	ctxtxt.fillText("Choisissez le mode de jeu et les pokémons !",5*d,0.3*Htxt+1.2*1.5*tailleDeBasePolice)
}


//************************************************************************************************************************






// position et taille des joueurs******************************************************************************************
WP2=0.45*H
HP2=0.45*H

X0P2=0.62*W
Y0P2=0.025*H

k=1.5
WP1=k*WP2
HP1=k*HP2

X0P1=W-X0P2-WP2/2-WP1/2
Y0P1=H-Y0P2-HP2/2-HP1/2
//**************************************************************************************************************************

function majWH(){// mise à jour de toutes les dimensions
	cvs.width=Math.min(window.innerWidth,window.innerHeight)*K;
	cvs.height=cvs.width*9/16;
	W=cvs.width;
	H=cvs.height;
	cvstxt=document.getElementById("cvtxt");
	ctxtxt=cvstxt.getContext('2d');
	cvstxt.width=W;
	cvstxt.height=H/3;
	Wtxt=W;
	Htxt=H/3;
	tailleDeBasePolice=Math.floor(0.04*H)+1
	ctx.font=tailleDeBasePolice.toString()+"px Staatliches";
	//ctx.font="italic 22px Arial";
	ctxtxt.font=tailleDeBasePolice.toString()+"px Staatliches";

	DXboutonBord=0.12*Htxt
	DYboutonBord=0.12*Htxt
	DXentreBoutons=0.02*Wtxt
	Wbouton=Wtxt*0.3
	Hbouton=0.35*Htxt

	bouton1.Ox=DXboutonBord
	bouton1.Oy=DYboutonBord
	bouton1.W=Wbouton
	bouton1.H=Hbouton

	bouton2.Ox=DXboutonBord+bouton1.W+DXentreBoutons
	bouton2.Oy=bouton1.Oy
	bouton2.W=Wbouton
	bouton2.H=Hbouton

	bouton3.Ox=bouton1.Ox
	bouton3.Oy=Htxt-DYboutonBord-Hbouton
	bouton3.W=Wbouton
	bouton3.H=Hbouton

	bouton4.Ox=bouton2.Ox
	bouton4.Oy=bouton3.Oy
	bouton4.W=Wbouton
	bouton4.H=Hbouton

	WP2=0.45*H
	HP2=0.45*H

	X0P2=0.62*W
	Y0P2=0.025*H

	k=1.5
	WP1=k*WP2
	HP1=k*HP2

	X0P1=W-X0P2-WP2/2-WP1/2
	Y0P1=H-Y0P2-HP2/2-HP1/2

	OxDesc=0.7*Wtxt
	OyDesc=0.2*Htxt

	boite=document.getElementById("selecteurs")
	boite.style.fontSize=tailleDeBasePolice
	boite.style.width=0.5*H

	grosBouton=document.getElementById("grosBouton")
	grosBouton.style.fontSize=1.5*tailleDeBasePolice
	grosBouton.style.fontSize=1.5*tailleDeBasePolice

	grosBoutonOut=document.getElementById("grosBoutonOut")
	grosBoutonOut.style.fontSize=1.5*tailleDeBasePolice
	grosBoutonOut.style.fontSize=1.5*tailleDeBasePolice

	document.getElementById("selectMode").style.fontSize=tailleDeBasePolice
	document.getElementById("selectJoueur1").style.fontSize=tailleDeBasePolice
	document.getElementById("selectJoueur2").style.fontSize=tailleDeBasePolice


	Hmute=2*tailleDeBasePolice
	Wmute=Hmute

	cvsmute.height=Hmute
	cvsmute.width=Wmute

	dessinerCanvasMute()

	if(started=="non"){
		dessinerPageInit()
		setTimeout(majWH,15)
	}

}


//******************************************************************************************************
//******************************************************************************************************
//******************************************************************************************************

async function run(){
	await MajJoueursPhp();

	majWH()

	// récupération du temps
	var time = new Date();
	t=(1000*60*time.getMinutes()+1000*time.getSeconds()+time.getMilliseconds())-t0// temps en ms

	// effacage des canvas
	ctx.clearRect(0,0,cvs.width,cvs.height)
	ctxtxt.clearRect(0,0,cvstxt.width,cvstxt.height)

	if(Phase!="fin"){
		//dessin de l'arene
		dessinerArene(ctx);

		//dessin second canvas
		dessinerCanvasTxt();
	
		//dessin des joueurs
		dessiner(P2.idImageP2,ctx,X0P2-P2.anim.Xt(t),Y0P2-P2.anim.Yt(t),WP2,HP2)
		dessiner(P1.idImageP1,ctx,X0P1+P1.anim.Xt(t),Y0P1+P1.anim.Yt(t),WP1,HP1)
	}
	else{ //fin

		if(P1.vie>0 && P2.vie>0){ //attendre baisse PV
			//dessin de l'arene
			dessinerArene(ctx);

			//dessin second canvas
			dessinerCanvasTxt();
		
			//dessin des joueurs
			dessiner(P2.idImageP2,ctx,X0P2-P2.anim.Xt(t),Y0P2-P2.anim.Yt(t),WP2,HP2)
			dessiner(P1.idImageP1,ctx,X0P1+P1.anim.Xt(t),Y0P1+P1.anim.Yt(t),WP1,HP1)

			ctxtxt.fillStyle='rgb(40,48,48)'
			ctxtxt.fillRect(0,0,Wtxt,Htxt)

			ctxtxt.fillStyle='rgb(200,168,72)'
			ctxtxt.fillRect(d,d,Wtxt-2*d,Htxt-2*d)

			ctxtxt.fillStyle='rgb(255,255,255)'
			ctxtxt.fillRect(2.5*d,2.5*d,Wtxt-5*d,Htxt-5*d)

			ctxtxt.fillStyle='rgb(40,80,104)'
			ctxtxt.fillRect(3*d,3*d,Wtxt-6*d,Htxt-6*d)

		}
		else{
			musique1.pause()
			musiquefin.play()

			ctx.fillStyle='rgb(230,0,0)'		
			dessiner("imagefin",ctx,0,0,W,H)
			dessiner(joueurActuel.idImageP1,ctx,W/2-WP1/2+joueurActuel.anim.Xt(t),H/2-HP1/2+joueurActuel.anim.Yt(t),WP1,HP1)

			d=0.01*H

			ctxtxt.fillStyle='rgb(40,48,48)'
			ctxtxt.fillRect(0,0,Wtxt,Htxt)

			ctxtxt.fillStyle='rgb(200,168,72)'
			ctxtxt.fillRect(d,d,Wtxt-2*d,Htxt-2*d)

			ctxtxt.fillStyle='rgb(255,255,255)'
			ctxtxt.fillRect(2.5*d,2.5*d,Wtxt-5*d,Htxt-5*d)

			ctxtxt.fillStyle='rgb(40,80,104)'
			ctxtxt.fillRect(3*d,3*d,Wtxt-6*d,Htxt-6*d)

			ctxtxt.textAlign='start'

			ctxtxt.font=1.5*tailleDeBasePolice.toString()+"px Staatliches";
			ctxtxt.fillStyle='rgb(255,255,255)'
			ctxtxt.fillText(joueurActuel.Nom+" vainqueur !",5*d,0.3*Htxt)
		}
	}
	ctx.fillStyle='rgb(0,0,0)'
	//ctx.fillText(affichage1,cvs.width/2,cvs.height/2+12+24);
	//ctx.fillText(affichage2,cvs.width/2,cvs.height/2+12+24+30);

	P1.majvie()
	P2.majvie()


	setTimeout(run,15);//recommencer dans 15ms

}

var affichage1=0
var affichage2=0

//******************************************************************************************************
//******************************************************************************************************
//******************************************************************************************************




function NextPhasePhp(){
	console.log('nextphase')
	$.getJSON("NextPhase.php", async function(data){
		if(P1.vieCible>0 && P2.vieCible>0){
			console.log(data)
			Mode=data['Mode'];
			JjoueurActuel=data['joueurActuel'];
			if (Mode=="multi"){
				copyPlayer(P3,P2)
				copyPlayer(P2,P1)
				copyPlayer(P1,P3)
				Phase="choix"
			}
			else if(Mode=="solo"){
				if (JjoueurActuel=='J1'){
					joueurActuel=P1;
					autreJoueur=P2;
				}
				else{
					joueurActuel=P2;
					autreJoueur=P1;
				}
				// Tempo=joueurActuel
				// joueurActuel=autreJoueur
				// autreJoueur=Tempo
				if(joueurActuel==P2){
					await tourIAPhp()
				}
				else if(joueurActuel==P1){Phase="choix"}
			}
		// Phase="choix"
		
	}
	else{
		Phase="fin";

	}





	})

}




async function combatPhp(Patt,Pdef,Numbouton){
	// alert('clic')
	console.log('combat')
	$.getJSON("FonctionCombat.php",{Num:Numbouton}, async function(data){
		PPsuffisants=data['PPsuffisants'];
		derniereAttaque=data['derniereAttaque'];
		Rate=data['Rate'];
		Crit=data['Crit'];

		if (PPsuffisants=='oui'){
			Phase="Text1"
			await MajJoueursPhp();

			Att=Patt.Attaques[Numbouton-1]
			
			var timestamp = new Date();
			t0 = (1000*60*timestamp.getMinutes()+1000*timestamp.getSeconds()+timestamp.getMilliseconds())

			Pdef.anim=Att.animDef
			Patt.anim=Att.anim

			if(Mode=="solo"){
				if(Patt.place=="P1"){
					setTimeout(resetanimP1,Att.anim.duree)
				}
				if(Patt.place=="P2"){
					setTimeout(resetanimP2,Att.anim.duree)
				}
				if(Pdef.place=="P1"){
					setTimeout(resetanimP1,Att.animDef.duree)
				}
				if(Pdef.place=="P2"){
					setTimeout(resetanimP2,Att.animDef.duree)
				}
			}
			else{
				setTimeout(resetanimP1,Att.anim.duree)
				setTimeout(resetanimP2,Att.animDef.duree)
				
			}

			
			setTimeout(NextPhasePhp,Math.max(Att.anim.duree,Att.animDef.duree)+1000)

			}

	});
}



document.addEventListener('mousedown',clickPhp)

function clickPhp(e){
	for(i = 0; i < Lboutons.length; i++){
		if(Lboutons[i].survol=="oui"){
			NumBouton=Lboutons[i].Num
			combatPhp(joueurActuel,autreJoueur,NumBouton)
			
		}
	}
}


function tourIAPhp(){
	console.log('touria')
	Naleatoire=Math.floor(Math.random() * 4)//0,1,2 ou 3
	console.log(Lboutons[Naleatoire].Num)
	combatPhp(joueurActuel,autreJoueur,Lboutons[Naleatoire].Num)
}

function resetanimP1(){P1.resetanim();affichage1=t}
function resetanimP2(){P2.resetanim();affichage2=t}



async function Start(){
	// document.getElementById('musique1').play()
	musique1.play()
	document.getElementById("selectMode").disabled=true
	document.getElementById("selectJoueur1").disabled=true
	document.getElementById("selectJoueur2").disabled=true
	if(started=="non"){
		// Mode=document.getElementById("selectMode").value
    	const result = await affecterJoueursPhp();

    	run()
    	grosBouton=document.getElementById("grosBouton")
    	grosBouton.style.visibility='hidden'
    	started="oui"
	}
}


majWH()






</script>

</body></html>