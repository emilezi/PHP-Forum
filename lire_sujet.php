<?php
	session_start();
	include 'database.php'; 
	
	if (!isset($_GET['id_sujet_a_lire'])) {

	echo "<html>";
	
	echo
	"<head>
   	<meta charset='utf-8'/>
   	<title>Sujet non defini</title>
   	</head>";
    
   	echo "<body>";

   	echo "<h1>Sujet non defini</h1>";

	echo "<p>Sujet non defini</p>";
   
   }else{
   	
  	$p = $db->prepare("SELECT * FROM forum_sujet WHERE id_sujet=:id_sujet");
  	$p->execute([
	  'id_sujet'=> $_GET['id_sujet_a_lire']
  	]);
  
  	$presult = $p->fetch();
  
  	if($presult ==  true){
  
  	echo
  	"<html>
    <head>
	<meta charset='utf-8'/>
	<link rel='stylesheet' href='style.css'/>
    <title>" . $presult['titre'] . "</title>
    </head>
    
   <body>";
   	
	echo "<h1>" . $presult['titre'] . "</h1>";
  
  	$q = $db->prepare("SELECT * FROM forum_reponses WHERE correspondance_sujet=:correspondance_sujet ORDER BY date_reponse ASC");
  	$q->execute([
  	'correspondance_sujet'=> $presult['titre']
  	]);
  
  	$i = 0;
	
	while($result = $q->fetch(PDO::FETCH_ASSOC)){
	
	sscanf($result['date_reponse'], "%4s-%2s-%2s %2s:%2s:%2s", $annee, $mois, $jour, $heure, $minute, $seconde);
	
	$i=$i+1;

	echo "<p>" . $result['auteur'] . "</p>";

	echo "<p'>" . $jour . "-" . $mois . "-" . $annee . " " . $heure . ":" . $minute . "</p>";

	echo "<p>" . $result['message'] . "</p>";
	
	if($i == 1){
		
	}else{
	if((isset($_SESSION['pseudo'])) && (isset($_SESSION['prenom'])) && (isset($_SESSION['nom'])) && ($result['auteur'] == $_SESSION['pseudo'])){
	
	echo "<form action='edit_message.php?message_a_modifier=".$result['id_reponses']."' method='post'>
	<input type='submit' name='edit_reponses".$result['id_reponses']."' value='Modifier'>
	</form>";
	
	echo "<form action='delreponse.php?message_a_supprimer=".$result['id_reponses']."&id_sujet_a_lire=".$_GET['id_sujet_a_lire']."' method='post'>
	<input type='submit' name='delreponse".$result['id_reponses']."' value='Supprimer'>
	</form><br/><br/>";
	
	}
	

	}
	}
	
	if(isset($result)){ 

	include 'new_reponse.php'; 
	
	}
	
	}else{
		
		echo "<html>";
	
		echo
		"<head>
	   	<meta charset='utf-8'/>
	   	<title>Sujet non defini</title>
	   	</head>";
		
	   	echo "<body>";
	
	   	echo "<h1>Sujet non defini</h1>";
	
		echo"<p>Sujet non defini</p></div>";
	}
	
}

	echo
	"</body>
	</html>";

?>
